<?php
class LogModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//添加后台操作日志	
	function addlog_backend($con=array()){
		$admin=$this->session->userdata ( 'admin');
		$langarr=languagelist();
		$num=0;
		for($i=0;$i<count($langarr);$i++){
			if(isset($con['logcontent'.$langarr[$i]['langtype']])){
				$num++;
			}
		}
		$ipcountryinfo=$this->getipcountryinfo();
		$country_id=$ipcountryinfo['country_id'];
		$ip_address=$ipcountryinfo['ip_address'];
		$arr=array('isfront'=>0,'uid'=>$admin['uid'],'username'=>$admin['username'],'type'=>$con['type'],'week_id'=>date("w"),'platform'=>checkagent(),'ipaddress'=>$ip_address,'country_id'=>$country_id,'created'=>mktime());
		for($i=0;$i<count($langarr);$i++){
			$arr['logcontent'.$langarr[$i]['langtype']]=$con['logcontent'.$langarr[$i]['langtype']];
		}
		$this->db->insert('gksel_log_list',$arr);
	}
	//添加前台访问日志	
	function addlog_front($con=array()){
		$langarr=languagelist();
		$num=0;
		for($i=0;$i<count($langarr);$i++){
			if(isset($con['logcontent'.$langarr[$i]['langtype']])){
				$num++;
			}
		}
		$ipcountryinfo=$this->getipcountryinfo();
		$country_id=$ipcountryinfo['country_id'];
		$ip_address=$ipcountryinfo['ip_address'];
		$arr=array('isfront'=>1,'uid'=>1,'username'=>'','type'=>$con['type'],'week_id'=>date("w"),'platform'=>checkagent(),'browser'=>$ipcountryinfo['browser'],'ipaddress'=>$ip_address,'country_id'=>$country_id,'created'=>mktime());
		for($i=0;$i<count($langarr);$i++){
			$arr['logcontent'.$langarr[$i]['langtype']]=$con['logcontent'.$langarr[$i]['langtype']];
		}
		$this->db->insert('gksel_log_list',$arr);
	}
	//获取Ip地址信息
	function getipcountryinfo(){
		$ip_address=getenv("REMOTE_ADDR");
//		$ip_address="114.89.251.201";//中国
//		$ip_address="195.112.173.199";//德国
		//获取ip地址所在的国家
		$numbers = preg_split( "/\./", $ip_address);    
		include("ip_files/".$numbers[0].".php");
		$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);    
		$country="";
		foreach($ranges as $key => $value){
			if($key<=$code){
			    if($ranges[$key][0]>=$code){$country=$ranges[$key][1];break;}
			}
		}
		if ($country==""){$country=0;}
		$result=$this->db->get_where('gksel_country_ip',array('grade'=>$country))->row_array();
		if(!empty($result)){
			$country_name=$result['country'];
			$country_id=$result['id'];
		}else{
			$country_name="Unkown";
			$country_id=230;
		}
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') ){
			$browser='ie6';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0') ){
			$browser='ie7';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') ){
			$browser='ie8';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0') ){
			$browser='ie9';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0') ){
			$browser='ie10';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 11.0') ){
			$browser='ie11';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 12.0') ){
			$browser='ie12';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 13.0') ){
			$browser='ie13';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 14.0') ){
			$browser='ie14';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 15.0') ){
			$browser='ie15';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 16.0') ){
			$browser='ie16';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 17.0') ){
			$browser='ie17';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 18.0') ){
			$browser='ie18';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 19.0') ){
			$browser='ie19';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 20.0') ){
			$browser='ie20';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ){
			$browser='ie';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') ){
			$browser='chrome';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') ){
			$browser='safari';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') ){
			$browser='firefox';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') ){
			$browser='opera';
		}else{
			$browser='other';
		}
		
		return array('country_id'=>$country_id,'country_name'=>$country_name,'ip_address'=>$ip_address,'browser'=>$browser);
	}
	function getloglist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['log_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " c.log_id =".$con['log_id'];}
		if(isset($con['isfront'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " c.isfront =".$con['isfront'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT c.* FROM gksel_log_list c $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_log_list c $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
}
