<?php use_helper('Validation') ?>
<?php include_partial('global/page_header', array('title' => 'Logowanie')) ?>


<div class="infobox">
<?php if ($sf_flash->has('verified')): ?><p class="center">Weryfikacja zakończona.</p><?php endif ?>
<p class="center">Zaloguj się, używając swojego loginu i hasła z <a href="http://forum.php.pl">Forum PHP.pl</a>.</p>
</div>


<?php echo form_tag('@login', array('id' => 'login_form')) ?>
    <div class="row">
        <?php echo form_error('login') ?>
        <label for="nickname">Login:</label>
        <?php echo input_tag('login', $sf_params->get('login')) ?>
    </div>
    <div class="row">
        <?php echo form_error('password') ?>
        <label for="password">Hasło:</label>
        <?php echo input_password_tag('password') ?>
    </div>

    <div class="center">
        <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
        <?php echo submit_tag('Zaloguj się', array('class' => 'submit')) ?>
        <?php echo button_to('Powrót', $sf_request->getReferer(), array('class' => 'submit')) ?>
    </div>
</form>
<hr />
<p class="center"><?php echo link_to('Zapomniałem hasła', 'http://forum.php.pl/index.php?act=Reg&CODE=10') ?></p>
<?php if (!$sf_flash->has('verified')): ?>
<p class="center"><?php echo link_to('Mój blog jest już dodany, jednak nie przeszedłem procesu weryfikacji', 'blog/verification') ?></p>
<?php endif ?>

<?php include_partial('global/page_footer') ?>