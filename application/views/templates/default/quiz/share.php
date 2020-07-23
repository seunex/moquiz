<div class="user-home-content">
    <div class="share-quiz-container">
        <div class="share-quiz-header">
            <h4 class="text-success congrats-title"><?php echo lang('congratulations'); ?></h4>
            <img src="<?php echo asset_url('default/img/emoticons/yum.svg') ?>" class="img" />
            <h4 class=""><?php echo lang('send_your_quiz_to_your_friends') ?> </h4>
        </div>
        <div class="share-quiz-content">
            <input class="form-control form-control-lg round-input"
                   data-title="<?php echo config('website-title','FriendsQuizzy'); ?>"
                   id="quiz-link-input" readonly value="<?php echo get_quiz_url($quiz) ?>" />
            <input type="hidden" id="content-to-share" value="<?php echo lang('take_my_quiz').' '.get_quiz_url($quiz).'<Br/><br/>'.lang('see_how_well_you_can_score') ?>">
            <br/>
            <div class="share-quiz-buttons">
                <button class="btn btn-info btn-lg share-action " data-type="copy" data-msg="Link Copied Successfully"> <?php echo lang('copy-quiz-link') ?> </button>
                <button class="btn btn-info btn-lg share-action " data-type="message"> <?php echo lang('text-message') ?> </button>
                <button class="btn btn-info btn-lg share-action " data-type="whatsapp"> <?php echo lang('whatsapp') ?> </button>
                <button class="btn btn-info btn-lg share-action " data-type="facebook"> <?php echo lang('facebook'); ?> </button>
                <button class="btn btn-info btn-lg share-action " data-type="twitter"> <?php echo lang('twitter') ?> </button>
                <button class="btn btn-info btn-lg share-action " data-sub="<?php echo lang('take_my_quiz') ?>" data-type="email"> <?php echo lang('email'); ?>  </button>
                <button class="btn btn-info btn-lg share-action " data-img="<?php echo config('share-banner',asset_url('default/img/q_banner.gif')) ?>" data-type="embed"> <?php echo lang('embed-on-website'); ?>  </button>
                <button class="btn btn-secondary btn-lg share-action " data-type="view"> <?php echo lang('view-quiz-page') ?> </button>
            </div>

        </div>
    </div>
</div>