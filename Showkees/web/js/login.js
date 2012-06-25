$(document).ready(function()
{
    
    if($('#closeError').length > 0)
    {
    
        $('#overlay').show();
        $('#overlay, #closeError').click(closeErrorClickHandler);
    }
    
    $('button#about').click(showAbout);
    
});

function closeErrorClickHandler()
{
    
    $('#overlay, #closeError').unbind('click');

    $('#overlay, #loginError').fadeOut(200, function()
    {

        $(this).hide();

    });
   
}

function showAbout(event)
{
    
    event.preventDefault();
    
    $('#overlay, div#aboutWindow').fadeIn(200, function()
    {

        $('#overlay, button#closeAbout').click(hideAbout);

    });
    
}

function hideAbout()
{

    $('#overlay, button#closeAbout').unbind('click');

    $('#overlay, div#aboutWindow').fadeOut(200, function()
    {

        $(this).hide();

    });

}