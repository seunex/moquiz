<?php $this->view('install/menu', array('i' => $i));
?> <?php echo form_open('install/database',array('id'=>'install-form','method'=>'post'));?>
    <div class="row">
        <div class="container">
            <div class="installation-wrapper-container__content mt-4 m-4">
                <?php if($message): ?>
                    <?php $this->view('templates/default/snippets/alert',array('message'=> $message,'type'=>'danger')); ?>
                <?php endif; ?>
                <div class="form-group">
                    <label id="host-name" class=""><?php echo "Hostname" ?></label>
                    <input id="host-name" name="db_hostname" type="text" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label id="db-name" class=""><?php echo "Database Name" ?></label>
                    <input id="db-name" name="db_name" type="text" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label id="db-name" class=""><?php echo "Username" ?></label>
                    <input id="db-name" name="db_username" type="text" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label id="db-name" class=""><?php echo "Password" ?></label>
                    <input id="db-name" name="db_password" type="text" class="form-control form-control-lg">
                </div>
            </div>
            <input type="hidden" name="success" value="1"/>
            <button type="submit" class="ml-4 btn btn-primary btn-lg btn-action"> <?php echo lang('continue') ?> </button>
        </div>
    </div>
<?php  echo form_close(); ?>