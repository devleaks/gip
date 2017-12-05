<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Style as StyleModel;

/**
 * Style represents the model behind the search form about `common\models\Style`.
 */
class Style extends StyleModel
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'display_name', 'description', 'created_at', 'updated_at', 'fontname', 'glyph', 'stroke_width', 'stroke_style', 'stroke_color', 'fill_pattern', 'fill_color'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StyleModel::find();

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
            'stroke_width' => $this->stroke_width,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'fontname', $this->fontname])
            ->andFilterWhere(['like', 'glyph', $this->glyph])
            ->andFilterWhere(['like', 'stroke_style', $this->stroke_style])
            ->andFilterWhere(['like', 'stroke_color', $this->stroke_color])
            ->andFilterWhere(['like', 'fill_pattern', $this->fill_pattern])
            ->andFilterWhere(['like', 'fill_color', $this->fill_color]);

        return $dataProvider;
    }
}
