<?php
$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
?>

<div id="<?= $widget_class ?>"
	 class="card gip-indicator style-bright gip-table"
>
	<span class="gip-header"><?= $widget->title ?></span><br/>
	<div class="gip-body" data-gip="value">
		
		<table class="table table-striped no-margin tableSorter">
			<thead>
				<tr>
					<th>Fl.#</th>
					<th>Apt</th>
					<th>Sched</th>
					<th>Est</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//echo json_encode($widget->flights);
				foreach($widget->flights as $flight) {
					$s = '<tr data-gip="flight" data-gip-id="'.$flight['registration'].'">';
					foreach(['flight_number','airport', 'schedule', 'estimated'] as $field) {
						$s .= '<td data-gip="'.$field.'">'.$flight[$field].'</td>';
					}
					$s .= '</tr>';
					echo $s;
				}
				?>
			</tbody>
		</table>
	
	</div><!-- .gip-body -->
	<span class="gip-footer" data-gip="note">LAST UPDATED</span>
	
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$('table.tableSorter').tableSort( {
			sortBy: ['text', 'text', 'numeric', 'numeric'],
			animation: 'slide',
			speed: 500
	} );		
			
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.dashboard.get_payload(msg);
		if(payload.length > 1) {
			$(this).find('tbody tr').remove();
			for (var i = 0; i < payload.length; i++) {
				flight = payload[i];
				var tr = $('<tr>').data('gip-id', flight.registration);
				for (var property in flight) {
					if(property == "registration") continue;
					tr.append( $('<td>').data('gip', property).html(flight[property]) );
				}
				$(this).find('tbody').append(tr);
			}
		} else { // one flight only: remove first in table, add this one at the end
			flight = payload[0];
			var tr = $('<tr>').data('gip-id', flight.registration);
			for (var property in flight) {
				if(property == "registration") continue;
				tr.append( $('<td>').data('gip', property).html(flight[property]) );
			}
			$(this).find('tbody tr:first()').remove();
			$(this).find('tbody').append(tr);
		}
		$.dashboard.last_updated(msg, $(this));
	});
	
	$(selector).click(function() {
		var delayed_time = moment($.dashboard.get_time());
		var what = $(this).find('.gip-header').html().substr(0,1);
		// get scheduled flights (all positive numbers)
		$.post(
			"wire/get-table",
			{
				'around': delayed_time.utc().format('YYYY-MM-DD HH:mm'),
				'what' : what,
				'count': 6
			},
			function (r) {
				var s = JSON.parse(r);
				//console.log(selector, r);
				$(selector).trigger('gip:message', {payload: JSON.stringify(s)});
			}
		);
	});

	/**
	 *	GIP Change Handler: Handle change messages
	 */
	$(selector).on('gip:change', function(event) {
		var payload = event.gip_payload;
		for (var property in payload) {
			$(this).find("[data-gip="+property+"]").html(payload[property]);
		}
	});

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
