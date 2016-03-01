<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\ProviderType as BaseProviderType;

/**
 * This is the model class for table "provider_type".
 */
class ProviderType extends BaseProviderType
{
	use Attribute;

    /**
     * @return boolean
     */
    public function hasParameters()
    {
		$cnt = $this->getParameters()->count();
		Yii::trace('count '.$cnt, 'ProviderType::hasParameters');
        return $cnt > 0;
    }
}
