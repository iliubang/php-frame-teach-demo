<?php if(!defined('LINGER')){header('HTTP/1.1 403 Forbidden');die();}?><!-- this file is generated by Linger! 2016/03/30 13:02:57 @author: liubang <it.liubang@qq.com> -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>出错了!</title>
    <script src="/js/Linger/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/Linger/common.css">
</head>
<body>
<!--顶部导航-->

<div class="menu"></div>
<!--顶部导航-->
<div class="error_404">
    <div class="container clearfix">
        <div class="error_pic"></div>
        <div class="error_info">
            <h2>
                <p>对不起，您访问的页面不存在！</p>
            </h2>
            <div class="operate">
                <input class="global_btn btn_89bf43" onClick="location.href='/'" type="button" value="返回主页">
                <input class="global_btn btn_39dec8 ml1" onClick="history.go(-1)" type="button" value="返回上一页">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#back_top > a").click(function(){
            $("html, body").animate({scrollTop:"0px"},1000);
            return false
        });
    })
</script>
<!-- 页脚 -->
<!--[if lte IE 9]>
<script src="/js/Linger/html5.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script type="text/javascript" src="/js/Linger/DD_belatedPNG.js"></script>
<script type="text/javascript">
    DD_belatedPNG.fix('div, ul, img, li, input , a, .png_bg');
</script>
<![endif]-->
</body>
</html>