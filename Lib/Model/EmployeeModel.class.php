<?php
class EmployeeModel extends Model {

	// 自动验证设置
	protected $_validate = array(
			array('employee_id', 'require', 'id不能为空！', 0),//1,为必须验证,2,值不为空验证,0,字段存在时验证
			array('employee_salary', 'require', '工资不能为空！', 1),
			array('employee_position', 'require', '职位不能为空！', 1),
			array('employee_address', 'require', '地址不能为空！', 1),
			array('employee_salary', 'number', '工资必须为数字', 1),
	);
	
	//自动填充
	protected $_auto = array (
			array('employee_updatetime','mydate',Model:: MODEL_BOTH,'callback'),//all time do
			array('employee_intime','mydate',Model:: MODEL_INSERT,'callback'),
	);
	 
	protected function mydate(){
		return date("Y-m-d H:i:s");
	}

}
?>