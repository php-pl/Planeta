<div class="title" style="color: #333333; border-color: #333333;">
	<?php echo image_tag('blogs.png') ?>
	<h2>Agregowane blogi</h2>
</div>
<div class="container">
	<ul>
		<?php foreach ($blogs as $blog): ?>
		<li><?php echo link_to($blog->getName(), $blog->getUrl()) ?></li>
		<?php endforeach ?>
    </ul>
</div>
