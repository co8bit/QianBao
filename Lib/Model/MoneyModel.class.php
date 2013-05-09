<?php
class MoneyModel extends Model {

	// 自动验证设置
	protected $_validate = array(
			array('company_name', 'require', '必须填写债权方名称', 0),
			array('money_amount', 'require', '必须填写金额', 0),//1,必须验证,2,值不为空验证,0,字段存在时验证
			//array('money_amount', 'number', '金额必须为数字', 1),
			array('money_inamount', 'require', '必须填写金额', 0),
			array('money_inamount', 'number', '金额必须为数字', 0),
	);
	
	//自动填充
	protected $_auto = array (
			array('money_intime','mydate',Model:: MODEL_BOTH,'callback'),//all time do
			array('money_outtime','mydate',Model:: MODEL_UPDATE,'callback'),//all time do
	);
	 
	protected function mydate(){
		return date("Y-m-d H:i:s");
	}

}
?>