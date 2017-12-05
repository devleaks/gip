<?php
use common\assets\MapAsset;

/**
 * @var yii\web\View $this
 * @var \yii\bootstrap\Widget $widget
 */
MapAsset::register($this);

$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
?>

<div id="<?= $widget_class ?>"
	 class="card card-bordered gip-map"
>
	<div class="sidebar-map <?= $widget->name ?>" id="<?= $widget->id ?>"></div>
</div>
<?php
	if($widget->leaflet) {
		echo \dosamigos\leaflet\widgets\Map::widget(['leafLet' => $widget->leaflet]);
	} else {
		echo "Could not generate Leaflet";
	}
 ?>