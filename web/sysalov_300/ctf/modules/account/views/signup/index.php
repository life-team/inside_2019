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
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model nord\yii\account\models\SignupForm */
/* @var $captchaClass yii\captcha\Captcha */

$this->title = Module::t('views', 'Зарегистрироваться');
?>

<div class="wrapper-page">

	<div class="text-center">
		<a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сибирь Телематика</span> </a>
	</div>

	<form id="loginform" class="form-horizontal m-t-20" action="/account/signup" method="post" role="form">
		<div class="form-group">
			<div class="col-xs-12">
                <?= Html::activeInput('text', $model, 'email', ['class'=>'form-control', 'placeholder'=>'Эл.почта', 'type'=>'email']) ?>
                <i class="md md-email form-control-feedback l-h-34"></i>
				<?php if ($model->hasErrors('email')) { ?> 
					<div class="error-line">
						<?= Html::encode(implode('. ', $model->getErrors('email'))); ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-12">
                <?= Html::activeInput('text', $model, 'username', ['class'=>'form-control', 'placeholder'=>'Контактное имя', 'type'=>'text']) ?>
                <i class="md md-account-circle form-control-feedback l-h-34"></i>
				<?php if ($model->hasErrors('username')) { ?> 
					<div class="error-line">
						<?= Html::encode(implode('. ', $model->getErrors('username'))); ?>
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
                <?= Html::activeInput('password', $model, 'verifyPassword', ['class'=>'form-control', 'placeholder'=>'Повторите пароль']) ?>
                <i class="md md-vpn-key form-control-feedback l-h-34"></i>
				<?php if ($model->hasErrors('verifyPassword')) { ?> 
					<div class="error-line">
						<?= Html::encode(implode('. ', $model->getErrors('verifyPassword'))); ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-12">
				<div class="checkbox checkbox-primary">
					<input id="checkbox-signup" type="checkbox" checked="checked">
					<label for="checkbox-signup">
						Я принимаю все <a href="#">Условия и Соглашения</a>
					</label>
				</div>

			</div>
		</div>

		<div class="form-group text-right m-t-20">
			<div class="col-xs-12">
				<?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
				<?= Html::submitButton(Module::t('views', 'Зарегистрироваться'), ['class' => 'btn btn-primary btn-custom waves-effect waves-light w-md']); ?>
			</div>
		</div>

		<div class="form-group m-t-30">
			<div class="col-sm-12 text-center">
				<?= Html::a('Уже есть аккаунт?', ['/account/auth/login'], ['class'=>'text-muted']) ?>
			</div>
		</div>
	</form>

</div>