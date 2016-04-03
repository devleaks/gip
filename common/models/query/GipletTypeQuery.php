<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\GipletType]].
 *
 * @see \common\models\query\GipletType
 */
class GipletTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\GipletType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GipletType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}