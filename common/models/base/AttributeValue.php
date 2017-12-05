<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "attribute_value".
 *
 * @property integer $id
 * @property integer $attribute_id
 * @property integer $entity_id
 * @property string $entity_type
 * @property string $value_text
 * @property string $value_number
 * @property string $value_date
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Attribute $attribute
 */
abstract class AttributeValue extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_attribute_id', 'entity_id', 'entity_type'], 'required'],
            [['entity_attribute_id', 'entity_id', 'created_by', 'updated_by'], 'integer'],
            [['value_number'], 'number'],
            [['value_date', 'created_at', 'updated_at'], 'safe'],
            [['entity_type'], 'string', 'max' => 200],
            [['value_text'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
        	'entity_attribute_id' => Yii::t('gip', 'Entity Type Attribute'),
            'entity_id' => Yii::t('gip', 'Entity'),
            'entity_type' => Yii::t('gip', 'Entity Type'),
            'value_text' => Yii::t('gip', 'Value Text'),
            'value_number' => Yii::t('gip', 'Value Number'),
            'value_date' => Yii::t('gip', 'Value Date'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityAttribute()
    {
        return $this->hasOne(\common\models\EntityAttribute::className(), ['id' => 'entity_attribute_id']);
    }




}
