<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\WwwAsset;

WwwAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
 
    <!-- Custom styles for this template -->
    <link href="/css/core.css" rel="stylesheet" type="text/css">
    <link href="/css/icons.css" rel="stylesheet" type="text/css">
    <link href="/css/components.css" rel="stylesheet" type="text/css">
    <link href="/css/pages.css" rel="stylesheet" type="text/css">
    <link href="/css/menu.css" rel="stylesheet" type="text/css">
    <link href="/css/responsive.css" rel="stylesheet" type="text/css">

	<link href="/js/plugins/switchery/switchery.min.css" rel="stylesheet" />
	<link href="/js/plugins/jquery-circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css" />

    <script src="/js/modernizr.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php $this->beginBody() ?>

<!-- Begin page -->
<div id="wrapper">
	<!-- Start content -->
	<div class="content">
		<div class="container"><?= $content ?></div>
		<!-- end container -->
	</div>
	<!-- end content -->
</div>
<!-- END wrapper -->				

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
