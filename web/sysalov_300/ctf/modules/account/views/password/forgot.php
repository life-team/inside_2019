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

$this->title = Module::t('views', 'Восстановление пароля');
?>

<div class="wrapper-page">
	<div class="text-center">
		<a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сеть 868</span> </a>
	</div>
	<form id="forgotpasswordform" class="text-center m-t-20" action="/account/forgotPassword" method="post" role="form">
		<p class="text-muted">Введите адрес электронной почты от аккаунта для восстановления пароля.</p>
		<div class="form-group m-b-0 m-t-30">
			<div class="input-group">
				<?= Html::activeInput('text', $model, 'email', ['class'=>'form-control', 'placeholder'=>'Введите E-Mail', 'type'=>'email']) ?>
                <i class="md md-email form-control-feedback l-h-34" style="left:6px;z-index: 99;"></i>
				<span class="input-group-btn">
					<?= Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
					<?= Html::submitButton(Module::t('views', 'Отправить'), ['class' => 'btn btn-email btn-primary waves-effect waves-light']); ?>
				</span>
			</div>
			<?php if ($model->hasErrors('email')) { ?> 
				<div class="error-line">
					<?= Html::encode(implode('. ', $model->getErrors('email'))); ?>
				</div>
			<?php } ?>
		</div>

	</form>
</div>


<script>
	var resizefunc = [];
</script>

<!-- Main  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>