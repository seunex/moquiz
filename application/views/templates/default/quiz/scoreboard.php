<div class="user-home-content">
    <div class="title-noquiz-wrapper">
        <h2 class="title-noquiz"><?php echo lang('score-board') ?></h2>
        <br/>
        <br/>
        <div class="quiz-question-row">
            <div class="divider-with-text">
                <span class="divider-with-text-line"
                      style="background: <?php echo config('side-bar-color', '#581E95') ?>"></span>
                <span class="d-text"
                      style="border-color :<?php echo config('side-bar-color', '#581E95') ?> "> <b> <?php echo $quiz['title'] ?> </b></span>
            </div>
            <?php if ($quiz_results): ?>
                <?php
                //$i = 1;
            if($i > 1) $i = $i + 1;
                ?>

                <table class="table table-bordered table-borderless mt-4 br15" style="border-radius: 30px;">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 25%"><?php echo lang('rank') ?></th>
                        <th style="width: 50%"><?php echo lang('name') ?></th>
                        <th style="width: 25%"><?php echo lang('score') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($quiz_results as $quiz_result):
                        $user = find_user($quiz_result['user_id']);
                        ?>
                        <tr class="<?php echo ($quiz_result['user_id'] == user_id()) ? 'bg-ccc' : ''; ?>">
                            <td><?php echo ordinal($i) ?></td>
                            <td><?php echo get_user_full_name($user); ?></td>
                            <td><?php echo get_quiz_score($quiz_result, true); ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>

                <div class="centered" style="text-align: center">
                    <?= $this->pagination->create_links() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>