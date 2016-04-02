<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class MetarAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';

    public $css = [
		'css/metar/metar.css',
    ];

    public $js = [
		'js/parse_metar.js',
    ];

    public $depends = [
    ];
}
