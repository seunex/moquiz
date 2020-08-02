<div class="container">
    <div class="user-home-wrapper">
        <div class="mobile-menu-row mobile-menu-header">
            <ul>
                <li class="<?php echo ($active == 'home') ? 'active' : null; ?>" data-title="<?php echo lang('home') ?>"><a href="<?php echo site_url('home') ?>"> <i data-feather="home"></i></a></li>
                <li class="<?php echo ($active == 'create-quiz') ? 'active' : null; ?>"  data-title="<?php echo lang('create_a_quiz') ?>"><a href="<?php echo site_url('quiz/create') ?>"><i data-feather="plus-square"></i></a></li>
                <li class="<?php echo ($active == 'profile') ? 'active' : null; ?>"  data-title="<?php echo lang('profile') ?>"><a href="<?php echo site_url('account') ?>"><i data-feather="user"></i></a></li>
                <?php if(is_admin()):; ?>
                    <li class="<?php echo ($active == 'admin-panel') ? 'active' : null; ?>"  data-title="<?php echo lang('admin_panel') ?>"><a href="<?php echo site_url('admincp') ?>"> <i data-feather="settings"></i></a></li>
                <?php endif; ?>
                <li class="<?php echo ($active == 'logout') ? 'active' : null; ?>"  data-title="<?php echo lang('logout') ?>"><a href="<?php echo site_url('logout') ?>"> <i data-feather="lock"></i></a></li>
            </ul>
        </div>
        <div class="user-side-bar-menu">
            <ul>
                <li class="<?php echo ($active == 'home') ? 'active' : null; ?>" data-title="<?php echo lang('home') ?>"><a href="<?php echo site_url('home') ?>"> <i data-feather="home"></i> <?php echo lang('home') ?> </a></li>
                <li class="<?php echo ($active == 'create-quiz') ? 'active' : null; ?>"  data-title="<?php echo lang('create_a_quiz') ?>"><a href="<?php echo site_url('quiz/create') ?>"><i data-feather="plus-square"></i><?php echo lang('create_a_quiz') ?></a></li>
                <li class="<?php echo ($active == 'profile') ? 'active' : null; ?>"  data-title="<?php echo lang('profile') ?>"><a href="<?php echo site_url('account') ?>"><i data-feather="user"></i><?php echo lang('profile') ?></a></li>
                <?php if(is_admin()):; ?>
                <li class="<?php echo ($active == 'admin-panel') ? 'active' : null; ?>"  data-title="<?php echo lang('admin_panel') ?>"><a href="<?php echo site_url('admincp') ?>"> <i data-feather="settings"></i> <?php echo lang('admin_panel') ?> </a></li>
                <?php endif; ?>
                <li class="<?php echo ($active == 'logout') ? 'active' : null; ?>"  data-title="<?php echo lang('logout') ?>"><a href="<?php echo site_url('logout') ?>"> <i data-feather="lock"></i> <?php echo lang('logout'); ?></a></li>
            </ul>
        </div>
        <?php echo $content; ?>
    </div>
</div>

