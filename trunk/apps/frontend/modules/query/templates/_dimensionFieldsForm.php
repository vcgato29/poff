<?php echo $form['katuse skeema']->render(array('style' => 'display:none')) ?>
<?php echo $form['katuse tüüp']->render(array('style' => 'display:none')) ?>

<?php for($i = 1; $i <= $form->getDimensions(); ++$i): ?>
    <div class="roofforms">
        <div class="formname"><b><?php echo $form->dimName($i) ?>:</b></div>
        <div class="roofform">
            <?php echo $form[$form->dimName($i)]->render(array('class' => 'roofinput')) ?>
        </div>
         <div class="formnameback"><?php echo __('mm') ?></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
<?php endfor; ?>