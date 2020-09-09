<div class="login-widget-wrapper">
    <?php if(DEMO): ?>
        <p><b>Demo Login Information</b></p>
        <p><em>Email Address</em> : test@mquizzy.com </p>
        <p><em>Password </em> : 123456 </p>
    <?php endif; ?>
    <form action="<?php echo key_to_url('login_auth') ?>" method="post">
        <?php echo form_input(array('type'=>'hidden','name'=>$this->security->get_csrf_token_name(),'value'=>$this->security->get_csrf_hash())) ?>
        <div class="form-group">
            <label for="email_address"><?php echo lang("username_or_emailaddress") ?></label>
            <?php echo form_input(array('type'=>'text','name'=>'email_address','class'=>'form-control')); ?>
        </div>

        <div class="form-group">
            <label> <?php echo lang('password') ?> </label>
            <?php echo form_input(array('type'=>'password','name'=>'password','class'=>'form-control')); ?>
        </div>

        <p class="forgot-me-container"><input type="checkbox" /> <?php echo lang('remember_me') ?>  </p>

        <button type="submit" class="btn btn-primary btn-smg btn-action"><?php echo lang('sign_in') ?></button>
    </form>
</div>
<?php $this->view('templates/default/login/login_social'); ?>