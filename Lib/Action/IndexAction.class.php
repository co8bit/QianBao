<?php

class IndexAction extends Action
{
	private function xuanranbianlan($th)//渲染侧栏及标题栏
	{
		include('MyConfigINI.php');
		$th->assign('Vsoftname',$_SOFTNAME);
		$th->assign('Vversion',$_VERSION);
		$power = session('user_power');
		$Vpower = "";
		for ($i =0; $i < strlen($power); $i++)
		{
		if ($power[$i])
			$Vpower = $Vpower.$_POWERCHINESE[$i].'|';
		}//TODO: delete last "|"
	
		$th->assign('Vuser_power',$Vpower);
    	$th->assign('Vuser_name',session('user_name'));
	    $th->assign('Vannouncement',$_ANNOUNCEMENT);
	    $th->display();
	}
	
	private function XuanranbianlanNDIS($th)//渲染侧栏及标题栏
	{
		include('MyConfigINI.php');
		$th->assign('Vsoftname',$_SOFTNAME);
		$th->assign('Vversion',$_VERSION);
		$power = session('user_power');
		$Vpower = "";
		for ($i =0; $i < strlen($power); $i++)
		{
		if ($power[$i])
			$Vpower = $Vpower.$_POWERCHINESE[$i].'|';
		}//TODO: delete last "|"
	
		$th->assign('Vuser_power',$Vpower);
		$th->assign('Vuser_name',session('user_name'));
		$th->assign('Vannouncement',$_ANNOUNCEMENT);
	}
	
    public function index()//首页
    {
    	include('MyConfigINI.php');
    	$this->assign('_SOFTNAME',$_SOFTNAME);
    	$this->assign('_VERSION',$_VERSION);
    	$this->display();
    }
    
    public function login()//登陆页面
    {
    	include('MyConfigINI.php');
    	$this->assign('_SOFTNAME',$_SOFTNAME);
    	$this->assign('_VERSION',$_VERSION);
    	$this->display();
    }
    
    public function islogin()//判断是否登录成功
    {
    	include('MyConfigINI.php');
    	//$this->assign('waitSecond',135);
    	
    	$dbuser = M("User");
    	$condition['user_name'] = $this->_post('user_name');
    	$condition['user_password'] = $this->_post('user_password');
    	$result = $dbuser->where($condition)->select();
    	
    	if($result) 
    	{
    		session('user_name',$result[0]['user_name']);
    		session('user_power',$result[0]['user_power']);
    		$this->success('登陆成功','main');/////////////////////////////////////////////////////////
    	}
    	else
    	{
    		$this->error('登录失败');
    	}
    }
    
    public function logout()//安全退出
    {
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	//$this->assign('waitSecond',135);
    	session('user_name',null);
    	session('user_power',null);
    	if ( (session('?user_name')) || (session('?user_power')) )
    		$this->error('退出失败');
    	else
    		$this->success('退出成功','index');////////////////////////////////////////////////////////
    }
    
    public function main()//主界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name')) 
    	{
    		$this->error('非法登录','index');
    	}
    	
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
    public function purchases()//进货单界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
   		$power = session('user_power');
    	if (!$power[1])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
    public function purchases_in()//进货单提交
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[1])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	$this->assign('waitSecond',8);
    	$productform = D('Product');
    	$buyform = D('Buy');
    	
    	$buy_data['company_name'] = $this->_post('company');
    	$buy_data['product_name'] = $this->_post('product_name1');
    	if (!$buyform->create($buy_data))
    		$this->error($buyform->getError());
    	
    	$product_data['product_name'] = $this->_post('product_name1');
    	$product_data['product_inprice'] = $this->_post('product_price1');
    	$product_data['product_incount'] = $this->_post('product_count1');
    	$product_data['product_inremarks'] = $this->_post('product_remarks1');
    	if (!$productform->create($product_data))
    		$this->error($productform->getError());
    	if(!$productform->add()) 
    	{
    		$this->error('写入错误！');
    	}
    	$tempbuyform = M('Buy');
    	$tempbuyform = $tempbuyform -> order('buy_id') -> select();
    	$buy_data['buy_id'] = $tempbuyform[count($tempbuyform)-1]['buy_id'] + 1;
    	$tempbuyform = M('Product');
    	$tempbuyform = $tempbuyform -> order('product_id') -> select();
    	$buy_data['product_id'] = $tempbuyform[count($tempbuyform)-1]['product_id'];
    	if (!$buyform->create($buy_data))
    		$this->error($buyform->getError());
    	$result = $buyform->add();
    	if(!$result) 
    	{
    		$this->error('写入错误！');
    	}
    	
    	$money = $product_data['product_incount']*$product_data['product_inprice'];
    	
    	if ($this->_post('product_name2') == "")
    	{
    		if($result)//只填写了第一个表单，提交，转向
    			{
    				
    				$this->success('操作成功！总计金额：'.$money);
    			}
    	}
    	else
    	{
    		$buy_data['company_name'] = $this->_post('company');
    		$buy_data['product_name'] = $this->_post('product_name2');
    		if (!$buyform->create($buy_data))
    			$this->error($buyform->getError());
    		
    		$product_data['product_name'] = $this->_post('product_name2');
    		$product_data['product_inprice'] = $this->_post('product_price2');
    		$product_data['product_incount'] = $this->_post('product_count2');
    		$product_data['product_inremarks'] = $this->_post('product_remarks2');
    		if (!$productform->create($product_data))
    			$this->error($productform->getError());
    		if(!$productform->add()) 
    		{
    			$this->error('写入错误！');
    		}
    		//$buy_data['buy_id'] = $tempbuyform[count($tempbuyform)-1]['buy_id'] + 1;  它的buy_id不变，还是上面的（第一个表单的）
    		$tempbuyform = M('Product');
    		$tempbuyform = $tempbuyform -> order('product_id') -> select();
    		$buy_data['product_id'] = $tempbuyform[count($tempbuyform)-1]['product_id'];
    		if (!$buyform->create($buy_data))
    			$this->error($buyform->getError());
    		if(!$buyform->add()) 
    		{
    			$this->error('写入错误！');
    		}
    		else
    		{
    			$this->success('操作成功!总计金额：'.($money+($product_data['product_incount']*$product_data['product_inprice'])));
    		}
    	}
    }
    
    public function sale()//销售单界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[0])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
    public function sale_in()//销售单提交
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[0])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	$this->assign('waitSecond',8);
    	$productform = D('Product');
    	$tempform = M('Product');
    	$update = M('Product');
    	$saleform = D('Sale');
    	
    	$sale_data['company_name'] = $this->_post('company');
    	$sale_data['product_name'] = $this->_post('product_name1');
    	if (!$saleform->create($sale_data))
    		$this->error($saleform->getError());
    	 
    	$product_data['product_name'] = $this->_post('product_name1');
    	$product_data['product_outprice'] = $this->_post('product_price1');
    	$product_data['product_outcount'] = $this->_post('product_count1');
    	$product_data['product_outremarks'] = $this->_post('product_remarks1');
    	if (!$productform->create($product_data))
    		$this->error($productform->getError());
    	$tempform = $tempform -> where('product_name=\''.$product_data['product_name'].'\'') -> order('product_id')  -> select();
    	$totalcount = 0;
    	for ($i = 0; $i <= count($tempform); $i++)
    	{
    		$totalcount += $tempform[$i]['product_incount'] - $tempform[$i]['product_outcount'];
    	}
    	
    	if ($totalcount < $product_data['product_outcount'])
    		$this->error('出售的物品数量比现有库存多，请修改');
    	else
    	{
    		$tempcount = $product_data['product_outcount'];
    		$i = 0;
    		$j = 0;
    		while ($tempcount != 0)
    		{
    			if ($tempcount <= ($tempform[$j]['product_incount'] - $tempform[$j]['product_outcount']))
    			{
    				$tempform[$j]['product_avgoutprice'] = ( ( ($tempform[$j]['product_avgoutprice'] * $tempform[$j]['product_outcount']) +  ($product_data['product_outprice'] * $tempcount) ) / ($tempform[$j]['product_outcount'] + $tempcount) );
    				$tempform[$j]['product_outcount'] = $tempform[$j]['product_outcount'] + $tempcount;
    				$tempform[$j]['product_outremarks'] = $product_data['product_outremarks'];
    				$update -> save($tempform[$j]);
    				$tempcount = 0;
    				$tempPid[++$i] = $tempform[$j]['product_id'];
    				break;
    			}
    			else
    			{
    				$tempoutcount = ($tempform[$j]['product_incount'] - $tempform[$j]['product_outcount']);
    				$tempcount -= $tempoutcount;
    				if ($tempoutcount != 0)
    				{
    					$tempform[$j]['product_avgoutprice'] = ( ( ($tempform[$j]['product_avgoutprice'] * $tempform[$j]['product_outcount']) +  ($product_data['product_outprice'] * $tempoutcount) ) / $tempform[$j]['product_incount'] );
    					$tempform[$j]['product_outcount'] = $tempform[$j]['product_incount'];
    					$tempform[$j]['product_outremarks'] = $product_data['product_outremarks'];
    					$update -> save($tempform[$j]);
    					$tempPid[++$i] = $tempform[$j]['product_id'];
    				}
    			}
    			$j++;
    		}
    	}
    	
		//更新第一个表单的sale 
    	$tempsaleform = M('Sale');
    	$tempsaleform = $tempsaleform -> order('sale_id') -> select();
    	$sale_data['sale_id'] = $tempsaleform[count($tempsaleform)-1]['sale_id'] + 1;
    	for ($j = 1; $j <= $i; $j++)
    	{
    		$sale_data['product_id'] = $tempPid[$j];
    		if (!$saleform->create($sale_data))//每次都要创建，不然就清空了
    			$this->error($saleform->getError());
    		$result = $saleform->add();
    		if(!$result)
    		{
    			$this->error('写入错误！');
    		}
    	}
    	
    	$money = $product_data['product_outcount']*$product_data['product_outprice'];
    	$tag = 0;
    	//处理表单2
    	if (! ($this->_post('product_name2') == ""))
    	{
    		$productform = D('Product');
    		$tempform = M('Product');
    		$update = M('Product');
    		$saleform = D('Sale');
    		 
    		$sale_data['company_name'] = $this->_post('company');
    		$sale_data['product_name'] = $this->_post('product_name2');
    		if (!$saleform->create($sale_data))
    			$this->error($saleform->getError());
    		
    		$product_data['product_name'] = $this->_post('product_name2');
    		$product_data['product_outprice'] = $this->_post('product_price2');
    		$product_data['product_outcount'] = $this->_post('product_count2');
    		$product_data['product_outremarks'] = $this->_post('product_remarks2');
    		if (!$productform->create($product_data))
    			$this->error($productform->getError());
    		$tempform = $tempform -> where('product_name=\''.$product_data['product_name'].'\'') -> order('product_id') -> select();
    		$totalcount = 0;
    		for ($i = 0; $i <= count($tempform); $i++)
    		{
    			$totalcount += $tempform[$i]['product_incount'] - $tempform[$i]['product_outcount'];
    		}
    		    	 
    		if ($totalcount < $product_data['product_outcount'])
    			$this->error('出售的物品数量比现有库存多，请修改');
    		else
    		{
    			$tempcount = $product_data['product_outcount'];
    		    $i = 0;
    		    $j = 0;
    		    while ($tempcount != 0)
    		    {
    		    	if ($tempcount <= ($tempform[$j]['product_incount'] - $tempform[$j]['product_outcount']))
    		    	{
    		    		$tempform[$j]['product_avgoutprice'] = ( ( ($tempform[$j]['product_avgoutprice'] * $tempform[$j]['product_outcount']) +  ($product_data['product_outprice'] * $tempcount) ) / ($tempform[$j]['product_outcount'] + $tempcount) );
    		    		$tempform[$j]['product_outcount'] = $tempform[$j]['product_outcount'] + $tempcount;
    					$tempform[$j]['product_outremarks'] = $product_data['product_outremarks'];
    		    		$update -> save($tempform[$j]);
    		    		$tempcount = 0;
    		    		$tempPid[++$i] = $tempform[$j]['product_id'];
    		    		break;
    		    	}
    		    	else
    		    	{
    					$tempoutcount = ($tempform[$j]['product_incount'] - $tempform[$j]['product_outcount']);
    		    		$tempcount -= $tempoutcount;
    		    		if ($tempoutcount != 0)
    		    		{
    		    			$tempform[$j]['product_avgoutprice'] = ( ( ($tempform[$j]['product_avgoutprice'] * $tempform[$j]['product_outcount']) +  ($product_data['product_outprice'] * $tempoutcount) ) / $tempform[$j]['product_incount'] );
    		    			$tempform[$j]['product_outcount'] = $tempform[$j]['product_incount'];
    		    			$tempform[$j]['product_outremarks'] = $product_data['product_outremarks'];
    		    			$update -> save($tempform[$j]);
    		    			$tempPid[++$i] = $tempform[$j]['product_id'];
    		    		}
    		    	}
    		    	$j++;
    		    }
    		}
    		$tag = 1;    					 
    		//更新第2个表单的sale
    		//$sale_data['sale_id'] = $tempsaleform[count($tempsaleform)-1]['sale_id'] + 1; sale_id没有变，还是第一个表的
    		for ($j = 1; $j <= $i; $j++)
    		{
    			$sale_data['product_id'] = $tempPid[$j];
    		    if (!$saleform->create($sale_data))//每次都要创建，不然就清空了
    		    $this->error($saleform->getError());
    		    $result = $saleform->add();
    		    if(!$result)
    		    {
    		    	$this->error('写入错误！');
    		    }
    		}
    	}
    	if ($tag)
    	{
    		if($result)
    			$this->success('操作成功!总计金额：'.($money+($product_data['product_outcount']*$product_data['product_outprice'])));
    	}
    	else
    	{
    		if($result)
    			$this->success('操作成功!总计金额：'.$money);
    	}
    }
    
    public function inventory()//库存单界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
   	 	$power = session('user_power');
    	if (!$power[2])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//渲染侧栏及标题栏
    	IndexAction::XuanranbianlanNDIS($this);
    	
    	//$this->assign('waitSecond',135);
    	$productform = M('Product');
    	$productform = $productform -> order('product_id') -> select();
    	//dump($productform);
    	$totalchengben = 0;
    	$totalshouru = 0;
    	for($i = 0; $i < count($productform); $i++)
    	{
    		$productform[$i]['product_shengyu'] = $productform[$i]['product_incount'] - $productform[$i]['product_outcount'];
    		$productform[$i]['product_lirun'] = ($productform[$i]['product_avgoutprice']*$productform[$i]['product_outcount']) - ($productform[$i]['product_inprice']*$productform[$i]['product_outcount']);
    		$totalchengben += $productform[$i]['product_incount']*$productform[$i]['product_inprice'];
    		$totalshouru += $productform[$i]['product_outcount']*$productform[$i]['product_avgoutprice'];
    		$temp = M('Buy');
    		$condition['product_id'] = $productform[$i]['product_id'];
    		$temp = $temp-> where($condition)->select();
    		$productform[$i]['product_intime'] = $temp[0]['buy_time'];
    		$temp = M('Sale');
    		$condition['product_id'] = $productform[$i]['product_id'];
    		$temp = $temp-> where($condition)->select();
    		$productform[$i]['product_outtime'] = $temp[0]['sale_time'];
    		if ($productform[$i]['product_outtime'] == "")
    			$productform[$i]['product_outtime'] = "还没有售出一本";
    	}
    	$totallirun = $totalyingli - $totalchengben;
    	$this->assign('list',$productform);
    	$this->assign('totallirun',$totallirun);
    	$this->assign('totalshouru',$totalshouru);
    	$this->assign('totalchengben',$totalchengben);
    	$this->display();
    }
    
    public function accountpayable()//应付款界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[4])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//渲染侧栏及标题栏
    	IndexAction::Xuanranbianlan($this);
    }
    
    public function accountpayable_in()//应付款提交
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[4])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//$this->assign('waitSecond',135);
    	$payableform = D('Money');
    	$data['money_amount'] = 0 - $this->_post('money_amount');
    	$data['money_remarks'] = $this->_post('money_remarks');
    	$data['company_name'] = $this->_post('company_name');
    	if (!$payableform->create($data))
    			$this->error($payableform->getError());
    	if(!$payableform->add())
    	{
    		$this->error('写入错误！');
    	}
    	else
    	{
    		$this->success('操作成功！');
    	}
    }
    
    public function accountdue()//应收款界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[3])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
    public function accountdue_in()//应收款提交
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[3])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	$dueform = D('Money');
    	if (!$dueform->create())
    		$this->error($dueform->getError());
    	if(!$dueform->add())
    	{
    		$this->error('写入错误！');
    	}
    	else
    	{
    		$this->success('操作成功！');
    	}
    }
    public function finance()//财务界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[6])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//渲染侧栏及标题栏
    	IndexAction::XuanranbianlanNDIS($this);
    	 
    	//$this->assign('waitSecond',135);
    	$moneyform = M('Money');
    	$moneyform = $moneyform -> order('money_id') -> select();
    	$totaldaikuan = 0;
    	$totaljiechu = 0;
    	$totalshengyu = 0;
    	for($i = 0; $i < count($moneyform); $i++)
    	{
    		if ($moneyform[$i]['money_amount'] < 0)
    		{
    			$totaldaikuan += (0 - $moneyform[$i]['money_amount']);
    			$moneyform[$i]['money_shengyu'] = $moneyform[$i]['money_amount'] + $moneyform[$i]['money_inamount'];
    			$totalshengyu += 0 - $moneyform[$i]['money_shengyu'];
    			if (!$moneyform[$i]['money_inamount']) $moneyform[$i]['money_inamount'] = 0;
    		}
    		else
    		{
    			$moneyform[$i]['money_shengyu'] = $moneyform[$i]['money_amount'] - $moneyform[$i]['money_inamount'];
    	    	$totaljiechu += $moneyform[$i]['money_amount'];
    	    	$totalshengyu += $moneyform[$i]['money_inamount'];
    	    	if (!$moneyform[$i]['money_inamount']) $moneyform[$i]['money_inamount'] = 0;
    		}
    	}
    	$this->assign('list',$moneyform);
    	$this->assign('totaldaikuan',$totaldaikuan);
    	$this->assign('totaljiechu',$totaljiechu);
    	//$this->assign('totalshengyu',$totalshengyu);
    	$this->display();
    }
    
    public function finaceedit()//财务修改
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[6])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//$this->assign('waitSecond',135);
    	$moneyform = M("Money");
    	$data['money_id'] = $this->_post('money_id');
    	$data['money_inamount'] = $this->_post('money_inamount');
    	$data['money_outtime'] = date("Y-m-d H:i:s");
    	//echo dump($data);
    	if ($moneyform->save($data))
    		$this->success("操作成功");
    	else
    		$this->error("操作失败！");
    }
    
    public function staffmanage()//员工管理界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[5])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlanNDIS($this);
    	
    	//$this->assign('waitSecond',135);
    	$userform = M('employee');
    	$userform = $userform -> order('employee_id') -> select();
    	$totalyuangongshu = count($userform);
    	$totalgongzi = 0;
    	for($i = 0; $i < count($userform); $i++)
    	{
    		$totalgongzi += $userform[$i]['employee_salary'];
    	}
    	$this->assign('list',$userform);
    	$this->assign('totalgongzi',$totalgongzi);
    	$this->assign('totalyuangongshu',$totalyuangongshu);
    	$this->display();
    }
    
    public function staffmanageedit()//员工edit
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[5])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//$this->assign('waitSecond',135);
    	$form = D("Employee");
    	if (!$form->create())
    		$this->error($form->getError());
    	if ($form->save())
    		$this->success("操作成功");
    	else
    		$this->error("操作失败！");
    }
    
    public function staffmanagenew()//员工new
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[5])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	 
    	//$this->assign('waitSecond',135);
    	$form = D("Employee");
    	if (!$form->create())
    		$this->error($form->getError());
    	
    	if ($form->add())
    		$this->success("操作成功");
    	else
    		$this->error("写入失败！");
    	
    }
    
    public function user()//员工界面
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[7])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlanNDIS($this);
    	 
    	//$this->assign('waitSecond',135);
    	$userform = M('User');
    	$userform = $userform -> order('user_id') -> select();
    	$totalzhanghao = count($userform);
    	include('MyConfigINI.php');
    	for($i = 0; $i < count($userform); $i++)
    	{
    		for ($j = 0; $j < count($_POWERCHINESE); $j++)
    			if ($userform[$i]['user_power'][$j])
    			{
    				$userform[$i]['user_power'.$j] = 1;
    			}
    			else
    				$userform[$i]['user_power'.$j] = 0;
    	}
    	$this->assign('list',$userform);
    	$this->assign('totalzhanghao',$totalzhanghao);
    	$this->display();
    
    }
    
    public function useredit()//user edit
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[7])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    	
    	//$this->assign('waitSecond',135);
    	$tempform = D("User");
    	if (!$tempform->create())
    		$this->error($tempform->getError());
    	$form = D("User");
    	$data['user_id'] = $this->_post('user_id');
    	include('MyConfigINI.php');
    	$data['user_power'] = "";
    	for($i = 0; $i < count($_POWERCHINESE); $i++)
    	{
    		$data['user_power'] = $data['user_power'].$this->_post('user_power'.$i);
    	}
    	$form -> data($data);
    	//echo dump($data);
    	if ($form->save())
    		$this->success("操作成功");
    	else
    		$this->error("操作失败！");
    }
    
    public function usernew()//user new
    {
    	//判断是否有权限进行该操作
    	if (!session('?user_name'))
    	{
    		$this->error('非法登录','index');
    	}
    	$power = session('user_power');
    	if (!$power[7])
    	{
    		$this->error('您的权限不能操作该页面');
    	}
    
    	//$this->assign('waitSecond',135);
    	$tempform = D("User");
    	if (!$tempform->create())
    		$this->error($tempform->getError());
    	$form = D("User");
    	$data['user_name'] = $this->_post('user_name');
    	$data['user_password'] = $this->_post('user_password');
    	include('MyConfigINI.php');
    	$data['user_power'] = "";
    	for($i = 0; $i < count($_POWERCHINESE); $i++)
    	{
    		$data['user_power'] = $data['user_power'].$this->_post('user_power'.$i);
    	}
    	$form -> data($data);
    	if ($form->add())
    		$this->success("操作成功");
    	else
    		$this->error("写入失败！");
    }
    
    
    public function about()//关于界面
    {
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
    public function addrow($i)//关于界面
    {
    	echo "xdfvhgghghjkklm";
    	//渲染侧栏及标题栏
    	IndexAction::xuanranbianlan($this);
    }
    
}