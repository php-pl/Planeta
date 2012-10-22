function toggleArchiveList(link) {
    var list = $('archive-list-more');
    
    if (list.style.display == 'none') {
        new Effect.BlindDown(list);
        link.innerHTML = 'Mniej...';
    } else {
        new Effect.BlindUp(list);
        link.innerHTML = 'Więcej...';
    }
}

function showIndicator(id) {
    $('content-indicator-' + id).style.display = 'block';
    $('content-nav1-' + id).style.display = 'none';
} 

function hideIndicator(id) {
    $('content-indicator-' + id).style.display = 'none';
    $('content-nav2-' + id).style.display = 'block';
    
    new Effect.BlindDown('content-more-' + id);
}

function hideMore(id) {
    $('content-nav2-' + id).style.display = 'none';
    $('content-nav1-' + id).style.display = 'block';
    
    new Effect.BlindUp('content-more-' + id);
}