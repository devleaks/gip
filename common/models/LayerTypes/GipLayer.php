<?php

namespace common\models\LayerTypes;

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
		//Yii::trace($this->group_name.'='.json_encode($e, JSON_PRETTY_PRINT), 'GipLayer::getRepresentation');		
		return new $this->layerModel(['data' => $e]);
	}
	
	protected function trsty($style_arr, $style) {
		if($style) {
			foreach($style->attributes as $a) {
				if(!isset($style_arr[$a])) {
					$style_arr[$a] = $style->$a;
				}
			}
		}
		return $style_arr;
	}
	
	public function style($object, $display_status_name) {
		$s = null; $style = [];
		
		$g = $this->getGroup();
		
		if($g->display_status_type_id > 0) {
			if($object->type_id > 0 && $object->status && $display_status_name) {
				$s = Style::find()
					->andWhere(['type_id' => $object->type_id])
					->andWhere(['status'  => $object->status])
					->andWhere(['name' => $display_status_name])
					->andWhere(['display_status_type_id' => $g->display_status_type_id])
					->one();
				$style = $this->trsty($style, $s);
			}
			if($object->type_id > 0 && $object->status) {
				$s = Style::find()
					->andWhere(['type_id' => $object->type_id])
					->andWhere(['status'  => $object->status])
					->andWhere(['display_status_type_id' => $g->display_status_type_id])
					->one();
				$style = $this->trsty($style, $s);
			}
			if($object->type_id < 1 && $display_status_name) {
				$s = Style::find()
					->andWhere(['status'  => $object->status])
					->andWhere(['name' => $display_status_name])
					->andWhere(['display_status_type_id' => $g->display_status_type_id])
					->one();
				$style = $this->trsty($style, $s);
			}
			if($object->type_id < 1) {
				$s = Style::find()
					->andWhere(['status'  => $object->status])
					->andWhere(['display_status_type_id' => $g->display_status_type_id])
					->one();
				$style = $this->trsty($style, $s);
			}		
		}

		if($object->type_id > 0 && $object->status && $display_status_name) {
			$s = Style::find()
				->andWhere(['type_id' => $object->type_id])
				->andWhere(['status'  => $object->status])
				->andWhere(['name' => $display_status_name])
				->one();
			$style = $this->trsty($style, $s);
		}
		if($object->type_id > 0 && $object->status) {
			$s = Style::find()
				->andWhere(['type_id' => $object->type_id])
				->andWhere(['status'  => $object->status])
				->one();
			$style = $this->trsty($style, $s);
		}
		if($object->type_id < 1 && $display_status_name) {
			$s = Style::find()
				->andWhere(['status'  => $object->status])
				->andWhere(['name' => $display_status_name])
				->one();
			$style = $this->trsty($style, $s);
		}
		if($object->type_id < 1) {
			$s = Style::find()
				->andWhere(['status'  => $object->status])
				->one();
			$style = $this->trsty($style, $s);
		}

		return $style;
	}
	
}
