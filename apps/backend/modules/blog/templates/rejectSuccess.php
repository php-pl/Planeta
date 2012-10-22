<div id="sf_admin_container">
    <h1>Odrzucenie bloga <?php echo $blog->getName() ?></h1>
    
    <div id="sf_admin_content">
        <?php echo form_tag('blog/reject') ?>
            <?php echo input_hidden_tag('id', $blog->getId()) ?>
    
            <fieldset id="sf_fieldset_none" class="">
                <div class="form-row"> 
                    <?php echo label_for('data_reason', 'Powód odrzucenia:'); ?>
                  
                    <div class="content">   
                        <?php echo textarea_tag('data[reason]', '', 'cols=80 rows=10'); ?>
                    </div>
                </div>
                
                <div class="form-row"> 
                    <?php echo label_for('data_delete', 'Usunąć?:'); ?>
                  
                    <div class="content">   
                        <?php echo checkbox_tag('data[delete]'); ?>
                    </div>
                </div>
            </fieldset>
    
            <ul class="sf_admin_actions">
                <li><?php echo submit_tag('Odrzuć') ?></li>
                <li><?php echo button_to('Powrót', 'blog/list?id='.$blog->getId(), array ('class' => 'sf_admin_action_list')) ?></li>
            </ul>
        </form>
    </div>
</div>