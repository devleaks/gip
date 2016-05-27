<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "wire".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property string $link
 * @property integer $source_id
 * @property integer $type_id
 * @property integer $priority
 * @property string $expired_at
 * @property string $icon
 * @property string $color
 * @property string $note
 * @property string $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $tags
 *
 * @property \common\models\Type $source
 * @property \common\models\Type $type
 */
class Wire extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject'], 'required'],
            [['body'], 'string'],
            [['source_id', 'type_id', 'priority', 'created_by', 'updated_by'], 'integer'],
            [['expired_at', 'created_at', 'updated_at'], 'safe'],
            [['subject', 'note'], 'string', 'max' => 160],
            [['link', 'tags'], 'string', 'max' => 400],
            [['icon', 'color', 'status'], 'string', 'max' => 40]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wire';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'subject' => Yii::t('gip', 'Subject'),
            'body' => Yii::t('gip', 'Body'),
            'link' => Yii::t('gip', 'Link'),
            'source_id' => Yii::t('gip', 'Source ID'),
            'type_id' => Yii::t('gip', 'Type ID'),
            'priority' => Yii::t('gip', 'Priority'),
            'expired_at' => Yii::t('gip', 'Expired At'),
            'icon' => Yii::t('gip', 'Icon'),
            'color' => Yii::t('gip', 'Color'),
            'note' => Yii::t('gip', 'Note'),
            'status' => Yii::t('gip', 'Status'),
            'tags' => Yii::t('gip', 'Tags'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }

/**
     * @inheritdoc
     * @return type mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\WireQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WireQuery(get_called_class());
    }
}
