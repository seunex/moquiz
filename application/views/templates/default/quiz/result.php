<?php
$score = get_quiz_score($quiz_result, true);
$score_color = 'text-danger';
$o_score = (int)$score;
if($o_score > 70){
    $o_score = 'text-success';
}elseif($o_score > 50 && $o_score < 70){
    $o_score = 'text-warning';
}else{
    $o_score = 'text-danger';
}
?>

<div class="user-home-content">
    <div class="home-title text-center">
        <img src="<?php echo get_avatar($user) ?>" class="avatar-start-quiz" />
        <h4 class="made-for-you-title"><em><?php echo get_user_name($user) ?></em> <?php echo lang('made_a_quiz_named'); ?></h4>
        <h4 class="quiz-start-title">"<?php echo quiz_data('title',$quiz); ?>"</h4>
        <!--<h4 class=""><?php /*echo lang('quiz_title') */?> : <?php /*echo $quiz['title']; */?></h4>-->
        <p class="score-show <?php echo $o_score; ?>"><?php echo lang('score')  ?> : <?php echo $score; ?></p>

        <a href="" class="btn btn-lg btn-action"><i data-feather="chevrons-left"></i> <?php echo lang('see_score_board') ?>  </a>
    </div>
    <div class="home-content no-padding-top">
        <?php foreach ($question_result as $k=>$qr):
            $question = get_question($qr['question_id']);
            $question = $question[0];
            ?>
            <div class="question-result-row <?php echo ($qr['correct']) ? 'bg-success' : 'bg-danger'; ?>">
                <?php if($question['image']): ?>
                    <img src="<?php echo site_url($question['image']) ?>" class="img img-thumbnail" />
                <?php endif; ?>
                <p><?php echo (isset($question['text'])) ? $question['text'] : null; ?></p>
                <?php if($qr['correct']): ?>
                    <span><i  data-feather="check"></i></span>
                <?php else: ?>
                    <span><i  data-feather="x"></i></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>