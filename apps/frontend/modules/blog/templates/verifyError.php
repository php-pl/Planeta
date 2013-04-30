<?php include_partial('global/page_header', array('title' => 'Weryfikacja autora bloga')) ?>
<p>Weryfikacja nie powiodła się. Plik <?php echo link_to($url, $url) ?> nie istnieje, nie znaleziono też tagu meta na stronie głównej.</p>

<p>Umieść plik <b><?php echo $file . '.html' ?></b> na serwerze lub umieść w sekcji head strony głównej kod:
	<code><?php echo htmlentities('<meta name="verify-phppl" content="' . $file . '" />') ?></code>,
	a następnie <?php echo link_to('odśwież stronę', "@verification?file=$file") ?>.</p>
<?php include_partial('global/page_footer'); ?>