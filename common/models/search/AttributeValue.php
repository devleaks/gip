<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AttributeValue as AttributeValueModel;

/**
 * AttributeValue represents the model behind the search form about `common\models\AttributeValue`.
 */
class AttributeValue extends AttributeValueModel
{
    public function rules()
    {
        return [
            [['id', 'attribute_id', 'entity_id', 'created_by', 'updated_by'], 'integer'],
            [['entity_type', 'value_text', 'value_date', 'created_at', 'updated_at'], 'safe'],
            [['value_number'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AttributeValueModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'attribute_id' => $this->attribute_id,
            'entity_id' => $this->entity_id,
            'value_number' => $this->value_number,
            'value_date' => $this->value_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'entity_type', $this->entity_type])
            ->andFilterWhere(['like', 'value_text', $this->value_text]);

        return $dataProvider;
    }
}
