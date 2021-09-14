jQuery(document).ready(function($){
   $('div[data-slick]').slick();
});

/* same hieght script usage
just add data-same-height and group name
<div class="col-md-4" data-same-height="group-1"></div>
<div class="col-md-4" data-same-height="group-1"></div>
<div class="col-md-4" data-same-height="group-1"></div>

// other example
<div class="somediv">
	<div data-same-height="group-2"></div>
</div>
<div class="someotherdiv">
	<div data-same-height="group-2"></div>
</div>
*/
jQuery(document).ready(function($){

   function mam_set_auto_height(){
      // reset sh-active class
      $('.sh-active').css('height', 'auto');
      $('.sh-active').removeClass('sh-active');

      // get all elemets with same height data
      $ashElements = $("[data-same-height]");
      // loop through the elements
      $ashElements.each(function(){
         $element = $(this);

         // skip if it's been configured already or not
         if($element.hasClass('sh-active')){
            return true;
         }
         // get group to set same height
         var _group = $element.attr('data-same-height');

         // get group elements
         $groupElements = $('[data-same-height="'+_group+'"]');

         // Cache the highest
         var highestBox = 0;

         // loop throgh the group elements
         $groupElements.each(function(){
            // If this box is higher than the cached highest then store it
            if($(this).height() > highestBox) {
               highestBox = $(this).height();
            }
         });
         // Set the height of all those children to whichever was highest
         $groupElements.addClass('sh-active').height(highestBox);
      });
   }

   $(window).load(function(){
      mam_set_auto_height();
   });
   $(window).resize(function(){
      mam_set_auto_height();
   });
   mam_set_auto_height();

   setInterval(mam_set_auto_height, 250);
});