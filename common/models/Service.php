<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\Service as BaseService;

/**
 * This is the model class for table "service".
 */
class Service extends BaseService
{
	use \common\behaviors\ListAll;
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
	
}
