$(document).ready(function()
{
   
   $("#notificationArea").click(markAsRead);
   
});

function markAsRead()
{
        
    $("#notificationArea").removeClass('new');
    $("#notificationArea>p").text('0');
    
    $.post($("#notificationArea>a").attr('href'), {});
    
}