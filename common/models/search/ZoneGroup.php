<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZoneGroup as ZoneGroupModel;

/**
 * ZoneGroup represents the model behind the search form about `common\models\ZoneGroup`.
 */
class ZoneGroup extends ZoneGroupModel
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'display_name', 'description', 'zone_group_type', 'schema_name', 'table_name', 'unique_id_column', 'geometry_column', 'where_clause', 'zone_type', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ZoneGroupModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'zone_group_type', $this->zone_group_type])
            ->andFilterWhere(['like', 'schema_name', $this->schema_name])
            ->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'unique_id_column', $this->unique_id_column])
            ->andFilterWhere(['like', 'geometry_column', $this->geometry_column])
            ->andFilterWhere(['like', 'where_clause', $this->where_clause])
            ->andFilterWhere(['like', 'zone_type', $this->zone_type]);

        return $dataProvider;
    }
}
