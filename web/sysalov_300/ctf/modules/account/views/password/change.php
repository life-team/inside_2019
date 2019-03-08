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
/* @var $model nord\yii\account\models\ForgotPasswordForm */
/* @var $title string */
/* @var $reason string */
?>


<div class="wrapper-page">

	<div class="text-center">
		<a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сибирь Телематика</span> </a>
	</div>

	<form id="passwordform" class="form-horizontal m-t-20" method="post" role="form">
		<p class="text-muted">Укажите новый пароль для Вашей учётной записи.</p>
		<div class="form-group m-t-30">
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

		<div class="form-group text-right m-t-20">
			<div class="col-xs-12">
				<?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
				<?= Html::submitButton(Module::t('views', 'Сменить'), ['class' => 'btn btn-primary btn-custom waves-effect waves-light w-md']); ?>
			</div>
		</div>

	</form>

</div>
