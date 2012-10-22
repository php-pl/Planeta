<?php use_helper('Validation') ?>
<?php use_helper('Object') ?>
<?php include_partial('global/page_header', array('title' => 'Zmiana informacji o blogu')) ?>
        <?php echo form_tag('ucp/edit') ?>
            <fieldset>
                <div class="row">
                    <?php echo form_error('name') ?>
                    <label for="name">Nazwa: </label>
                    <?php echo object_input_tag($blog, 'getName'); ?>
                    <span class="desc">2-64 znaków</span>
                </div>
                
                <div class="row">
                    <?php echo form_error('author') ?>
                    <label for="author">Autor: </label>
                    <?php echo object_input_tag($blog, 'getAuthor'); ?>
                    <span class="desc">2-64 znaków</span>
                </div>
                
                <div class="row">
                    <?php echo form_error('url') ?>
                    <label for="url">Adres: </label>
                    <?php echo object_input_tag($blog, 'getUrl'); ?>
                    <span class="desc">Maksymalnie 128 znaków</span>
                </div>
                
                <div class="row">
                    <?php echo form_error('feed') ?>
                    <label for="feed">Adres kanału RSS/ATOM: </label>
                    <?php echo object_input_tag($blog, 'getFeed'); ?>
                    <span class="desc">Maksymalnie 128 znaków</span>
                </div>
            </fieldset>
         
            <?php echo submit_tag('Zapisz', array('class' => 'submit')) ?>
            <?php echo button_to('Powrót', $sf_request->getReferer(), array('class' => 'submit')) ?>
        </form>
<?php include_partial('global/page_footer') ?>