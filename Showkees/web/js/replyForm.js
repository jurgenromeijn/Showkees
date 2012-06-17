/* 
 * reply form slides up and down
 */
$(function(){
   
   var commentButton    = $('.commentButton'),
       checkReplyForm   = $('.replyForm');
       
   if($('div').hasClass('replyFormCheck formReplyBool'))
   {
       var postIdForm = $('.replyFormCheck.formReplyBool').attr('id'),
           form = $('.' + postIdForm);
           
       checkReplyForm.hide();//all replyforms hide
       $(form).show();
       $('textarea', '.' + form).focus();
        
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


