<div class="title" style="color: #DD601B; border-color: #DD601B;">
	<?php echo image_tag('archives.png') ?>
	<h2>Archiwum</h2>
</div>
<div class="container">
    <ul style="margin-bottom: 0">
        <?php for ($i = 0; $i < $max; $i++): ?>
        <li><?php echo link_to($months[$i]['f'], "@archives?month={$months[$i]['m']}&year={$months[$i]['y']}") ?></li>
        <?php endfor; ?>
	</ul>
  
    <?php if ($count > $max): ?>
    <ul id="archive-list-more" style="margin-bottom: 0; display: none">
        <?php for ($i = $max; $i < $count; $i++): ?>
        <li><?php echo link_to($months[$i]['f'], "@archives?month={$months[$i]['m']}&year={$months[$i]['y']}") ?></li>
        <?php endfor; ?>
    </ul>
    <?php endif ?>
    <ul><li><a href="javascript:void(0)" onclick="toggleArchiveList(this)">Więcej...</a></li></ul>  
</div>