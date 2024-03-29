<!DOCTYPE html>
<html lang="<?php echo $locale; ?>">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <meta property="og:site_name" content="<?php echo $title; ?>"/>
    <meta property="og:title" content="<?php echo $title ?>"/>
    <meta name="twitter:title" content="<?php echo $title ?>"/>
    <meta itemprop="headline" content="<?php echo $title ?>"/>
    <meta itemprop="og:headline" content="<?php echo $title; ?>"/>
    <meta name="description" content="<?php echo config('website-description', '') ?>"/>
    <meta name="twitter:description" content="<?php echo config('website-description', '') ?>"/>
    <meta property="og:description" content="<?php echo config('website-description', '') ?>"/>
    <meta itemprop="description" content="<?php echo config('website-description', '') ?>"/>
    <meta name="keywords" content="<?php echo config('website-keywords', '') ?>"/>
    <meta property="og:url" content="<?php echo current_url() ?>"/>
    <meta itemscope itemtype="https://schema.org/article"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="<?php echo asset_url() . 'default/img/favicon.ico' ?>" type="image/gif" sizes="16x16">

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/custom.min.css' ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/overrides.css' ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/style.css' ?>"/>
    <?php if (get_active_lang() == 'arabic'): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/rtl.min.css' ?>"/>
        <style>
            .user-side-bar-menu {
                left: 0;
            }
        </style>
    <?php endif; ?>
    <style>
        body,
        .container-wrapper.header,
        .bg-light-quiz {
            background: <?php echo config('background-color','#DCD2F0') ?>;
            background-image: url("<?php echo asset_url('default/img/bg/bg-01.svg') ?>");
        }

        .user-side-bar-menu,
        .mobile-menu-header {
            background: <?php echo config('side-bar-color','#581E95') ?>
        }

        .btn-action {
            background-color: <?php echo config('btn-action-color', '#FF088F');?> !important;
            color: #fff !important;
        }

        .btn-border {
            border-color: <?php echo config('btn-action-color', '#FF088F');?> !important;;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'default' . '/css/dark.css' ?>"/>
    <?php if (config('website-google-analytics')): ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', '<?php echo config('website-google-analytics'); ?>', 'auto');
            ga('send', 'pageview');
        </script>
    <?php endif; ?>
</head>
<body class="overall-body <?php echo active_mode(); ?>">
<div class="container-wrapper header" style="background: <?php //echo config('background-color','#DCD2F0') ?>">
    <div class="container">
        <?php if (!is_install()): ?>
            <nav class="navbar navbar-light bg-light-quiz pr-0 pl-0"
                 style="background: <?php //echo config('background-color','#DCD2F0') ?>">
                <a class="navbar-brand" href="<?php echo url(''); ?>">
                    <?php echo config('website-title', 'FriendsQuizzy'); ?>
                </a>

                <div class="top-corner-button navbar-text">
                    <?php if (config('enable-dark-mode-feature', 1)): ?>
                        <a href="" class="border-0" onclick="return toggle_dark_mode(this)"><i data-feather="moon"></i></a>
                    <?php endif; ?>

                    <?php if (!isLoggedIn()): ?>

                        <a style="background : "
                           href=""
                           onclick="return Moquiz.toggleAccountCreateBtn(this)"
                           data-ltext="<?php echo lang('login') ?>"
                           data-ctext="<?php echo lang('create_new_account') ?>"
                           class="btn-action btn-border"> <?php echo lang('create_new_account') ?>
                        </a>
                    <?php else: ?>
                        <span class="language-banner">
                      <?php echo lang('hi') ?><?php echo ucfirst(get_user_full_name()) ?>
                </span>
                    <?php endif; ?>

                    <div class="language-banner dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    data-feather="map"></i><?php //echo get_active_lang(); ?></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="<?php echo language_url('english') ?>">English <img
                                        alt="english"
                                        class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/us.png'); ?>"/>
                            </a>
                            <a class="dropdown-item" href="<?php echo language_url('french') ?>">Français <img
                                        alt="english"
                                        class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/fr.png'); ?>"/></a>
                            <a class="dropdown-item" href="<?php echo language_url('japanese') ?>">japəˈnēz <img
                                        alt="english" class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/jp.png'); ?>"/></a>
                            <a class="dropdown-item" href="<?php echo language_url('italian') ?>">Italiano <img
                                        alt="english" class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/it.png'); ?>"/></a>
                            <a class="dropdown-item" href="<?php echo language_url('portuguese') ?>">Português <img
                                        alt="english" class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/br.png'); ?>"/></a>
                            <a class="dropdown-item" href="<?php echo language_url('spanish') ?>">Español <img
                                        alt="english"
                                        class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/es.png'); ?>"/></a>
                            <a class="dropdown-item" href="<?php echo language_url('arabic') ?>"> عربى <img
                                        alt="english"
                                        class="pull-right"
                                        src="<?php echo asset_url('default/img/flags/sa.png'); ?>"/></a>
                        </div>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?php if (DEMO): ?>
    <div class="container">
        <div class="mb-2 d-block text-center font-14" style="">
            <?php $this->view('templates/default/snippets/alert', array('message' => DEMO_MSG, 'type' => 'info')); ?>
        </div>
    </div>
<?php endif; ?>
<?php if (config('ads-code')): ?>
    <div class="container">
        <div class="mb-2 d-block text-center font-14" style="">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <?php echo config('ads-code'); ?>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </div>
<?php endif; ?>

