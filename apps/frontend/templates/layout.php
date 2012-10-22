<?php if ($sf_request->getParameter('type') == 'tags'): $tag = $sf_request->getParameter('name'); endif ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
    <link rel="alternate" type="application/atom+xml" title="Planeta PHP.pl"  href="<?php echo url_for('@feed', true) ?>" />
	<?php if (isset($tag)): ?>
    <link rel="alternate" type="application/atom+xml" title="Planeta PHP.pl - tag: <?php echo $tag ?>"  href="<?php echo url_for("@feeds?tag=$tag", true) ?>" />
    <?php endif ?>
</head>
<body>
<div id="wrapper">

<div id="topbar">
	<?php include_partial('global/topbar') ?>
</div>

<div id="header">
    <?php include_component('menu', 'header') ?>
</div>

<div id="menu">
    <?php include_partial('global/menu') ?>
</div>

<div id="content">
    <?php echo $sf_data->getRaw('sf_content') ?>
</div>

<div id="infobar">Wszystkie wpisy należą do ich twórców. PHP.pl nie ponosi odpowiedzialności za treść wpisów.</div>
<div id="footer">Copyright (c) 2003-2006 php.pl&nbsp;&nbsp;&nbsp;&nbsp;Wszystkie prawa zastrzeżone</div>
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-256753-9");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
