<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\Layer]].
 *
 * @see \common\models\query\Layer
 */
class LayerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\Layer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Layer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}