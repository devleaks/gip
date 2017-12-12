<?php

namespace common\models;

use Yii;
use \common\models\base\AttributeValue as BaseAttributeValue;

/**
 * This is the model class for table "attribute_value".
 */
class AttributeValue extends BaseAttributeValue
{
		const DATA_TYPE_TEXT   = 'text';
		const DATA_TYPE_NUMBER = 'number';
		const DATA_TYPE_DATE   = 'date';

		public $attribute_value;
		
	    /**
	     * @inheritdoc
	     */
	    public function attributeLabels()
	    {
	        return array_merge([
	            'attribute_value' => Yii::t('gip', 'Value'),
	        ], parent::attributeLabels());
	    }
	
		public function getBaseType() {
			if($ea = $this->getEntityAttribute()->one()) {
				if($a = $ea->getEntityAttribute()->one()) {
					if($at = $a->getAttributeType()->one()) {
						//Yii::trace("at:".$at->data_type, 'AttributeValue::getValue');
						if($at->list_of_values_id > 0) { // LoV always stored in value_text, even if number returned
							return AttributeValue::DATA_TYPE_TEXT;
						}
						if(in_array($at->data_type, [AttributeType::DATA_TYPE_INTEGER, AttributeType::DATA_TYPE_NUMBER, AttributeType::DATA_TYPE_BOOLEAN]))
							return AttributeValue::DATA_TYPE_NUMBER;
						else if($at->data_type == AttributeType::DATA_TYPE_DATE) {
							return AttributeValue::DATA_TYPE_DATE;
						}
					}
				}
			}
			return AttributeValue::DATA_TYPE_TEXT;
		}

		public function getValue() {
			//Yii::trace($this->getBaseType(), 'AttributeValue::getValue');		
			switch($this->getBaseType()) {
				case AttributeValue::DATA_TYPE_NUMBER: return $this->value_number; break;
				case AttributeValue::DATA_TYPE_DATE:   return $this->value_date; break;
				default:                               return $this->value_text; break;
			}
			return '';
		}

		public function setValue($value) {
			//Yii::trace($this->getBaseType().'='.$value, 'AttributeValue::setValue');		
			switch($this->getBaseType()) {
				case AttributeValue::DATA_TYPE_NUMBER: $this->value_number = $value; break;
				case AttributeValue::DATA_TYPE_DATE:   $this->value_date = $value; break;
				default:                               $this->value_text = $value; break;
			}
			$this->value_text = $value;
		}

		public function getName() {
			return $this->entityAttribute->entityAttribute->name;
		}

		public function getListOfValues() {
			if($ea = $this->getEntityAttribute()->one()) {
				if($aa = $ea->getEntityAttribute()->one()) {
					if($at = $aa->getAttributeType()->one()) {
						if($lv = $at->getListOfValues()->one()) {
							return $lv->getValues();
						}
					}
				}
			}
			return null;
		}
		
}
