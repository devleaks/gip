<?php

use backend\assets\DashboardDesignAsset;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Dashboard $searchModel
 */

$this->title = $model->display_name . ' — ' . Yii::t('gip', 'Edit Layout');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->display_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('gip', 'Edit Layout');
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

var curr_div = null;

function addGiplet(giplet_id) {
	console.log('adding giplet id '+giplet_id);
	var getGiplet = function(id) {
		for(var i = 0; i < GIPLETS.length; i++) {
			if(GIPLETS[i]['id'] == id)
				return GIPLETS[i];
		} // else not found:
		return null;
	};	
	var giplet = getGiplet(giplet_id);
	if(giplet != null) { // if giplet found		
	    $(('.gm-tools:last'),curr_div)
			.before(elem = $('<div>')
				.addClass('gm-editable-region gm-content-draggable')
				.append( $('<div>').addClass('gm-controls-element')
					.append( $('<a>').addClass('gm-move fa fa-arrows')
						.attr('href', '#')
						.attr('title', 'Move')
					)
					.append( $('<a>').addClass('gm-delete fa fa-times')
						.attr('href', '#')
						.attr('title', 'Delete')
					)
				)
				.append( $('<div>')
					.addClass('gm-content')
					.append(// begin GIPlet markup
						/*
						$('<div>')
							.attr('id', "giplet-"+giplet['name'].toLowerCase()) // should call standard sanitize function
							.data('giplet-name', giplet['name'])
							.data('giplet-type', giplet['typeId'])
							.addClass('giplet')
							.html( $('<p>').html(giplet['displayName']+' ('+giplet['type']+')' ) )
						*/
						$('<div>')
							.addClass('giplet')
							.append( // wrap polymer elements into regular div for gridmanager
							$('<gip-'+giplet['tag']+'>')
								.attr('id', "giplet-"+giplet['name']) // should call standard sanitize function
								.data('giplet-type', giplet['typeId'])
								.html( $('<p>').html(giplet['displayName']+' ('+giplet['type']+')' ) )
						)
					)		// end GIPlet markup
				)
			)
			.before('<!--/gm-editable-region-->')
			.prev()
			.before('<!--gm-editable-region-->');
		curr_div = null;
	}
}


function gridmanager_select_giplet(container, btnElem) { // function must be lower case letter only.
	curr_div = container;
	$('#gipletmodal').modal('show');
}

jQuery(document).ready(function($){
	var gridcanvas = "#gridcanvas";
	
	var gm = $(gridcanvas).gridmanager({
	    customControls: {
	        global_col: [{
				callback: gridmanager_select_giplet,
				btnLabel: ' Add a GIPlet...',
				title: 'Add a GIPlet to this zone',
				iconClass: 'fa fa-plane'
			}]
	    },
		colSelectEnabled: false,
		editableRegionEnabled: true, // must be on to append/remove editing elements
		colCustomClasses: [],
		rowCustomClasses: [],
		remoteURL: 'save-layout?id='+<?=$model->id?>,
	    debug : 1
    }).data('gridmanager');

	$.ajax({
		url: 'get-giplets',
		data: {
			id: <?=$model->id?>
		},
		success: function(data) {
			GIPLETS = JSON.parse(data);
			
			$('#giplet-table').dynatable({
				dataset: {
					records: GIPLETS
				},
				writers: {
				    _rowWriter: function (rowIndex, record, columns, cellWriter) {
						return '<tr><td>'+record.displayName+'</td><td>'+record.type+'</td>'
							  +'<td><button type="button" class="label label-primary add-giplet" data-giplet="'+record.id+'" data-dismiss="modal">Select</button></td></tr>';;
					}
				}
			});			  
			
			$(".add-giplet").click(function() {
				addGiplet($(this).data('giplet'));
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
