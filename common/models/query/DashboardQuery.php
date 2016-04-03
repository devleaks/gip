<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\Dashboard]].
 *
 * @see \common\models\query\Dashboard
 */
class DashboardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\Dashboard[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Dashboard|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}