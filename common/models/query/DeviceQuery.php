<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\Device]].
 *
 * @see \common\models\query\Device
 */
class DeviceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\Device[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Device|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
