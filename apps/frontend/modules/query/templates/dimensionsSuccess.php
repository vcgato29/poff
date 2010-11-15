<?php slot('subject') ?>
<h1><?php echo __('Dimensions') ?></h1>
<?php end_slot() ?>

<?php get_component('bottomArticlesWidget', 'render') ?>

<?php slot('content') ?>

<div id="roofcarousel" class="roofcarousel">
    <div class="boxinrighttop">
        <ul>
            <?php foreach($data as $index => $info): ?>
             <li>
                <div class="roofimg">
                    <div class="roofid" style="display:none"><?php echo $index ?></div>
                    <a href="#"><img src="<?php echo $info['small_picture_url'] ?>" width="56" height="56" alt="" /></a>
                    <div class="roofbigimg" <?php if($index == $activeElementIndex): ?>style="display:block" <?php endif; ?>>
                        <img src="<?php echo $info['small_picture_url_selected'] ?>" width="80" height="56" alt="" />
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
            <?php if(count($data) < 6): ?>
                <?php echo str_repeat('<li></li>', 6 - count($data)) ?>
            <?php endif; ?>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<?php use_javascript('/olly/js/blockUI/script.js') ?>
<script type="text/javascript">
// carousel scripts
$('.roofimg').click(function(e){
    e.preventDefault();

    // already selected
    if($(this).find('.roofbigimg').is(':visible'))return false;


    $('.roofbigimg').css('display','none');
    $(this).find('.roofbigimg').css('display','block');

    // block ui
    $.blockUI({ message: '<h1><?php echo __('Oota...') ?></h1>' });

    // send request
    var roofID = $('.roofid', this).text();
    //set selected ID to input
    $('input[name=roofID]').val(roofID);

    $.post('<?php echo $helper->link('getRoofInfo') ?>', {roofID: roofID},
            function(data){
                // replace big picture
                $('.skeemimg img').attr('src',data.schema);

                // replace form html
                $('#roofdimensions').html(data.formHTML)

                // unblock ui
                $.unblockUI();
        },'json');

    return false;
});

jQuery(document).ready(function() {
    jQuery('#roofcarousel').jcarousel({
        scroll: 1,
        visible: 6,
    	wrap: 'circular',
        start: <?php echo $activeElementIndex + 1 ?>
    })
});
</script>

<form method="post" action="<?php echo $helper->link('dimensionsSubmit') ?>">
<input type="hidden" name="roofID" value="<?php echo  $activeElementIndex?>" />
<?php echo $form->renderHiddenFields(true) ?>

<div class="roofoptions">
    <div class="roofoptionsleft">
        <div class="roofskeem">
            <div class="skeemimg">
                <img  src="<?php echo $data[$activeElementIndex]['big_picture_url'] ?>" width="265" height="207" alt="" />
            </div>
        </div>
    </div>
    <div class="roofoptionsright">
        <div class="roofsoov">
            <div class="uncheck<?php if($form['katuse mõõdistamine']->getValue()): ?>active<?php endif; ?>"><?php echo $form['katuse mõõdistamine']->render(array('style' => 'display:none')) ?></div>
            <div class="turvachecktext"><p><?php echo __('Soovin katuse mõõdistamist') ?></p></div>
        </div>
        <div class="clear"></div>
            <?php include_partial('query/dimensionsForm', array('form' => $form)) ?>
    </div>
    <div class="clear"></div>
</div>


<?php include_partial('query/footerButtons', array('helper' => $helper)) ?>

<script type="text/javascript">
	$('.uncheck, .uncheckactive').click(function(){

		var input = $('input', this);

		// kas soovib katuse m66distamist ?
		if($(this).hasClass('uncheckactive')){
			input.val('0');
		}else{
			input.val('1');
		}

		$(this).toggleClass('uncheckactive');
		$(this).toggleClass('uncheck');
	});
</script>

</form>

<?php end_slot() ?>