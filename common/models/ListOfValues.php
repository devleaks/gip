<?php

namespace common\models;

use \common\models\base\ListOfValues as BaseListOfValues;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "list_of_values".
 */
class ListOfValues extends BaseListOfValues
{
	public function getValues() {
		$q = null;
		if($this->table_name != '') {
			$q = new Query();
			$q->select([
				'id' => $this->value_column_name,
				'name' => $this->display_column_name])
			  ->from($this->table_name)
			  ->orderBy($this->display_column_name)
			;
		} else {
		    $q = $this->getLovValues();
		}
		$ret = [];
		foreach($q->each() as $value) {
			$ret[$value['id']] = $value['name'];
		}
		return $ret;
	}
	
}
