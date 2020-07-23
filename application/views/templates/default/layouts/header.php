<!DOCTYPE html>
<html lang="<?php echo $locale; ?>">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/custom.min.css' ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/overrides.css' ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/style.css' ?>"/>
    <style>
        body{
            background: <?php echo config('background-color','#DCD2F0') ?>;
        }
        .user-side-bar-menu{
            background : <?php echo config('side-bar-color','#581E95') ?>
        }
        .btn-action{
            background-color: <?php echo config('btn-action-color', '#FF088F');?> !important;
            color : #fff !important;
        }
        .btn-border{
            border-color: <?php echo config('btn-action-color', '#FF088F');?> !important;;
        }
    </style>
</head>
<body class="overall-body">

<div class="container-wrapper header">
    <div class="container">
        <nav class="navbar navbar-light bg-light-quiz pr-0 pl-0">
            <a class="navbar-brand" href="<?php echo url(''); ?>">
                <!--<img src="<?php /*echo asset_url() . '/default/' . 'img/logo_test.png' */?>" width="30" height="30"
                     class="d-inline-block align-top" alt="">-->
                <?php echo config('website-title', 'FriendsQuizzy'); ?>
            </a>

            <span class="top-corner-button navbar-text">

                <?php if(!isLoggedIn()): ?>
                 <a style="background : "
                    href=""
                    onclick="return Moquiz.toggleAccountCreateBtn(this)"
                    data-ltext="<?php echo lang('login') ?>"
                    data-ctext="<?php echo lang('create_new_account') ?>"
                    class="btn-action btn-border"> <?php echo lang('create_new_account') ?>
                  </a>
                <?php else: ?>
                    <span class="language-banner">
                      <?php echo lang('welcome') ?>, <?php echo ucfirst(get_user_full_name()) ?>
                </span>
                <?php endif; ?>

                <span class="language-banner">
                    <a href=""><?php echo lang('language'); ?></a>
                </span>

                </span>
            <!--<span class="navbar-text"> Languages </span>-->

        </nav>
    </div>

</div>

