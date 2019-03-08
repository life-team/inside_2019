<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = 'Dark shop';

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<!-- Bootstrap core CSS     -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!--  Fonts and icons     -->
	<link type="text/css" href="https://fonts.googleapis.com/css?family=Muli:400,300" rel="stylesheet">
	<link type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="static/css/themify-icons.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body>
	<?php $this->beginBody() ?>
	<script>
		var options = <?= json_encode($options); ?>
	</script>
	<div class="wrapper" id="app"></div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
