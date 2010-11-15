<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture() ?>" lang="<?php echo $sf_user->getCulture() ?>">
<?php get_component('layoutBuilder', 'buildLayout')?>

<?php include_partial('global/head')?>

<body>

        <div class="page" style="<?php if(!has_slot('FestivalDropdownWidget')): ?>background:url(/img/header2.png) repeat-x;<?php endif; ?>">
    <div class="header">
      <div class="top">
        <table>
          <tr>
                <td class="remaining"><div id="counter"></div></td>
	            <td class="datetime"><div id="clocker"></div></td>
            <td class="languages">
              <div class="languages_floater">
                <ul>
                  <?php include_component('headerMenu', 'langSelect')?>
                </ul>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="center" style="<?php if(has_slot('bannerHeader')): ?>background:url(<?php include_slot('bannerHeader')?>) no-repeat center top;<?php endif; ?>">
        <div class="banner">
          <?php include_slot('bannerLogo')?>
        </div>
        <div class="controllers">
          <div class="searchbox">

            <?php include_component('searchResults', 'searchBox') ?>

          </div>

          <?php include_slot('ArchiveListWidget')?>


             <?php include_slot('FestivalDropdownWidget')?>

          <div class="socialmedia">
            <div class="socialmedia_floater">
              <ul>
                <?php include_slot('bannersSocialWidget')?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php include_slot('FestivalListWidget')?>
    </div>
    <div class="page_content">
      <table class="page_content_table">
        <tr>
          <td class="column_left">

            <div id="poff_menu">
              <div class="box-183">
                <div class="block_top"></div>
                <div class="block_content">
                  <div class="pages_menu">
                    <ul>
                      <?php  include_component('headerMenu', 'render') ?>
                    </ul>
                  </div>
                </div>
                <div class="block_bottom"></div>
              </div>
            </div>

            <div class="boxseparator"></div>

            <?php include_slot('CSI')?>

            <?php include_slot('bannersOnLeftWidget')?>
            <?php include_slot('bannersOnLeft2Widget')?>
          </td>
          <td class="column_center">
            <?php include_slot('newsBlock')?>
            <?php include_slot('newsBlock2')?>


            <?php include_slot('newsBlock3')?>

            <?php include_slot('newsBlock4')?>

	        <?php include_slot('article') ?>
	        <?php include_slot('searchResults') ?>
            <?php include_slot('newsArchivePage2') ?>
          </td>
          <td class="column_right">

            <?php include_slot('blogWidget')?>


            <?php include_slot('bannersOnRightWidget')?>



            <?php include_slot('bannersOnRightBWidget')?>
            <div class="boxseparator"></div>



        <?php //include_partial('global/topbox')?>
        <?php //include_partial('global/centerbox') ?>
        <?php include_partial('global/footer')?>
</body>


</html>