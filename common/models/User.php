<?php

namespace common\models;

use common\behaviors\Constant;
use common\behaviors\MediaBehavior;

use Yii;

/**
 * User model
 */
class User extends \dektrium\user\models\User
{
	use Constant;
	
	const MAX_IMAGES = 1;
	
	const ROLE_ADMIN = 'admin';
	const ROLE_INTERNAL = 'internal';
	const ROLE_DEVELOPER = 'developer';
	const ROLE_USER = 'user';
	
	public $default_profile_picture = '/gipmedia/default.png';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
				'uploadFile' => [
	                'class' => MediaBehavior::className(),
	                'mediasAttributes' => ['media']
	            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
			parent::rules(),
			[
				// Role
	            [['role'], 'string', 'max' => 255],
				['role', 'default', 'value' => User::ROLE_USER],
        	]
		);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(
			parent::attributeLabels(),
			[
	            'role' => Yii::t('gip', 'Role'),
        	]
		);
    }

    /**
     * @inheritdoc
	 * Note: When we update User, we only update those additional attributes, original attributes from \dektrium\user\models\User
	 *       are updated from Dektrium's UI. Dektrium defines scenarii, so must must override his definition here and at least provide a default.
     */
	function scenarios() {
		return [ 
	    	'default' => ['role'], 
	    ];
	}
	

	public function getProfilePicture() {
		if($this->media)
			if($pic = $this->media[0]->getThumbnailUrl())
				return $pic;
		return $this->default_profile_picture;
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialAccounts()
    {
        return $this->hasMany(\common\models\SocialAccount::className(), ['user_id' => 'id']);
    }

	/**
	 * Checks whether a user has a role.
	 */
	public function isA($roles) {
		return is_array($roles) ? in_array($this->role, $roles) : $this->role == $roles;
	}

	/**
	 * Check whether user is admin role. Added to prevent inclusion of User model where isA(User::ROLE_ADMIN) needed.
	 */
	public function isAdmin() {
		return $this->isA(self::ROLE_ADMIN);
	}
	
	public function toJson() {
		$j = $this->toArray(['username','email','role']);
		$j['profile'] = Profile::findOne($this->id)->toJson();
		if($this->getSocialAccounts()->exists()) {
			$j['profile']['social_accounts'] = [];
			foreach($this->getSocialAccounts()->each() as $sa) {
				$j['profile']['social_accounts'][] = $sa->toJson();
			}
		}
		return $j;
 	}
	

}
