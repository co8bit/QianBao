<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($Vsoftname); ?></title>
<!-- Bootstrap -->   <link href="__TMPL__css/bootstrap.min.css" rel="stylesheet" media="screen">
  
  <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 1060px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 5px;/*下边距*/
        padding: 7px 9px;
      }

    </style>
    
    
    <!-- orign -->
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
<script language="JavaScript">
 <!--
	function edit(id)
 	{
		window.location.href="__URL__/finance/id/"+id;
	}
 //-->
 </script>
 
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
              <li><a href="__URL__/main" class="btn dropdown-toggle  btn-small btn btn-inverse">首页 </a></li>
               <li><a href="__URL__/purchases" class="btn data-toggle btn-small btn btn-inverse">进货单 </a></li>
               <li><a href="__URL__/sale" class="btn dropdown-toggle btn-small btn btn-inverse">销售单 </a></li>
               <li><a href="__URL__/inventory" class="btn dropdown-toggle btn-small btn btn-inverse">库存单 </a></li>
               <li><a href="__URL__/accountpayable" class="btn dropdown-toggle btn-small btn btn-inverse">应付款 </a></li>
               <li><a href="__URL__/accountdue" class="btn dropdown-toggle btn-small btn btn-inverse">应收款 </a></li>
               <li><a href="__URL__/finance" class="btn dropdown-toggle="dropdown" btn-small btn btn-inverse">财务</a></li>
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
          <div class="well sidebar-nav"><!-- 框架从这里开始 ////////////////////////////////////////////////////////// -->
           	<form class="form-signin" method="post" action="__URL__/finaceedit">
           	
           	
           	
  			<fieldset>
      <div id="legend" class="">
        <legend class=""><h1>财务</h1></legend>
      </div>
	 
	<table align="center" class="table table-bordered able-striped" >
		<thed>
			<th><div align="center">编号</div></th>
			<th colspan="2"><div align="center">对方名称</div></th>
			<th><div align="center">金额</div></th>
			<th><div align="center">已还金额</div></th>
			<th><div align="center">剩余金额</div></th>
			<th colspan="2"><div align="center">备注</div></th>
			<th><div align="center">记账时间</div></th>
			<th><div align="center">还款时间</div></th>
			<th><div align="center">操作</div></th>
		</thed>
		<tbody>
			
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "没有数据" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr> <form name="financeedit" method="post" action="__URL__/finaceedit">
    			<td><div align="center"><input class="input-small" type="text" value="<?php echo ($vo["money_id"]); ?>" name="money_id"></div></td>
    			<td colspan="2"><div align="center"><?php echo ($vo["company_name"]); ?></div></td>
    			<td><div align="center"><?php echo ($vo["money_amount"]); ?></div></td>
    			<td><div align="center"><input class="input-small" type="text" placeholder="<?php echo ($vo["money_inamount"]); ?>" name="money_inamount"></div></td>
    			<td><div align="center"><?php echo ($vo["money_shengyu"]); ?></div></td>
    			<td colspan="2"><div align="center"><?php echo ($vo["money_remarks"]); ?></div></td>
    			<td><div align="center"><?php echo ($vo["money_intime"]); ?></div></td>
    			<td><div align="center"><?php echo ($vo["money_outtime"]); ?></div></td>
    			<td><div align="center"><button class="btn btn-small btn-warning" type="submit">还款</button></div></td>
    		</tr></form><?php endforeach; endif; else: echo "没有数据" ;endif; ?>
    	</tbody>
    </table>
	
	<p>
	<button class="btn btn-large btn-block btn-success" type="button">总借出：<?php echo ($totaljiechu); ?></button>
	<button class="btn btn-large btn-block btn-danger " type="button">总贷款：<?php echo ($totaldaikuan); ?></button>
	</p>
	
    </fieldset>
  </form>
  			
  			
  			
  			
  			
  			
  			
          </div><!-- 框架到这里结束 //////////////////////////////////////////////////////////////////////////////// -->
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