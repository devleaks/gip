<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "giplet".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $giplet_type_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $aliasModel
 */
abstract class Giplet extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'giplet';
    }

    /**
     * Alias name of table for crud viewsLists all Area models.
     * Change the alias name manual if needed later
     * @return string
     */
    public function getAliasModel($plural=false)
    {
        if($plural){
            return Yii::t('gip', 'Giplets');
        }else{
            return Yii::t('gip', 'Giplet');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'giplet_type_id'], 'required'],
            [['giplet_type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'status'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['giplet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GipletType::className(), 'targetAttribute' => ['giplet_type_id' => 'id']]
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
            'giplet_type_id' => Yii::t('gip', 'Giplet Type ID'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(
            parent::attributeHints(),
            [
            'id' => Yii::t('gip', 'ID'),
            'name' => Yii::t('gip', 'Name'),
            'description' => Yii::t('gip', 'Description'),
            'giplet_type_id' => Yii::t('gip', 'Giplet Type Id'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
            ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGipletType()
    {
        return $this->hasOne(\common\models\GipletType::className(), ['id' => 'giplet_type_id']);
    }



}
