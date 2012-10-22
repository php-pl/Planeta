<?php use_helper('Validation') ?>
<?php include_partial('global/page_header', array('title' => 'Zaproponuj nowy tag')) ?>
<form method="post">
    <fieldset>
        <div class="row">
            <?php echo form_error('name') ?>
            <label for="blog_name">Nazwa kategorii: </label>
            <?php echo input_tag('name'); ?>
            <span class="desc">Zostanie zamieniona na nazwę tagu</span>
        </div>
    </fieldset>
 
    <?php echo submit_tag('Zgłoś', array('class' => 'submit')) ?>
    <?php echo button_to('Powrót', $sf_request->getReferer(), array('class' => 'submit')) ?>
</form>
<?php include_partial('global/page_footer') ?>