<?php $this->view('install/menu', array('i' => $i));
$error = false;
?> <?php echo form_open('install',array('id'=>'install-form','method'=>'post'));?>
    <div class="row">
        <div class="container">
            <div class="installation-wrapper-container__content mt-4 font-14">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> PHP VERSION <span class="pull-right">
                            <?php if (phpversion() >= 5.3): ?>
                                <span class="text-success"><i data-feather="check"></i></span>
                            <?php else:$error = true ?>
                                <span class="text-danger"><?php echo phpversion() ?></span>
                                <p> Upgrade your PHP version</p>
                            <?php endif ?>
                        </span>
                    </li>
                    <li class="list-group-item"> MYSQLI <span
                            class="pull-right"><?php if (function_exists('mysqli_connect')): ?>
                                <span class="text-success"><i data-feather="check"></i></span>
                            <?php else:$error = true ?>
                                <span class="text-danger">Not Available</span>
                                <p>Mysqli extension is required, please contact your server support to enable it </p>
                            <?php endif ?> </span>
                    </li>
                    <li class="list-group-item"> CONFIGURATION FILE <span
                            class="pull-right"><?php if (is_writable(FCPATH.'config.php')): ?>
                                <span class="text-success"><i data-feather="check"></i></span>
                            <?php else:$error = true ?>
                                <span class="text-danger"> Not Writable </span>
                                <span class="d-block">Give this file <strong>0777</strong> Permission </span>
                                <span class="d-block"><strong><?php echo FCPATH.'config.php' ?></strong></span>
                            <?php endif ?>
                            </span>
                    </li>
                    <li class="list-group-item">STORAGE FOLDER <span
                            class="pull-right"><?php if (is_writable(FCPATH.'storage/')): ?>
                                <span class="text-success"><i data-feather="check"></i></span>
                            <?php else:$error = true ?>
                                <span class="text-danger"> Not Writable </span>
                                <span class="d-block">Give this folder <strong>0777</strong> Permission </span>
                                <span class="d-block"><strong><?php echo FCPATH.'storage' ?></strong></span>
                            <?php endif ?>
                            </span>
                    </li>
                </ul>
            </div>
            <br/>
            <br/>
            <input type="hidden" name="success" value="<?php echo ($error) ? 0 : 1 ?>"/>
            <button type="submit" class="ml-3 btn btn-primary btn-lg btn-action <?php echo ($error) ? 'disabled' : ''; ?>"  <?php echo ($error) ? 'disabled' : ''; ?>> <?php echo lang('continue') ?> </button>
        </div>
    </div>
<?php  echo form_close(); ?>