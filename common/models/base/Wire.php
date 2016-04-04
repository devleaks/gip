<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "wire".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property integer $type_id
 * @property string $link
 * @property string $icon
 * @property string $color
 * @property string $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \common\models\Type $type
 */
abstract class Wire extends \yii\db\ActiveRecord
{



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
    public function rules()
    {
        return [
            [['subject', 'type_id'], 'required'],
            [['body'], 'string'],
            [['type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 160],
            [['link'], 'string', 'max' => 200],
            [['icon', 'color', 'status'], 'string', 'max' => 40]
        ];
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
            'type_id' => Yii::t('gip', 'Type'),
            'link' => Yii::t('gip', 'Link'),
            'icon' => Yii::t('gip', 'Icon'),
            'color' => Yii::t('gip', 'Color'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                'timestamp' => [
                        'class' => TimestampBehavior::className(),
                        'attributes' => [
							ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
							ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                        ],
                        'value' => function() { return 'NOW()'; }, // mysql function
                ],
                'blameable' => [
                        'class' => BlameableBehavior::className(),
                        'attributes' => [
							ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
							ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                        ],
                        'value' => null,
                ],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }




}
