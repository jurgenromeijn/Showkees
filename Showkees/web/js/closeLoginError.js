$(document).ready(function()
{
    
    $('#loginErrorOverlay, #closeError').click(function()
    {
        
        $('#loginErrorOverlay, #closeError').unbind('click');
        
        $('#loginErrorOverlay, #loginError').fadeOut(200, function()
        {
            
            $(this).hide();
            
        });
        
    });

})