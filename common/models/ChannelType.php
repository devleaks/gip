<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\ChannelType as BaseChannelType;

/**
 * This is the model class for table "channel_type".
 */
class ChannelType extends BaseChannelType
{
	use Constant;

	const DIRECTION_IN  = 'IN';
	const DIRECTION_OUT = 'OUT';
	
	const DIRECTION = null;

    /**
     * @inheritdoc
     */
	public static function instantiate($row)
	{
	    switch ($row['direction']) {
	        case ProviderType::DIRECTION:
	            return new ProviderType();
	        case TargetType::DIRECTION:
	            return new TargetType();
	        default:
	           return new self;
	    }
	}
}
