<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class RandomChartAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';

    public $css = [
    ];

    public $js = [
		'js/socket.io.js',
    ];

    public $depends = [
    ];
}
