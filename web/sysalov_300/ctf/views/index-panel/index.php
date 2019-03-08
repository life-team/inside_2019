<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\PanelAsset;

$this->title = 'Сибирь Телематика';

PanelAsset::register($this);
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
 
    <link href="/css/icons.css" rel="stylesheet" type="text/css">
    <link href="/css/components.css" rel="stylesheet" type="text/css">

</head>
<body>
	<?php $this->beginBody() ?>
	<script>
		var options = <?= json_encode($options); ?>
	</script>
	<div id="app"></div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>