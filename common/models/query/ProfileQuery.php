<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\Profile]].
 *
 * @see \common\models\query\Profile
 */
class ProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\Profile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Profile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
