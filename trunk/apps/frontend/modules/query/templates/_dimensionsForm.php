    <div class="roofforms rftop">
        <div class="formname"><b><?php echo __('Katuse pindala') ?>:</b></div>
        <div class="roofform">
            <?php echo $form['katuse pindala']->render(array('class' => 'roofinput')) ?>
        </div>
         <div class="formnameback">m&#178;</div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div id="roofdimensions">
        <?php include_partial('query/dimensionFieldsForm', array('form' => $form)) ?>
    </div>
