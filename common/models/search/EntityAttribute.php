<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EntityAttribute as EntityAttributeModel;

/**
 * EntityAttribute represents the model behind the search form about `common\models\EntityAttribute`.
 */
class EntityAttribute extends EntityAttributeModel
{
    public function rules()
    {
        return [
            [['id', 'attribute_id', 'entity_id', 'position', 'mandatory', 'created_by'], 'integer'],
            [['entity_type', 'description', 'default_value', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EntityAttributeModel::find();

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
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'entity_type', $this->entity_type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'default_value', $this->default_value]);

        return $dataProvider;
    }
}
