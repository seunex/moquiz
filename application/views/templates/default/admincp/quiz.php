
<h3 class="ml-4 mt-4 mr-4"><?php echo lang('manage-quiz') ?>
    <span class="pull-right font-14"><?php echo lang('total').' :  '.$total; ?></span>
</h3>

<?php if ($quiz): ?>
    <div class="title-noquiz-wrapper mt-0">
        <div class="user-home-content__my_quizzes">
            <div class="table-responsive">
                <table class="table table-bordered text-left">
                    <thead>
                    <tr>
                        <th style="width: 20%"><?php echo lang('owner') ?></th>
                        <th style="width: 40%"><?php echo lang('quiz_title') ?></th>
                        <th style="width: 5%"><?php echo lang('participants') ?></th>
                        <th style="width: 25%"><?php echo lang('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($quiz as $q):
                        $owner = find_user($q['user_id']);
                    $avatar = get_avatar($owner);
                        ?>
                        <tr>
                            <td class="text-center"><img src="<?php echo $avatar; ?>" class="img-table-quiz" /> <span class=""><?php echo get_user_name($owner); ?></span></td>
                            <td><?php echo $q['title']; ?></td>
                            <td><?php echo get_participants($q, 'count'); ?></td>
                            <td class="quiz-list-actions">
                                <a class="text-danger ml-2 quiz-delete-btn"
                                   data-title="<?php echo lang('are-you-sure-you-want-to-delete-this-quiz'); ?>"
                                   data-text="<?php echo lang('you_wont_be_able_to_revert_this'); ?>"
                                   data-confirm="<?php echo lang('yes_delete_it'); ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   data-id="<?php echo $q['id'] ?>" title="<?php echo lang('delete') ?>" href="#"> <i
                                            data-feather="x"></i></a>
                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('score-board') ?>"
                                   href="<?php echo site_url('quiz/scoreboard/' . $q['id']) ?>"><i
                                            data-feather="monitor"></i>
                                </a>

                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('share-quiz') ?>"
                                   href="<?php echo site_url('quiz/share/' . $q['id']) ?>"><i
                                            data-feather="share-2"></i>
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
        <div class="alert alert-info">
            <?php echo lang('no-quiz-found') ?>
        </div>
    </div>
<?php endif; ?>
