<?php

namespace common\models;

use Yii;
use \common\models\base\NotificationGroup as BaseNotificationGroup;

/**
 * This is the model class for table "notification_group".
 */
class NotificationGroup extends BaseNotificationGroup
{
	public function getNotifications() {
	    return $this->hasMany(Notification::className(), ['id' => 'notification_id'])->viaTable('notification_notification_group', ['notification_group_id' => 'id']);
	}
	
	public function add($notification) {
		if(! NotificationNotificationGroup::findOne(['notification_group_id' => $this->id, 'notification_id' => $notification->id]) ) {
			$ddg = new NotificationNotificationGroup([
				'notification_id' => $notification->id,
				'notification_group_id' => $this->id,
			]);
			$ddg->save();
			//Yii::trace('errors '.print_r($model->errors, true), 'NotificationGroup::add');
		}
		return false;
	}

	public function remove($notification) {
		if($ddg = NotificationNotificationGroup::findOne(['notification_group_id' => $this->id, 'notification_id' => $notification->id])) {
			return $ddg->delete();
		}
		return false;
	}
}
