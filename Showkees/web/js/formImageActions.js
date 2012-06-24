var collectionHolder;

$(document).ready(function()
{
    
    
    collectionHolder = $('#postFormImageList');
    collectionHolder.append('<li class="add"><a href="#" class="addImageLink">+ Voeg een plaatje toe</a></li>');
    
    $("#postFormImageList .addImageLink").click(addImage);
    $("#postFormImageList .deleteImage").live('click', removeImage);

});

function addImage(e)
{
    e.preventDefault();
    
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    var newForm = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);

    $("#postFormImageList .add").before(newForm);
}

function removeImage()
{
    $(this).parentsUntil('#postFormImageList').remove();
}