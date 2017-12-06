<?php

namespace common\models;

use common\behaviors\Attribute as AttributeBehavior;

use Yii;
use \common\models\base\LayerType as BaseLayerType;

/**
 * This is the model class for table "layer_type".
 */
class LayerType extends BaseLayerType
{
	use AttributeBehavior;

	const TYPE_BASE = 'base';
	const TYPE_OVERLAY = 'overlay';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'type_id'], 'safe'],
            [['created_by', 'updated_by', 'type_id'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['factory'], 'string', 'max' => 80],
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
            'type_id' => Yii::t('gip', 'Type ID'),
            'created_at' => Yii::t('gip', 'Created At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }

	public static function formatOptions($parameters) {
		return [];
	}

	
}
