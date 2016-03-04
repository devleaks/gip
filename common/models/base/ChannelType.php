<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "channel_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $direction
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Channel[] $channels
 */
abstract class ChannelType extends \yii\db\ActiveRecord
{



    /**
    * ENUM field values
    */
    const DIRECTION_IN = 'IN';
    const DIRECTION_OUT = 'OUT';
    var $enum_labels = false;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'direction'], 'required'],
            [['direction'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            ['direction', 'in', 'range' => [
                    self::DIRECTION_IN,
                    self::DIRECTION_OUT,
                ]
            ]
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
            'description' => Yii::t('gip', 'Description'),
            'direction' => Yii::t('gip', 'Direction'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(\common\models\Channel::className(), ['channel_type_id' => 'id']);
    }




    /**
     * get column direction enum value label
     * @param string $value
     * @return string
     */
    public static function getDirectionValueLabel($value){
        $labels = self::optsDirection();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }

    /**
     * column direction ENUM value labels
     * @return array
     */
    public static function optsDirection()
    {
        return [
            self::DIRECTION_IN => Yii::t('gip', 'In'),
            self::DIRECTION_OUT => Yii::t('gip', 'Out'),
        ];
    }

}
