<?php

namespace common\models;

use Yii;
use \common\models\base\Map as BaseMap;

/**
 * This is the model class for table "map".
 */
class Map extends BaseMap
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackgrounds()
    {
	    return $this->hasMany(Background::className(), ['id' => 'background_id'])->viaTable(MapBackground::tableName(), ['map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayers()
    {
	    return $this->hasMany(Layer::className(), ['id' => 'layer_id'])->viaTable(MapLayer::tableName(), ['map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolGroups()
    {
	    return $this->hasMany(ToolGroup::className(), ['id' => 'tool_group_id'])->viaTable(MapToolGroup::tableName(), ['map_id' => 'id']);
    }

}
