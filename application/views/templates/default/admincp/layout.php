<div class="user-home-content p-0">
    <div class="py-3 top-admin-header" style="background-color: #eeeeee;">
        <h3 class="title-noquiz text-center mt-3 mb-4"><?php echo lang('admin-control-panel') ?></h3>
        <ul class="nav justify-content-center mb-3">
            <li class="nav-item">
                <a class="nav-link <?php echo ($active == 'dashboard') ? 'active' : '' ?> btn btn-secondary border-right-0" href="<?php echo site_url('admincp') ?>"><?php echo lang('dashboard') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-secondary <?php echo ($active == 'users') ? 'active' : '' ?> border-right-0" href="<?php echo site_url('admincp/users') ?>"><?php echo lang('manage-users') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-secondary <?php echo ($active == 'quiz') ? 'active' : '' ?> border-right-0" href="<?php echo site_url('admincp/quiz') ?>"><?php echo lang('manage-quiz') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-secondary <?php echo ($active == 'settings') ? 'active' : '' ?> border-right-0" href="<?php echo site_url('admincp/settings') ?>"><?php echo lang('system-settings'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-secondary <?php echo ($active == 'pages') ? 'active' : '' ?>" href="<?php echo site_url('admincp/pages') ?>"><?php echo lang('manage-pages'); ?></a>
            </li>
        </ul>
    </div>

    <?php echo $content; ?>
</div>
