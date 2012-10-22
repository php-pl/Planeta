<?php header('Content-type: application/atom+xml; charset=utf-8'); ?>
<?php decorate_with(false) ?>
<?php echo $feed->asXml() ?>