<?php include_partial('global/page_header', array('title' => 'Zarządzanie blogiem')) ?>
<?php if ($sf_flash->has('updated')): ?>
<div class="infobox"><p><?php echo $sf_flash->get('updated') ?></p></div>
<?php endif ?>

<h2>Działy panelu</h2>
<ul>
    <li><?php echo link_to('Zmień informacje o blogu', 'ucp/edit') ?></li>
    <li><?php echo link_to('Zaproponuj nowy tag', 'ucp/tag') ?></li>
</ul>

<h2>Lista ostatnich wpisów</h2>

<table class="list">
    <thead>
        <tr>
            <th>Tytuł</td>
            <th>Data dodania</td>
            <th>Opcje</td>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td style="text-align: left"><?php echo link_to($post->getTitle(), $post->getLink()); ?></td>
            <td><?php echo $post->getCreatedAt() ?></td>
            <td><?php echo link_to('odśwież', 'post/refresh?id=' . $post->getId()); ?> <?php echo link_to('usuń', 'post/delete?id=' . $post->getId()); ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<?php include_partial('global/page_footer') ?>