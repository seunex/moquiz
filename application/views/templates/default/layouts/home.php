<div class="container-wrapper">
    <div class="container">
        <div class="container-inner-landing-page">
            <div class="row">
                <div class="col homepage-left-handside" style="background-image: url('<?php echo asset_url().'default/img/friendsq.jpeg'; ?>');"></div>
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
                    <h5 class="landing-page-intro__box__title"><span> Create your quiz </span></h5>
                    <p class="landing-page-intro__box__desc">Make your own quiz - create  funny questions about yourself.
                        You can use our examples or write your own questions and answers.</p>

                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/winking_eye.svg') ?>" alt="😜"/></p>
                </div>
                <div class="col-4 landing-page-intro__box border-left-0">
                    <h5 class="landing-page-intro__box__title"><span> Share with your friends</span></h5>
                    <p class="landing-page-intro__box__desc">After answering all the questions you'll get a link to your quiz.
                        Share it with your friends on Whatsapp,Twitter,Facebook.</p>
                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/sunglass.svg') ?>" alt="😜"/></p>
                </div>
                <div class="col-4 landing-page-intro__box border-left-0">
                    <h5 class="landing-page-intro__box__title"><span>See their results</span></h5>
                    <p class="landing-page-intro__box__desc">Your friends will try to answer your questions and you can check the result on the scoreboard.
                        Results are sorted from top to bottom. </p>
                    <p class="text-center"><img style="height: 40px" src="<?php echo asset_url('default/img/emoticons/thumbsup.svg') ?>" alt="😜"/></p>
                </div>
            </div>
        </div>
    </div>
</div>
