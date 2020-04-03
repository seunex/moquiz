<?php $i = 1; ?>
<?php echo form_open(site_url('quiz/take'),array('id'=>'take-quiz-form', 'method'=>'post')) ?>
<input type="hidden" name="ajax" value="submit" />
<input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>" />
<div class="form-loader">
    <i class="loading-icon" data-feather="loader"></i>
</div>
<?php foreach ($questions as $k => $q):
    ?>
<!--<form class="" id="take-quiz-form" action="<?php /*echo site_url('quiz/take') */?>" method="post">-->

    <div class="question-each-box question-each-box-index-<?php echo $i; ?>  <?php echo ($i == 1) ? 'active' : 'not-active' ?>" data-idx="<?php echo $i; ?>">

        <?php if ($q['image']): ?>
            <img style="max-height: 300px" src="<?php echo site_url($q['image']) ?>" class="img"/>
            <br/>
            <br/>
        <?php endif; ?>

        <?php if ($q['text']): ?>
            <h4><?php echo $q['text']; ?></h4>
        <?php endif; ?>
        <br/>
        <div class="answers-block">
            <?php
            $answers = get_question_answers($q);
            $answerType = answers_type($answers);
            ?>
            <?php foreach ($answers as $a): ?>
                <div class="answer-row-text-image">
                    <?php if($a['image']): ?>
                        <img src="<?php echo site_url($a['image']) ?>" class="answer-image-display" />
                    <?php endif;?>

                        <div class="pretty p-default <?php echo ($answerType == 'radio') ? 'p-round' : 'p-curve' ?> p-thick">
                            <?php if($answerType == 'radio'): ?>
                                <input type="<?php echo 'radio' ?>" value="<?php echo $a['id'] ?>" name="answer[<?php echo $q['id'] ?>]"/>
                            <?php else: ?>
                                <input type="<?php echo 'checkbox' ?>" value="<?php echo $a['id'] ?>" name="answer[<?php echo $q['id'] ?>][]"/>
                            <?php endif; ?>
                            <div class="state p-success-o">
                                <?php if ($a['txt']): ?>
                                <label class="answer-text-row"><?php echo $a['txt']; ?></label>
                                <?php else: ?>
                                    <label class="answer-text-row">&nbsp;&nbsp;</label>
                                <?php endif; ?>
                            </div>
                        </div>
                </div><br/>
                <!--<span class="answer-txt-row"><?php /*echo $a['txt']; */ ?></span>-->
            <?php endforeach; ?>
        </div>
    </div>
    <?php $i++; endforeach; ?>
<div class="start-quiz-action-btns">
    <br/>
    <button class="btn btn-info btn-lg btn-round-corner btn-start-action-prev"
            style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
        <i data-feather="arrow-left"></i> <?php echo lang('prev'); ?>
    </button>

    <button class="btn btn-info btn-lg btn-round-corner btn-start-action-next"
            data-canswer="<?php echo lang('choose-answer') ?>"
            style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
        <?php echo lang('next') ?> <i data-feather="arrow-right"></i>
    </button>
    <button type="button" class="btn btn-info btn-lg btn-round-corner btn-start-action-submit"
            onclick=""
            style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
        <span style="font-size: 14px"> <?php echo lang('submit') ?></span> <!--<i data-feather="save"></i>-->
    </button>

</div>
<?php echo form_close(); ?>




