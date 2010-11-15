      <div id="header">
        <div class="logoff"><a href="<?php echo url_for('sf_guard_signout')?>"><img src="img/admin/logoff.png" alt=""  class="unitPng" /></a></div>
        <span>attitude adjustor CMS:  &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Kasutaja: <?php echo $username?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <?php echo link_to('Logout', '@sf_guard_signout') ?></span>
        <div id="logobox" class="unitPng">
            <span><a href="admin"><img src="img/admin/logo.png" alt="Logo" class="unitPng" /></a></span>
            <div class="boxcorner"></div>
        </div>
    </div>