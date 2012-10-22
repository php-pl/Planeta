<div class="loginbox">
<?php if ($sf_user->isAuthenticated()): ?>Zalogowany jako <?php echo link_to($sf_user->getName(), "http://forum.php.pl/user-m{$sf_user->getMid()}.html") ?> [ <?php echo link_to('wyloguj', '@logout') ?> ]<?php else: ?>Niezalogowany [ <?php echo link_to('logowanie', '@login') ?> ]<?php endif ?>
</div>
<div>
<?php 
if ($sf_request->getParameter('type') == 'tags') 
    $tag = $sf_request->getParameter('name'); 
    
echo link_to(
    image_tag('feed.gif', array('alt' => 'Subskrybuj kanał ATOM')) . ' Kanał ATOM', 
    '@feed',  
    array('title' => 'Subskrybuj kanał ATOM')
);

if (isset($tag)) {
    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
    echo link_to(
        image_tag('feed.gif', array('alt' => "Subskrybuj kanał ATOM dla tagu $tag")) . " Kanał ATOM (tag: $tag)", 
        "@feeds?tag=$tag",  
        array('title' => "Subskrybuj kanał ATOM dla tagu $tag")
    );
}
?>
</div>