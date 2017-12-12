<?php

namespace common\widgets;

use \dosamigos\leaflet\LeafLet;
use \dosamigos\leaflet\LeafLetAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class PreparedMap extends \dosamigos\leaflet\widgets\Map
{
    /**
     * Register the script for the map to be rendered according to the configurations on the LeafLet
     * component.
     */
    public function registerScript()
    {
        $view = $this->getView();

        LeafLetAsset::register($view);
        $this->leafLet->getPlugins()->registerAssetBundles($view);

        $id = $this->options['id'];
        $name = $this->leafLet->name;
        $js = $this->leafLet->getJs();

        $clientOptions = $this->leafLet->clientOptions;

        // for map load event to fire, we have to postpone setting view, until events are bound
        // see https://github.com/Leaflet/Leaflet/issues/3560
        $lateInitClientOptions['center'] = Json::encode($clientOptions['center']);
        $lateInitClientOptions['zoom'] = $clientOptions['zoom'];
        if (isset($clientOptions['bounds'])) {
            $lateInitClientOptions['bounds'] = $clientOptions['bounds'];
            unset($clientOptions['bounds']);
        }
        unset($clientOptions['center']);
        unset($clientOptions['zoom']);

        $options = empty($clientOptions) ? '{}' : Json::encode($clientOptions, LeafLet::JSON_OPTIONS);
	    array_unshift($js, 	'L.Oscars.Util.prepareMap(map, {'
				.'id: "'.$id.'",'
				.'layerControlOptions: { useGrouped: true, groupCheckboxes: true, collapsed: false },'
				.'center: '.$lateInitClientOptions['center'].','
				.'zoom: '.$lateInitClientOptions['zoom'].','
				.'});');
        array_unshift($js, "var $name = L.map('$id', $options);");
        if ($this->leafLet->getTileLayer() !== null) {
            $js[] = $this->leafLet->getTileLayer()->encode();
        }

        $clientEvents = $this->leafLet->clientEvents;

        if (!empty($clientEvents)) {
            foreach ($clientEvents as $event => $handler) {
                $js[] = "$name.on('$event', $handler);";
            }
        }

        if (isset($lateInitClientOptions['bounds'])) {
            $js[] = "$name.fitBounds({$lateInitClientOptions['bounds']});";
        } else {
            $js[] = "$name.setView({$lateInitClientOptions['center']}, {$lateInitClientOptions['zoom']});";
        }

        $view->registerJs("function {$name}_init(){\n" . implode("\n", $js) . "}\n{$name}_init();");
    }
}
