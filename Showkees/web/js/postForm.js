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
       
        $(this).slideUp(200, function()
        {
            
            postForm.slideDown(600);
            $('textarea', postForm).focus();
            
        });
       
       return false;
       
   });
   
});


