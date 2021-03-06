<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "list_of_values".
 *
 * @property integer $id
 * @property string $name
 * @property string $data_type
 * @property string $description
 * @property string $table_name
 * @property string $value_column_name
 * @property string $display_column_name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\AttributeType[] $attributeTypes
 * @property \common\models\LovValues $lovValues
 */
abstract class ListOfValues extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'list_of_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'data_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['display_name'], 'string', 'max' => 80],
            [['data_type'], 'string', 'max' => 255],
            [['description', 'table_name'], 'string', 'max' => 200],
            [['value_column_name', 'display_column_name'], 'string', 'max' => 80],
            [['name'], 'unique']
        ];
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
            'data_type' => Yii::t('gip', 'Data Type'),
            'description' => Yii::t('gip', 'Description'),
            'table_name' => Yii::t('gip', 'Table Name'),
            'value_column_name' => Yii::t('gip', 'Value Column Name'),
            'display_column_name' => Yii::t('gip', 'Display Column Name'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypes()
    {
        return $this->hasMany(\common\models\AttributeType::className(), ['list_of_values_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLovValues()
    {
        return $this->hasOne(\common\models\LovValues::className(), ['list_of_values_id' => 'id']);
    }




}
