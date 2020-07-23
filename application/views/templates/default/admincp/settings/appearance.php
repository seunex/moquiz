<h6 class="mt-4 mb-4"><?php echo lang('appearance-settings') ?></h6>


<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="background-color" class="font-14"> <?php echo lang('background-color') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'background-color', 'value' => config('background-color','#DCD2F0'), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control color-picker', 'id' => 'background-color')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="btn-action-color" class=" font-14"> <?php echo lang('btn-action-color') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'btn-action-color', 'value' => config('btn-action-color', '#FF088F'), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control color-picker', 'id' => 'btn-action-color')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="side-bar-color" class="font-14"> <?php echo lang('side-bar-color') ?> </label>
        </div>
        <div class="col-8">
            <?php echo form_input(array('name' => 'side-bar-color', 'value' => config('side-bar-color','#581E95'), 'type' => 'text', 'placeholder' => '', 'class' => 'form-control color-picker', 'id' => 'side-bar-color')); ?>
        </div>
    </div>
</div>