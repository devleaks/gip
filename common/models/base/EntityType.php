<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "entity_type".
 *
 * @property integer $id
 * @property string $category
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Wire[] $wires
 */
abstract class EntityType extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['category', 'name', 'icon', 'color'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
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
            'category' => Yii::t('gip', 'Category'),
            'name' => Yii::t('gip', 'Name'),
            'description' => Yii::t('gip', 'Description'),
            'icon' => Yii::t('gip', 'Icon'),
            'color' => Yii::t('gip', 'Color'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWires()
    {
        return $this->hasMany(\common\models\Wire::className(), ['type_id' => 'id']);
    }




}