<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($Vsoftname); ?></title>
<!-- Bootstrap -->   <link href="__TMPL__css/bootstrap.min.css" rel="stylesheet" media="screen">
 <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
</head>
<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><?php echo ($Vsoftname); ?></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
            	  登录中的账户为： <?php echo ($Vuser_name); ?>&nbsp&nbsp&nbsp&nbsp<a href="__URL__/logout" class="navbar-link">安全退出</a>
            </p>
            <ul class="nav">
              <li><a href="__URL__/main" class="btn dropdown-toggle data-toggle="dropdown" btn-small btn btn-inverse">首页 </a></li>
               <li><a href="__URL__/purchases" class="btn dropdown-toggle btn-small btn btn-inverse">进货单 </a></li>
               <li><a href="__URL__/sale" class="btn dropdown-toggle btn-small btn btn-inverse">销售单 </a></li>
               <li><a href="__URL__/inventory" class="btn dropdown-toggle btn-small btn btn-inverse">库存单 </a></li>
               <li><a href="__URL__/accountpayable" class="btn dropdown-toggle btn-small btn btn-inverse">应付款 </a></li>
               <li><a href="__URL__/accountdue" class="btn dropdown-toggle btn-small btn btn-inverse">应收款 </a></li>
               <li><a href="__URL__/finance" class="btn dropdown-toggle btn-small btn btn-inverse">财务</a></li>
               <li><a href="__URL__/staffmanage" class="btn dropdown-toggle btn-small btn btn-inverse">员工管理 </a></li>
               <li><a href="__URL__/user" class=" btn dropdown-toggle btn-small btn btn-inverse">账户管理 </a></li>
               <li><a href="__URL__/about" class=" btn dropdown-toggle btn-small btn btn-inverse">关于 </a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">基本信息</li>
              <li><a href="#">登录中的账户为：<?php echo ($Vuser_name); ?></a></li>
              <li><a href="#">权限为：|<?php echo ($Vuser_power); ?></a></li>            <!-- TODO:delete '|' /////////////////////-->
              <li><a href="#">系统版本：<?php echo ($Vversion); ?></a></li>
              <li class="nav-header">系统公告</li>
              <li><a href="#"><?php echo ($Vannouncement[0]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[1]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[2]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[3]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[4]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[5]); ?></a></li>
              <li><a href="#"><?php echo ($Vannouncement[6]); ?></a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">
            <h1><?php echo ($Vsoftname); ?></h1>
            <strong><em><p>                 ————进销存管理系统</p></em></strong>
            <p>欢迎使用本系统，希望本系统能给您带来方便O(∩_∩)O</p>
            <p><a href="__URL__/purchases" class="btn btn-primary btn-large">进货单 &raquo;</a>
               <a href="__URL__/sale" class="btn btn-success btn-large">销售单 &raquo;</a>
               <a href="__URL__/inventory" class="btn btn-warning btn-large">库存单 &raquo;</a>
               <a href="__URL__/accountpayable" class="btn btn-danger btn-large">应付款 &raquo;</a>
               <a href="__URL__/accountdue" class="btn btn-info btn-large">应收款 &raquo;</a>
               <a href="__URL__/staffmanage" class="btn  btn btn-inverse btn-large">员工管理 &raquo;</a></p>
          </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; co8bit 2013</p>
      </footer>

    </div><!--/.fluid-container-->






<!-- Bootstrap -->    <script src="__TMPL__js/bootstrap.min.js"></script>
</body>
</html>