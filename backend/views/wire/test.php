<?php

use common\models\Wire as WireModel;

use backend\widgets\Beacon;
use backend\widgets\Clock;
use backend\widgets\DelayTable;
use backend\widgets\FlightTable;
use backend\widgets\Indicator;
use backend\widgets\Metar;
use backend\widgets\Movement;
use backend\widgets\News;
use backend\widgets\Parking;
use backend\widgets\Wire;

//use backend\assets\WireAsset;
use backend\assets\DashboardAsset;
use backend\assets\GridAsset;

use devleaks\weather\Weather;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

use yii\web\JsExpression;
use yii\bootstrap\Alert;
use yii\helpers\Html;

GridAsset::register($this);
$asset = DashboardAsset::register($this);

// /@50.6231023,4.2940581
// EBLG: 50.63639, 5.44278
$liege = [
	'lat' => 50.63639,
	'lon' => 5.44278
];

$this->title = 'GIP Dashboard';
/** card style colors
.style-accent
.style-accent-bright
.style-accent-dark
.style-accent-light

.style-default
.style-default-bright
.style-default-dark
.style-default-light

.style-primary
.style-primary-bright
.style-primary-dark
.style-primary-light

.style-danger
.style-info
.style-success
.style-warning
**/
?>
<style>
.grid-container {
  position: absolute;
  top: 66px;
  left: 0;
  right: 10px;
  bottom: 0;
  overflow: auto;
}
.grid {
  position: relative;
  height: 100%;
  list-style: none;
  /* Will be modified by the grid jquery lib, depending on the items */
  -webkit-transition: width 0.2s,
                      height 0.2s;
          transition: width 0.2s,
                      height 0.2s;
}
  .grid li {
    position: absolute;
    z-index: 1;
    font-weight: bold;
    line-height: 4em;
    text-align: center;
    cursor: pointer;
    -webkit-transition: top 0.2s,
                        left 0.2s,
                        width 0.2s,
                        height 0.2s,
                        font-size 0.2s,
                        line-height 0.2s;
            transition: top 0.2s,
                        left 0.2s,
                        width 0.2s,
                        height 0.2s,
                        font-size 0.2s,
                        line-height 0.2s;
  }
  .grid li .inner {
    position: absolute;
    background: #fff;
    border: 1px solid #bbb;
    top: 0;
    bottom: 10px;
    left: 10px;
    right: 0;
    -webkit-transition: background 3s;
            transition: background 3s;
  }
  .grid li.changed .inner {
    background: #ffff66;
    -webkit-transition: none;
            transition: none;
  }
  .grid li.ui-draggable-dragging {
    -webkit-transition: none;
            transition: none;
  }
  .grid li.position-highlight {
    -webkit-transition: none;
            transition: none;
  }
    .grid li.position-highlight .inner {
      border: none;
      background: #ccc;
    }
  .grid .controls {
    position: absolute;
    top: 0;
    right: 0;
    float: right;
    font-size: 0.4em;
    font-weight: normal;
    line-height: 1em;
    opacity: 0;
    -webkit-transition: opacity 0.2s;
            transition: opacity 0.2s;
  }
    .grid .controls .resize {
      font-size: 0.6em;
      float: left;
      margin: 5px 5px 0 0;
      padding: 0.3em;
      background: #fafafa;
      color: #444;
      text-decoration: none;
    }
    .grid .controls .resize:hover {
      background: #f1f1f1;
    }
  .grid li:hover .controls {
    opacity: 1;
  }

.header {
  height: 55px;
  border-bottom: 1px solid #ccc;
}
  .header .button {
    float: left;
    width: 40px;
    height: 40px;
    margin: 6px 0 0 10px;
    border: solid 1px #ccc;
    background: #fafafa;
    color: #000;
    font-size: 18px;
    line-height: 40px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
  }
  .header p {
    float: left;
    padding: 14px 0 0 10px;
    font-size: 18px;
    line-height: 18px;
  }
</style>
<div class="grid-container container-fluid">
	
<ul id="grid" class="grid">
	      
<li class="position-highlight" style="display: none;">
	 <div class="inner"></div>
</li>
	    
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>0</div></li>
<li data-w="1" data-h="2" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>1</div></li>
<li data-w="2" data-h="2" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>2</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>3</div></li>
<li data-w="2" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>4</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>5</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>6</div></li>
<li data-w="1" data-h="0" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>7</div></li>
<li data-w="3" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>8</div></li>
<li data-w="2" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>9</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>10</div></li>
<li data-w="2" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>11</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>12</div></li>
<li data-w="2" data-h="0" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>13</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>14</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>15</div></li>
<li data-w="1" data-h="1" ><div class="inner"><div class="controls"><a href="#zoom1" class="resize" data-w="1" data-h="1">1x1</a><a href="#zoom2" class="resize" data-w="2" data-h="1">2x1</a><a href="#zoom3" class="resize" data-w="3" data-h="1">3x1</a><a href="#zoom1" class="resize" data-w="1" data-h="2">1x2</a><a href="#zoom2" class="resize" data-w="2" data-h="2">2x2</a></div>16</div></li>
</ul>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_DASHBOARD') ?>
jQuery(document).ready(function($){
	
	$('#grid').gridList({direction: 'horizontal', lanes: 3}, {handle: 'div.card span.gip-header'});
	
});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_DASHBOARD'], yii\web\View::POS_READY);
