<?php
$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
?>

<div id="<?= $widget_class ?>"
	 class="card gip-indicator style-bright gip-table"
>
	<span class="gip-header"><?= $widget->title ?></span><br/>
	<div class="gip-body" data-gip="value">
		
		<table class="table table-striped no-margin">
			<thead>
				<tr>
					<th>Fl.#</th>
					<th>Dest</th>
					<th>Sched</th>
					<th>Est</th>
					<th>Act</th>
					<th>Dly</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//echo json_encode($widget->flights);
				foreach($widget->flights as $flight) {
					$s = '<tr data-gip="flight" data-gip-id="'.$flight['registration'].'">';
					foreach(['flight_number','destination', 'schedule', 'estimated', 'actual', 'delay'] as $field) {
						$s .= '<td data-gip="'.$field.'">'.$flight[$field].'</td>';
					}
					$s .= '</tr>';
					echo $s;
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan=5>Delay Average: </th>
					<th data-gip="delay_avg">0</th>
				</tr>
			</tfoot>						
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
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.parseJSON(msg.body);
		var delay_cnt = 0, delay_avg = 0;
		$(this).find('tbody tr').remove();
		for (var i = 0; i < payload.length; i++) {
			flight = payload[i];
			var tr = $('<tr>').data('gip-id', flight.registration);
			for (var property in flight) {
				if(property == "registration") continue;
				tr.append( $('<td>').data('gip', property).html(flight[property]) );
			}
			delay_avg += parseInt(flight.delay);
			delay_cnt++;
			$(this).find('tbody').append(tr);
		}
		$(this).find('[data-gip="delay_avg"]').html(delay_cnt > 0 ? Math.round(delay_avg/delay_cnt) : 0);
		$(this).find('[data-gip="note"]').html('LAST UPDATED ' + moment().format('HH:mm')+ ' L');
		
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
