$(document).ready(function() {
   vCycleImages = setInterval(function() {
      var bImgLoaded = true;
      var images = $(".indexgallery img");
 
      for (var i = 0; i < images.length; i++) {
         var img = images[i];
         if (img.complete == false)
            bImgLoaded = false;
      }
 
      if (bImgLoaded) {
         $(".indexgallery").cycle({ delay: 1000, speed: 2000 });
         clearInterval(vCycleImages);
      }
   }, 1000);
});