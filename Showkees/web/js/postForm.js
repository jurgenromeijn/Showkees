/* 
 * forms opens in a popup
 */
$(function(){
   
   var addPostButton    = $('.add_post_button'),
       postForm         = $('#postForm'),
       formMenu         = $('#formMenu');
       
   if(formMenu.hasClass('formBool'))
   {
       
       addPostButton.hide();
       $('textarea', postForm).focus();
        
   }
   else
   {
       
       postForm.hide();
       
   } 
   
   addPostButton.click(function(){
       
        $(this).fadeOut(200, function()
        {
            
            postForm.fadeIn(600);
            $('textarea', postForm).focus();
            
        });
       
       return false;
       
   });
   
});


