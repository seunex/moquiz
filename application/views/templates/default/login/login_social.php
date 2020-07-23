<div class="divider-with-text">
    <span class="divider-with-text-line"></span>
    <span class="d-text"> <?php echo lang('or-login-with') ?> </span>
</div>

<div class="social-login-wrapper">
    <div class="container">
        <div class="row">
            <?php if (config('allow-facebook-signup', 1)): ?>
            <div class="col-sm-12">
                <div class="sl-row sl-facebook">
                    <a href="<?php echo url('auth/facebook') ?>">
                        <img src="<?php echo img_url('social/facebook.png'); ?>"/>
                        <span class="sl-text-wrapper">
                     <span class="sl-text"> Facebook </span>
                     </span>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php  if (config('allow-twitter-signup', 1)): ?>
            <div class="col-sm-12">
                <div class="sl-row sl-tw">
                    <a href="<?php echo url('auth/twitter') ?>">
                        <img src="<?php echo img_url('social/twitter.png'); ?>"/>
                        <span class="sl-text-wrapper">
                        <span class="sl-text"> Twitter </span>
                        </span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            <?php if (config('allow-google-signup', 1)): ?>
            <div class="col-sm-12">
                <div class="sl-row sl-google">
                    <a href="<?php echo url('auth/google') ?>">
                        <img src="<?php echo img_url('social/google.png'); ?>"/>
                        <span class="sl-text-wrapper">
                        <span class="sl-text"> Google </span>
                        </span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>