//likes per post
$(function(){
   
   $('.like_button').click(likePost);
   
});

function likePost()
{
    
    var url = $(this).attr('href'),
        likesView = $(this).next('p');
    
    if(likesView.children().size() == 0)
    {
        
        likesView.html('(<span>0</span>)');
        
    }
    
    var amountLikes = likesView.children('span').text();
    $.post(url);
    
    alert(url);
    
    amountLikes++;
    likesView.children('span').text(amountLikes);
    
    return false;
    
}

