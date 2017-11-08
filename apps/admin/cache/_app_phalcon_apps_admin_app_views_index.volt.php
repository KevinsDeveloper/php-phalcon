<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8"/>
    <title>后台管理中心</title>
    <meta name="description" content="后台管理中心"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link id="bootstrap-rtl-link" href="" rel="stylesheet"/>
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/assets/css/weather-icons.min.css" rel="stylesheet"/>

    <!--Beyond styles-->
    <link id="beyond-link" href="/assets/css/beyond.min.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="/assets/css/demo.min.css" rel="stylesheet" /> -->
    <link href="/assets/css/typicons.min.css" rel="stylesheet"/>
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>
    <link href="/assets/css/style.css" rel="stylesheet"/>
    <link id="skin-link" href="/assets/css/skins/deepblue.min.css" rel="stylesheet" type="text/css"/>

    <!-- datetimepicker -->
    <link href="/assets/js/time/jquery.datetimepicker.css" rel="stylesheet">

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="/assets/js/skins.min.js"></script>
    <script src="/assets/js/jquery-2.0.3.min.js"></script>
</head>
<!-- /Head -->
<!-- Body -->
<body>
<!-- Loading Container -->
<div class="loading-container">
    <div class="loading-progress">
        <div class="rotator">
            <div class="rotator">
                <div class="rotator colored">
                    <div class="rotator">
                        <div class="rotator colored">
                            <div class="rotator colored"></div>
                            <div class="rotator"></div>
                        </div>
                        <div class="rotator colored"></div>
                    </div>
                    <div class="rotator"></div>
                </div>
                <div class="rotator"></div>
            </div>
            <div class="rotator"></div>
        </div>
        <div class="rotator"></div>
    </div>
</div>
<!--  /Loading Container -->
<!-- Navbar -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="/" class="navbar-brand">
                    <small><img src="/assets/img/logo.png"/></small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">

                        <!-- <li>
                            <a class="wave in dropdown-toggle" data-toggle="dropdown" title="Help" href="javascript:void(0);">
                                <i class="icon fa fa-envelope"></i>
                                <span class="badge">3</span>
                            </a>
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-messages">
                                <li>
                                    <a href="#">
                                        <img src="/assets/img/avatars/divyia.jpg" class="message-avatar" alt="Divyia Austin">
                                        <div class="message">
                                            <span class="message-sender">
                                                Divyia Austin
                                            </span>
                                            <span class="message-time">
                                                2 minutes ago
                                            </span>
                                            <span class="message-subject">
                                                Here's the recipe for apple pie
                                            </span>
                                            <span class="message-body">
                                                to identify the sending application when the senders image is shown for the main icon
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="/assets/img/avatars/bing.png" class="message-avatar" alt="Microsoft Bing">
                                        <div class="message">
                                            <span class="message-sender">
                                                Bing.com
                                            </span>
                                            <span class="message-time">
                                                Yesterday
                                            </span>
                                            <span class="message-subject">
                                                Bing Newsletter: The January Issue‏
                                            </span>
                                            <span class="message-body">
                                                Discover new music just in time for the Grammy® Awards.
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="/assets/img/avatars/adam-jansen.jpg" class="message-avatar" alt="Divyia Austin">
                                        <div class="message">
                                            <span class="message-sender">
                                                Nicolas
                                            </span>
                                            <span class="message-time">
                                                Friday, September 22
                                            </span>
                                            <span class="message-subject">
                                                New 4K Cameras
                                            </span>
                                            <span class="message-body">
                                                The 4K revolution has come over the horizon and is reaching the general populous
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="/assets/img/head.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span><?= $auth['realname'] ?></span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="edit"><a class="pull-center" href="javascript:layers.frame('/index/info/', '修改个人资料', 600 ,500);"><?= $auth['account'] ?></a></li>
                                <!--Theme Selector Area-->
                                <li class="theme-area">
                                    <ul class="colorpicker" id="skin-changer">
                                        <li><a class="colorpick-btn" href="#" style="background-color:#5DB2FF;" rel="/assets/css/skins/blue.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#2dc3e8;" rel="/assets/css/skins/azure.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#03B3B2;" rel="/assets/css/skins/teal.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#53a93f;" rel="/assets/css/skins/green.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#FF8F32;" rel="/assets/css/skins/orange.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#cc324b;" rel="/assets/css/skins/pink.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#AC193D;" rel="/assets/css/skins/darkred.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#8C0095;" rel="/assets/css/skins/purple.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#0072C6;" rel="/assets/css/skins/darkblue.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#585858;" rel="/assets/css/skins/gray.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#474544;" rel="/assets/css/skins/black.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#001940;" rel="/assets/css/skins/deepblue.min.css"></a></li>
                                    </ul>
                                </li>
                                <!--/Theme Selector Area-->
                                <li class="dropdown-footer">
                                    <a href="<?= $this->url->get('/login/out') ?>">退出</a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->

                        <li>
                            <a class="in dropdown-toggle padright-15" href="/login/out">
                                <i class="icon fa fa-sign-out">
                                    <small>退出</small>
                                </i>
                            </a>
                        </li>
                        <!--Note: notice that setting div must start right after account area list.
                        no space must be between these elements-->
                        <!-- Settings -->
                    </ul>

                    <!-- Settings -->
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>
<!-- /Navbar -->
<!-- Main Container -->
<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <!--Dashboard-->
                <li class="">
                    <a href="/">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> 首页 </span>
                    </a>
                </li>
                <?php if ($menus) { ?>
                <?php foreach ($menus as $menu) { ?>
                <li class="<?php if (in_array($urlPath, $menu['suburl']) || $menu['module'] == $urlModule[0]) { ?>active open<?php } ?>">
                    <a href="javascript:void(0);" class="menu-dropdown">
                        <i class="menu-icon <?= $menu['icon'] ?>"></i>
                        <span class="menu-text"><?= $menu['title'] ?></span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <?php if ($menu['sub']) { ?>
                        <?php foreach ($menu['sub'] as $pmenu) { ?>
                            <li class="<?php if ($urlPath == $pmenu['url']) { ?>active<?php } ?>"><a href="<?= $pmenu['url'] ?>"> <span class="menu-text"><?= $pmenu['title'] ?></span> </a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php } ?>
            </ul>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <?= $this->getContent() ?>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
</div>

</body>
</html>