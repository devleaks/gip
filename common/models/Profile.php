<?php

namespace common\models;

use Yii;
use \common\models\base\Profile as BaseProfile;

/**
 * This is the model class for table "profile".
 */
class Profile extends BaseProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['bio'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40]
        ]);
    }
	

	
	public function toJson() {
		return $this->toArray(['name','public_email','gravatar_email','gravatar_id','location','website','bio','timezone']);
 	}
	
}
