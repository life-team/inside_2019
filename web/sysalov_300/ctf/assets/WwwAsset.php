<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WwwAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'/css/bootstrap.min.css'
	];
    public $js = [
		'/js/jquery.min.js',
		'/js/bootstrap.min.js',
	];
    public $jsOptions = [
		'position' => View::POS_BEGIN
	];
    public $depends = [
	];
}
