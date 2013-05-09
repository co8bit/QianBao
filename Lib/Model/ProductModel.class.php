<?php
class ProductModel extends Model {

	// 自动验证设置
	protected $_validate = array(
			array('product_name', 'require', '必须填写商品名称！', 1),//1,必须验证,2,值不为空验证,0,字段存在时验证
			array('product_inprice', 'require', '必须填写商品价格', 0),//in
			array('product_incount', 'require', '必须填写商品数量', 0),
			array('product_inprice', 'number', '商品价格必须为数字', 0),
			array('product_incount', 'number', '商品数量必须为数字', 0),
			array('product_outprice', 'require', '必须填写商品价格', 0),//out
			array('product_outcount', 'require', '必须填写商品数量', 0),
			array('product_outprice', 'number', '商品价格必须为数字', 0),
			array('product_outcount', 'number', '商品数量必须为数字', 0),
	);

}
?>