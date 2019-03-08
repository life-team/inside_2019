<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\PanelController;
use app\modules\account\models\Account;

class UserController extends PanelController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'options-save'],
                        'allow' => true
                    ], [
                        'actions' => ['index', 'items-get', 'item-lists-get', 'item-get', 'item-edit', 'item-remove'],
                        'allow' => true,
                        'roles' => ['admin']
                    ], [
                        'actions' => ['token'],
                        'allow' => true
                    ]
					
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => []
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		return $this->render('index');
    }

	/**
     * @return string
     */
    public function actionOptionsSave()
    {
		if (($post = Yii::$app->request->getBodyParam('Account'))) {
			/** @var Account $model */
			$model = $this->user;
			$model->scenario = 'update';
			$save = ['email', 'username', 'tz'];
			
			$model->email = empty($post['email']) ? '' : $post['email'];
			$model->username = empty($post['username']) ? '' : $post['username'];
			$model->tz = empty($post['tz']) ? '' : $post['tz'];
			
			if (!empty($post['password'])) {
				$model->password = $post['password'];
				$model->verifyPassword = empty($post['verifyPassword']) ? '' : $post['verifyPassword'];
				$save[] = 'password';
			}
			
			if (!$model->save(true, $save)) {
				return json_encode(['success' => false, 'messages' => $model->getFirstErrors()]);
			}
			
			$item = $model->getAttributes(['email', 'username', 'tz', 'telegramKey']);
			return json_encode(['success' => true, 'account' => $item]);
		}
		return json_encode(['success' => false]);
    }
	
	/**
	 * @return string
	 */
	public function actionAccessTokenUpdate()
    {
		$account = $this->user;
		if (empty($account)) {
			return json_encode(['success' => true, 'message' => 'Пользователь не найден']);
		}
		$account->access_token = sha1(uniqid(implode(':', $this->user->getAttributes()), true));

		if (!$account->save(true, ['access_token'])) {
			return json_encode(['success' => false, 'message' => 'Возникла ошибка при сохранении']);
		}
		
		return json_encode(['success' => true, 'token' => $account->access_token]);
    }
	
	/**
     * @return string
     */
    public function actionLogout()
    {
		if (!Yii::$app->user->getIsGuest()) {
			Yii::$app->user->logout();
		}
		return json_encode(['success' => true]);
    }
	
	/**
     * @return string
     */
    public function actionItemsGet()
    {
		$data = ['items' => [], 'success' => true];
		
		$items = Account::find()->orderBy('`id` DESC')->all();
		
		foreach ($items AS $item) {
			$device = [
				'id' => $item->id,
				'puttime' => (new \DateTime($item->createdAt))->format('Y-m-d H:i:s'),
				'lastlogintime' => $item->lastLoginAt ? (new \DateTime($item->lastLoginAt))->format('Y-m-d H:i:s') : null,
				'username' => $item->username,
				'email' => $item->email,
				'status' => $item->status,
				'role' => $item->roleTitle
			];
			
			$data['items'][] = $device;
		}
		
		return json_encode($data);
    }

    /**
     * @return string
     */
    public function actionItemListsGet()
    {
		$rolesItems = (new Account())->roles;
		$roles = [];
		foreach ($rolesItems AS $key => $item) {
			$roles[] = ['value' => $key, 'label' => $item];
		}
		return json_encode(['success' => true, 'roleList' => $roles]);
    }

	/**
     * @return string
     */
    public function actionItemGet()
    {
		$data = ['success' => true];
		
		$id = Yii::$app->request->getQueryParam('id', null);
		if ($id !== null) {
			$account = Account::find()->andWhere(['id' => $id])->one();
			if (empty($account)) {
				return json_encode(['success' => false, 'message' => 'Пользователь не найден, возможно он удалён']);
			}
			$fieldsAllow = ['id', 'createdAt', 'lastLoginAt', 'username', 'email', 'status', 'role', 'tz', 'access_token'];
			$item = $account->getAttributes($fieldsAllow);
			
			$data['model'] = $item;
		}
		
		$rolesItems = (new Account())->roles;
		$roles = [];
		foreach ($rolesItems AS $key => $item) {
			$roles[] = ['value' => $key, 'label' => $item];
		}
		$data['roleList'] = $roles;
		
		$tzItems = Yii::$app->params['tz'];
		$tzs = [];
		foreach ($tzItems AS $key => $item) {
			$tzs[] = ['value' => $key, 'label' => $item];
		}
		$data['tzList'] = $tzs;
		
		return json_encode($data);
    }

	/**
     * @return string
     */
    public function actionItemEdit()
    {
		$item = Yii::$app->request->getBodyParam('User');
		if (empty($item) || empty($item['id'])) {
			return json_encode(['success' => false, 'message' => 'Не переданы данные для редактирования Пользователя']);
		}
		
		$user = Account::find()->andWhere(['id' => (int)$item['id']])->one();
		if (empty($user)) {
			return json_encode(['success' => false, 'message' => 'Пользователь не найден, возможно был удалён']);
		}
		
		$oldValues = $user->getAttributes();
		
		$user->setAttributes($item);
		$roles = (new Account())->roles;
		if (isset($item['role']) && isset($roles[$item['role']])) {
			$user->role = $item['role'];
		}
		if (isset($item['tz']) && isset(Yii::$app->params['tz'][$item['tz']])) {
			$user->tz = $item['tz'];
		}
		$user->status = ($item['status'] == 1 || $item['status'] == 'true') ? 1 : 0;
		
		if (!$user->save(true, ['username', 'email', 'status', 'role', 'tz'])) {
			if (($errors = $user->getFirstErrors())) {
				return json_encode(['success' => false, 'message' => implode('. ', $errors)]);
			}
			return json_encode(['success' => false, 'message' => 'Возникла ошибка при сохранении, попробуйте позже']);
		}
		
		(new \app\models\AccountLog())->createItem($this->user->id, \app\models\AccountLog::NUM_ACCOUNT_EDIT, 
			['id' => $user->id, 'old'=>$oldValues, 'new'=>$user->getAttributes()]);
		
		return json_encode(['success' => true]);
		
    }

	/**
     * @return string
     */
    public function actionItemRemove()
    {
		$id = Yii::$app->request->getBodyParam('id');
		$account = Account::find()->andWhere(['id' => $id])->one();
		
		if ($account) {
			$account->delete();
			(new \app\models\AccountLog())->createItem($this->user->id, \app\models\AccountLog::NUM_ACCOUNT_DELETE, $account->getAttributes());
			return json_encode(['success' => true]);
		}
		return json_encode(['success' => false, 'message' => 'Пользователь в системе не найден']);
    }

	/**
     * @return string
     */
    public function actionToken()
    {
		$account = $this->user;
		
		if ($account && $account->access_token) {
			return json_encode(['success' => true, 'access-token' => $account->access_token]);
			
		} else if ($account) {
			return json_encode(['success' => false, 'message' => 'Необходимо сгенерировать токен в личном кабинете, в Настройках пользователя.']);
		}
		
		return json_encode(['success' => false, 'message' => 'Необходимо авторизоваться в личном кабинете']);
    }
}
