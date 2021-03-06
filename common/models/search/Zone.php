<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Zone as ZoneModel;

/**
 * Zone represents the model behind the search form about `common\models\Zone`.
 */
class Zone extends ZoneModel
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'display_name', 'description', 'zone_type', 'zone_dimension', 'geometry', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ZoneModel::find();

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
            ->andFilterWhere(['like', 'zone_type', $this->zone_type])
            ->andFilterWhere(['like', 'zone_dimension', $this->zone_dimension])
            ->andFilterWhere(['like', 'geometry', $this->geometry]);

        return $dataProvider;
    }
}
