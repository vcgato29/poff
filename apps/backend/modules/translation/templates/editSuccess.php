<table id="mainTable"  width="260" align="center">
      <tr>
        <td>
          <form action="<?php echo url_for('@admin_page?module=translation&action=update')?>" method="post">
          <fieldset>
          <legend class="formLabel"> <?php echo __("Muutuja") ?>  </legend>
          <input type="text" <?php if( $sf_request->getParameter('action') != 'new' ):?>readonly<?php endif;?> name="transUnit" value="<?php echo $variable?>">
          </fieldset>
          	<br />
          	<br />
          	<br />
          	
          	<?php foreach( $langs as $lang ):?>
	          	<fieldset>
              		<legend class="formLabel">  <?php echo $lang['title_est']?> </legend>
	              	<textarea name="unitvars[<?php echo $lang['abr']?>]" style="width:300px;"><?php if( isset( $groupedUnits[$lang['abr']]['target'] ) ):?><?php echo $groupedUnits[$lang['abr']]['target']?><?php endif;?></textarea>
            	</fieldset>
            <br />
            <?php endforeach;?>
	    	<br />

            <input type="submit" class="formSubmit" value="Salvesta" />
          </form>
        </td>
      </tr>

</table>
