<?php use_helper('I18N') ?>
<div id="loginbox" class="login_box">
    <div class="login_box_header_up"></div>

    <img src="img/admin/logo.png" alt="Logo" align="right" class="unitPng" />
    <br /><br /><br /><br /><br />
    <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" name="loginform">

    <h1></h1>
    <?php echo $form['_csrf_token'] ?>
    
    <div class="field">Username <span class="input"><span><?php echo $form['username'] ?></span></span></div>
    <div class="field">Password <span class="input"><span><?php echo $form['password'] ?></span></span></div>
    <input type="hidden" name="login" value="1" class="hidden" />
    <input type="submit" name="asd" value="" style="display:none" />

     <br />
    <a class="button3" href="javascript:void(0);" onclick="document.loginform.submit();"><span><?php echo __('sign in') ?></span></a>

    </form>

    <br /><br />

    <div class="field">
    	Remember me <span style="width:35px"><?php echo $form['remember'] ?></span>
    </div>

    <div class="login_box_header_down"></div>
</div>






