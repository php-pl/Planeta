<?php
if (!function_exists('strip_tags_attributes')) {
	function strip_tags_attributes($sSource, $aAllowedTags = array(), $aDisabledAttributes = array( 'class', 'style', 'id', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'))
    {
        if (empty($aDisabledAttributes)) return strip_tags($sSource, implode('', $aAllowedTags));

        return preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", strip_tags($sSource, implode('', $aAllowedTags)));
    }
$allow = array(
	'<a>',
	'<address>',
	'<img>',
	'<strong>',
	'<b>','<u>','<i>',
	'<span>',
	'<p>',
	'<h1>','<h2>','<h3>','<h4>','<h5>','<h6>','<h7>',
	'<blockquote>',
	'<em>',
	'<ol>','<ul>','<li>',
	'<code>',
	'<pre>',
	'<table>','<tr>','<th>','<td>',

);

}



?>
<?php use_helper('Javascript'); ?>
<?php foreach ($pager->getResults() as $i => $post): ?>
<div class="entry">
    <div class="title"<?php if ($i == 0): ?> style="border-top: none"<?php endif ?>>
        <?php echo image_tag('post') ?>
        <h1><?php echo link_to(strip_tags($post->getTitle()), $post->getLink()) ?></h1>
    </div>
    <h4>
        Autor wpisu: <?php echo link_to(strip_tags($post->getBlog()->getAuthor()), $post->getBlog()->getUrl()) ?>, 
        dodany: <?php echo $post->getCreatedAt('d.m.Y H:i'); ?>, 
        tagi:
        <?php $tags = $post->getTags(); $last = count($tags) - 1; ?> 
        <?php foreach ($tags as $i => $tag): ?>
		<?php $sTag = strip_tags( $tag->getName() ); ?>
        <?php echo link_to( $sTag, "@tags?name={$sTag}"); if ($i != $last) echo ', ' ?>
        <?php endforeach ?>
    </h4>
    <div class="content">
        <?php //echo $post->getContent() ?>
		<?php echo strip_tags_attributes( $post->getContent(), $allow ) ?>
        
        <?php if ($post->getShortened()): ?>
            <div id="content-more-<?php echo $post->getId() ?>" style="display: none"></div>
            <p id="content-nav1-<?php echo $post->getId() ?>">
                <?php echo link_to_remote('Czytaj dalej tutaj (rozwija treść wpisu)', array(
                    'update' => 'content-more-' . $post->getId(),
                    'url'    => 'post/more?id=' . $post->getId(),
                    'loading' => "showIndicator({$post->getId()})",
                    'success' => "hideIndicator({$post->getId()})",
                )) ?><br/>
                <?php echo link_to('Czytaj dalej na blogu autora...', $post->getLink()) ?>
            </p>
            <p id="content-indicator-<?php echo $post->getId() ?>" style="display: none; text-align: center"><?php echo image_tag('loading.gif') ?></p>
            <p id="content-nav2-<?php echo $post->getId() ?>" style="display: none">
                <?php echo link_to_function('Zwiń', "hideMore({$post->getId()})") ?><br/>
                <?php echo link_to('Czytaj na blogu autora...', $post->getLink()) ?>
            </p>
        <?php endif ?>
    </div>
</div>
<?php endforeach ?>

<?php if ($pager->haveToPaginate()): ?>
<div class="nav">
    <?php echo link_to('&laquo;', "$iuri&page=1") ?>
    <?php echo link_to('&lt;', "$iuri&page={$pager->getPreviousPage()}") ?>
 
    <?php foreach ($pager->getLinks() as $page): ?>
        <?php echo link_to_unless($page == $pager->getPage(), $page, "$iuri&page=$page") ?>
        <?php echo ($page != $pager->getCurrentMaxLink()) ? '-' : '' ?>
    <?php endforeach; ?>
 
    <?php echo link_to('&gt;', "$iuri&page={$pager->getNextPage()}") ?>
    <?php echo link_to('&raquo;', "$iuri&page={$pager->getLastPage()}") ?>
</div>
<?php endif; ?>
