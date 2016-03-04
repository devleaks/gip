<?php

namespace common\models\Query;

use yii\db\ActiveQuery;

class ChannelType extends ActiveQuery
{
    public $direction;

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        if ($this->direction !== null) {
            $this->andWhere(['direction' => $this->direction]);
        }
        return parent::prepare($builder);
    }
}