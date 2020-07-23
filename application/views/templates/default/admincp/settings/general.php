<h6 class="mt-2 mb-4"><?php echo lang('general-settings') ?></h6>

<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="website-title" class=" font-14"> <?php echo lang('website-title') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'website-title', 'value' => config('website-title', 'FriendsQuizzy'), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control', 'id' => 'website-title')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="website-description"
                   class=" font-14"> <?php echo lang('website-description') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'website-description', 'value' => config('website-description', ''), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control', 'id' => 'website-description')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="website-keywords" class=" font-14"> <?php echo lang('website-keywords') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'website-keywords', 'value' => config('website-keywords', ''), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control', 'id' => 'website-keywords')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="website-google-analytics"
                   class=" font-14"> <?php echo lang('website-google-analytics') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_textarea(array('name' => 'website-google-analytics', 'value' => config('website-google-analytics', ''), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control min-height-textarea', 'id' => 'website-google-analytics')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="website-google-analytics" class=" font-14"> <?php echo lang('ads-code') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_textarea(array('name' => 'ads-code', 'value' => config('ads-code', ''), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control min-height-textarea', 'id' => 'ads-code')); ?>
        </div>
    </div>
</div>