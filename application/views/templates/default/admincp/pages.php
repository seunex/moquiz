<h3 class="ml-4 mt-4 mr-4"><?php echo $title; ?>
    <?php if ($show_add_btn): ?>
        <a class="pull-right btn btn-action btn-sm"
           href="<?php echo url('admincp/pages').'?type=add'; ?>">
            <i data-feather="plus"></i> &nbsp;<?php echo lang('add-page') ?>
        </a>
    <?php endif; ?>
</h3>

<?php if($msg): ?>
    <?php $this->view('templates/default/snippets/alert',array('message'=>$msg,'type'=>'info')); ?>
<?php endif; ?>

<?php if ($pages && !$type): ?>
    <div class="title-noquiz-wrapper mt-0">
        <div class="user-home-content__my_quizzes">
            <div class="table-responsive">
                <table class="table table-bordered text-left">
                    <thead>
                    <tr>
                        <th style="width: 75%;" class="h6"><?php echo lang('page-title') ?></th>
                        <th style="width: 25%" class="h6"><?php echo lang('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pages as $p): ?>
                        <tr>
                            <td class="py-4"><a class="font-16" href="<?php echo page_url($p); ?>"> <?php echo $p['title']; ?></a></td>
                            <td class="py-4 quiz-list-actions">
                                <a class="text-danger ml-2 page-delete-btn"
                                   data-title="<?php echo lang('are-you-sure-you-want-to-delete-this-page'); ?>"
                                   data-text="<?php echo lang('you_wont_be_able_to_revert_this'); ?>"
                                   data-confirm="<?php echo lang('yes_delete_it'); ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   data-id="<?php echo $p['id'] ?>" title="<?php echo lang('delete-page') ?>" href="#"> <i
                                            data-feather="x"></i></a>
                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('view-page') ?>"
                                   href="<?php echo page_url($p); ?>"><i
                                            data-feather="eye"></i>
                                </a>

                                <a class="text-secondary ml-4"
                                   data-toggle="tooltip" data-placement="top"
                                   title="<?php echo lang('edit-page') ?>"
                                   href="<?php echo site_url('admincp/pages?type=edit&id=' . $p['id']) ?>"><i
                                            data-feather="edit-3"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == 'edit' || $type == 'add'): ?>
    <div class="title-noquiz-wrapper text-left max-width-form m-0">
        <?php echo form_open_multipart('admincp/pages?type='.$type, array('id' => 'profile-form')); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="title" class=" font-14"> <?php echo lang('page-title') ?> </label>
                    <?php echo form_input(array('autocomplete' => 'off', 'name' => 'title', 'value' => (isset($p['title'])) ? $p['title'] : null , 'type' => 'text', 'placeholder' => '', 'class' => 'form-control', 'id' => 'page-title')); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="title" class=" font-14"> <?php echo lang('page-content') ?> </label>
                    <?php echo form_textarea(array('name' => 'content', 'value' => (isset($p['content'])) ? $p['content'] : null, 'type' => 'text', 'placeholder' => '', 'class' => 'form-control p-editor', 'id' => 'page-content')); ?>
                </div>
            </div>
        </div>
        <input type="hidden" name="pid" value="<?php echo isset($p['id']) ? $p['id'] : null  ?>" />
        <div class="profile-wrapper__btn_container">
            <button type="submit" class="btn btn-primary btn-lg btn-action"
                    style=""> <?php echo lang('save_changes') ?> </button>
        </div>
        <?php echo form_close(); ?>
    </div>
<?php endif; ?>