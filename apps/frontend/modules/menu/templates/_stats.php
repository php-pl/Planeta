<div class="title" style="color: #5FA0AE; border-color: #5FA0AE;">
    <?php echo image_tag('stats') ?>
    <h2>Statystyki</h2>
</div>
<div class="container">
    <ul>
        <li><b>Planetę czyta: </b> <?php echo $stats['reader_cnt'] ?></li>
        <li><b>Agregowanych kanałów:</b> <?php echo $stats['blog_cnt'] ?></li>
        <li><b>Ilość wpisów:</b> <?php echo $stats['post_cnt'] ?></li>
        <li><b>Miesięcznie wpisów:</b> <?php echo $stats['month_avg'] ?></li>
    </ul>
</div>