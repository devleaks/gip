<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "attribute_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $data_type
 * @property string $data_format
 * @property integer $list_of_values_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $attribute_type_id
 *
 * @property \common\models\Attribute[] $attributes
 * @property \common\models\AttributeType $attributeType
 * @property \common\models\AttributeType[] $attributeTypes
 * @property \common\models\ListOfValues $listOfValues
 */
class AttributeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name', 'data_type'], 'required'],
            [['list_of_values_id', 'created_by', 'updated_by', 'attribute_type_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description', 'data_format'], 'string', 'max' => 200],
            [['data_type'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_type';
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
            'data_type' => Yii::t('gip', 'Data Type'),
            'data_format' => Yii::t('gip', 'Data Format'),
            'list_of_values_id' => Yii::t('gip', 'List Of Values'),
            'attribute_type_id' => Yii::t('gip', 'Attribute Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributesOfType()
    {
        return $this->hasMany(\common\models\Attribute::className(), ['attribute_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(\common\models\AttributeType::className(), ['id' => 'attribute_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypes()
    {
        return $this->hasMany(\common\models\AttributeType::className(), ['attribute_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListOfValues()
    {
        return $this->hasOne(\common\models\ListOfValues::className(), ['id' => 'list_of_values_id']);
    }

/**
     * @inheritdoc
     * @return type mixed
     */ 
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\AttributeTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AttributeTypeQuery(get_called_class());
    }
}
