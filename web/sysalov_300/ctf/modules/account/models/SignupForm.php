<?php
/*
 * This file is part of Account.
 *
 * (c) 2014 Nord Software
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\account\models;

use nord\yii\account\Module;
use yii\helpers\ArrayHelper;

class SignupForm extends \nord\yii\account\models\SignupForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var Module $module */
        $module = Module::getInstance();

        /** @var Account $accountClass */
        $accountClass = $module->getClassName(Module::CLASS_ACCOUNT);

        return ArrayHelper::merge(
			\nord\yii\account\models\PasswordForm::rules(),
            [
                [['email', 'username'], 'required'],
				['username', 'string', 'min' => Module::getParam(Module::PARAM_MIN_USERNAME_LENGTH)],
                ['email', 'email'],
                [['email'], 'unique', 'targetClass' => $accountClass],
                [
                    'captcha',
                    'captcha',
                    'captchaAction' => $module->createRoute(Module::URL_ROUTE_CAPTCHA),
                    'on' => 'captcha',
                ],
            ]
        );
    }
}
