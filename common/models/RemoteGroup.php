<?php

namespace common\models;

use Yii;
use \common\models\base\RemoteGroup as BaseRemoteGroup;

/**
 * This is the model class for table "remote_group".
 */
class RemoteGroup extends BaseRemoteGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'display_name'], 'required'],
            [['type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['schema_name', 'table_name', 'unique_id_column', 'geometry_column'], 'string', 'max' => 80],
            [['where_clause'], 'string', 'max' => 4000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }
	
}
