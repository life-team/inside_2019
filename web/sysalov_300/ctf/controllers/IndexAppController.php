<?php

namespace app\controllers;

use Yii;
use app\components\AppController;

class IndexAppController extends AppController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$data = [];
		
		if (Yii::$app->request->isAjax && empty($this->user)) {
			return json_encode(['success' => false, 'reason'=>'login']);
		}
		
		$account = $this->user ? $this->user->getAttributes(['id', 'email', 'username', 'status', 'tz']) : [];
		
		$authItems = ['guest'];
		if ($this->user) {
			$authItems = array_keys(Yii::$app->authManager->getChildRoles($this->user->role));
		}
		
		$options = [
			'AppAccount' => [
				'name' => 'account',
				'value' => $account,
				'params' => ['module' => 'app']
			],
			'AppAuthItems' => [
				'name' => 'authItems',
				'value' => $authItems,
				'params' => ['module' => 'app']
			]
		];
		
		$data['options'] = $options;
		return $this->render('index', $data);
    }

}
