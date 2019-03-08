<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Сибирь Телематика';

$user = $this->context->user;

?>

<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<ol class="breadcrumb pull-right">
				<li><a href="/dashboard.html">Рабочий стол</a></li>
				<li class="active">Пользователь</li>
			</ol>
			<h4 class="page-title">Личный кабинет</h4>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box">
			<h4 class="text-dark header-title m-t-0 m-b-15">Информация</h4>
			<div class="row">
				<div class="col-lg-6">
					<form action="#" class="form-horizontal editor-horizontal">
						<div class="form-group">
							<label class="col-sm-5 control-label">Ваше полное имя</label>
							<div class="col-sm-7">
								<a href="#" id="username" data-pk="<?= $user->id ?>"><?= $user->username ?></a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label">Временная зона</label>
							<div class="col-sm-7">
								<a href="#" id="tz" data-pk="<?= $user->id ?>" data-value="<?= $user->tz ?>"></a>
							</div>
						</div>
						<?php if (Yii::$app->user->can('operator')): ?>
						<div class="form-group">
							<label class="col-sm-5 control-label">Токен API</label>
							<div class="col-sm-7">
								<span class="js-access-token"><?= $user->access_token ?></span>
								<a href="#" id="accesstoken" data-pk="<?= $user->id ?>" class="editable editable-click">Создать новый</a>
							</div>
						</div>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	var resizefunc = [];
</script>

<?php
	$this->context->registerJs();

	$this->registerCssFile('/css/pages/account.css');
	
	$this->registerJsFile('/js/pages/jquery.account.js');
	
	$this->registerCssFile('/js/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css');
	$this->registerJsFile('/js/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js');
	
	$this->registerJsFile('/js/jquery.core.js');
	$this->registerJsFile('/js/jquery.app.js');
	
	$tzList = json_encode(Yii::$app->params['tz']);
	
	$csrf = Yii::$app->request->getCsrfToken();
	$this->registerJs(<<<JS
jQuery(document).ready(function($) {
	sibAccount.index.tz = {$tzList};
	sibAccount.index.init();
});
JS
  , $this::POS_END);
