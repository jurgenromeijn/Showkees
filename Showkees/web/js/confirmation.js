$(document).ready(function()
{
    
    $('a.confirm').click(showConfirmation);
    
});

function showConfirmation(event)
{

    event.preventDefault();

    var confirmationHtml = '<div class="confirmationOverlay"></div>';
    confirmationHtml += '<form class="confirmation" method="get" action="'+ $(this).attr('href') +'">';
    confirmationHtml += '<h3>' + $(this).find('.head').html() + '</h3>';
    confirmationHtml += '<p>' + $(this).find('.body').html() + '</p>';
    confirmationHtml += '<input type="submit" class="button confirm" value="Ja" />';
    confirmationHtml += '<input type="button" class="button cancel" value="Nee" />';
    confirmationHtml += '</form>';
    
    $('body').append(confirmationHtml);
    
    $('.confirmationOverlay, .confirmation').hide();
    
    $('.confirmationOverlay, .confirmation').fadeIn(200);
    
    $('.cancel').click(removeConfirmation);
    
    $('.confirmation .confirm').focus();
    
}

function removeConfirmation()
{

    $('.confirmationOverlay, .confirmation').fadeOut(200, function()
    {

        $(this).remove();

    });

}