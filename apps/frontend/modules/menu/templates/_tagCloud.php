<div class="title" style="color: #5FA0AE; border-color: #5FA0AE;">
	<?php echo image_tag('tags.png') ?>
	<h2>Tagi</h2>
</div>
<div class="container">
	<div id="tagCloud">
	<?php foreach ($tags as $tag): ?>
	<?php if ($tag->getCount() > 0): ?>
	<?php echo link_to($tag->getName(), "@tags?name={$tag->getName()}", array('style' => "font-size: {$tag->getSize()}em", 'title' => "Ilość wpisów: {$tag->getCount()}")) ?>
	<?php endif ?>
	<?php endforeach ?>
	</div>
  
    <?php //echo link_to('Wszystkie tagi', 'blog/tags') ?>
</div>