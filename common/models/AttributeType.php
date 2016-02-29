<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\AttributeType as BaseAttributeType;

/**
 * This is the model class for table "attribute_type".
 */
class AttributeType extends BaseAttributeType
{
	use Constant;
	
	const DATA_TYPE_STRING  = 'String';
	const DATA_TYPE_NUMBER  = 'Number';
	const DATA_TYPE_FLOAT   = 'Float';
	const DATA_TYPE_DOUBLE  = 'Double';
	const DATA_TYPE_INTEGER = 'Int';
	const DATA_TYPE_DATE    = 'Date';
	const DATA_TYPE_TIME    = 'Time';
	const DATA_TYPE_DATETIME = 'DateTime';
	const DATA_TYPE_TIMESTAMP = 'DateTime';
	const DATA_TYPE_OBJECT  = 'Object';
	const DATA_TYPE_PAYLOAD = 'Payload';


}
