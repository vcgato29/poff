 <?php slot('CSI')?>
 <div id="poff_csi">
              <div class="halfbox2-183">
                <div class="block_top"></div>
                <div class="block_content">
                  <h3><?php echo __('POFFI POSTILJON') ?></h3>
                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="halfbox-183-content">
               <?php
               $cadd =  0;
               if(isset($_POST['csi_email']) && $_POST['csi_email']!=''): ?>
                <?php
                 $groups =  "";

                 if(isset($_POST['festival_poff']) and !empty($_POST['festival_poff'])) $groups =   $groups.$_POST['festival_poff'].":";
                 if(isset($_POST['festival_kumu']) and !empty($_POST['festival_kumu'])) $groups =   $groups.$_POST['festival_kumu'].":";
                 if(isset($_POST['festival_hoff']) and !empty($_POST['festival_hoff'])) $groups =   $groups.$_POST['festival_hoff'].":";
                 if(isset($_POST['festival_tartuff']) and !empty($_POST['festival_tartuff'])) $groups =   $groups.$_POST['festival_tartuff'].":";
                 if(isset($_POST['festival_ad']) and !empty($_POST['festival_ad'])) $groups =   $groups.$_POST['festival_ad'].":";
                 if(isset($_POST['festival_sleepwalkers']) and !empty($_POST['festival_sleepwalkers'])) $groups =   $groups.$_POST['festival_sleepwalkers'].":";
                 if(isset($_POST['festival_justfilm']) and !empty($_POST['festival_justfilm'])) $groups =   $groups.$_POST['festival_justfilm'].":";
                 $groups = substr($groups, 0, -1);
                 if($groups==""){
				 	echo '<p>'; echo __('Viga: Peab vähemalt üks list olema!'); echo'</p>';
	             }
                 else {
	                 $result=file_get_contents('http://csi.poff.ee/csi_connect.php?email='.urlencode($_POST['csi_email']).'&groups='.$groups.'');
					 $cadd =  0;

					 if($result=='success'){
					 	echo '<p>'; echo __('Edukalt lisatud!'); echo'</p>';
					 $cadd =  1;
					 }
					 else  { echo '<p>'; echo __('Viga: e-mail on ebaoige!'); echo'</p>'; }
				}

             	?>
             	<?php endif; ?>
             	<?php if($cadd!=1): ?>
                <p><?php echo __('Telli POFFi uudiskiri!') ?></p>
             	<form method="post" action="<?php include_component('linker', 'articleLinkBuilder', array( 'params' => array( 'p0' => $node['lang'], 'p1' => $node['slug'])) )?>.act" name="csiform">
                <div class="input">
                  <div class="input_left"></div>
                  <div class="input_content">
                    <input type="text" value="<?php if(isset($_POST['csi_email']) and !empty($_POST['csi_email'])): ?><?php echo $_POST['csi_email']; ?><?php else: ?><?php echo __('sisesta oma e-posti aadress') ?><?php endif; ?>" onfocus="if(this.value=='<?php echo __('sisesta oma e-posti aadress') ?>'){this.value='';document.getElementById('postv').style.display = 'block';}" onblur="if(this.value==''){this.value='<?php echo __('sisesta oma e-posti aadress') ?>';}" name="csi_email" id="csimail" />
                  </div>
                  <div class="input_right"></div>
                </div>
                <div id="postv" style="<?php if(!$_POST): ?>display:none<?php endif; ?>">
	                <br /><p><?php echo __('Vali liitumiseks listid') ?>:</p>
	                <input type="checkbox" name="festival_all" value="1" id="post_all" <?php if(isset($_POST['festival_all']) and !empty($_POST['festival_all'])): ?>checked<?php endif; ?>><?php echo __('KÕIK') ?><br />
	                <input type="checkbox" name="festival_poff" value="2" class="posting" <?php if(isset($_POST['festival_hoff']) and !empty($_POST['festival_hoff'])): ?>checked<?php elseif($_POST): ?><?php else: ?>checked<?php endif; ?>><?php echo __('POFF') ?><br />
	                <input type="checkbox" name="festival_kumu" value="8" class="posting" <?php if(isset($_POST['festival_kumu']) and !empty($_POST['festival_kumu'])): ?>checked<?php endif; ?>><?php echo __('Kumu dokumentaa') ?><br />
	                <input type="checkbox" name="festival_hoff" value="6" class="posting" <?php if(isset($_POST['festival_hoff']) and !empty($_POST['festival_hoff'])): ?>checked<?php endif; ?>><?php echo __('HOFF') ?><br />
	                <input type="checkbox" name="festival_tartuff" value="7" class="posting" <?php if(isset($_POST['festival_tartuff']) and !empty($_POST['festival_tartuff'])): ?>checked<?php endif; ?>><?php echo __('tARTuFF') ?><br />
	                <input type="checkbox" name="festival_ad" value="4" class="posting" <?php if(isset($_POST['festival_ad']) and !empty($_POST['festival_ad'])): ?>checked<?php endif; ?>><?php echo __('Animated Dreams') ?><br />
	                <input type="checkbox" name="festival_sleepwalkers" value="3" class="posting" <?php if(isset($_POST['festival_sleepwalkers']) and !empty($_POST['festival_sleepwalkers'])): ?>checked<?php endif; ?>><?php echo __('Sleepwalkers') ?><br />
	                <input type="checkbox" name="festival_justfilm" value="5" class="posting" <?php if(isset($_POST['festival_justfilm']) and !empty($_POST['festival_justfilm'])): ?>checked<?php endif; ?>><?php echo __('Just Film') ?><br />
	             </div>
                <div class="submit" onclick="javascript:document.csiform.submit();">
                  <div class="submit_left"></div>
                  <div class="submit_content">
                    <?php echo __('Tellin') ?>
                  </div>
                  <div class="submit_right"></div>
                </div>
                </form>
                <?php endif; ?>
                <div style="clear: both;"></div>
              </div>
            </div>

            <div class="boxseparator"></div>
<?php end_slot()?>