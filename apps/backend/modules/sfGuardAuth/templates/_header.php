<div id="header">
        <div class="logoff"><a href="<?php echo url_for('sf_guard_signout')?>"><img src="img/admin/logoff.png" alt=""  class="unitPng" /></a></div>
        <span>attitude adjustor CMS:  &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <?php echo __('Username')?>: <?php echo $username?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <?php echo link_to(__('Logout'), '@sf_guard_signout') ?></span>
        <div id="logobox" class="unitPng">
            <span><a href="<?php echo url_for( '@structure_page?action=settings' )?>"><img src="img/admin/logo.png" alt="Logo" class="unitPng" /></a></span>
            <div class="boxcorner"></div>
        </div>
</div>