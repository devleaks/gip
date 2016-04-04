<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $name
 * @property integer $size
 * @property string $type
 * @property integer $related_id
 * @property string $related_class
 * @property string $related_attribute
 * @property string $name_hash
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size', 'related_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'type'], 'string', 'max' => 80],
            [['related_class', 'related_attribute'], 'string', 'max' => 160],
            [['name_hash'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20]
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
            'size' => Yii::t('gip', 'Size'),
            'type' => Yii::t('gip', 'Type'),
            'related_id' => Yii::t('gip', 'Related'),
            'related_class' => Yii::t('gip', 'Related Class'),
            'related_attribute' => Yii::t('gip', 'Related Attribute'),
            'name_hash' => Yii::t('gip', 'Name Hash'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
        ];
    }
}
