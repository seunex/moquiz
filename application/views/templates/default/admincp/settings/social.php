<h6 class="mt-4 mb-4"><?php echo lang('social-login') ?></h6>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="enable-facebook-login"
                   class=" font-14"> <?php echo lang('enable-facebook-login') ?> </label>
        </div>
        <div class="col-8">
            <label class="switch">
                <input type="radio" name="allow-facebook-signup"
                       value="0" <?php echo (!config('allow-facebook-signup', 1)) ? 'checked' : '' ?>/>
                <input type="radio" name="allow-facebook-signup"
                       value="1" <?php echo (config('allow-facebook-signup', 1)) ? 'checked' : '' ?>/>
                <span class="slider round"></span>
            </label>
            <br/>
            <label for="facebook-key" class=" font-12"> <?php echo lang('facebook-key') ?> </label>
            <?php echo form_input(array('placeholder' => lang('facebook-key'), 'name' => 'facebook-key', 'value' => config('facebook-key', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'facebook-key')); ?>
            <br/>
            <label for="facebook-secret" class=" font-12"> <?php echo lang('facebook-secret') ?> </label>
            <?php echo form_input(array('placeholder' => lang('facebook-secret'), 'name' => 'facebook-secret', 'value' => config('facebook-secret', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'facebook-secret')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="enable-twitter-login"
                   class=" font-14"> <?php echo lang('enable-twitter-login') ?> </label>
        </div>
        <div class="col-8">
            <label class="switch">
                <input type="radio" name="allow-twitter-signup"
                       value="0" <?php echo (!config('allow-twitter-signup', 1)) ? 'checked' : '' ?>/>
                <input type="radio" name="allow-twitter-signup"
                       value="1" <?php echo (config('allow-twitter-signup', 1)) ? 'checked' : '' ?>/>
                <span class="slider round"></span>
            </label>
            <br/>
            <label for="twitter-key" class=" font-12"> <?php echo lang('twitter-key') ?> </label>
            <?php echo form_input(array('placeholder' => lang('twitter-key'), 'name' => 'twitter-key', 'value' => config('twitter-key', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'twitter-key')); ?>
            <br/>
            <label for="twitter-secret" class=" font-12"> <?php echo lang('twitter-secret') ?> </label>
            <?php echo form_input(array('placeholder' => lang('twitter-secret'), 'name' => 'twitter-secret', 'value' => config('twitter-secret', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'twitter-secret')); ?>


        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label for="enable-google-login"
                   class=" font-14"> <?php echo lang('enable-google-login') ?> </label>
        </div>
        <div class="col-8">
            <label class="switch">
                <input type="radio" name="allow-google-signup"
                       value="0" <?php echo (!config('allow-google-signup', 1)) ? 'checked' : '' ?>/>
                <input type="radio" name="allow-google-signup"
                       value="1" <?php echo (config('allow-google-signup', 1)) ? 'checked' : '' ?>/>
                <span class="slider round"></span>
            </label>
            <br/>
            <label for="google-key" class="font-12"> <?php echo lang('google-key') ?> </label>
            <?php echo form_input(array('placeholder' => lang('google-key'), 'name' => 'google-key', 'value' => config('google-key', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'google-key')); ?>
            <br/>
            <label for="google-secret" class="font-12"> <?php echo lang('google-secret') ?> </label>
            <?php echo form_input(array('placeholder' => lang('google-secret'), 'name' => 'google-secret', 'value' => config('google-secret', ''), 'type' => 'text', 'class' => 'form-control', 'id' => 'google-secret')); ?>

        </div>
    </div>
</div>