<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "entity_attribute".
 *
 * @property integer $id
 * @property integer $attribute_id
 * @property integer $entity_id
 * @property string $entity_type
 * @property string $description
 * @property integer $position
 * @property integer $mandatory
 * @property string $default_value
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property \common\models\Attribute $attribute
 */
abstract class EntityAttribute extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'entity_id', 'entity_type'], 'required'],
            [['attribute_id', 'entity_id', 'position', 'mandatory', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['entity_type'], 'string', 'max' => 200],
            [['description', 'default_value'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'attribute_id' => Yii::t('gip', 'Attribute'),
            'entity_id' => Yii::t('gip', 'Entity'),
            'entity_type' => Yii::t('gip', 'Entity Type'),
            'description' => Yii::t('gip', 'Description'),
            'position' => Yii::t('gip', 'Position'),
            'mandatory' => Yii::t('gip', 'Mandatory'),
            'default_value' => Yii::t('gip', 'Default Value'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityAttribute()
    {
        return $this->hasOne(\common\models\Attribute::className(), ['id' => 'attribute_id']);
    }




}
