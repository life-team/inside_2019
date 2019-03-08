<?php

namespace app\modules\app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use nord\yii\account\Module;
use app\components\AppController;
use app\models\account\Account;
use app\models\referral\ReferralAccount;


/**
 * Default controller for the `app` module
 */
class UserController extends AppController
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
						'actions' => ['login', 'signup', 'activate', 'forgot', 'reset', 'check', 'logout', 'save'],
						'allow' => true,
					],
				],
			]
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionSignup()
	{
		$accountModule = Yii::$app->getModule('account');
		$dataContract = $accountModule->getDataContract();

		$referral = Yii::$app->request->getBodyParam('referral');

		/** @var SignupForm $model */
		$model = $dataContract->createSignupForm(['scenario' => 'default']);

		if ($model->load(Yii::$app->request->post(), 'Account')) {
			if (!$model->signup()) {
				return json_encode(['success' => false, 'messages' => $model->getFirstErrors()]);
			}
			$account = $dataContract->findAccount(['email' => $model->email]);
			$this->sendActivationMail($account);

			$r = false;
			if ($referral !== NULL) {
				$tokenModel = $accountModule->loadToken('referal-link', $referral);

				if ($tokenModel === null) {
					$r = false;
				} else {
					$dataContractReferral = $accountModule->getDataContract();
					$invitingAccount = $dataContractReferral->findAccount($tokenModel['accountId']);
	
					$RA = new ReferralAccount();
					$RA->account_id = $invitingAccount['id'];
					$RA->referral_account_id = $account['id'];
	
					if ($RA->save()) {
						$dataContractReferral->useToken($tokenModel);
						$r = true;
					}
				}
			}
			
			if ($referral !== NULL) {
				return json_encode(['success' => true, 'referral' => $r]);
			} else {
				return json_encode(['success' => true]);
			}
		}
		return json_encode(['success' => false]);
	}

	/**
	 * Displays the 'forgot password' page.
	 *
	 * @return string
	 */
	public function actionForgot()
	{
		
		$accountModule = Yii::$app->getModule('account');
		$dataContract = $accountModule->getDataContract();
		$model = $dataContract->createForgotPasswordForm();
		
		if ($model->load(Yii::$app->request->post(), 'Account') && $model->validate()) {
			$account = $dataContract->findAccount(['email' => $model->email]);

			if (!isset($account)) {
				return json_encode(['success' => false, 'messages' => 'Invalid email address']);
			}

			$this->sendResetPasswordMail($account);
			return json_encode(['success' => true]);
		} else {
			return json_encode(['success' => false]);
		}
	}

	/**
	 * Displays the 'reset password' page.
	 *
	 * @param string $token authentication token.
	 * @return string|\yii\web\Response
	 */
	public function actionReset()
	{
		$token = Yii::$app->request->getBodyParam('token');
		$accountModule = Yii::$app->getModule('account');

		$tokenModel = $accountModule->loadToken(Module::TOKEN_RESET_PASSWORD, $token);

        if (!isset($tokenModel->accountId)) {
            return json_encode(['success' => false, 'messages' => 'Invalid token']);
        }

		$dataContract = $accountModule->getDataContract();

		/** @var PasswordForm $model */
		$model = $dataContract->createPasswordForm(['scenario' => 'change']);
		$model->account = $dataContract->findAccount($tokenModel->accountId);

		if ($model->load(Yii::$app->request->post(), 'Account') && $model->changePassword()) {
			$dataContract->useToken($tokenModel);
			return json_encode(['success' => true]);
		} else {
			return json_encode(['success' => false]);
		}
	}
	

	/**
	 * Displays the 'reset password' page.
	 *
	 * @param string $token authentication token.
	 * @return string|\yii\web\Response
	 */
	public function actionCheck()
	{
		$token = Yii::$app->request->getBodyParam('token');
		$accountModule = Yii::$app->getModule('account');

		$tokenModel = $accountModule->loadToken(Module::TOKEN_RESET_PASSWORD, $token);

        if (!isset($tokenModel->accountId)) {
            return json_encode(['success' => false, 'messages' => 'Invalid token']);
        }else {
            return json_encode(['success' => true]);
        }
	}

	/**
	 * Displays homepage.
	 *
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
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		$accountModule = Yii::$app->getModule('account');
		$dataContract = $accountModule->getDataContract();

		/** @var LoginForm $model */
		$model = $dataContract->createLoginForm();

		if ($model->load(Yii::$app->request->post(), 'Account')) {
			if ($model->login()) {
				$account = $dataContract->findAccount([$accountModule->emailAttribute => $model->email]);
				$authItems = array_keys(Yii::$app->authManager->getChildRoles($account->role));
				$item = $account->getAttributes(['id', 'email', 'username', 'status', 'tz']);
				return json_encode(['success' => true, 'authItems' => $authItems, 'account' => $item]);
			} else {
				return json_encode(['success' => false, 'message' => 'Неправильный адрес электронной почты или пароль']);
			}
		}
		return json_encode(['success' => false]);
	}
	
	/**
	 * Activates an account.
	 *
	 * @return \yii\web\Response
	 */
	public function actionActivate()
	{
		$token = Yii::$app->request->getBodyParam('token');
		$accountModule = Yii::$app->getModule('account');

		$tokenModel = $accountModule->loadToken(Module::TOKEN_ACTIVATE, $token);

		if ($tokenModel === null) {
			return json_encode(['success' => false, 'message' => 'Строка активации не действительна']);
		}

        $dataContract = $accountModule->getDataContract();
		$account = $dataContract->findAccount($tokenModel->accountId);

		if ($account === null) {
			return json_encode(['success' => false, 'message' => 'Аккаунт для активации не найден']);
		}

		$RA = ReferralAccount::find()->where(['referral_account_id' => $account->id])->one();
		if (!empty($RA)) {
			$RA->status = 1;
			$RA->save();
		}

		$dataContract->activateAccount($account);
		$dataContract->useToken($tokenModel);

		return json_encode(['success' => true]);
	}




	/**
	 * Sends an activation email to owner of the given account.
	 *
	 * @param ActiveRecord $account account instance.
	 */
	protected function sendActivationMail($account)
	{
		$accountModule = Yii::$app->getModule('account');
		$token = $accountModule->generateToken(Module::TOKEN_ACTIVATE, $account->id, $account->email);
		$actionUrl = Url::toRoute(['/#/activate/' . $token], true);
		$accountModule->getMailSender()->sendActivationMail([
			'to' => [$account->email],
			'from' => Yii::$app->params['fromEmailAddress'],
			'subject' => Module::t('email', 'Вы успешно зарегистрировались'),
			'data' => ['actionUrl' => $actionUrl]
		]);
	}
	
	/**
	 * Sends a reset password email to owner of the given account.
	 *
	 * @param ActiveRecord $account model instance.
	 */
	protected function sendResetPasswordMail($account)
	{
		$accountModule = Yii::$app->getModule('account');
		$token = $accountModule->generateToken(Module::TOKEN_RESET_PASSWORD, $account->id);
        $actionUrl = Url::toRoute(['/#/reset/' . $token], true);
		$accountModule->getMailSender()->sendResetPasswordMail([
			'to' => [$account->email],
			'from' => $accountModule->getParam(Module::PARAM_FROM_EMAIL_ADDRESS),
			'subject' => Module::t('email', 'Reset Password'),
			'data' => ['actionUrl' => $actionUrl],
		]);
	}
}
