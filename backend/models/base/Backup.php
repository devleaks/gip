<?php

namespace backend\models\base;

use Yii;

/**
 * This is the model class for table "backup".
 *
 * @property integer $id
 * @property string $filename
 * @property string $note
 * @property string $status
 * @property string $created_at
 */
class Backup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['filename'], 'string', 'max' => 250],
            [['note'], 'string', 'max' => 160],
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
            'filename' => Yii::t('gip', 'Filename'),
            'note' => Yii::t('gip', 'Note'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
        ];
    }
}
