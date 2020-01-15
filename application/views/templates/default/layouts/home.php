<div class="container-wrapper">
    <div class="container">
        <div class="container-inner-landing-page">
            <div class="row">
                <div class="col homepage-left-handside" style="background-image: url('<?php echo asset_url().'default/img/banners/friend.jpg'; ?>');"></div>
                <div class="col homepage-right-handside">
                    <div class="home-page-wrapper">
                        <h4><?php echo lang('see_who_know_you_best'); ?></h4>
                        <span><?php echo strtoupper(lang('make_a_quiz')); ?></span>
                    </div>
                    <?php $this->view('templates/default/login/login_widget'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
