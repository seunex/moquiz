<div class="row">
    <div class="container">
        <div class="installation-wrapper-container__content mt-4 m-4">
            <?php $congrats = lang('congratulations') ?>
            <?php $msg = lang('your-installation-is-now-complete'); ?>
            <div class="font-14 alert alert-<?php echo 'success'; ?> alert-dismissible fade show" role="alert">
                <strong><?php echo $congrats; ?></strong><?php echo $msg; ?>
            </div>
            <a href="<?php echo url('') ?>" class="btn btn-primary btn-lg btn-action"> <?php echo lang('visit-site') ?> </a>
        </div>
    </div>
</div>