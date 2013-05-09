<?php
class SaleModel extends Model {

	// 自动验证设置
	protected $_validate = array(
			array('company_name', 'require', '必须填写客户名称！', 1),//1为必须验证
	);
	
	//自动填充
	protected $_auto = array (
			array('sale_time','mydate',Model:: MODEL_BOTH,'callback'),//all time do
	);
	 
	protected function mydate(){
		return date("Y-m-d H:i:s");
	}

}
?>