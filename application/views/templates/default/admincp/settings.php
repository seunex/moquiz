<div class="title-noquiz-wrapper mt-0">
    <div class="user-home-content__my_quizzes text-left">
        <?php if ($msg): ?>
            <?php $this->view('templates/default/snippets/alert', array('message' => $msg, 'type' => 'info')); ?>
        <?php endif; ?>
        <?php echo form_open_multipart('admincp/settings', array('id' => 'profile-form')); ?>
        <?php $this->view('templates/default/admincp/settings/general'); ?>
        <?php $this->view('templates/default/admincp/settings/appearance'); ?>
        <?php $this->view('templates/default/admincp/settings/social'); ?>
        <br/>
        <br/>
        <div class="profile-wrapper__btn_container text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-action"
                    style=""> <?php echo lang('save_changes') ?> </button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

