<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
<div id="content">
<?php if ($sf_user->isAuthenticated()): ?>
<div id="navbar">
    <ul>
        <li><?php echo link_to('blogi do zatwierdzenia', 'blog/list?filters[verified]=1&filters[approved]=0&filter=filter') ?></li>
        <li><?php echo link_to('tagi do zatwierdzenia', 'tag/list?filters[approved]=0&filter=filter') ?></li>
        <li><?php echo link_to('zarządzaj blogami', 'blog/index?filter=filter') ?></li>
        <li><?php echo link_to('zarządzaj wpisami', 'post/index?filter=filter') ?></li>
        <li><?php echo link_to('zarządzaj tagami', 'tag/index?filter=filter') ?></li>
        <li><?php echo link_to('strona główna', 'http://' . $this->getContext()->getRequest()->getHost() . (SF_ENVIRONMENT == 'prod' ? '' : '/frontend_dev.php')) ?>
        <li><?php echo link_to('wyloguj', '@logout') ?></p></li>
    </ul>
</div>
<?php endif ?>

<?php echo $sf_data->getRaw('sf_content') ?>

</div>
</body>
</html>
