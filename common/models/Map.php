<?php

namespace common\models;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;

use Yii;
use \common\models\base\Map as BaseMap;

/**
 * This is the model class for table "map".
 */
class Map extends BaseMap
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayers()
    {
	    return $this->hasMany(Layer::className(), ['id' => 'layer_id'])->viaTable(MapLayer::tableName(), ['map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolGroups()
    {
	    return $this->hasMany(ToolGroup::className(), ['id' => 'tool_group_id'])->viaTable(MapToolGroup::tableName(), ['map_id' => 'id']);
    }


	public function getLeaflet() {
		$layers = [];

		foreach($this->getLayers()->each() as $layer) {
			$factory = $layer->getFactory();		
			$layers[] = $factory->getRepresentation();
		}

		// The Tile Layer (very important)
		$layers[] = new TileLayer([
			'urlTemplate' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		    'clientOptions' => [
		        'attribution' => '<a href="http://openstreetmap.org">OpenStreetMap</a>',
		    ],
		]);

		// now our component and we are going to configure it
		$center = new LatLng(['lat' => 50.639, 'lng' => 5.450]);
		$leaflet = new LeafLet([
		    'center' => $center, // set the center
		]);
		
		foreach($layers as $layer) {
			$leaflet->addLayer($layer);
		}
		
		return $leaflet;
	}

}
