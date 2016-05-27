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
            [['id', 'source_id', 'type_id', 'priority', 'created_by', 'updated_by'], 'integer'],
            [['subject', 'body', 'link', 'expired_at', 'icon', 'color', 'note', 'status', 'created_at', 'updated_at', 'tags'], 'safe'],
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
            'source_id' => $this->source_id,
            'type_id' => $this->type_id,
            'priority' => $this->priority,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        return $dataProvider;
    }
}
