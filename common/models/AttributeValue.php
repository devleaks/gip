<?php

namespace common\models;

use Yii;
use \common\models\base\AttributeValue as BaseAttributeValue;

/**
 * This is the model class for table "attribute_value".
 */
class AttributeValue extends BaseAttributeValue
{
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

		public function getValue() {
			if($this->value_date != '') return $this->value_date;
			if($this->value_number != '') return $this->value_number;
			if($this->value_text != '') return $this->value_text;
			return '';
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
