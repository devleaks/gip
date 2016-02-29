<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AttributeType as AttributeTypeModel;

/**
 * AttributeType represents the model behind the search form about `common\models\AttributeType`.
 */
class AttributeType extends AttributeTypeModel
{
    public function rules()
    {
        return [
            [['id', 'list_of_values_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'data_type', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AttributeTypeModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'list_of_values_id' => $this->list_of_values_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data_type', $this->data_type])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
