<div class="login-widget-wrapper">
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

        <p class="forgot-me-container"><input type="checkbox" /> <?php echo lang('remember_me') ?> <span class="pull-right"> <a class="forgot-password" href=""> <?php echo lang("forgot_password") ?></a> </span> </p>

        <button type="submit" class="btn btn-primary btn-smg"><?php echo lang('sign_in') ?></button>
    </form>
</div>
<?php $this->view('templates/default/login/login_social'); ?>