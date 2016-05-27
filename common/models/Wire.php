<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\Wire as BaseWire;

/**
 * This is the model class for table "wire".
 */
class Wire extends BaseWire
{
	use Constant;
	
	const STATUS_UNREAD		= 'UNREAD';
	const STATUS_ACTIVE		= 'ACTIVE';
	const STATUS_PUBLISHED	= 'PUBLISHED';
	const STATUS_ACKNOWLEDGED = 'ACKNOWLEDGED';
	const STATUS_ARCHIVED	= 'ARCHIVED';

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('gip', 'Wire'),
             'source_id' => Yii::t('gip', 'Source'),
            'type_id' => Yii::t('gip', 'Type'),
        ]);
    }

}