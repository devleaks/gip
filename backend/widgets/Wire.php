<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use common\models\search\Wire as WireSearch;

use Yii;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Widget;
use common\models\Message;

class Wire extends Widget {
	/** number of recent message to display */
	public $wire_count = 5;
	
	/** text excerpt length */
	public $words = 50;
	
	public function run() {		
        $searchModel = new WireSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('wire', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
	}

}