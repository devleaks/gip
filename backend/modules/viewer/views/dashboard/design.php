<?php

use backend\assets\DashboardDesignAsset;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Dashboard $searchModel
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
DashboardDesignAsset::register($this);

?>
<div class="dashboard-design">
	
	<div id="gipletmodal" class="modal fade">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        <h4 class="modal-title">Add a GIPlet...</h4>
	      </div>
	      <div class="modal-body">
			<table id="giplet-table" class="table">
			  <thead>
			    <th>Display Name</th>
			    <th>Type</th>
			    <th></th>
			  </thead>
			  <tbody>
			  </tbody>
			</table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div id="gridcanvas"><?= $model->layout ?></div>

</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_DASHBOARD_DESIGN') ?>

var GIPLETS = null;

var curr_div = null, curr_giplet = null;

function select_giplet(container, btnElem) {
	curr_div = container;
	$('#gipletmodal').modal('show');
}

function addGipletToTable(rowIndex, record, columns, cellWriter) {
  var str;
  str = '<tr><td>'+record.displayName+'</td><td>'+record.type+'</td>'+
		'<td><button type="button" class="label label-primary add-giplet" data-giplet="'+record.id+'" data-dismiss="modal">Select</button></td></tr>';
  return str;
}

function getGiplet(id) {
	for(var i = 0; i < GIPLETS.length; i++) {
		if(GIPLETS[i]['id'] == id)
			return GIPLETS[i];
	} // else not found:
	return null;
}

function addGiplet() {
	var cTagOpen = '<!--gm-giplet-region-->',
        cTagClose = '<!--/gm-giplet-region-->',
        elem = null,
		gm = $.gridmanager;
    $(('.gm-tools:last'),curr_div)
		.before(elem = $('<div>')
		.addClass('gm-editable-region gm-content-draggable')
		.append('<div class="gm-controls-element"> <a class="gm-move fa fa-arrows" href="#" title="Move"></a> <a class="gm-delete fa fa-times" href="#" title="Delete"></a> </div>'
+'<div class="gm-content"><div id="giplet-'+curr_giplet['name'].toLowerCase()+'" class="giplet"><p>'+curr_giplet['displayName']+' ('+curr_giplet['type']+')</p></div></div>')).before(cTagClose).prev().before(cTagOpen);

	curr_div = null;
	curr_giplet = null;
}
/**
<!--gm-giplet-region-->
<div class="gm-giplet-region gm-content-draggable">
	<div class="gm-controls-element">
	<a class="gm-move fa fa-arrows" href="#" title="Move"></a>
	<a class="gm-delete fa fa-times" href="#" title="Delete"></a>
	</div>
	<div class="gm-content">
		<p>GIPlet Name</p>
	</div>
</div>
<!--gm-giplet-region-->
**/
jQuery(document).ready(function($){
	
	$("#gridcanvas").gridmanager({
	    customControls: {
	        global_col: [{ callback: select_giplet, loc: 'top' , btnLabel: ' Add a GIPlet', iconClass: 'fa fa-plane' }]
	    },
		colSelectEnabled: false,
		editableRegionEnabled: false,
		colCustomClasses: [],
		rowCustomClasses: [],
		remoteURL: 'save-layout?id='+<?=$model->id?>,
	    debug : 1
    });

	$.ajax({
		url: 'get-giplets',
		success: function(data) {
			GIPLETS = JSON.parse(data);
			
			$('#giplet-table').dynatable({
				dataset: {
					records: GIPLETS
				},
				writers: {
				    _rowWriter: addGipletToTable
				},
			});			  
			
			$(".add-giplet").click(function() {
				giplet_id = $(this).data('giplet');
				curr_giplet = getGiplet(giplet_id)
				
				console.log('adding giplet id '+giplet_id);
				console.log(curr_giplet);
				addGiplet();
			});

			console.log(GIPLETS);
		},
		error: function(e) {
			console.log(e);
		}
	});
	
	
	

	
});

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_DASHBOARD_DESIGN'], yii\web\View::POS_READY);
