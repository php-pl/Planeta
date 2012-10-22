<div class="menu">
    <?php include_component('menu', 'blogs') ?>
</div>

<div class="menu">
    <div class="title" style="color: #4E768B; border-color: #4E768B;">
        <?php echo image_tag('menu') ?>
        <h2>Menu</h2>
    </div>
    <div class="container">
        <ul>
            <li><?php echo link_to('Strona główna', '@homepage') ?></li>
            <?php if (!$sf_user->isAuthenticated()): ?><li><?php echo link_to('Dodaj blog', '@add') ?></li><?php endif ?>
            <li><?php echo link_to('Zarządzaj blogiem', 'ucp/index') ?></li>
            <li><?php echo link_to('O planecie', '@about') ?></li>
            <li><?php echo link_to('Kontakt', '@contact') ?>
            <?php if ($sf_user->isAuthenticated()): ?><li><?php echo link_to('Wyloguj się', '@logout') ?></li><?php endif ?>
        </ul>
    </div>
    <?php include_component('menu', 'archives') ?>
    <?php include_component('menu', 'tagCloud') ?>
    <?php include_component('menu', 'stats') ?>
</div>



