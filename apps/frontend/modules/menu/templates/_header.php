<?php echo link_to(image_tag('logo', array('alt' => 'Planeta PHP.pl')), '@homepage') ?>
<?php if (is_array($links)):?>
<ul>
    <?php foreach ($links as $title => $link) printf('<li><a%s href="%s">%s</a></li>', $link == 'http://planeta.php.pl/' ? ' class="h-activeList"' : '', $link, $title) ?>
</ul>
<?php endif ?>