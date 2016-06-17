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
					<th>Reason</th>
					<th>Delay&nbsp;(min.)</th>
					<th>Delay&nbsp;(%)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//echo json_encode($widget->flights);
				foreach($widget->delays as $delay) {
					$s = '<tr data-gip="delay" data-gip-id="'.$delay['code'].'">';
					foreach(['reason','time','percent'] as $field) {
						$s .= '<td data-gip="'.$field.'">'.$delay[$field].'</td>';
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
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.dashboard.get_payload(msg);
		$(this).find('tbody tr').remove();
		if(payload.length > 0) {
			for (var i = 0; i < payload.length; i++) {
				flight = payload[i];
				var tr = $('<tr>').data('gip-id', flight.registration);
				for (var property in flight) {
					if(property == "code") continue;
					tr.append( $('<td>').addClass('gip-'+property).html(flight[property]) );
				}
				$(this).find('tbody').append(tr);
			}
		} else {
			$(this).find('tbody').append($('<tr>').append( $('<td>').attr('colspan', 3).html('No delay') ) );
		}
		
		$.dashboard.last_updated(msg, $(this));
	});

	$(selector).click(function() {
		delayed_time = moment($.dashboard.get_time());
		// get scheduled flights (all positive numbers)
		$.post(
			"wire/get-delay",
			{
				'around': delayed_time.format('YYYY-MM-DD HH:mm')
			},
			function (r) {
				//console.log(selector, r);
				var s = JSON.parse(r);
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
