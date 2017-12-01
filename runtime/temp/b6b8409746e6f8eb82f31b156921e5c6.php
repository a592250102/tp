<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\phpStudy\WWW\ThinkPHP\public/../application/home/view/default/community\index.html";i:1511949420;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid" id="mydiv">
        <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$notice): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <a href="<?php echo url('detail?id='.$notice['id']); ?>">
                <div class="col-xs-2">
                    <img class="noticeImg" src="<?php echo get_cover($notice['cover_id'])['path']; ?>" />
                </div>
                <div class="col-xs-10">
                    <p class="title"><?php echo $notice['title']; ?></p>
                    <p class="intro"><?php echo $notice['description']; ?></p>
                    <p class="info">浏览: <?php echo $notice['view']; ?> <span class="pull-right"><?php echo time_format($notice['create_time']); ?></span> </p>
                </div>
            </a>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>
</div>
<div>
    <button id="add">加载更多</button>
    <p id="page" hidden="hidden"><?php echo $page; ?></p>
</div>
<div style="height: 200px;"></div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $("#add").click(function () {
        var int = $('#page').text();
        int = parseInt(int);
        page = int+1;
        $.getJSON('/home/community/index',{page:page},function (notice) {
            var data = $.parseJSON(notice).list;
            $('#page').text($.parseJSON(notice).page);
            $.each(data,function (index) {

                    $.post('/home/community/path',{cover_id:data[index].cover_id,time:data[index].create_time},function (path) {
                        var path1 = path['path'];
                        var time = path['time'];
                        $("<div class='row noticeList'><a href='/home/notice/detail/id/"+data[index].id+".html'>\
            <div class='col-xs-2'>\
                <img id='myimg' class='noticeImg' src='"+path1+"' />\
                </div>\
                <div class='col-xs-10'>\
                <p class='title'>"+data[index].title+"</p>\
            <p class='intro'>"+data[index].description+"</p>\
            <p class='info'>浏览: "+data[index].view+"<span class='pull-right'> "+time+"</span> </p>\
                </div>\
                </a></div>").appendTo($("#mydiv"));
                    });
            })
        });
    });
</script>
</body>
</html>