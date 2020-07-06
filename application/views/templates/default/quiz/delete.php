<div class="user-home-content">
    <div class="text-center">
    <?php if($type == 'no-quiz'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><?php echo lang('error-occured') ?></strong> <?php echo lang('quiz-not-found') ?>
            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>-->
        </div>
    <?php endif; ?>

    <?php if($type == 'no-perm'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><?php echo lang('unathorized') ?></strong> <?php echo lang('you-donont-have-permission') ?>
            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>-->
        </div>
    <?php endif; ?>

    <?php if($type == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo lang('success') ?></strong> <?php echo lang('quiz-successfully-deleted') ?>
        </div>
    <?php endif; ?>
</div>
</div>