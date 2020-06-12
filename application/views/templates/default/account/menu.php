<div class="container">
    <div class="user-home-wrapper">
        <div class="user-side-bar-menu">
            <ul>
                <li class="<?php echo ($active == 'home') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Home"><a href="<?php echo site_url('home') ?>"> <i data-feather="home"></i> Home </a></li>
                <li class="<?php echo ($active == 'create-quiz') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Create a Quiz"><a href="<?php echo site_url('quiz/create') ?>"><i data-feather="plus-square"></i>Create a Quiz </a></li>
                <li class="<?php echo ($active == 'profile') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Profile"><a href=""><i data-feather="user"></i>Profile </a></li>
                <li class="<?php echo ($active == 'score-board') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Score Board"><a href=""> <i data-feather="monitor"></i>Score Board </a></li>
                <li class="<?php echo ($active == 'admin-panel') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Admin Panel"><a href=""> <i data-feather="settings"></i> Admin Panel </a></li>
                <li class="<?php echo ($active == 'logout') ? 'active' : null; ?>" data-toggle="tooltip" data-title="Logout"><a href="<?php echo site_url('logout') ?>"> <i data-feather="lock"></i>Logout </a></li>
            </ul>
        </div>
        <?php echo $content; ?>
    </div>
</div>

