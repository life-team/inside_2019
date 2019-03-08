<?php

namespace app\modules\app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\AppController;
use app\models\referral\ReferralAccount;


/**
 * Default controller for the `app` module
 */
class ReferralController extends AppController
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
						'actions' => ['get-link', 'get-link-items'],
						'allow' => true,
					],
				],
			]
		];
	}

	/**
	 * @return string
	 */
	public function actionGetLink()
	{
		$accountModule = Yii::$app->getModule('account');
		$token = $accountModule->generateToken('referal-link', $this->user->id);
		
		return json_encode(['success' => true, 'item' => $token]);
	}
	/**
	 * @return string
	 */
	public function actionGetLinkItems()
	{
		$sql = <<<SQL
SELECT RA.*, A.email FROM referral_account RA
JOIN `account` A ON A.id = RA.referral_account_id
WHERE RA.account_id = :USERID
SQL;
		$items = Yii::$app->getDb()->createCommand($sql, [':USERID' => $this->user->id])->queryAll();

		return json_encode(['success' => true, 'items' => $items]);
	}

}
