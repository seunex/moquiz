<div class="container">
    <div class="start-quiz-container">
        <div class="start-quiz-container-box">

            <img src="<?php echo get_avatar($user) ?>" class="avatar-start-quiz"/>

            <h4 class="made-for-you-title"><?php echo get_user_name($user) ?><?php echo lang('made_a_quiz_named'); ?></h4>
            <h4 class="quiz-start-title">"<?php echo quiz_data('title', $quiz); ?>"</h4>

            <?php /*if (config('take-quiz-with-name-only', 0)): */ ?>
            <?php if (isLoggedIn()): ?>
                <br/>
                <div class="divider-with-text">
                    <span class="divider-with-text-line"
                          style="background: <?php echo config('side-bar-color', '#581E95') ?>"></span>
                    <span class="d-text"
                          style="border-color :<?php echo config('side-bar-color', '#581E95') ?> "> <b> <?php echo 'Question ' ?><span
                                    class="q-start-count">1</span> </b></span>
                </div>
                <?php $this->view('templates/default/quiz/list/questions', array('questions' => $questions, 'quiz' => $quiz)); ?>
                <!--<div class="form-holder-for-just-name" style="display: none">
                    <div class="form-group">
                        <label class="label-input-name"><?php /*echo lang('your_name') */ ?></label>
                        <input type="text" name="first_name" placeholder="<?php /*echo lang('your_name') */ ?>"
                               class="form-control form-control-lg form-round"/>
                    </div>
                    <button class="btn btn-info btn-lg"
                            style="background: <?php /*echo config('btn-action-color', '#FF088F'); */ ?>"><i
                                data-feather="edit"></i> <?php /*echo lang('take_quiz') */ ?> </button>
                </div><br/><br/>-->
            <?php else: ?>
                <div class="social-login-wrapper">
                    <div class="container">
                        <a href="<?php echo site_url('signup') ?>" onclick="return signup_with_email_modal()"
                           class="btn btn-info btn-block join-with-email-parent py-2 mb-3"
                           style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
                            <!--<i data-feather="mail"></i>-->
                            <span class="join-with-email"><?php echo lang('signup_with_email_to_take_quiz') ?> </span>
                        </a>

                        <div class="row">
                            <?php if (config('allow-facebook-signup', 1)): ?>
                                <div class="col-sm-12 mb-2">
                                    <div class="sl-row sl-facebook">
                                        <a href="<?php echo url('auth/facebook') ?>">
                                            <img src="<?php echo img_url('social/facebook.png'); ?>"/>
                                            <span class="sl-text-wrapper">
                     <span class="sl-text"> <?php echo lang('login_with_facebook_to_take_quiz') ?></span>
                     </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (config('allow-twitter-signup', 1)): ?>
                                <div class="col-sm-12 mb-2">
                                    <div class="sl-row sl-tw">
                                        <a href="<?php echo url('auth/twitter') ?>">
                                            <img src="<?php echo img_url('social/twitter.png'); ?>"/>
                                            <span class="sl-text-wrapper">
                        <span class="sl-text"> <?php echo lang('login_with_twitter_to_take_quiz'); ?> </span>
                        </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (config('allow-google-signup', 1)): ?>
                                <div class="col-sm-12">
                                    <div class="sl-row sl-google">
                                        <a href="<?php echo url('auth/google') ?>">
                                            <img src="<?php echo img_url('social/google.png'); ?>"/>
                                            <span class="sl-text-wrapper">
                        <span class="sl-text"> <?php echo lang('login_with_google_to_take_quiz'); ?> </span>
                        </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <div class="or-take-quiz-actions" style="display: none">
                <p><b>Or : </b></p>
                <button class="btn btn-info btn-lg btn-round-corner btn-start-action"
                        style="background: <?php echo config('btn-action-color', '#FF088F'); ?>"><?php echo lang('view'); ?>
                    <br/> <?php echo lang('score_board') ?> </button>
                <button class="btn btn-info btn-lg btn-round-corner btn-start-action"
                        style="background: <?php echo config('btn-action-color', '#FF088F'); ?>"> <?php echo lang('send_quiz') ?>
                    <br/> <?php echo lang('to_more_friends') ?> </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Signup -->
<?php $this->view('templates/default/register/modal'); ?>