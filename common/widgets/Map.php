<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace common\widgets;

use Yii;
use yii\bootstrap\Widget;

use common\models\Map as BaseMap;
use common\assets\MapAsset;

class Map extends Giplet {
	public $leaflet = null;
	
	public function init() {
		parent::init();
		$this->registerAssets();
	}
	
	public function run() {
		$this->id = $this->id ? $this->id : 'map';
		if($map = BaseMap::findOne(['display_name'=>$this->data['MAP']])) {
			$this->leaflet = $map->getLeaflet();
		}
		
        return $this->render('map', [
			'id' => $this->id,
			'widget' => $this
        ]);
	}

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        MapAsset::register($view);
    }

}