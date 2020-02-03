<div class="user-home-content">
    <?php if ($quiz): ?>
        <h2>Display Quiz</h2>
    <?php else: ?>
        <div class="title-noquiz-wrapper">
            <h6 class="title-noquiz">You have no Quiz Yet! <a href="<?php echo site_url('quiz/create') ?>"> Create Quiz
                    Now </a></h6>
            <i data-feather="cloud-snow"></i>
        </div>
    <?php endif; ?>
</div>
