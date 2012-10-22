<?php 
$link = substr($blog->getUrl(), 7);

if ($link[strlen($link) - 1] == '/') {
    $link = substr($link, 0, -1);
}

if (strlen($link) > 20) {
    $link = substr($link, 0, 20) . '...';
}


echo link_to($link, $blog->getUrl(), array('title' => $blog->getUrl())) 
?>