<div class="container">
    <div class="main-register-wrapper">
        <div class="wrapper">
            <div class="wrapper-title">
                <?php echo lang('login'); ?>
            </div>
            <div class="wrapper-content">
                <?php  if(validation_errors()):?>
                    <?php $this->view('templates/default/snippets/alert',array('message'=> validation_errors(),'type'=>'danger')); ?>
                <?php endif; ?>

                <?php  if(isset($message)):?>
                    <?php $this->view('templates/default/snippets/alert',array('message'=> $message,'type'=>'danger')); ?>
                <?php endif; ?>
                <div class="">
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
                </di v>
            </div>
        </div>
    </div>
</div>