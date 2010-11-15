<b><?php echo $sf_user->getFlash('attachmentNotice') ?></b> <br />

<form action="<?php echo $helper->link('attachPicturesSubmit') ?>" method="post" enctype="multipart/form-data">
    <?php echo $form->renderHiddenFields(true) ?>

    <?php for($i = 1; $i <= $form->getPicturesAmount(); ++$i): ?>
        <?php echo $form['picture' . $i]->render() ?> <br />
    <?php endfor; ?>

    <input type="submit" name="submit" value="<?php echo __('Lae pildid') ?>" />
</form>