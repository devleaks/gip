<?php

namespace common\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/maps';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
		'common\assets\MapAsset'
    ];
}
