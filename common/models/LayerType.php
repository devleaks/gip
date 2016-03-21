<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\LayerType as BaseLayerType;

/**
 * This is the model class for table "layer_type".
 */
class LayerType extends BaseLayerType
{
	use Attribute;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

	
}
