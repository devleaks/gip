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
		//Yii::trace('Group ' . $e['properties']['name'], 'GipLayer::getRepresentation');		
		if(isset($e['features']) && count($e['features']) > 0) {
			$sf = [];
			foreach($e['features'] as $f) {
				//Yii::trace($f['properties']['name'].'...', 'GipLayer::getRepresentation');		
				if($s = $this->style(isset($f['properties']) ? $f['properties'] : null, 'TEST')) {
					$f['properties']['_style'] = $s;
//					Yii::trace($f['properties']['name'].'=styled='/*.json_encode($f, JSON_PRETTY_PRINT)*/, 'GipLayer::getRepresentation');		
				}
				$sf[] = $f;
			}
			$e['features'] = $sf;
		}
		Yii::trace($this->group_name.'='.json_encode($e, JSON_PRETTY_PRINT), 'GipLayer::getRepresentation');		
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
	protected function mapStyle($style) {
		$c = [
			'stroke_color' => "markerColor",
			'stroke_width' => "weight",
			'stroke_color_opacity' => "opacity",
			'fill_color' => "fillColor",
			'fill_color_opacity' => "fillOpacity",
			'glyph' => "markerSymbol",
			'glyph_rotation_offset' => "markerRotationOffset"
		];
		$ret = [];
		foreach(array_keys($c) as $field) {
			if(isset($style[$field])) {
				$ret[$c[$field]] = $style[$field];
			}
		}
		if(isset($ret['markerSymbol'])) {
			$ret['markerSymbol'] = str_replace('fa-', '', $ret['markerSymbol']);
		}
		Yii::trace(json_encode($ret, JSON_PRETTY_PRINT), 'GipLayer::mapStyle');		
		return $ret;
	}

	// cascade style
	protected function trsty($style_arr, $style) {
		if($style) {
			foreach(array_keys($style->attributes) as $a) {
				if(!in_array($a, ['id','created_at','created_by','updated_at','updated_by','name','display_name'])) {
					if(!isset($style_arr[$a]) && $style[$a] != '' && $style[$a] != null) {
						$style_arr[$a] = $style->$a;
					}
				}
			}
		}
		//Yii::trace(json_encode($style_arr, JSON_PRETTY_PRINT), 'GipLayer::trsty');		
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
				Yii::trace($object['name'].' STYLED from display status '.$dspst.'='.json_encode($style, JSON_PRETTY_PRINT), 'GipLayer::style');		
			} else {
				Yii::trace($object['name'].' display status '.$dspst.' not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no display status ', 'GipLayer::style');		
		}

		// get generic style for GIP status
		if(isset($object['status'])) {
			if($t = Type::find()->where(['type_id' => Type::findOne(['name' => $this->modelName.':status'])->id,
										 'name'    => $object['status']])->one()) {
				$style = $this->trsty($style, $t->style);
				Yii::trace($object['name'].' STYLED from status '.$object['status'].'='.json_encode($style, JSON_PRETTY_PRINT), 'GipLayer::style');		
			} else {
				Yii::trace($object['name'].' status '.$object['status'].' not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no status ', 'GipLayer::style');		
		}

		// get generic style for type
		if(isset($object['type'])) {
			if($t = Type::findOne(['name' => $object['type']['name']])) {
				$style = $this->trsty($style, $t->style);
				Yii::trace($object['name'].' STYLED from type '.$object['type']['name'].'='.json_encode($style, JSON_PRETTY_PRINT), 'GipLayer::style');		
			} else {
				Yii::trace($object['name'].' type not found', 'GipLayer::style');		
			}
		} else {
			Yii::trace($object['name'].' no type ', 'GipLayer::style');		
		}

		$ret = $this->mapStyle($style);
		
		return count($ret) > 0 ? $ret : null;
	}
	
}
