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
	
	// Core Types							# Stored in:
	const DATA_TYPE_ARRAY   = 'Array';		# varchar2, clob
	const DATA_TYPE_BOOLEAN = 'Boolean';	# varchar2, number
	const DATA_TYPE_INTEGER = 'Integer';	# number, timestamp?
	const DATA_TYPE_NUMBER  = 'Number';		# number
	const DATA_TYPE_OBJECT  = 'Object';		# varchar2, clob
	const DATA_TYPE_STRING  = 'String';		# varchar2, clob
	const DATA_TYPE_DATE    = 'Date';		# date, datetime, timestamp?

	/** Extra Types / Derived Types
	const DATA_TYPE_FLOAT   = 'Float';
	const DATA_TYPE_DOUBLE  = 'Double';
	const DATA_TYPE_DATE    = 'Date';
	const DATA_TYPE_TIME    = 'Time';
	const DATA_TYPE_DATETIME  = 'DateTime';
	const DATA_TYPE_TIMESTAMP = 'DateTime';
	const DATA_TYPE_PAYLOAD = 'Payload';
	*/
}
