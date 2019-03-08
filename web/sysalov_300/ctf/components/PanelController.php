<?php

namespace app\components;

use Yii;
use yii\web\Controller;

class PanelController extends Controller
{
	/**
	 * @var string
	 */
    public $defaultAction = 'index';

	/**
	 * @var string
	 */
    public $layout = '@app/views/layouts/panel';

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

	/**
     * 
     */
    public function registerJS()
    {
        $this->view->registerJsFile('/js/detect.js');
		$this->view->registerJsFile('/js/fastclick.js');
		$this->view->registerJsFile('/js/jquery.slimscroll.js');
		$this->view->registerJsFile('/js/jquery.blockUI.js');
		$this->view->registerJsFile('/js/waves.js');
		$this->view->registerJsFile('/js/wow.min.js');
    }
}
