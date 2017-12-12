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
				if($zone = Zone::fromGeoJson($feature)) {
					$group->add($zone);
				}
			}
		}
		return $group;
	}
	
	public function toGeoJson() {
		$e = [];
		$e['type'] = 'FeatureCollection';
		$e['properties'] = $this->toArray(['name','display_name','description','status','created_at','updated_at']);;

		if($this->type_id > 0) {
			$e['properties']['type'] = Type::findOne($this->type_id)->toJson();
		}
		
		if($this->created_by > 0) {
			$e['properties']['created_by'] = User::findOne($this->created_by)->toJson();
		}
		
		if($this->updated_by > 0) {
			$e['properties']['updated_by'] = User::findOne($this->updated_by)->toJson();
		}
		
		$e['features'] = [];
		foreach($this->getZones()->each() as $z) {
			$f = $z->toGeoJson();
			$f['group_name'] = $this->name;
			$f['group_display_name'] = $this->display_name;
			$e['features'][] = $f;
		}
		return $e;
 	}
	
}
