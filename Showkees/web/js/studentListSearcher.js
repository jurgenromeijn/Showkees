/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function()
{
    
    $('#sidebarColumn #studentSearchForm').submit(function(event)
    {
        event.preventDefault();
    });
    
    $('#sidebarColumn #studentSearchField').keyup(searchInList);
    
})

function searchInList()
{
    var searchString = $(this).val().toLowerCase();

    var results = 0;
    
    $("#studentList li a").each(function()
    {
        
        var name = $(this).text().toLowerCase();
        
        if(name.indexOf(searchString) >= 0)
        {

            $(this).parent().slideDown(200);
            results++;

        }
        else
        {

            $(this).parent().slideUp(200);

        }

    });
    
    var errorText = $("#studentSearchForm p");
    
    if(results < 1 && errorText.length < 1)
    {

        $("#studentSearchForm").append("<p>Er zijn geen leerlingen die voldoen aan je zoekopdracht.</p>");

        $("#studentSearchForm p").hide();
        $("#studentSearchForm p").slideDown(200);
        

    }
    else if(results > 0 && errorText.length > 0)
    {

        $("#studentSearchForm p").slideUp(200, function()
        {
            $(this).remove();
        });

    }

}