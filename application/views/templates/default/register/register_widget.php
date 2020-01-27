
<div class="login-widget-wrapper">
    <div class="divider-with-text">
        <span class="divider-with-text-line"></span>
        <span class="d-text bold"> <?php echo lang('create_your_account') ?> </span>
    </div>
    <br/>
    <form method="post" action="<?php echo key_to_url('register_auth') ?>">
        <?php echo form_input(array('type'=>'hidden','name'=>$this->security->get_csrf_token_name(),'value'=>$this->security->get_csrf_hash())) ?>
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

        <button type="submit" class="btn btn-primary "> <?php echo lang('create_your_account') ?> </button>
    </form>
</div>