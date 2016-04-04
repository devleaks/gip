<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Dashboard $searchModel
 */

$this->title = Yii::t('gip', 'Dashboards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

        	'display_name',
            'description',

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{render}',
                'buttons' => [
                	'render' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-picture"></span>',
											Yii::$app->urlManager->createUrl(['/dashboard/view','id' => $model->id]),
											['title' => Yii::t('yii', 'Render')]
									);
								}
                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
