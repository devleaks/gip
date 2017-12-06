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
    protected function getLayersOfType($type)
    {
		$tlt = Type::findOne(['name' => LayerType::className()]);
		$blt = Type::findOne(['type_id' => $tlt->id, 'name' => $type]);
	    return $this->hasMany(Layer::className(), ['id' => 'layer_id'])
					->viaTable(MapLayer::tableName(), ['map_id' => 'id'])
					->andWhere(['layer_type_id' => LayerType::find()->where(['type_id' => $blt->id])->select('id')]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseLayers()
    {
		return $this->getLayersOfType(LayerType::TYPE_BASE);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOverlayLayers()
    {
		return $this->getLayersOfType(LayerType::TYPE_OVERLAY);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolGroups()
    {
	    return $this->hasMany(ToolGroup::className(), ['id' => 'tool_group_id'])->viaTable(MapToolGroup::tableName(), ['map_id' => 'id']);
    }


	public function getLeaflet() {
		$layers = []; $c = ''; $first = true;

		$ll = explode(',', $this->center);
		$center = new LatLng(['lat' => $ll[0], 'lng' => $ll[1]]);
		$leaflet = new LeafLet([
		    'center' => $center, // set the center
			'zoom' => $this->zoom
		]);
		$leaflet->appendJs('L.Oscars.Util.prepareMap(map, {"id": "w2"});');

		foreach($this->getBaseLayers()->each() as $layer) {
			//$c .= 'console.log("adding '.$layer->name.'");';
			$factory = $layer->getFactory();		
			$r = $factory->getRepresentation();
			if($first) {
				$leaflet->addLayer($r);
				$first = false;
			}
		}

		foreach($this->getOverlayLayers()->each() as $layer) {
			//$c .= 'console.log("adding '.$layer->name.'");';
			$factory = $layer->getFactory();		
			$r = $factory->getRepresentation();
			$leaflet->addLayer($r);	
		}

		$leaflet->appendJs($c);
		
		return $leaflet;
	}

}
