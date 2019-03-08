<?php
/*
 * This file is part of Account.
 *
 * (c) 2014 Nord Software
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use nord\yii\account\Module;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model nord\yii\account\models\LoginForm */

$this->title = Module::t('views', 'Войти');
?>


<div class="wrapper-page">

    <div class="text-center">
        <a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сибирь Телематика</span> </a>
    </div>

    <form id="loginform" class="form-horizontal m-t-20" action="/account/login" method="post" role="form">
        <div class="form-group">
            <div class="col-xs-12">
                <?= Html::activeInput('text', $model, 'email', ['class'=>'form-control', 'placeholder'=>'Эл.почта', 'type'=>'email']) ?>
                <i class="md md-account-circle form-control-feedback l-h-34"></i>
				<?php if ($model->hasErrors('email')) { ?> 
					<div class="error-line">
						<?= Html::encode(implode('. ', $model->getErrors('email'))); ?>
					</div>
				<?php } ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
				<?= Html::activeInput('password', $model, 'password', ['class'=>'form-control', 'placeholder'=>'Пароль']) ?>
                <i class="md md-vpn-key form-control-feedback l-h-34"></i>
				<?php if ($model->hasErrors('password')) { ?> 
					<div class="error-line">
						<?= Html::encode(implode('. ', $model->getErrors('password'))); ?>
					</div>
				<?php } ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="checkbox checkbox-primary">
                    <?= Html::activeInput('checkbox', $model, 'rememberMe', ['placeholder'=>'Пароль', 'id'=>'checkbox-signup']) ?>
                    <label for="checkbox-signup">Запомнить меня</label>
                </div>

            </div>
        </div>

        <div class="form-group text-right m-t-20">
            <div class="col-xs-12">
				<?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
				<?= Html::submitButton(Module::t('views', 'Войти'), ['class' => 'btn btn-primary btn-custom w-md waves-effect waves-light']); ?>
            </div>
        </div>

        <div class="form-group m-t-30">
            <div class="col-sm-7">
                <?= Html::a('<i class="fa fa-lock m-r-5"></i> Забыли пароль?', [Module::URL_ROUTE_FORGOT_PASSWORD], ['class'=>'text-muted']) ?>
            </div>
            <?php if (Module::getInstance()->enableSignup): ?>
            <div class="col-sm-5 text-right">
                <?= Html::a('Зарегистрироваться', [Module::URL_ROUTE_SIGNUP], ['class'=>'text-muted']) ?>
            </div>
            <?php endif; ?>
        </div>
    </form>
</div>