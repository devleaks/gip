<?php

namespace common\models\LayerTypes;

use common\models\Type;
use common\models\DisplayStatus;

use Yii;
use yii\base\Component;

/**
 * This is the model base class for layer type representations.
 */
class GipLayer extends Layer
{
	const TYPE_DEVICE = 'DEVICE_GROUP';
	const TYPE_ZONE   = 'ZONE_GROUP';
	
	public $group_type;
	public $group_name;
	public $groupModel;
	public $modelName;
	public $layerModel;

	
	public function init() {
		$parameters = $this->layer->getAttributeValues();
		$this->group_name = $parameters[$this->group_type];
	}
	
	public function getGroup() {
		return ($this->groupModel)::findOne(['name' => $this->group_name]);
	}
	
	public function toGeoJson() {
		$g = $this->getGroup();
		$e = $g->toGeoJson();
		return $e;
	}
	
	public function getRepresentation() {
		$e  = $this->toGeoJson();
		if(isset($e['features']) && count($e['features']) > 0) {
			$sf = [];
			foreach($e['features'] as $f) {
				if($s = $this->style(isset($f['properties']) ? $f['properties'] : null, 'TEST')) {
					$f['properties']['_style'] = $s;
					Yii::trace($f['properties']['name'].'=styled='.json_encode($f, JSON_PRETTY_PRINT), 'GipLayer::getRepresentation');		
				}
			}
		}
		//Yii::trace($this->group_name.'='.json_encode($e, JSON_PRETTY_PRINT), 'GipLayer::getRepresentation');		
		return new $this->layerModel(['data' => $e]);
	}

/* Name correspondance
 * -------------------
Leaflet Style					GIP Style
"markerColor": "rgb(0,0,255)",	stroke_color
"weight": 1,					stroke_width
"opacity": 0.8,					stroke_color(alpha)
"fillColor": "rgb(0,255,0)",	fill_color
"fillOpacity": 0.4,				fill_color(alpha)
"markerSymbol": "plane",		glyph
"markerRotationOffset": -45		glyph_rotation_offset
*/

	// cascade style
	protected function trsty($style_arr, $style) {
		if($style) {
			foreach(array_keys($style->attributes) as $a) {
				if(!isset($style_arr[$a]) && $style_arr[$a] != '' && $style_arr[$a] != null) {
					$style_arr[$a] = $style->$a;
				}
			}
		}
		return $style_arr;
	}
	
	public function style($object, $display_status_name = null) {
		if(! $object) return;

		$style = [];
		
		$g = $this->getGroup();
		
		$dspst = isset($object['display_status']) ? $object['display_status'] : $display_status_name;
		
		// feature is in a group with dedicated display_status_type
		if($g->display_status_type_id > 0 && $dspst) {
			if($ds = DisplayStatus::find()->where(['display_status_type_id' => $g->display_status_type_id,
												   'name' => $dspst])->one()) {
				$style['_templates'] = $g->getDisplayStatusType()->toArray(['text_label','text_popup','text_sidebar','text_link','text_url']);
				$style = $this->trsty($style, $ds->style);
			} else {
				Yii::trace($object['name'].' display status '.$dspst.' not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no display status '.json_encode($object, JSON_PRETTY_PRINT), 'GipLayer::style');		
		}

		// get generic style for GIP status
		if(isset($object['status'])) {
			if($t = Type::find()->where(['type_id' => Type::findOne(['name' => $this->modelName.':status'])->id,
										 'name'    => $object['status']])->one()) {
				$style = $this->trsty($style, $t->style);
			} else {
				Yii::trace($object['name'].' status '.$object['status'].' not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no status '.json_encode($object, JSON_PRETTY_PRINT), 'GipLayer::style');		
		}

		// get generic style for type
		if(isset($object['type'])) {
			if($t = Type::findOne(['name' => $object['type']['name']])) {
				$style = $this->trsty($style, $t->style);
			} else {
				Yii::trace($object['name'].' type not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no type '.json_encode($object, JSON_PRETTY_PRINT), 'GipLayer::style');		
		}


		return count($style) > 0 ? $style : null;
	}
	
}
