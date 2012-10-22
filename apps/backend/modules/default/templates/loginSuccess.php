<?php use_helper('Validation') ?>
<?php echo form_tag('@login', array('id' => 'login-form')) ?>
    <fieldset>
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
    </fieldset>
 
    <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
    <?php echo submit_tag('Zaloguj się', array('class' => 'submit')) ?>
</form>