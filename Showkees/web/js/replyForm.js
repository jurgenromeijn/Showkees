/* 
 * forms opens in a popup
 */
$(function(){
   
   var commentButton    = $('.commentButton'),
       checkReplyForm   = $('.replyForm');
       
   if(checkReplyForm.hasClass('formReplyBool'))
   {
       
       checkReplyForm.show();
       $('textarea', commentForm).focus();
        
   }
   else
   {
       
       checkReplyForm.hide();
       
   } 
   
   commentButton.click(function(){
       
       var postId = $(this).attr('href'),
            replyFormByPostId = $('.replyFormShow' + postId);

        
       if(replyFormByPostId.is(":hidden"))
       {
           
           replyFormByPostId.slideDown(600);
           $('textarea', replyFormByPostId).focus();
           
       }
       else
       {
           
           replyFormByPostId.slideUp(600);
           
       } 
        
       return false;
       
   });
    
   
});


