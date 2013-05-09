<?php
class UserModel extends Model {

	// 自动验证设置
	protected $_validate = array(
			array('user_name', 'require', '名称不能为空！', 0),//1,为必须验证,2,值不为空验证,0,字段存在时验证
			array('user_password', 'require', '密码不能为空！', 0),
			array('user_power0', 'require', '权限不能为空！', 1),
			array('user_power1', 'require', '权限不能为空！', 1),
			array('user_power2', 'require', '权限不能为空！', 1),
			array('user_power3', 'require', '权限不能为空！', 1),
			array('user_power4', 'require', '权限不能为空！', 1),
			array('user_power5', 'require', '权限不能为空！', 1),
			array('user_power6', 'require', '权限不能为空！', 1),
			array('user_power7', 'require', '权限不能为空！', 1),
	);

}
?>