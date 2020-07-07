<div class="user-home-content">
    <div class="title-noquiz-wrapper">
        <h2 class="title-noquiz"><?php echo lang('my_profile') ?></h2>
        <br/>
        <br/>
        <div class="profile-wrapper text-left">
            <?php  if($msg):?>
                <?php $this->view('templates/default/snippets/alert',array('message'=> $msg,'type'=>'info')); ?>
            <?php endif; ?>
            <?php echo form_open_multipart('account', array('id' => 'profile-form')); ?>
            <?php ///echo form_input(array('type' => 'hidden', 'name' => $this->security->get_csrf_token_name(), 'value' => $this->security->get_csrf_hash())) ?>
            <div class="form-group">
                <label for="full_name"> <?php echo lang('full_name') ?> </label>
                <?php echo form_input(array('name' => 'full_name', 'value' => $user['full_name'], 'type' => 'text', 'placeholder' => '', 'class' => 'form-control', 'id' => 'full_name')); ?>
            </div>

            <div class="form-group">
                <label for="username"> <?php echo lang('username') ?> </label>
                <?php echo form_input(array('name' => 'username', 'value' => $user['username'], 'type' => 'text', 'class' => 'form-control', 'id' => 'username', 'autocomplete' => 'off')) ?>
            </div>

            <div class="form-group">
                <label for="email_address"> <?php echo lang('email_address') ?> </label>
                <?php echo form_input(array('name' => 'email_address', 'value' => $user['email_address'], 'type' => 'email', 'class' => 'form-control', 'id' => 'email_address')); ?>
            </div>

            <h6 class="mt-4"><?php echo lang('change-password') ?></h6>
            <div class="form-group">
                <label> <?php echo lang('old_password'); ?> </label>
                <?php echo form_password(array('name' => 'old_password', 'class' => 'form-control', 'autocomplete' => 'off')) ?>
            </div>
            <div class="form-group">
                <label> <?php echo lang('new_password'); ?> </label>
                <?php echo form_password(array('name' => 'new_password', 'class' => 'form-control', 'autocomplete' => 'off')) ?>
            </div>
            <div class="form-group">
                <label> <?php echo lang('new_password_confirmation'); ?> </label>
                <?php echo form_password(array('name' => 'new_password_c', 'class' => 'form-control', 'autocomplete' => 'off')) ?>
            </div>

            <h6 class="mt-4"><?php echo lang('profile-photo') ?></h6>
            <?php $avatar = get_avatar(); ?>
            <div class="profile-picture-wrapper">
                <img src="<?php echo $avatar ?>" class="img">
                <input type="file" name="avatar" class="form-control-file" accept="image/*"/>
            </div>
            <br/>
            <br/>
            <div class="profile-wrapper__btn_container text-center">
                <button type="submit" class="btn btn-primary btn-lg"> <?php echo lang('save_changes') ?> </button>
                <hr/>
                <button type="button"
                        data-title="<?php echo lang('are-you-sure-you-want-to-delete-account'); ?>"
                        data-text="<?php echo lang('you_wont_be_able_to_revert_this'); ?>"
                        data-confirm="<?php echo lang('yes_delete_it'); ?>"
                        data-id="<?php echo md5(get_user_name()) ?>"
                        onclick="return delete_user(this)" class="btn btn-danger btn-lg"><?php echo lang('delete-account') ?></button>
            </div>
            </form>
        </div>
    </div>
</div>
