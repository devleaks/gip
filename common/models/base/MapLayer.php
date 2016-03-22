<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "map_layer".
 *
 * @property integer $id
 * @property integer $map_id
 * @property integer $layer_id
 * @property integer $position
 * @property string $group
 * @property integer $default
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $aliasModel
 */
abstract class MapLayer extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_layer';
    }

    /**
     * Alias name of table for crud viewsLists all Area models.
     * Change the alias name manual if needed later
     * @return string
     */
    public function getAliasModel($plural=false)
    {
        if($plural){
            return Yii::t('gip', 'MapLayers');
        }else{
            return Yii::t('gip', 'MapLayer');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id', 'layer_id'], 'required'],
            [['map_id', 'layer_id', 'position', 'default', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['group', 'status'], 'string', 'max' => 40],
            [['layer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Layer::className(), 'targetAttribute' => ['layer_id' => 'id']],
            [['map_id'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['map_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'map_id' => Yii::t('gip', 'Map ID'),
            'layer_id' => Yii::t('gip', 'Layer ID'),
            'position' => Yii::t('gip', 'Position'),
            'group' => Yii::t('gip', 'Group'),
            'default' => Yii::t('gip', 'Default'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }


}
