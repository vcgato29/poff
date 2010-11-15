<div id="leftlink_link1" class="leftlink<?php if($active): ?>active<?php endif; ?>">
    <div id="leftlinkbox_link1" class="leftlinkbox<?php if($active): ?>active<?php endif; ?>">
        <div id="linkinner_link1" class="linkinner<?php if($active): ?>active<?php endif; ?>">
            <a href="<?php echo $link ?>"><?php echo __($name) ?></a>
        </div>
    </div>
</div>

<?php if($active): ?>
<div id="arrowleft_link1" class="hiddenarrow" style="display: block;">
    <div class="arrowbox">
        <img width="23" height="81" alt="" src="/olly/img/linkarrow.png">
    </div>
</div>
<?php endif; ?>
<div class="clear"></div>