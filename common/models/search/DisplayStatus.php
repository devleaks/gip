<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DisplayStatus as DisplayStatusModel;

/**
 * DisplayStatus represents the model behind the search form about `common\models\DisplayStatus`.
 */
class DisplayStatus extends DisplayStatusModel
{
    public function rules()
    {
        return [
            [['id', 'display_status_type_id', 'created_by', 'updated_by', 'stroke_width', 'stroke_style'], 'integer'],
            [['name', 'display_name', 'description', 'created_at', 'updated_at', 'style_name', 'marker', 'stroke_color', 'fill_pattern', 'fill_color'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DisplayStatusModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'display_status_type_id' => $this->display_status_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'stroke_width' => $this->stroke_width,
            'stroke_style' => $this->stroke_style,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'style_name', $this->style_name])
            ->andFilterWhere(['like', 'marker', $this->marker])
            ->andFilterWhere(['like', 'stroke_color', $this->stroke_color])
            ->andFilterWhere(['like', 'fill_pattern', $this->fill_pattern])
            ->andFilterWhere(['like', 'fill_color', $this->fill_color]);

        return $dataProvider;
    }
}
