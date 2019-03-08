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

$this->title = Module::t('views', 'Восстановить пароль');
?>

<div class="wrapper-page">
	<div class="text-center">
		<a href="/" class="logo-lg"><i class="md md-equalizer"></i> <span>Сибирь Телематика</span> </a>
	</div>
	<div class="card-box m-t-20">
		<div class="text-center">
			<h4 class="text-uppercase font-bold m-b-0">Восстановление пароля!</h4>
		</div>
		<div class="text-center">
			<img src="/images/mail_confirm.png" alt="img" class="thumb-lg m-t-20 center-block">
			<p class="text-muted font-13 m-t-20"><b>На адрес эл.почты выслана инструкция!</b> <br>Для восстановления пароля перейдите по ссылке указанной в письме.</p>
		</div>
	</div>
</div>