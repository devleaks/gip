<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\query\Style]].
 *
 * @see \common\models\query\Style
 */
class StyleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\query\Style[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Style|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}