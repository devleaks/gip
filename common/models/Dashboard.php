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
     * @return \yii\db\ActiveQuery
     */
    public function getGiplets()
    {
	    return $this->hasMany(Giplet::className(), ['id' => 'giplet_id'])->viaTable(DashboardGiplet::tableName(), ['dashboard_id' => 'id']);
    }

}
