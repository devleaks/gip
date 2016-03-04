<?php

namespace common\models;

use Yii;
use \common\models\base\Channel as BaseChannel;

/**
 * This is the model class for table "channel".
 */
class Channel extends BaseChannel
{
	const DIRECTION = null;

    /**
     * @inheritdoc
     */
	public static function instantiate($row)
	{
	    switch ($row['direction']) {
	        case Provider::DIRECTION:
	            return new Provider();
	        case Target::DIRECTION:
	            return new Target();
	        default:
	           return new self;
	    }
	}
}
