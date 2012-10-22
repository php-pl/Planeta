<?php 
$link = substr($blog->getFeed(), 7);

if ($link[strlen($link) - 1] == '/') {
    $link = substr($link, 0, -1);
}

if (strlen($link) > 20) {
    $link = '...' . substr($link, -20);
}


echo link_to($link, $blog->getFeed(), array('title' => $blog->getFeed())) 
?>