var collectionHolder;

$(document).ready(function()
{
    
    
    collectionHolder = $('#postFormImageList');
    collectionHolder.append('<li class="add"><a href="#" class="addImageLink">+ Voeg nog een afbeelding toe</a></li>');
    
    $("#postFormImageList .addImageLink").click(addImage);

});

function addImage(e)
{
    e.preventDefault();
    
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    var newForm = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);

    $("#postFormImageList .addImageLink").before(newForm);
}