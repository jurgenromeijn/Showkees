$(document).ready(function()
{
    
    $("#colorMenu li").click(switchColor);
    
})

function switchColor()
{
    
    var color = $(this).attr('class');
    
    $("body").attr('class', color);
    
}