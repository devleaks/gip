<?php

namespace common\models;

use Yii;
use \common\models\base\ZoneGroup as BaseZoneGroup;
use backend\models\CaptureImport;

/**
 * This is the model class for table "zone_group".
 */
class ZoneGroup extends BaseZoneGroup
{
	use \common\behaviors\ListAll;


	public function getZones() {
		if($this->type_id != '') {
			return Zone::find()->where(['type_id' => $this->type_id]);
		} else {
		    return $this->hasMany(Zone::className(), ['id' => 'zone_id'])->viaTable('zone_zone_group', ['zone_group_id' => 'id']);
		}
	}
	
	public function add($zone) {
		if(! ZoneZoneGroup::findOne(['zone_group_id' => $this->id, 'zone_id' => $zone->id]) ) {
			$zzg = new ZoneZoneGroup([
				'zone_id' => $zone->id,
				'zone_group_id' => $this->id,
			]);
			$zzg->save();
			Yii::trace('errors '.print_r($zzg->errors, true), 'ZoneGroup::add');
			return true;
		}
		return false;
	}

	public function remove($device) {
		if($zzg = ZoneZoneGroup::findOne(['zone_group_id' => $this->id, 'zone_id' => $device->id])) {
			return $zzg->delete();
		}
		return false;
	}

	public static function fromGeoJson($geojson) {
		if($geojson->type != "FeatureCollection" || count($geojson->features) < 1)
			return null;
		$group = new ZoneGroup();
		$group = CaptureImport::featureAttributes($group, $geojson);

		$group->save();
		$group->refresh();
		foreach($geojson->features as $feature) {
			if(in_array($feature->geometry->type, ["Polygon","MultiPolygon"])) {
				if($zone = Zone::import($feature)) {
					$group->add($zone);
				}
			}
		}
		return $group;
	}
	
	public function toGeoJson() {
		$g = [];
		$g['type'] = 'FeatureCollection';
		$g['properties'] = $this->toArray(['id','name','display_name','description','type_id','status','created_at','updated_at','created_by','updated_by']);;
		$g['features'] = [];
		foreach($this->getZones()->each() as $e) {
			$g['features'][] = $e->toGeoJson();
		}
		return $g;
 	}
	
}
