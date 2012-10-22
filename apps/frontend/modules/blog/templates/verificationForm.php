<?php use_helper('Validation') ?>
<?php use_helper('Object') ?>
<?php include_partial('global/page_header', array('title' => 'Weryfikacja właściciela bloga')) ?>
<?php echo form_tag('blog/verification') ?>
    <fieldset>
        <div class="row">
            <label for="login">Wybierz swój blog: </label>
            <?php echo select_tag('blog_id', objects_for_select($blogs, 'getId', 'getName')) ?>
        </div>
    
        <div class="infobox"><p class="center">Podaj swój login i hasło z <a href="http://forum.php.pl">Forum PHP.pl</a></p></div>
    
        <div class="row">
            <?php echo form_error('login') ?>
            <label for="login">Login: </label>
            <?php echo input_tag('login'); ?>
        </div>
        
        <div class="row">
            <?php echo form_error('password') ?>
            <label for="password">Hasło: </label>
            <?php echo input_password_tag('password'); ?>
        </div>
    </fieldset>
    
    <?php echo submit_tag('Dalej', array('class' => 'submit')); ?>
    <?php echo button_to('Powrót', $sf_request->getReferer(), array('class' => 'submit')) ?>
</form>
<?php include_partial('global/page_footer') ?>