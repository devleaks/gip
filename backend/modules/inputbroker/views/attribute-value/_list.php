<?php

use common\models\EntityAttribute;

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Attribute $searchModel
 */
?>
<div class="attribute-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'entityAttribute.name',
				'label' => Yii::t('gip', 'Attribute')
			],
			[
				'attribute' => 'entityAttribute.attributeType.name',
				'label' => Yii::t('gip', 'Attribute Type')
			],
            'value_text',
            'value_number',
            'value_date',
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode(Yii::t('gip', 'Attributes')).' </h3>',
            'type'=>'info',
             'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
