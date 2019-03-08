<?php

namespace app\modules\account\controllers;

use app\components\PanelController;
use yii\filters\AccessControl;
use Yii;

class DashboardController extends PanelController
{
	/**
     * @var string default action.
     */
    public $defaultAction = 'index';

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
                        'actions' => ['index', 'account-update'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['access-token-update'],
                        'allow' => true,
                        'roles' => ['operator'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Index options
     */
    public function actionIndex()
    {
		return $this->render('index', []);
    }

	/**
     * Index options
     */
    public function actionAccountUpdate()
    {
		$field = Yii::$app->request->post('name');
		$value = Yii::$app->request->post('value');
		
		if (!in_array($field, ['username', 'tz'])) {
			return json_encode(['status' => 'error', 'msg' => 'Редактирование запрещено']);
		}
		if ($field == 'tz' && empty(Yii::$app->params['tz'][$value])) {
			return json_encode(['status' => 'error', 'msg' => 'Неверно указана временная зона']);
		}
		
		$account = \app\modules\account\models\Account::find()->andWhere(['id'=>$this->user->id])->one();
		if (empty($account)) {
			return json_encode(['status' => 'error', 'msg' => 'Пользователь не найден']);
		}
		
		$account->setAttribute($field, $value);
		if (!$account->save(true, [$field])) {
			return json_encode(['status' => 'error', 'msg' => 'Возникла ошибка при сохранении']);
		}
		return json_encode(['success' => true]);
    }
	
	/**
     * Index options
     */
    public function actionAccessTokenUpdate()
    {
		$account = $this->user;
		if (empty($account)) {
			return json_encode(['status' => 'error', 'msg' => 'Пользователь не найден']);
		}
		$account->access_token = sha1(uniqid(implode(':', $this->user->getAttributes()), true));

		if (!$account->save(true, ['access_token'])) {
			return json_encode(['status' => 'error', 'msg' => 'Возникла ошибка при сохранении']);
		}
		
		return json_encode(['token' => $account->access_token]);
    }
}
