<div class="container">
    <div class="main-register-wrapper">
        <div class="wrapper">
            <div class="wrapper-title">
                 <?php echo lang('register'); ?>
            </div>
            <div class="wrapper-content">
                <?php  if(validation_errors()):?>
                    <?php $this->view('templates/default/snippets/alert',array('message'=> validation_errors())); ?>
                <?php endif; ?>
                <div class="">
                     <?php  $this->view('templates/default/register/form'); ?>
                </div>
            </div>
        </div>
    </div>
</div>