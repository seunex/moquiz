<?php $i = 1; ?>
<?php foreach ($questions as $k => $q):
    ?>
    <div class="question-each-box" data-idx="<?php echo $i; ?>">

        <?php if ($q['image']): ?>
            <img src="<?php echo site_url($q['image']) ?>" class="img"/>
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
                    <?php if ($a['txt']): ?>
                        <div class="pretty p-default <?php echo ($answerType == 'radio') ? 'p-round' : 'p-curve' ?> p-thick">
                            <input type="<?php echo $answerType ?>" name="answer[<?php $q['id'] ?>][]"/>
                            <div class="state p-success-o">
                                <label class="answer-text-row"><?php echo $a['txt']; ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                </div><br/>
                <!--<span class="answer-txt-row"><?php /*echo $a['txt']; */ ?></span>-->
            <?php endforeach; ?>
        </div>
    </div>
    <?php $i++; endforeach; ?>
<div class="start-quiz-action-btns">
    <br/>
    <button class="btn btn-info btn-lg btn-round-corner btn-start-action"
            style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
        <i data-feather="arrow-left"></i> <?php echo lang('prev'); ?>
    </button>

    <button class="btn btn-info btn-lg btn-round-corner btn-start-action"
            style="background: <?php echo config('btn-action-color', '#FF088F'); ?>">
        <?php echo lang('next') ?> <i data-feather="arrow-right"></i>
    </button>
</div>




