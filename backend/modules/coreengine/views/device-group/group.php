<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\web\IdentityInterface */
?>
<div class="group-index">

    <div class="col-lg-5">
        <?php
		echo Yii::t('gip', 'Devices not in group');
        echo Html::textInput('search_outgroup', '', ['class' => 'device-search', 'data-target' => 'outgroup']) . '<br>';
        echo Html::listBox('devices', '', $outgroup, [
            'id' => 'outgroup',
            'multiple' => true,
            'size' => 20,
            'style' => 'width:100%']);
        ?>
    </div>
    <div class="col-lg-1">
        &nbsp;<br><br>
        <?php
        echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'add']) . '<br>';
        echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'remove']) . '<br>';
        ?>
    </div>
    <div class="col-lg-5">
        <?php
		echo Yii::t('gip', 'Devices in group');
        echo Html::textInput('search_ingroup', '', ['class' => 'device-search', 'data-target' => 'ingroups']) . '<br>';
        echo Html::listBox('devices', '', $ingroup, [
            'id' => 'ingroups',
            'multiple' => true,
            'size' => 20,
            'style' => 'width:100%']);
        ?>
    </div>
</div>
<?php
$this->render('_groupscript',['id'=>$model->id]);
