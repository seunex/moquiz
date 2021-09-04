<div class="container-wrapper">
    <div class="container">
        <div class="container-inner-landing-page">
            <div class="row">
                <div class="col homepage-left-handside" style="
                        background-color: <?php echo config('btn-action-color', '#FF088F'); ?>;
                        background-image: url('<?php echo asset_url('default/img/bg/bg-6.svg'); ?>');
                        "></div>
                <div class="col homepage-right-handside">
                    <div class="home-page-wrapper home-page-wrapper-text">
                        <h4><?php echo lang('see_who_know_you_best'); ?></h4>
                        <span><?php echo strtoupper(lang('make_a_quiz')); ?></span>
                    </div>
                    <div class="home-page-wrapper-content">
                        <div class="home-page-wrapper-content-login">
                            <?php $this->view('templates/default/login/login_widget'); ?>
                        </div>
                        <div class="home-page-wrapper-content-signup">
                            <?php $this->view('templates/default/register/register_widget'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="container p-0 mb-5">
            <div class="row landing-page-intro">
                <div class="col-4 landing-page-intro__box">
                    <h5 class="landing-page-intro__box__title"><span> <?php echo lang('create-your-quiz'); ?> </span></h5>
                    <p class="landing-page-intro__box__desc"><?php echo lang('create-your-quiz-intro') ?></p>

                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/winking_eye.svg') ?>" alt="😜"/></p>
                </div>
                <div class="col-4 landing-page-intro__box border-left-0">
                    <h5 class="landing-page-intro__box__title"><span><?php echo lang('share-with-your-friends'); ?></span></h5>
                    <p class="landing-page-intro__box__desc"><?php echo lang('share-with-your-friends-intro') ?></p>
                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/sunglass.svg') ?>" alt="😜"/></p>
                </div>
                <div class="col-4 landing-page-intro__box border-left-0">
                    <h5 class="landing-page-intro__box__title"><span><?php echo lang('see-their-results'); ?></span></h5>
                    <p class="landing-page-intro__box__desc"><?php echo lang('see-their-results-intro') ?></p>
                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/thumbsup.svg') ?>" alt="😜"/></p>
                </div>
            </div>
        </div>
    </div>
</div>
