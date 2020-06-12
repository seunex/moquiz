<?php $type = isset($type) ? $type : 'warning'; ?>

<div class="alert alert-<?php echo $type; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>