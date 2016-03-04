<?php

namespace common\models;

use Yii;
use \common\models\base\TargetType as BaseTargetType;

/**
 * This is the model class for table "channel_type::DIRECTION_OUT".
 */
class TargetEvent extends Event
{

	const DIRECTION = ChannelType::DIRECTION_OUT;	

    /**
     * @inheritdoc
     */
	public function init()
	{
	    $this->direction = self::DIRECTION;
	    parent::init();
	}

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new query\ChannelType(get_called_class(), ['direction' => self::DIRECTION]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->direction = self::DIRECTION;
        return parent::beforeSave($insert);
    }
}
