<div class="container">
    <div class="start-quiz-container">
        <div class="start-quiz-container-box">

            <img src="<?php echo get_avatar($user) ?>" class="avatar-start-quiz"/>

            <h4 class="made-for-you-title"><?php echo get_user_name($user) ?> <?php echo lang('made_a_quiz_named'); ?></h4>
            <h4 class="quiz-start-title">"<?php echo quiz_data('title', $quiz); ?>"</h4>
            <?php if (isLoggedIn()): ?>
                <br/>
                <div class="divider-with-text">
                    <span class="divider-with-text-line"
                          style="background: <?php echo config('side-bar-color', '#581E95') ?>"></span>
                    <span class="d-text"
                          style="border-color :<?php echo config('side-bar-color', '#581E95') ?> "> <b> <?php echo 'Completed' ?></b></span>
                </div>
                <div class="alert alert-success mt-4">
                    <span> <?php echo lang('you_already_took_this_quiz'); ?> <a href="<?php echo get_outcome_url($quiz)  ?>"> <?php echo lang('see-quiz-results-here'); ?></a></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
