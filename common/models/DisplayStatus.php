<?php

namespace common\models;

use Yii;
use \common\models\base\DisplayStatus as BaseDisplayStatus;

/**
 * This is the model class for table "display_status".
 */
class DisplayStatus extends BaseDisplayStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['display_status_type_id', 'name', 'display_name'], 'required'],
            [['display_status_type_id', 'created_by', 'updated_by', 'stroke_width', 'stroke_style'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name', 'style_name', 'marker', 'stroke_color', 'fill_pattern', 'fill_color'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'display_status_type_id' => Yii::t('gip', 'Display Status Type'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
            'style_name' => Yii::t('gip', 'Style Name'),
            'marker' => Yii::t('gip', 'Marker'),
            'stroke_width' => Yii::t('gip', 'Stroke Width'),
            'stroke_style' => Yii::t('gip', 'Stroke Style'),
            'stroke_color' => Yii::t('gip', 'Stroke Color'),
            'fill_pattern' => Yii::t('gip', 'Fill Pattern'),
            'fill_color' => Yii::t('gip', 'Fill Color'),
        ];
    }

	
}
