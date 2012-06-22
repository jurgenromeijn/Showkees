var collectionHolder;

$(document).ready(function()
{
    
    
    collectionHolder = $('div#WallPost_images');
    collectionHolder.append('<a href="#" class="addImageLink">Voeg een afbeelding toe</a>');
    
    $("div#WallPost_images .addImageLink").click(addImage);

});

function addImage(e)
{
    e.preventDefault();
    
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    var newForm = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);

    $("div#WallPost_images .addImageLink").before(newForm);
}