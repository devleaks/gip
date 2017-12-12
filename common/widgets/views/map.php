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
<div></div>
<?php
	if($widget->leaflet) {
		echo common\widgets\PreparedMap::widget([
			'leafLet' => $widget->leaflet,
			'options' => [
				'style' => 'height: 700px',
				'class' => 'sidebar-map oscars'
			]
		]);
	} else {
		echo "Could not generate Leaflet map.";
	}
 ?>