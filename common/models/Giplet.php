<?php

namespace common\models;

use common\behaviors\AttributeValue;
use common\behaviors\Constant;

use Yii;
use \common\models\base\Giplet as BaseGiplet;

/**
 * This is the model class for table "giplet".
 */
class Giplet extends BaseGiplet
{
	use \common\behaviors\ListAll;
	use AttributeValue;
	use Constant;

	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	

	/**
	 * returns associative array of status, color for all possible status values
	 * Bootstrap colors are: default  primary  success  info  warning  danger
	 *
	 * @param $what Attribute to get color for.
	 *
	 * @return array()
	 */
	public static function getLabelColors($what) {
		$colors = [];
		switch($what) {
			case 'status':
				$colors = [
					self::STATUS_ENABLED => 'success',
					self::STATUS_DISABLED => 'warning',
				];
				break;
		}
		return $colors;
	}
	
	/**
	 * returns type of current instance
	 *
	 * @return string
	 */
	public function getType() {
		return $this->gipletType;
	}
}
