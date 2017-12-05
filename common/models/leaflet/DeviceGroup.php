<?php
/**
 * @copyright Copyright (c) 2016-2017
 * @link http://oscars-sa.eu
 */

namespace common\models\leaflet;

use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\layers\Layer;
use yii\helpers\Json;
use yii\web\JsExpression;

class DeviceGroup extends Layer
{
    public $data = [];

    /**
     * Returns the javascript ready code for the object to render
     * @return string|JsExpression
     */
    public function encode()
    {
        $data = Json::encode($this->data, LeafLet::JSON_OPTIONS);
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = "L.Oscars.deviceGroup($data, $options)" . ($map !== null ? ".addTo($map)" : "") . ";";
        if (!empty($name)) {
            $js = "var $name = $js";
        }

        return new JsExpression($js);
    }

}
