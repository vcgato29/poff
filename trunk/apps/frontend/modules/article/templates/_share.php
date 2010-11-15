<div class="boxtoplink">
    <div class="addthis_toolbox">
        <div class="hover_menu">
            <div class="column1">
                <a class="addthis_button_email">Email</a>
            </div>
            <div class="column2">
                <a class="addthis_button_print">Print</a>

            </div>
            <div class="clear"></div>
            <div class="top">
            </div>
            <div class="column1">
                <a class="addthis_button_twitter">Twitter</a>
                <a class="addthis_button_facebook">Facebook</a>
                <a class="addthis_button_myspace">MySpace</a>

            </div>
            <div class="column2">
                <a class="addthis_button_delicious">Delicous</a>
                <a class="addthis_button_stumbleupon">Stumble</a>
                <a class="addthis_button_digg">Digg</a>
            </div>
            <div class="clear"></div>

            <div class="more">
                <a class="addthis_button_expanded">More...</a>
            </div>
        </div>
    </div>

    <div class="custom_button">
    <img width="12" height="11" alt="" src="/olly/img/jaga.png">
    <a href="#"><?php echo __('Share') ?></a>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>

<?php use_javascript('/olly/js/addthis_widget.js') ?>
<?php use_stylesheet('/olly/addthis.css') ?>

<script type="text/javascript">
$(function() {
    var delay = 400;

    function hideMenu() {
        if (!$('.custom_button').data('in') && !$('.hover_menu').data('in') && !$('.hover_menu').data('hidden')) {
            $('.hover_menu').fadeOut('fast');
            $('.custom_button').removeClass('active');
            $('.hover_menu').data('hidden', true);
        }
    }

    $('.custom_button, .hover_menu').mouseenter(function() {
        $('.hover_menu').fadeIn('fast');
        $('.custom_button').addClass('active');
        $(this).data('in', true);
        $('.hover_menu').data('hidden', false);
    }).mouseleave(function() {
        $(this).data('in', false);
        setTimeout(hideMenu, delay);
    });

});
</script>