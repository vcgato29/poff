<?php get_component('categoriesLeftMenuWidget', 'render')?>

<?php slot('productGroupsPics')?>

<div class="maingallery">
    <img id="maingalleryimage" width="572" height="382" alt="" src="<?php echo @myPicture::getInstance( $category->getPicture() )->thumbnail(573,382,'center')->url()?>">
</div>

<div class="gallerybottom"><img width="574" height="10" alt="" src="/olly/img/gallshadowbottom.jpg"></div>

<div class="banners small">
    <?php foreach($banners as $index => $banner): ?>
    <?php
        switch($index){
            case 0:
                $class = 'leftbanner';
                break;
            case 1:
                $class = 'centerbanner';
                break;
            case 2:
                $class = 'rightbs';
                break;
        }
    ?>
    <div class="<?php echo $class ?>">
    <a href="<?php echo $banner['link'] ?>"><img width="182" height="87" alt="" src="<?php echo @myPicture::getInstance( $banner->getPicture() )->thumbnail(182,87,'center')->url()?>"></a>
    </div>
    <?php endforeach; ?>

    
    <div class="clear"></div>
</div>
<div class="clear"></div>



<script type="text/javascript">


    function menuItemActivatedCallback(menuItem, clickedID){

        
        //show new picture on the left widget
         var picture = $('.productGroupPictures').find('[alt=' + clickedID + ']');
         if(picture) picture = picture.attr('src');
         else{
            alert('picture not found');
            return false;
         }

         $('#maingalleryimage').fadeOut('fast', function(){
            $(this).attr('src', picture);
            $(this).fadeIn('fast');
         });
    }
</script>

<?php end_slot()?>