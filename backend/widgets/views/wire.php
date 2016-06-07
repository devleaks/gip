<?php

use backend\assets\WireAsset;

use yii\helpers\Html;

use devleaks\sieve\Sieve;
use kartik\icons\Icon;
use kartik\daterange\MomentAsset;

Icon::map($this);
$asset = WireAsset::register($this);
MomentAsset::register($this);
$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */
?>
<div  id="<?= $widget_class ?>">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<header class="wire-top">
		<div class="wire-seave row">
			<div class="col-lg-12">
				<?= Sieve::widget([
					'id' => 'the-wire',
					'pluginOptions' => [
						'itemSelector' => '.wire-message'
					]
				]) ?>
			</div>
		</div>

		<div class="wire-tagsort row">
			<div class="tagsort-tags-container col-lg-12 ">
			</div>  
		</div>
	</header>


	<div class="wire-body row">
		<div class="col-lg-12">
			<ul class="timeline collapse-lg timeline-hairline">
				<?php
					if($widget->wire_count != 0) {
						foreach($dataProvider->query->each() as $model) {
							if(!$widget->last) {
							    echo '<li class="time-label"><span class="bg-blue">'.date("d M h:m", strtotime($model->created_at)).'</span></li>';
								$widget->last = $model->created_at;
							} else if (round(abs(strtotime($widget->last) - strtotime($model->created_at)) / 60) > $widget->repeat) {
							    echo '<li class="time-label"><span class="bg-blue">'.date("d M h:m", strtotime($model->created_at)).'</span></li>';
								$widget->last = $model->created_at;
							}
							echo $this->render('_wire-timeline', ['model' => $model]);
						}
					}
				?>
			</ul>
		</div>
	</div>
	
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>	
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";

	/*
	 * Default Values
	 */
	var lastDateReminder = null;
	var opts = {
		debug: false,
		id: "gip-gip-wire ul",
		// Websocket feeds
		websocket: 'ws://localhost:8051/',
		initSeed: '',///gipadmin/wire/seed
		markRead: '/gipadmin/wire/read',
		moreOlder: '',///gipadmin/wire/older
		// General presentation
		color: '#bbb',
		size: 'medium',
		speed: 500,
		// More
		numWords: 50,
		dateReminder: 3, // minutes
		ellipsestext: '<i class="fa fa-ellipsis-h"></i>',
		moretext: '<i class="fa fa-angle-double-right"></i>',
		lesstext: '<i class="fa fa-angle-double-left"></i>',
		ignoreTags: ['default','unknown'],
		filterNewMessage: false,
		priority_map: [
			'default',
			'info',
			'success',
			'primary',
			'warning',
			'danger'
		]
	};

	/**
	 *	Utility functions
	 */
	// Acknowledge Checkbox
	$('input.wire-checkbox').click(function() {
		vid = $(this).data('message');
		$.post(
			opts.markRead,
            {
				id: vid
			},
   			function () {
				console.log('marked as read '+vid);
            }
		);
		$(this).prop('disabled', true);
	});

	// More... (only works with plain text)
	// Chops text
	$('.wire-more').each(function() {
		var content = $(this).html().split(" ");
		if(content.length > opts.numWords) {
			var c = content.slice(0,opts.numWords).join(" ");
			var h = content.slice(opts.numWords,content.length).join(" ");
			var html = c + '&nbsp;<span class="wire-more-elipses">' + opts.ellipsestext
						 + '</span>&nbsp;<span class="wire-more-content"><span>'
						 + h + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
						 + opts.moretext + '</a></span>';
			$(this).html(html);
		}
	});

	$(".wire-more-link").click(function(){
		if($(this).hasClass("wire-less")) {
			$(this).removeClass("wire-less");
			$(this).html(opts.moretext);
		} else {
			$(this).addClass("wire-less");
			$(this).html(opts.lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});

	
	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$(selector).on('gip:message', function(event, message) {
		var tags = new Array();
		var addTags = function(str) {
			if(opts.ignoreTags.indexOf(str) == -1)
				tags.push(str);
		}

		// Priority
		var priority = message.priority == null ? 0 : parseInt(message.priority);

		if(priority < 0)	// convention: we do not display wire message with negative priority on the wire.
			return; 		// they are handled by other giplet handlers, but they are not displayed on the wire.
		if(priority > (opts.priority_map - 1))
			priority = opts.priority_map - 1;

		var priority_string = '★'.repeat(priority)+'☆'.repeat(5-priority);

		addTags(priority_string);
		addTags(message.source.toLowerCase());
		addTags(message.type.toLowerCase());
		var bs_color = opts.priority_map[priority % opts.priority_map.length];


		// Color
		if(message.color.substr(0, 1) != '#' && $.inArray(message.color, opts.priority_map)) { // uses bootstrap color
			//console.log('uses bs color');
			message.color = opts.color;
		}

		// Icon


		// Link
		var title = message.subject;
		if(message.link) {
			title = $('<a>').attr('href', message.link).html('<i class="fa fa-link"></i>&nbsp;' + message.subject);
		}

		// Body
		var text = message.body;

		// special message parsing
		if(message.type.toLowerCase() == 'metar') {
			var metar = metar_decode(text);
			if(metar.length > 0) {
				text = metar.replace(/(?:\r\n|\r|\n)/g, '<br />') + '<br/><pre>'+text+'</pre>';
			}
		}
		// text shortening
		if(opts.numWords > 0) {
			var content = text.split(" ");
			if(content.length > opts.numWords) {
				text = content.slice(0,opts.numWords).join(" ")
						 + '&nbsp;<span class="wire-more-elipses">' + opts.ellipsestext
						 + '</span>&nbsp;<span class="wire-more-content"><span>'
						 + content.slice(opts.numWords,content.length).join(" ")
						 + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
						 + opts.moretext + '</a></span>';
			}
		}

		// Do we need a new Date reminder in the margin?
		if(lastDateReminder == null || ((Date() - lastDateReminder) > (opts.dateReminder * 60000)) ) {
			$('<li>').addClass('time-label')
					.append($('<span>').addClass('bg-blue').html(moment().format("ddd D MMM H:mm")))
					.prependTo("#"+opts.id);
			lastDateReminder = new Date();
		}

		// Assembly
		var tagPills = $('<span>');
		for(var idx = 0; idx < tags.length; idx++) {
			tagPills.append($('<span>').addClass('label').addClass('label-default').html(tags[idx])).append('&nbsp;');
		}

		//materialadmin-based
		$('<li>').addClass('timeline-inverted')
			.append( $('<div>').addClass('timeline-circ').addClass('circ-xl').addClass('style-'+bs_color)
				.append(
					$('<i>').addClass('fa').addClass(message.icon).html(' ')
				)
			)
			.append( $('<div>').addClass('timeline-entry')
				.append( $('<div>').addClass('card').addClass('style-default-bright')
					.append( $('<div>').addClass('card-body').addClass('small-padding')
						.append(
							$('<span>').addClass('message-header')
								.append( $('<span>').addClass('time').addClass('opacity-50')
									.append(
										$('<i>').addClass('fa').addClass('fa-clock-o')
									).append(moment(new Date()).format('ddd D MMM YY H:mm'))
								)
								.append( $('<span>').addClass('title').html(title) )
						)
						.append(
							$('<span>').addClass('message-body').addClass('wire-more').addClass('text-medium').html('<br/>' + text + '<br/>')
						)
						.append(
							$('<span>').addClass('message-footer')
							.append(tagPills)
							.append(
								$('<span>').addClass('label').addClass('label-info').html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
							)
						)
					)
				)
			)
		.addClass('wire-message')
		.attr('data-item-tags', tags.join(','))
		.attr('id', 'wire-message-'+message.id)
		.prependTo("#"+opts.id).hide().slideDown(opts.speed);

		// increase alert count indicator
		var counter_selector = '#gip-gip-alert .gip-body';
		$(counter_selector).html(parseInt($(counter_selector).html()) + 1);

		// Cleanup

		// Rebuild task list, sort it, and set those that were active.
		// 1. remember which ones where selected
		var tagsortActive = $('div.tagsort-tags-container span.tagsort-active');
		// 2. rebuild list
		$('div.tagsort-tags-container').html('').tagSort({
			items:'.wire-message'
		}).find('span').sortElements(function(a, b){
		    return $(a).text() > $(b).text() ? 1 : -1;
		});
		// 3. select those which were selected
		var hasTags = 0;
		if(tagsortActive.length !== 0) {
			tagsortActive.each(function() {
				tag = $(this).html();
				if(opts.filterNewMessage && (tags.indexOf(tag) > -1)) { // current message has tag
					hasTags++;
				}
				$('div.tagsort-tags-container span:contains("'+tag+'")').addClass('tagsort-active');
			});
		}
		if(opts.filterNewMessage && tagsortActive.length !== hasTags) {
			$('li#wire-message-'+message.id).toggle(false);
		}

		$(".wire-more-link").click(function(){
			if($(this).hasClass("wire-less")) {
				$(this).removeClass("wire-less");
				$(this).html(opts.moretext);
			} else {
				$(this).addClass("wire-less");
				$(this).html(opts.lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
	});

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);