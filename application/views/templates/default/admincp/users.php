
<h3 class="ml-4 mt-4 mr-4"><?php echo lang('manage-users') ?>
    <span class="pull-right font-14"><?php echo lang('total').' :  '.$total; ?></span>
</h3>

<?php if ($users): ?>
    <div class="title-noquiz-wrapper mt-0">
        <div class="user-home-content__my_quizzes">
            <div class="table-responsive">
                <table class="table table-bordered text-left">
                    <thead>
                    <tr>
                        <th style="width: 30%"><?php echo lang('photo') ?></th>
                        <th style="width: 40%"><?php echo lang('full_name') ?></th>
                        <th style="width: 25%"><?php echo lang('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user):
                        $avatar = get_avatar($user);
                        ?>
                        <tr>
                            <td class="text-center"><img src="<?php echo $avatar; ?>" class="img-table-quiz"/></td>
                            <td><?php echo get_user_name($user); ?></td>
                            <td class="quiz-list-actions">
                                <a class="text-danger ml-2 user-delete-btn"
                                   data-title="<?php echo lang('are-you-sure-you-want-to-delete-this-user'); ?>"
                                   data-text="<?php echo lang('you_wont_be_able_to_revert_this'); ?>"
                                   data-confirm="<?php echo lang('yes_delete_it'); ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   data-id="<?php echo $user['id'] ?>" title="<?php echo lang('delete') ?>" href="#"> <i
                                        data-feather="x"></i>
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
            <?php echo lang('no-user-found') ?>
        </div>
    </div>
<?php endif; ?>
