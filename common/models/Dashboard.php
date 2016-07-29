<?php

namespace common\models;

use Yii;
use \common\models\base\Dashboard as BaseDashboard;

/**
 * This is the model class for table "dashboard".
 */
class Dashboard extends BaseDashboard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'display_name'], 'required'],
            [['layout'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }
	
}
