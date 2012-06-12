/* 
 * forms opens in a popup
 */
$(function(){
   
   var postButton   = $('.add_post_button'),
       postForm     = $('#postForm');
   
   postButton.click(function(e){
       
       $(this).fadeOut(200);
       postForm.fadeIn(200);
       $('textarea', postForm).focus();
       
       e.preventDefault();
       
   });
   
});


