<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\ProviderType as BaseProviderType;

/**
 * This is the model class for table "channel_type::DIRECTION_IN".
 */
class ProviderType extends ChannelType
{
	use Attribute;

	const DIRECTION = ChannelType::DIRECTION_IN;	

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
