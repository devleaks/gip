<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wire as WireModel;

/**
 * Wire represents the model behind the search form about `common\models\Wire`.
 */
class Wire extends WireModel
{
    public function rules()
    {
        return [
            [['id', 'type_id', 'created_by', 'updated_by'], 'integer'],
            [['subject', 'body', 'icon', 'color', 'status', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = WireModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
