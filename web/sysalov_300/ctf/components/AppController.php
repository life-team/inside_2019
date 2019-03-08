<?php

namespace app\components;

use Yii;
use yii\web\Controller;

class AppController extends Controller
{
	/**
	 * @var string
	 */
    public $defaultAction = 'index';

	/**
	 * @var string
	 */
    public $layout = false;

	/**
	 * @var \nord\yii\account\models\Account
	 */
    public $user;

    /**
     * @inheritdoc
     */
    public function init()
    {
		$webUser = Yii::$app->get('user', false);
		if (!$webUser->isGuest) {
			$this->user = Yii::$app->user->getIdentity();
			
			date_default_timezone_set($this->user->tz);
			Yii::$app->db->createCommand("SET time_zone = '{$this->user->tz}'")->execute();
		}
    }

	/**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
