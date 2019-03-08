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

/* @var $this yii\web\View */

$this->title = Module::t('views', 'Успешная регистрация');
?>

<div class="wrapper-page">
	<div class="text-center">
		<a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сибирь Телематика</span> </a>
	</div>
	<div class="card-box m-t-20">
		<div class="text-center">
			<h4 class="text-uppercase font-bold m-b-0">Учётная запись создана!</h4>
		</div>
		<div class="text-center">
			<img src="/images/mail_confirm.png" alt="img" class="thumb-lg m-t-20 center-block">
			<p class="text-muted font-13 m-t-20"><b>Последний шаг, активация аккаунта.</b> <br>На указанный адрес электронной почты отправлено сообщение со ссылкой. Перейдите по этой ссылке для активации учётной записи.</p>
		</div>
	</div>
</div>