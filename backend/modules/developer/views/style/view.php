<?php

use common\models\Style;
use common\models\Type;
use common\models\User;

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

use kartik\icons\Icon;
use insolita\iconpicker\Iconpicker;

/**
 * @var yii\web\View $this
 * @var common\models\Style $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Styles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="style-view">

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'name',
            'display_name',
            'description',
            'font_name',
            [
				'attribute' => 'glyph',
				'value' => Icon::show(str_replace('fa-', '', $model->glyph)),
				'format' => 'raw',
				'type' => DetailView::INPUT_WIDGET,
				'widgetOptions' => [
					'class' => Iconpicker::className(),
					'rows' => 6,
					'columns' => 8,
					'iconset'=> 'fontawesome',
					'options'=>['placeholder'=>'Enter Glyph...', 'maxlength'=>40]
				]
			],
	        [
	            'attribute'=>'stroke_style',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+Type::forClass(Style::STROKE_TYPES),
				'value' => (isset($model->stroke_style) && intval($model->stroke_style) > 0)? Type::findOne($model->stroke_style)->display_name : '',
	        ],
            'stroke_width',
            [
				'attribute' => 'stroke_color',
	            'format' => 'raw', 
	            'value' => "<span class='badge' style='background-color: {$model->stroke_color}'> </span>  <code>" . $model->stroke_color . '</code>',
	            'type'=> DetailView::INPUT_COLOR,
	            'valueColOptions' => ['style'=>'width:30%'], 
			],
	        [
	            'attribute'=>'fill_pattern',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+Type::forClass(Style::FILL_PATTERNS),
				'format' => 'raw',
				'value' => '<div class="css_pattern"><div style="width: 40px; height: 40px; float:left; color: '.
					($model->fill_color ? $model->fill_color : '#888888').
					'" class="pattern-swatch '.
					(intval($model->fill_pattern) > 0 ? Type::findOne($model->fill_pattern)->name : '').
					'"></div></div>'.
					'<div style="display: inline-block; margin: 9px;"">'.(intval($model->fill_pattern) > 0 ? Type::findOne($model->fill_pattern)->display_name : '').'</div>'
	        ],
			[
				'attribute' => 'fill_color',
	            'format' => 'raw', 
	            'value' => "<span class='badge' style='background-color: {$model->fill_color}'> </span>  <code>" . $model->fill_color . '</code>',
	            'type'=> DetailView::INPUT_COLOR,
	            'valueColOptions' => ['style'=>'width:30%'], 
			],
            [
                'attribute'=>'created_at',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y HH:MM'],
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y'],
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'created_by',
				'value' => intval($model->created_by) > 0 ? User::findOne($model->created_by)->username : '',
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'updated_by',
				'value' => intval($model->updated_by) > 0 ? User::findOne($model->updated_by)->username : '',
                'displayOnly'=>true,
            ],
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
