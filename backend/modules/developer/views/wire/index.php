<?php

use common\models\Type;
use common\models\Wire;

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */

$this->title = Yii::t('gip', 'Wires');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
				'attribute' => 'subject',
				'format' => 'raw',
				'value' => function($model, $key, $index, $widget) {
					return '<span>'.$model->subject.'</span>' . ($model->link ? Html::a(' <i class="fa fa-link"></i>', $model->link, ['target' => '_blank']) : '');
				},
			],
            [
				'attribute' => 'source_id',
				'filter' => Type::forClass(Wire::className().':source'),
				'value' => function ($model, $key, $index, $widget) {
							return $model->source ? $model->source->display_name : $model->source_id;
	            		},
			],
            [
				'attribute' => 'type_id',
				'filter' => Type::forClass(Wire::className().':type'),
				'value' => function ($model, $key, $index, $widget) {
							return $model->type ? $model->type->display_name : $model->type_id;
	            		},
			],
			'channel',
	        [
				'attribute' => 'priority',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
	        [
				'attribute' => 'icon',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return Icon::show(str_replace('fa-', '', $model->icon));
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
			[
			    'attribute'=>'color',
			    'value'=>function ($model, $key, $index, $widget) {
			        return $model->color ? "<span class='badge' style='background-color: {$model->color}'> </span>" : '';
			    },
			    'width'=>'8%',
			    'vAlign'=>'middle',
				'hAlign' => GridView::ALIGN_CENTER,
			    'format'=>'raw',
				'filter' => false,
			],
            [
				'attribute' => 'status',
				'filter' => Wire::getLocalizedConstants('STATUS_'),
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{view} {update} {delete} {publish}',
                'buttons' => [
                	'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/wire/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                    ]);
								},
                	'publish-php' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-bullhorn"></span>', Yii::$app->urlManager->createUrl(['developer/wire/publish','id' => $model->id]), [
                                                    'title' => Yii::t('yii', 'Publish with PHP'),
                                    ]);
								},
                	'publish' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-bullhorn"></span>', '#', [
                                                    'title' => Yii::t('yii', 'Publish'),
													'class' => 'publish',
													'data-id' => $model->id
                                    ]);
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info'])
				.' '.Html::a('<i class="glyphicon glyphicon-news"></i> Live Wire', ['/wire'], ['class' => 'btn btn-primary', 'target' => '_blank']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
<script type="text/javascript">
<?php
$this->beginBlock('JS_WIRE_CLI') ?>

$(function(){
    function wsStart() {
        ws = new WebSocket("<?= Yii::$app->params['websocket_server'] ?>");
    }
    wsStart();	

	$('a.publish').click(function() {
		var vid = $(this).data('id');
		var msg = null;
		$.post(
			'/gipadmin/developer/wire/get',
            {
				id: vid
			},
   			function (r) {
				//console.log(r);
				ws.send(r);		
            }
		);
	});
});

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_WIRE_CLI'], yii\web\View::POS_END);