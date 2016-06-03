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
 * @property string $payload
 * @property integer $source_id
 * @property integer $type_id
 * @property integer $channel
 * @property integer $priority
 * @property string $icon
 * @property string $color
 * @property string $tags
 * @property string $note
 * @property string $status
 * @property string $ack_at
 * @property string $expired_at
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
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
            [['subject', 'source_id', 'type_id'], 'required'],
            [['body', 'payload'], 'string'],
            [['source_id', 'type_id', 'channel', 'priority', 'created_by', 'updated_by'], 'integer'],
            [['ack_at', 'expired_at', 'created_at', 'updated_at'], 'safe'],
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
            'payload' => Yii::t('gip', 'Payload'),
            'source_id' => Yii::t('gip', 'Source ID'),
            'type_id' => Yii::t('gip', 'Type ID'),
            'channel' => Yii::t('gip', 'Channel'),
            'priority' => Yii::t('gip', 'Priority'),
            'icon' => Yii::t('gip', 'Icon'),
            'color' => Yii::t('gip', 'Color'),
            'tags' => Yii::t('gip', 'Tags'),
            'note' => Yii::t('gip', 'Note'),
            'status' => Yii::t('gip', 'Status'),
            'ack_at' => Yii::t('gip', 'Ack At'),
            'expired_at' => Yii::t('gip', 'Expired At'),
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
