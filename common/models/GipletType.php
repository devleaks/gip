<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\GipletType as BaseGipletType;

/**
 * This is the model class for table "giplet_type".
 */
class GipletType extends BaseGipletType
{
	use Attribute;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'display_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name', 'element_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['factory'], 'string', 'max' => 80],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }
	
}
