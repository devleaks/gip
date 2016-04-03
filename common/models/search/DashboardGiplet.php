<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DashboardGiplet as DashboardGipletModel;

/**
 * DashboardGiplet represents the model behind the search form about `common\models\DashboardGiplet`.
 */
class DashboardGiplet extends DashboardGipletModel
{
    public function rules()
    {
        return [
            [['id', 'dashboard_id', 'giplet_id', 'row_number', 'position', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DashboardGipletModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'dashboard_id' => $this->dashboard_id,
            'giplet_id' => $this->giplet_id,
            'row_number' => $this->row_number,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
