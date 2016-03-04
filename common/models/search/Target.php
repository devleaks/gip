<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Target as TargetModel;

/**
 * Target represents the model behind the search form about `common\models\Target`.
 */
class Target extends TargetModel
{
    public function rules()
    {
        return [
            [['id', 'provider_type_id', 'input_event_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TargetModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'provider_type_id' => $this->provider_type_id,
            'input_event_id' => $this->input_event_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataTarget;
    }
}
