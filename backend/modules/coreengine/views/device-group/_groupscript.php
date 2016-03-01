<?php

use yii\helpers\Url;
?>
<script type="text/javascript">
<?php $this->beginBlock('JS_END') ?>
yii.process = (function ($) {
    var _onSearch = false;
    var pub = {
        golferSearch: function () {
            if (!_onSearch) {
                _onSearch = true;
                var $th = $(this);
                setTimeout(function () {
                    _onSearch = false;
                    var data = {
                        id:<?= json_encode($id) ?>,
                        target:$th.data('target'),
                        term: $th.val(),
                    };
                    var target = '#' + $th.data('target');
                    $.get('<?= Url::toRoute(['device-search']) ?>', data,
                        function (html) {
                            $(target).html(html);
                        });
                }, 500);
            }
        },
        action: function () {
            var action = $(this).data('action');
            var params = $((action == 'add' ? '#outgroup' : '#ingroup') + ', .device-search').serialize();
            var urlRegister   = '<?= Url::toRoute(['add',   'group_id' => $id]) ?>';
            var urlDeregister = '<?= Url::toRoute(['remove', 'group_id' => $id]) ?>';
            $.post(action == 'add' ? urlRegister : urlDeregister,
                   params,
	   function (r) {
                     $('#outgroup').html(r[0]);
                     $('#ingroup').html(r[1]);
                   });
            return false;
        }
    }

    return pub;
})(window.jQuery);
<?php $this->endBlock(); ?>

<?php $this->beginBlock('JS_READY') ?>
$('.device-search').keydown(yii.process.deviceSearch);
$('a[data-action]').click(yii.process.action);
<?php $this->endBlock(); ?>
</script>
<?php
yii\web\YiiAsset::register($this);
$this->registerJs($this->blocks['JS_END'], yii\web\View::POS_END);
$this->registerJs($this->blocks['JS_READY'], yii\web\View::POS_READY);
