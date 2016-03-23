<?php
use common\models\User;

use kartik\grid\GridView;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('gip', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="golfer-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> '.Html::encode($this->title).' </h3>',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            	
            'showFooter'=>false
        ],
        'columns' => [
            [
				'attribute' => 'username',
            ],
            'email:email',
            [
				'attribute' => 'role',
				'filter' => User::getLocalizedConstants('ROLE_'),
            ],
            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{view}'
			],
        ],
    ]); ?>

</div>
