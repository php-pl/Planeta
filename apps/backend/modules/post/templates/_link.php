<?php 
$link = $post->getLink();

if (strlen($link) > 32) {
    $link = substr($link, 0, 32) . '...';
}


echo link_to($link, $post->getLink(), array('title' => $post->getLink())) 
?>