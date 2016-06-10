<?php

use common\models\Type;
use common\models\Wire;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\icons\Icon;
use insolita\iconpicker\Iconpicker;
use devgroup\jsoneditor\Jsoneditor;

/**
 * @var yii\web\View $this
 * @var common\models\Wire $model
 */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Wires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


function indent($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element,
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}

?>
<div class="wire-view">

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
			'subject',
            [
				'attribute' => 'body',
            	'type'=> DetailView::INPUT_TEXTAREA,
				'options' => ['rows' => 10],
			],
            [
				'attribute' => 'payload',
            	'type'=> DetailView::INPUT_WIDGET,
				'format' => 'raw',
				'value' => '<pre>'.indent($model->payload).'</pre>',
				'widgetOptions' => [
					'class' => Jsoneditor::className(),
					'options' => [
				        'editorOptions' => [
				            'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
				            'mode' => 'tree', // current mode
				        ],
						'attribute' => 'payload',
				        'options' => [], // html options
				    ],
				],
			],
           	'link',
            [
				'attribute' => 'source_id',
				'items' => Type::forClass(Wire::className().':source'),
            	'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'value' => $model->type ? $model->type->display_name : '',
			],
           	[
				'attribute' => 'type_id',
				'items' => Type::forClass(Wire::className().':type'),
           		'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'value' => $model->type ? $model->type->display_name : '',
			],
			'channel',
           	'priority',
            [
				'attribute' => 'icon',
				'value' => Icon::show(str_replace('fa-', '', $model->icon)),
				'format' => 'raw',
            	'type'=> DetailView::INPUT_WIDGET,
				'widgetOptions' => [
					'class' => Iconpicker::className(),
					'iconset'=> 'fontawesome',
				],
			],
			[
                'attribute' => 'color', 
                'format' => 'raw', 
                'value' => "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" . $model->color . '</code>',
                'type'=> DetailView::INPUT_COLOR,
                'valueColOptions' => ['style'=>'width:30%'], 
            ],
           	'tags',
            [
                'attribute'=>'expired_at',
				'format' => 'datetime',
				'type' => DetailView::INPUT_DATETIME,
				'widgetOptions' => [
					'pluginOptions' => [
	                	'format' => 'yyyy-mm-dd hh:ii:ss',
	                	'todayHighlight' => true
	            	]
				],
				'value' => $model->expired_at ? new DateTime($model->expired_at) : '',
            ],
            [
				'attribute' => 'status',
        		'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'items' => Wire::getLocalizedConstants('STATUS_'),
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
