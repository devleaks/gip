<?php

namespace backend\models;

use common\behaviors\Constant;
use common\models\Device;
use common\models\Zone;
use common\models\DeviceGroup;
use common\models\ZoneGroup;

use Yii;
use yii\base\Model;

/**
 * This is the model class to capture file for upload.
 */
class CaptureImport extends Model
{
	use Constant;
	
	const TYPE_DEVICE = "DEVICE";
	const TYPE_ZONE = "ZONE";
	const TYPE_ALL = "ALL";
	
	public $file;
	public $what;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'js, json, geojson, txt'],
            [['file'], 'required'],
            [['file', 'what'], 'safe'],
            ['what', 'in', 'range' => [
                    self::TYPE_DEVICE,
                    self::TYPE_ZONE,
					self::TYPE_ALL
                ]
			]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => Yii::t('store', 'Filename'),
        	'what' => Yii::t('store', 'Content'),
        ];
    }


	public static function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	

	public static function featureAttributes($model, $feature) {
		if(isset($feature->properties)) {
			$model->name = isset($feature->properties->name) ? $feature->properties->name : CaptureImport::generateRandomString();
			$model->display_name = isset($feature->properties->display_name) ? $feature->properties->display_name : $model->name;

			//$model->status = isset($feature->properties->status) ? $feature->properties->status : null;
			$model->description = isset($feature->properties->description) ? $feature->properties->description : null;
		} else {
			$model->name = CaptureImport::generateRandomString();
			$model->display_name = $model->name;
		}
		if($feature->type != "FeatureCollection")
			$model->geojson = json_encode($feature);
		
		return $model;
	}
	
	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	// return either new object created from GeoJSON or return existing object found by name attribute.
	public static function import($s, $c) {
		return CaptureImport::isJson($s) ? $c::fromGeoJson($s) : $c::findOne(['name' => $s]);
	}
	
	public function doImport() {
		$feedback = 'Feedback: Import: '.$this->what.'. ';
		$content = file_get_contents($this->file->tempName);

		if($geojson = json_decode($content)) {
			if($geojson->type == "FeatureCollection") {  // FeatureCollection
				if($this->what != self::TYPE_ZONE && ($group = DeviceGroup::fromGeoJson($geojson))) {
					$feedback .= 'Imported devices in group '.$group->name.'(';
					foreach($group->getDevices()->each() as $device) {
						$feedback .= $device->name.',';
					}
					$feedback .= ')';
				}
				if($this->what != self::TYPE_DEVICE && ($group = ZoneGroup::fromGeoJson($geojson))) {
					$feedback .= 'Imported zones in group '.$group->name.'(';
					foreach($group->getZones()->each() as $zone) {
						$feedback .= $zone->name.',';
					}
					$feedback .= ')';
				}
			} else if($geojson->type == "Feature") { // Single Feature
				if($this->what != self::TYPE_ZONE && $geojson->geometry->type == "Point") {
					$feature = Device::fromGeoJson($geojson);
					$feedback .= 'Imported device feature '.$feature->name;
				} else if($this->what != self::TYPE_DEVICE && in_array($geojson->geometry->type, ["Polygon","MultiPolygon"])) {
					$feature = Zone::fromGeoJson($geojson);
					$feedback .= 'Imported zone feature '.$feature->name;
				}
			} else if($this->what != self::TYPE_ZONE && $geojson->type == "Point") { // Simple geometry
				$zone = Device::fromGeoJson($geojson);
				$feedback .= 'Imported '.$zone->name;
			} else if($this->what != self::TYPE_DEVICE && in_array($geojson->type, ["Polygon","MultiPolygon"])) {
				$zone = Zone::fromGeoJson($geojson);
				$feedback .= 'Imported '.$zone->name;
			}
		} else {
			$feedback .= 'Cannot JSON decode '.$this->file->name.'.';
		}
		
		return $feedback;
	}
}
