<?php

namespace common\models;

use Yii;
use \common\models\base\ToolGroup as BaseToolGroup;

/**
 * This is the model class for table "tool_group".
 */
class ToolGroup extends BaseToolGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'type_id'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'type_id' => Yii::t('gip', 'Type'),
        ];
    }

	
	public function getTools() {
		if($this->type_id != '') {
			return Tool::find()->where(['type_id' => $this->type_id]);
		} else {
		    return $this->hasMany(Tool::className(), ['id' => 'tool_id'])->viaTable('tool_tool_group', ['tool_group_id' => 'id']);
		}
	}
	
	public function add($tool) {
		if(! ToolToolGroup::findOne(['tool_group_id' => $this->id, 'tool_id' => $tool->id]) ) {
			$ddg = new ToolToolGroup([
				'tool_id' => $tool->id,
				'tool_group_id' => $this->id,
			]);
			$ddg->save();
			//Yii::trace('errors '.print_r($model->errors, true), 'ToolGroup::add');
		}
		return false;
	}

	public function remove($tool) {
		if($ddg = ToolToolGroup::findOne(['tool_group_id' => $this->id, 'tool_id' => $tool->id])) {
			return $ddg->delete();
		}
		return false;
	}
	
}
