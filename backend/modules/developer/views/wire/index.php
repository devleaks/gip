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
					return '<span class="test">'.$model->subject.'</span>' . ($model->link ? Html::a(' <i class="fa fa-link"></i>', $model->link, ['target' => '_blank']) : '');
				},
			],
            [
				'attribute' => 'type_id',
				'filter' => Type::forClass(Wire::className()),
				'value' => function ($model, $key, $index, $widget) {
							return $model->type ? $model->type->name : $model->type_id;
	            		},
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
			        return "<span class='badge' style='background-color: {$model->color}'> </span>";
			    },
			    'width'=>'8%',
			    'vAlign'=>'middle',
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
                	'publish' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-bullhorn"></span>', '#', [
                                                    'title' => Yii::t('yii', 'Publish'),
													'class' => 'publish'
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
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
<script type="text/javascript">
<?php
$this->beginBlock('JS_WIRE_CLI') ?>

$(function(){
    function wsStart() {
        ws = new WebSocket("ws://imac.local:8051/");
    }
    wsStart();	

	$('a.publish').click(function() {
		line = $(this).closest('tr').find('span.test').html();
		ws.send(line);		
		console.log('sent');
	});
});

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_WIRE_CLI'], yii\web\View::POS_END);