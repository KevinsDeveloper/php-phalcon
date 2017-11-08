<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>后台管理中心</title>
    <meta name="description" content="后台管理中心" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/assets/css/weather-icons.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="/assets/css/beyond.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="/assets/css/demo.min.css" rel="stylesheet" /> -->
    <link href="/assets/css/typicons.min.css" rel="stylesheet" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />
    <link id="skin-link" href="/assets/css/skins/deepblue.min.css" rel="stylesheet" type="text/css" />
    <!-- datetimepicker -->
    <link href="/assets/js/time/jquery.datetimepicker.css" rel="stylesheet">

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="/assets/js/skins.min.js"></script>
    <script src="/assets/js/jquery-2.0.3.min.js"></script>
    <style type="text/css">html,body,body:before{background: #fff;}</style>
</head>
<!-- /Head -->
<!-- Body -->
<body>
{{ content() }}
{% include './layouts/bot.volt' %}
</body>
</html>
