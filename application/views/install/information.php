<?php $this->view('install/menu', array('i' => $i));
?> <?php echo form_open('install/info',array('id'=>'install-form','method'=>'post'));?>
    <div class="row">
        <div class="container">
            <div class="installation-wrapper-container__content mt-4 m-4">
                <?php if($message): ?>
                    <?php $this->view('templates/default/snippets/alert',array('message'=> $message,'type'=>'danger')); ?>
                <?php endif; ?>
                <h6>Admin Login</h6>
                <div class="form-group">
                    <label for="full_name"> <?php echo lang('full_name') ?> </label>
                    <?php  echo form_input(array('name'=>'full_name', 'value' => set_value('full_name'), 'type'=>'text', 'placeholder'=>'', 'class'=>'form-control', 'id'=>'full_name')); ?>
                </div>

                <div class="form-group">
                    <label for="username"> <?php echo lang('username') ?> </label>
                    <?php echo form_input(array('name'=>'username', 'value' => set_value('username'), 'type'=>'text','class'=>'form-control','id'=>'username')) ?>
                </div>

                <div class="form-group">
                    <label for="email_address"> <?php echo lang('email_address') ?> </label>
                    <?php echo form_input(array('name'=> 'email_address' , 'value' => set_value('email_address'), 'type'=>'email', 'class'=> 'form-control','id'=>'email_address')); ?>
                </div>

                <div class="form-group">
                    <label> <?php echo lang('password'); ?> </label>
                    <?php echo form_password(array('name'=>'password','class'=>'form-control')) ?>
                </div>
            </div>
            <input type="hidden" name="success" value="1"/>
            <button type="submit" class="ml-4 btn btn-primary btn-lg btn-action"> <?php echo lang('continue') ?> </button>
        </div>
    </div>
<?php  echo form_close(); ?>