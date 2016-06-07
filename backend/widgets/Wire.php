<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use backend\assets\WireAsset;
use kartik\daterange\MomentAsset;

use common\models\search\Wire as WireSearch;

use Yii;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Widget;

class Wire extends Giplet {
	/** number of recent message to display */
	public $wire_count = 10;
	
	/** text excerpt length */
	public $words = 50;
	
	/** retricted to show only wires with this status */
	public $statuses = null;
	
	/** top element identifier */
	public $id = null;
	
	/** whether to start listening on websocket */
	public $live = false;
	
	/** */
	public $repeat = 120; // minutes
	
	/** */
	public $last;
	
	
	public function init() {
		parent::init();
		if($this->live) {
			$this->registerAssets();
		}
	}
	
	public function run() {		
        $searchModel = new WireSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		if($this->statuses) {
			$dataProvider->query->andWhere(['status' => $this->statuses]);
		}
		if(intval($this->wire_count) > 0) {
			$dataProvider->query->limit(intval($this->wire_count));
		}

        return $this->render('wire', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
			'id' => $this->id ? $this->id : 'the-wire',
			'widget' => $this
        ]);
	}

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
		MomentAsset::register($view);
        WireAsset::register($view);
    }

}