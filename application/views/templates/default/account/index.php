<div class="user-home-content">
    <?php if ($quiz): ?>
    <div class="title-noquiz-wrapper">
        <div class="user-home-content__my_quizzes">
            <h2 class="mb-4"><?php echo lang('my-quizzes') ?></h2>
            <div class="table-responsive">
                <table class="table table-bordered text-left">
                    <thead>
                    <tr>
                        <th style="width: 50%"><?php echo lang('quiz') ?></th>
                        <th style="width: 10%"><?php echo lang('participants') ?></th>
                        <th style="width: 30%"><?php echo lang('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($quiz as $q): ?>
                        <tr>
                            <td><?php echo $q['title']; ?></td>
                            <td><?php echo get_participants($q,'count'); ?></td>
                            <td class="quiz-list-actions">
                                <a class="text-danger ml-2 quiz-delete-btn"
                                   data-title="<?php echo lang('are-you-sure-you-want-to-delete-this-quiz'); ?>"
                                   data-text="<?php echo lang('you_wont_be_able_to_revert_this'); ?>"
                                   data-confirm="<?php echo lang('yes_delete_it'); ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   data-id="<?php echo $q['id'] ?>" title="<?php echo lang('delete') ?>" href="#"> <i data-feather="x"></i></a>
                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('score-board') ?>" href="<?php echo site_url('quiz/scoreboard/'.$q['id']) ?>"><i data-feather="monitor"></i>
                                </a>

                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('share-quiz') ?>" href="<?php echo site_url('quiz/share/'.$q['id']) ?>"><i data-feather="share-2"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="centered" style="text-align: center">
                    <?= $this->pagination->create_links() ?>
                </div>
            </div>
        </div>
        </div>
    <?php else: ?>
        <div class="title-noquiz-wrapper">
            <h6 class="title-noquiz"><?php echo lang('you_have_no_quiz_yet') ?> <a
                        href="<?php echo site_url('quiz/create') ?>"> <?php echo lang('create_quiz_now') ?></a></h6>

            <div class="icon-wrapper"> <i data-feather="cloud-snow"></i></div>
        </div>
    <?php endif; ?>
</div>
