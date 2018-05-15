<?php
namespace app\common\model;

use think\Model;
use think\Db;

class ProductsAttributes extends Model
{
	 protected $table = TABLE_PRODUCTSATTRIBUTES;
	 
	/**
	 * 通过产品id获取产品属性
	 * */
	public  function getproattr($id){
		$list=Db::table($this->table)->alias('pa')->field('pa.products_attributes_id,pa.options_id,pa.options_values_id,pa.attributes_image,pp.products_options_name,po.products_options_values_name,pa.attributes_status,pp.products_options_type,pot.products_options_types_name')->where('products_id',$id)->join(TABLE_PRODUCTSOPTIONS.' pp','pa.options_id=pp.products_options_id','left')->join(TABLE_PRODUCTSOPTIONSVALUES.' po','pa.options_values_id=po.products_options_values_id and po.language_id=1','left')->join(TABLE_PRODUCTSOPTIONSTYPES.' pot','pp.products_options_type=pot.products_options_types_id','left')->order('pa.products_options_sort_order')->select();
	$result=array();
	foreach($list as $key=>&$val){
		
	
			if($val['attributes_image']){
				$val['fullimage']=HTTPS_SERVER.'/'.DIR_WS_IMAGES.$val['attributes_image'];
			}else{
				$val['fullimage']=null;
			}
	
		$result[$val['products_options_name']][]=$val;
	}
	
	return $result;
	}
	
	/**
	 * 移除产品属性
	 * @param int $pid products_id 产品ID
	 * @param int $attid products_attributes_id
	 * */
	public function delproattr($pid,$attid){
		Db::table($this->table)->where('products_id',(int)$pid)->where('products_attributes_id',(int)$attid)->delete();
	}
	

}