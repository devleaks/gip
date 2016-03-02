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


		public function getListOfValues() {
			if($ea = $this->getEntityAttribute()->one()) {
				if($at = $ea->getAttributeType()->one()) {
					if($lv = $at->getListOfValues()->one()) {
						return $lv->getValues();
					}
				}
			}
			return null;
		}
		
}
