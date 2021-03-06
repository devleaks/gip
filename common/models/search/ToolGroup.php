<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ToolGroup as ToolGroupModel;

/**
 * ToolGroup represents the model behind the search form about `common\models\ToolGroup`.
 */
class ToolGroup extends ToolGroupModel
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'type_id'], 'integer'],
            [['name', 'display_name', 'description', 'created_at', 'updated_at', 'display_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ToolGroupModel::find();

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
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'display_name', $this->display_name]);

        return $dataProvider;
    }
}
