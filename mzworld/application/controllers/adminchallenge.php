<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Adminchallenge extends CI_Controller {
	
	function Adminchallenge() {
		session_start();
		parent::__construct ();
		$this->session->set_userdata('menu','challenge');
		$this->langtype='_en';
		$this->lang->load('gksel','english');
		
		$this->category_id=78;//category_id
		$this->category_key='eDkv5Sf59btGZikJIqGeUhSCG5KTByDv';//category_id
		$this->controller='product';
	}
	
	//分类列表
	function index(){
		$con=array('orderby'=>'a.challenge_id','orderby_res'=>'DESC');
		$data['challengelist']=$this->ChallengeModel->getchallengelist($con);
		$this->load->view('admin/challenge_list',$data);
	}
	
	//添加子分类
	function toadd_challenge(){
		$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> > 添加召集';
		$this->load->view('admin/challenge_add',$data);
	}
	//添加子分类
	function add_challenge(){
		//----获取数据--START-----//
			$challenge_name=$this->input->post('challenge_name');
			$challenge_shichang=$this->input->post('challenge_shichang');
			if($challenge_shichang!=-1&&$challenge_shichang!=0&&$challenge_shichang!=30&&$challenge_shichang!=60){
				$challenge_shichang=$this->input->post('zidingyi_shichang');
				if($challenge_shichang==''){
					$challenge_shichang=0;
				}
			}
			$challenge_profile=$this->input->post('challenge_profile');
			$challenge_description=$this->input->post('challenge_description');
			$arr=array('challenge_name'=>$challenge_name,'challenge_shichang'=>$challenge_shichang,'challenge_profile'=>$challenge_profile,'challenge_description'=>$challenge_description,'created'=>mktime(),'edited'=>mktime());
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			$challenge_id=$this->ChallengeModel->add_challenge($arr);
		//----修改数据库--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect(base_url().'?c=adminchallenge&m=index');
			}
		}else{
			redirect(base_url().'?c=adminchallenge&m=index');
		}
	}
	
	//修改子分类
	function toedit_challenge(){
		$challenge_id=$this->input->get('challenge_id');
		$key=$this->input->get('key');
		$data['backurl']=$this->input->get('backurl');
		$data['challengeinfo']=$this->ChallengeModel->getchallengeinfo($challenge_id);
		$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> > 修改召集';
		$this->load->view('admin/challenge_edit',$data);
	}
	//修改子分类
	function edit_challenge(){
		//----获取数据--START-----//
		$challenge_id=$this->input->post('challenge_id');
		$challenge_name=$this->input->post('challenge_name');
		$challenge_shichang=$this->input->post('challenge_shichang');
		if($challenge_shichang!=-1&&$challenge_shichang!=0&&$challenge_shichang!=30&&$challenge_shichang!=60){
			$challenge_shichang=$this->input->post('zidingyi_shichang');
			if($challenge_shichang==''){
				$challenge_shichang=0;
			}
		}
		$challenge_profile=$this->input->post('challenge_profile');
		$challenge_description=$this->input->post('challenge_description');
		//----获取数据--END-----//
		
		//----获取数据--START-----//
			$arr=array('challenge_name'=>$challenge_name,'challenge_shichang'=>$challenge_shichang,'challenge_profile'=>$challenge_profile,'challenge_description'=>$challenge_description,'edited'=>mktime());
			
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			$this->ChallengeModel->edit_challenge($challenge_id,$arr);
		//----修改数据库--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect(base_url().'?c=adminchallenge&m=index');
			}
		}else{
			redirect(base_url().'?c=adminchallenge&m=index');
		}
	}
	
	//作品列表
	function zuopin_list(){
		$challenge_id=$this->input->get('challenge_id');
		$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> > 作品列表';
		//获取召集的作品
		$sql="SELECT * FROM px_opus WHERE type_id=".$challenge_id." ORDER BY opus_id ASC";
		$zuopin_list=$this->db->query($sql)->result_array();
		if(!empty($zuopin_list)){
			$data['zuopin_list']=$zuopin_list;
		}else{
			$data['zuopin_list']=null;
		}
		$this->load->view('admin/challenge_zuopin_list',$data);
	}
	
	//添加产品
	function toadd_article(){
		$subcategory_id=$this->input->get('subcategory_ID');
		$key=$this->input->get('key');
		$data['backurl']=$this->input->get('backurl');
		$category_info=$this->ArticleModel->getarticle_categoryinfo($this->category_id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$data['category_info']=$category_info;
		$data['subcategory_info']=$subcategory_info;
		//判断category 是否直接进入下一节--开始
			$is_next=doactionisnext($category_info['parameter_list']);
		//判断category 是否直接进入下一节--结束
		if($is_next==1){
			$data['url']='<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> > Add Article';
		}else{
			$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> > <a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> > Add Article';
		}
		$this->load->view('admin/article_first_add',$data);
	}
	//修改产品
	function add_article(){
		$langarr=languagelist();//多语言
		
		//----获取数据--START-----//
		$key=$this->input->post('key');
		$subcategory_id=$this->input->post('subcategory_id');
		
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		//加载配置--START
			$con=array('name','created');
			for($tt=1;$tt<=5;$tt++){
				$con[]='pic_'.$tt;
				$con[]='nolaninput_'.$tt;
				$con[]='laninput_'.$tt;
				$con[]='nolantextarea_'.$tt;
				$con[]='lantextarea_'.$tt;
				$con[]='selection_'.$tt;
				$con[]='checkboxion_'.$tt;
			}
			$parameter=$subcategory_info['parameter_post'];
			$parameter=explode('-',$parameter);
			if(!empty($parameter)){
				for($j=0;$j<count($con);$j++){
					${'is_'.$con[$j]}=0;
				}
				for($i=0;$i<count($parameter);$i++){
					for($j=0;$j<count($con);$j++){
						if($parameter[$i]==$con[$j]){
							${'is_'.$con[$j]}=1;
						}
					}
				}
			}
		//加载配置--END
		
			
		//----获取数据--START-----//
			$arr=array('category_id'=>$this->category_id,'subcategory_id'=>$subcategory_id,'created'=>mktime(),'edited'=>mktime());
			if($is_name==1){//标题
				for($la=0;$la<count($langarr);$la++){//多语言
					${'article_name'.$langarr[$la]['langtype']}=$this->input->post('article_name'.$langarr[$la]['langtype']);
					$arr['article_name'.$langarr[$la]['langtype']]=${'article_name'.$langarr[$la]['langtype']};
				}
				if($subcategory_id==80){
					//判断生成 short url
					$newyin_str = '';
					$str = strtoupper(${'article_name_en'});
					for ($i=0;$i<strlen($str);$i++){
						 $s = substr($str,$i,1);
						 if($s==' '){
							$newyin_str .= '-';
						 }else if($s=='-'){
							$newyin_str .= $s;
						 }else if($s=='_'){
							$newyin_str .= $s;
						 }else if($s=='/'){
							$newyin_str .= '-';
						 }else if($s=="'"){
							$newyin_str .= '-';
						 }else if($s=="'"){
							$newyin_str .= '-';
						 }else if($s=='"'){
							$newyin_str .= '-';
						 }else{
						 	if (preg_match ("/^[A-Za-z]/",  $s)) {
			   					$newyin_str .= $s;//是字母
							}else if (preg_match ("/^[0-9]/",  $s)) {
			   					$newyin_str .= $s;//是数字
							}else {
			//    				echo "不是字母数字和自定的";
							}
						 }
					}
					$arr['shorturl']=$newyin_str;//首字母
				}
			}
			for($tt=1;$tt<=5;$tt++){
				if(${'is_selection_'.$tt}==1){//没有多语言的Input
					${'selection_'.$tt}=$this->input->post('selection_'.$tt);
					$arr['selection_'.$tt]=${'selection_'.$tt};
				}
				if(${'is_nolaninput_'.$tt}==1){//没有多语言的Input
					${'nolaninput_'.$tt}=$this->input->post('nolaninput_'.$tt);
					$arr['nolaninput_'.$tt]=enbaseurlcontent(${'nolaninput_'.$tt});
				}
				if(${'is_laninput_'.$tt}==1){//有多语言的 Input
					for($la=0;$la<count($langarr);$la++){//多语言
						${'laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post('laninput_'.$tt.$langarr[$la]['langtype']);
						$arr['laninput_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'laninput_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_nolantextarea_'.$tt}==1){//没有多语言的Textarea
					${'nolantextarea_'.$tt}=$this->input->post('nolantextarea_'.$tt);
					$arr['nolantextarea_'.$tt]=enbaseurlcontent(${'nolantextarea_'.$tt});
				}
				if(${'is_lantextarea_'.$tt}==1){//有多语言的 Textarea
					for($la=0;$la<count($langarr);$la++){//多语言
						${'lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post('lantextarea_'.$tt.$langarr[$la]['langtype']);
						$arr['lantextarea_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'lantextarea_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_pic_'.$tt}==1){//图片$tt
					for($la=0;$la<count($langarr);$la++){//多语言
						${'pic_'.$tt.$langarr[$la]['langtype']}=$this->input->post('pic_'.$tt.$langarr[$la]['langtype']);
						$arr['pic_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'pic_'.$tt.$langarr[$la]['langtype']});
					}
				}
			}
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			//%**************************************当是添加国家时*****************************************%
			if($this->category_id==81){
				$arr['parameter_list']='name-name_en_Name-add-add_en_Add City-edit-edit_en_Edit City-nolaninput_1-nolaninput_1_en_Longitude-nolaninput_2-nolaninput_2_en_Latitude-manage_1-manage_1_en_Manage Cities-created-author-del-orderby-orderby_move-orderby_res_ASC';
				$arr['parameter_post']='name-name_width_200-name_required_0-name_en_Name-nolaninput_1-nolaninput_1_width_200-nolaninput_1_required_0-nolaninput_1_format_vachar-nolaninput_1_en_Longitude-nolaninput_2-nolaninput_2_width_200-nolaninput_2_required_0-nolaninput_2_format_vachar-nolaninput_2_en_Latitude';
			}
			$id=$this->ArticleModel->add_article($arr);
		//----修改数据库--END-----//
		
			
		for($tt=1;$tt<=5;$tt++){
			if(${'is_checkboxion_'.$tt}==1){//没有多语言的Input
				$checkboxion=$this->input->post('checkboxion_'.$tt);
				
				if(!empty($checkboxion)){
					for($ch=0;$ch<count($checkboxion);$ch++){
						$this->db->insert('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id,'condition_id'=>$checkboxion[$ch]));
					}
				}
			}
		}
		
		
		//----修改图片路径--START-----//
			$arr_pic=array();
			for($tt=1;$tt<=5;$tt++){
				if(${'is_pic_'.$tt}==1){//图片$tt
					${'img'.$tt.'_gksel'}=$this->input->post('img'.$tt.'_gksel');
					$arr_pic[]=array('num'=>$tt,'item'=>'pic_'.$tt,'value'=>${'img'.$tt.'_gksel'});
				}
			}
			$arr_pic=autotofilepath('article',$arr_pic);
			if(!empty($arr_pic)){
				$this->ArticleModel->edit_article($id,$arr_pic);
			}
		//----修改图片路径--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$key);
			}
		}else{
			redirect('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$key);
		}
	}
	
	//修改产品
	function toedit_article(){
		$subcategory_id=$this->input->get('subcategory_ID');
		$id=$this->input->get('ID');
		$key=$this->input->get('key');
		$data['backurl']=$this->input->get('backurl');
		$category_info=$this->ArticleModel->getarticle_categoryinfo($this->category_id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$data['category_info']=$category_info;
		$data['subcategory_info']=$subcategory_info;
		
		$data['articleinfo']=$this->ArticleModel->getarticleinfo($id);
		//判断category 是否直接进入下一节--开始
			$is_next=doactionisnext($category_info['parameter_list']);
		//判断category 是否直接进入下一节--结束
		if($is_next==1){
			$data['url']='<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> > 修改文章 ('.$data['articleinfo']['article_name'.$this->langtype].')';
		}else{
			$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> > <a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> > 修改文章 ('.$data['articleinfo']['article_name'.$this->langtype].')';
		}
		$this->load->view('admin/article_first_edit',$data);
	}
	//修改产品
	function edit_article(){
		$langarr=languagelist();//多语言
		
		$id=$this->input->post('id');
		$key=$this->input->post('key');
		$subcategory_id=$this->input->post('subcategory_id');
		
		$articleinfo=$this->ArticleModel->getarticleinfo($id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		
		//加载配置--START
			$con=array('name','created');
			for($tt=1;$tt<=5;$tt++){
				$con[]='pic_'.$tt;
				$con[]='nolaninput_'.$tt;
				$con[]='laninput_'.$tt;
				$con[]='nolantextarea_'.$tt;
				$con[]='lantextarea_'.$tt;
				$con[]='selection_'.$tt;
				$con[]='checkboxion_'.$tt;
			}
			if($articleinfo['parameter_ben']!=""){
				$parameter=$articleinfo['parameter_ben'];
			}else{
				$parameter=$subcategory_info['parameter_post'];
			}
			$parameter=explode('-',$parameter);
			if(!empty($parameter)){
				for($j=0;$j<count($con);$j++){
					${'is_'.$con[$j]}=0;
				}
				for($i=0;$i<count($parameter);$i++){
					for($j=0;$j<count($con);$j++){
						if($parameter[$i]==$con[$j]){
							${'is_'.$con[$j]}=1;
						}
					}
				}
			}
		//加载配置--END
		
		
		//----获取数据--START-----//
			$arr=array('edited'=>mktime());
			if($is_name==1){//标题
				for($la=0;$la<count($langarr);$la++){//多语言
					${'article_name'.$langarr[$la]['langtype']}=$this->input->post('article_name'.$langarr[$la]['langtype']);
					$arr['article_name'.$langarr[$la]['langtype']]=${'article_name'.$langarr[$la]['langtype']};
				}
				if($subcategory_id==80){
					//判断生成 short url
					$newyin_str = '';
					$str = strtoupper(${'article_name_en'});
					for ($i=0;$i<strlen($str);$i++){
						 $s = substr($str,$i,1);
						 if($s==' '){
							$newyin_str .= '-';
						 }else if($s=='-'){
							$newyin_str .= $s;
						 }else if($s=='_'){
							$newyin_str .= $s;
						 }else if($s=='/'){
							$newyin_str .= '-';
						 }else if($s=="'"){
							$newyin_str .= '-';
						 }else if($s=="'"){
							$newyin_str .= '-';
						 }else if($s=='"'){
							$newyin_str .= '-';
						 }else{
						 	if (preg_match ("/^[A-Za-z]/",  $s)) {
			   					$newyin_str .= $s;//是字母
							}else if (preg_match ("/^[0-9]/",  $s)) {
			   					$newyin_str .= $s;//是数字
							}else {
			//    				echo "不是字母数字和自定的";
							}
						 }
					}
					$arr['shorturl']=$newyin_str;//首字母
				}
			}
			for($tt=1;$tt<=5;$tt++){
				if(${'is_selection_'.$tt}==1){//没有多语言的Input
					${'selection_'.$tt}=$this->input->post('selection_'.$tt);
					if(${'selection_'.$tt}==""){${'selection_'.$tt}=0;}
					$arr['selection_'.$tt]=${'selection_'.$tt};
				}
				if(${'is_nolaninput_'.$tt}==1){//没有多语言的Input
					${'nolaninput_'.$tt}=$this->input->post('nolaninput_'.$tt);
					$arr['nolaninput_'.$tt]=enbaseurlcontent(${'nolaninput_'.$tt});
				}
				if(${'is_laninput_'.$tt}==1){//有多语言的 Input
					for($la=0;$la<count($langarr);$la++){//多语言
						${'laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post('laninput_'.$tt.$langarr[$la]['langtype']);
						$arr['laninput_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'laninput_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_nolantextarea_'.$tt}==1){//没有多语言的Textarea
					${'nolantextarea_'.$tt}=$this->input->post('nolantextarea_'.$tt);
					$arr['nolantextarea_'.$tt]=enbaseurlcontent(${'nolantextarea_'.$tt});
				}
				if(${'is_lantextarea_'.$tt}==1){//有多语言的 Textarea
					for($la=0;$la<count($langarr);$la++){//多语言
						${'lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post('lantextarea_'.$tt.$langarr[$la]['langtype']);
						$arr['lantextarea_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'lantextarea_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_pic_'.$tt}==1){//图片$tt
					for($la=0;$la<count($langarr);$la++){//多语言
						${'pic_'.$tt.$langarr[$la]['langtype']}=$this->input->post('pic_'.$tt.$langarr[$la]['langtype']);
						$arr['pic_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'pic_'.$tt.$langarr[$la]['langtype']});
					}
				}
			}
			if($subcategory_id==80){//如果是项目时
				$arr['audit_status']=$this->input->post('audit_status');
			}
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			$this->ArticleModel->edit_article($id,$arr);
		//----修改数据库--END-----//
		
			
			
		for($tt=1;$tt<=5;$tt++){
			if(${'is_checkboxion_'.$tt}==1){//没有多语言的Input
				$checkboxion=$this->input->post('checkboxion_'.$tt);
				
				//后期修改成on  和 off
				$this->db->delete('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id));
				
				if(!empty($checkboxion)){
					for($ch=0;$ch<count($checkboxion);$ch++){
						$this->db->insert('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id,'condition_id'=>$checkboxion[$ch]));
					}
				}
			}
		}
		
		//----修改图片路径--START-----//
			$arr_pic=array();
			for($tt=1;$tt<=5;$tt++){
				if(${'is_pic_'.$tt}==1){//图片$tt
					${'img'.$tt.'_gksel'}=$this->input->post('img'.$tt.'_gksel');
					$arr_pic[]=array('num'=>$tt,'item'=>'pic_'.$tt,'value'=>${'img'.$tt.'_gksel'});
				}
			}
			$arr_pic=autotofilepath('article',$arr_pic);
			if(!empty($arr_pic)){
				$this->ArticleModel->edit_article($id,$arr_pic);
			}
		//----修改图片路径--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$key);
			}
		}else{
			redirect('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$key);
		}
	}
	
	//文章列表
	function subarticle_list(){
		$langarr=languagelist();//多语言
		
		$subcategory_id=$this->input->get('subcategory_ID');
		$first_id=$this->input->get('first_id');
		$tongji_split=$this->input->get('tongji_split');
		$key=$this->input->get('key');
		$keyword=$this->input->get('keyword');
		for($tt=1;$tt<=5;$tt++){
			${'selection_'.$tt}=$this->input->get('selection_'.$tt);
		}
		$category_info=$this->ArticleModel->getarticle_categoryinfo($this->category_id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$firstinfo=$this->ArticleModel->getarticleinfo($first_id);
		
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$data['row']=$row;
		$data['page']=100;
		//判断category 是否直接进入下一节--开始
			$is_next=doactionisnext($category_info['parameter_list']);
		//判断category 是否直接进入下一节--结束
		if($is_next==1){
			$data['url']='<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; '.$firstinfo['article_name'.$this->langtype];
		}else{
			$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; '.$firstinfo['article_name'.$this->langtype];
		}
		$data['category_info']=$category_info;
		$data['subcategory_info']=$subcategory_info;
		$data['firstinfo']=$firstinfo;
		$data['tongji_split']=$tongji_split;
		$con=array('parent'=>$first_id,'tongji_split'=>$tongji_split,'category_id'=>$this->category_id,'subcategory_id'=>$subcategory_id,'row'=>$data['row'],'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword']=$keyword;
		}
		for($tt=1;$tt<=5;$tt++){
			if(${'selection_'.$tt}!=""){
				$con['selection_'.$tt]=${'selection_'.$tt};
			}
		}
		//排序--开始
			$actionorderby=doactionorderby($firstinfo['parameter_list']);
			if($actionorderby['orderby']=='move'){
				$con['orderby']='sort';
				$con['orderby_res']=$actionorderby['orderby_res'];
			}else{
				$con['orderby']='category_id';
				$con['orderby_res']='DESC';
			}
			$data['oldorderby']=$actionorderby['orderby'];
			$data['oldorderby_res']=$actionorderby['orderby_res'];
		//排序--结束
		$data['article']=$this->ArticleModel->getarticlelist($con);
		$data['count']=$this->ArticleModel->getarticlelist($con,1);
		
		
		$urlstr='admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key.'&keyword='.$keyword;
		for($tt=1;$tt<=5;$tt++){
			$urlstr .='&selection_'.$tt.'='.${'selection_'.$tt};
		}
		$url = site_url($urlstr);
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],3,2);
		$this->load->view('admin/article_second_list',$data);
	}
	
	//添加子文章
	function toadd_subarticle(){
		$subcategory_id=$this->input->get('subcategory_ID');
		$first_id=$this->input->get('first_id');
		$tongji_split=$this->input->get('tongji_split');
		$key=$this->input->get('key');
		$data['backurl']=$this->input->get('backurl');
		$category_info=$this->ArticleModel->getarticle_categoryinfo($this->category_id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$firstinfo=$this->ArticleModel->getarticleinfo($first_id);
		$data['category_info']=$category_info;
		$data['subcategory_info']=$subcategory_info;
		$data['firstinfo']=$firstinfo;
		$data['tongji_split']=$tongji_split;
		//判断category 是否直接进入下一节--开始
			$is_next=doactionisnext($category_info['parameter_list']);
		//判断category 是否直接进入下一节--结束
		if($is_next==1){
			$data['url']='<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key).'">'.$firstinfo['article_name'.$this->langtype].'</a> &gt; Add Article';
		}else{
			$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key).'">'.$firstinfo['article_name'.$this->langtype].'</a> &gt; Add Article';
		}
		$this->load->view('admin/article_second_add',$data);
	}
	
	//添加子文章
	function add_subarticle(){
		$langarr=languagelist();//多语言
		
		//----获取数据--START-----//
		$key=$this->input->post('key');
		$subcategory_id=$this->input->post('subcategory_id');
		$first_id=$this->input->post('first_id');
		$tongji_split=$this->input->post('tongji_split');
		
		$firstinfo=$this->ArticleModel->getarticleinfo($first_id);
		//加载配置--START
			$con=array('name','created');
			for($tt=1;$tt<=5;$tt++){
				$con[]='pic_'.$tt;
				$con[]='nolaninput_'.$tt;
				$con[]='laninput_'.$tt;
				$con[]='nolantextarea_'.$tt;
				$con[]='lantextarea_'.$tt;
				$con[]='selection_'.$tt;
				$con[]='checkboxion_'.$tt;
			}
			$parameter=$firstinfo['parameter_post'];
			$parameter=explode('-',$parameter);
			if(!empty($parameter)){
				for($j=0;$j<count($con);$j++){
					${'is_'.$con[$j]}=0;
				}
				for($i=0;$i<count($parameter);$i++){
					for($j=0;$j<count($con);$j++){
						if($parameter[$i]==$con[$j]){
							${'is_'.$con[$j]}=1;
						}
					}
				}
			}
		//加载配置--END
		
			
		//----获取数据--START-----//
			$arr=array('parent'=>$first_id,'tongji_split'=>$tongji_split,'category_id'=>$this->category_id,'subcategory_id'=>$subcategory_id,'created'=>mktime(),'edited'=>mktime());
			if($is_name==1){//标题
				for($la=0;$la<count($langarr);$la++){//多语言
					${'article_name'.$langarr[$la]['langtype']}=$this->input->post('article_name'.$langarr[$la]['langtype']);
					$arr['article_name'.$langarr[$la]['langtype']]=${'article_name'.$langarr[$la]['langtype']};
				}
			}
			for($tt=1;$tt<=5;$tt++){
				if(${'is_selection_'.$tt}==1){//没有多语言的Input
					${'selection_'.$tt}=$this->input->post('selection_'.$tt);
					$arr['selection_'.$tt]=${'selection_'.$tt};
				}
				if(${'is_nolaninput_'.$tt}==1){//没有多语言的Input
					${'nolaninput_'.$tt}=$this->input->post('nolaninput_'.$tt);
					$arr['nolaninput_'.$tt]=enbaseurlcontent(${'nolaninput_'.$tt});
				}
				if(${'is_laninput_'.$tt}==1){//有多语言的 Input
					for($la=0;$la<count($langarr);$la++){//多语言
						${'laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post('laninput_'.$tt.$langarr[$la]['langtype']);
						$arr['laninput_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'laninput_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_nolantextarea_'.$tt}==1){//没有多语言的Textarea
					${'nolantextarea_'.$tt}=$this->input->post('nolantextarea_'.$tt);
					$arr['nolantextarea_'.$tt]=enbaseurlcontent(${'nolantextarea_'.$tt});
				}
				if(${'is_lantextarea_'.$tt}==1){//有多语言的 Textarea
					for($la=0;$la<count($langarr);$la++){//多语言
						${'lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post('lantextarea_'.$tt.$langarr[$la]['langtype']);
						$arr['lantextarea_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'lantextarea_'.$tt.$langarr[$la]['langtype']});
					}
				}
			}
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			$id=$this->ArticleModel->add_article($arr);
		//----修改数据库--END-----//
		
			
		for($tt=1;$tt<=5;$tt++){
			if(${'is_checkboxion_'.$tt}==1){//没有多语言的Input
				$checkboxion=$this->input->post('checkboxion_'.$tt);
				
				if(!empty($checkboxion)){
					for($ch=0;$ch<count($checkboxion);$ch++){
						$this->db->insert('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id,'condition_id'=>$checkboxion[$ch]));
					}
				}
			}
		}
		
		
		//----修改图片路径--START-----//
			$arr_pic=array();
			for($tt=1;$tt<=5;$tt++){
				if(${'is_pic_'.$tt}==1){//图片$tt
					${'img'.$tt.'_gksel'}=$this->input->post('img'.$tt.'_gksel');
					$arr_pic[]=array('num'=>$tt,'item'=>'pic_'.$tt,'value'=>${'img'.$tt.'_gksel'});
				}
			}
			$arr_pic=autotofilepath('article',$arr_pic);
			if(!empty($arr_pic)){
				$this->ArticleModel->edit_article($id,$arr_pic);
			}
		//----修改图片路径--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key);
			}
		}else{
			redirect('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key);
		}
	}
	
	//修改产品
	function toedit_subarticle(){
		$subcategory_id=$this->input->get('subcategory_ID');
		$first_id=$this->input->get('first_id');
		$tongji_split=$this->input->get('tongji_split');
		$id=$this->input->get('ID');
		$key=$this->input->get('key');
		$data['backurl']=$this->input->get('backurl');
		$category_info=$this->ArticleModel->getarticle_categoryinfo($this->category_id);
		$subcategory_info=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$firstinfo=$this->ArticleModel->getarticleinfo($first_id);
		$data['category_info']=$category_info;
		$data['subcategory_info']=$subcategory_info;
		$data['firstinfo']=$firstinfo;
		$data['tongji_split']=$tongji_split;
		
		$data['articleinfo']=$this->ArticleModel->getarticleinfo($id);
		//判断category 是否直接进入下一节--开始
			$is_next=doactionisnext($category_info['parameter_list']);
		//判断category 是否直接进入下一节--结束
		if($is_next==1){
			$data['url']='<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key).'">'.$firstinfo['article_name'.$this->langtype].'</a> &gt; 修改文章';
		}else{
			$data['url']='<a href="'.base_url().'?c=adminchallenge&m=index">管理召集</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory_id.'&key='.$subcategory_info['key']).'">'.$subcategory_info['category_name'.$this->langtype].'</a> &gt; <a href="'.site_url('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key).'">'.$firstinfo['article_name'.$this->langtype].'</a> &gt; 修改文章';
		}
		$this->load->view('admin/article_second_edit',$data);
	}
	//修改产品
	function edit_subarticle(){
		$langarr=languagelist();//多语言
		
		$id=$this->input->post('id');
		$key=$this->input->post('key');
		$subcategory_id=$this->input->post('subcategory_id');
		$first_id=$this->input->post('first_id');
		$tongji_split=$this->input->post('tongji_split');
		
		$articleinfo=$this->ArticleModel->getarticleinfo($id);
		$firstinfo=$this->ArticleModel->getarticleinfo($first_id);
		
		//加载配置--START
			$con=array('name','created');
			for($tt=1;$tt<=5;$tt++){
				$con[]='pic_'.$tt;
				$con[]='nolaninput_'.$tt;
				$con[]='laninput_'.$tt;
				$con[]='nolantextarea_'.$tt;
				$con[]='lantextarea_'.$tt;
				$con[]='selection_'.$tt;
				$con[]='checkboxion_'.$tt;
			}
			if($articleinfo['parameter_ben']!=""){
				$parameter=$articleinfo['parameter_ben'];
			}else{
				$parameter=$firstinfo['parameter_post'];
			}
			$parameter=explode('-',$parameter);
			if(!empty($parameter)){
				for($j=0;$j<count($con);$j++){
					${'is_'.$con[$j]}=0;
				}
				for($i=0;$i<count($parameter);$i++){
					for($j=0;$j<count($con);$j++){
						if($parameter[$i]==$con[$j]){
							${'is_'.$con[$j]}=1;
						}
					}
				}
			}
		//加载配置--END
		
		
		//----获取数据--START-----//
			$arr=array('edited'=>mktime());
			if($is_name==1){//标题
				for($la=0;$la<count($langarr);$la++){//多语言
					${'article_name'.$langarr[$la]['langtype']}=$this->input->post('article_name'.$langarr[$la]['langtype']);
					$arr['article_name'.$langarr[$la]['langtype']]=${'article_name'.$langarr[$la]['langtype']};
				}
			}
			for($tt=1;$tt<=5;$tt++){
				if(${'is_selection_'.$tt}==1){//没有多语言的Input
					${'selection_'.$tt}=$this->input->post('selection_'.$tt);
					$arr['selection_'.$tt]=${'selection_'.$tt};
				}
				if(${'is_nolaninput_'.$tt}==1){//没有多语言的Input
					${'nolaninput_'.$tt}=$this->input->post('nolaninput_'.$tt);
					$arr['nolaninput_'.$tt]=enbaseurlcontent(${'nolaninput_'.$tt});
				}
				if(${'is_laninput_'.$tt}==1){//有多语言的 Input
					for($la=0;$la<count($langarr);$la++){//多语言
						${'laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post('laninput_'.$tt.$langarr[$la]['langtype']);
						$arr['laninput_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'laninput_'.$tt.$langarr[$la]['langtype']});
					}
				}
				if(${'is_nolantextarea_'.$tt}==1){//没有多语言的Textarea
					${'nolantextarea_'.$tt}=$this->input->post('nolantextarea_'.$tt);
					$arr['nolantextarea_'.$tt]=enbaseurlcontent(${'nolantextarea_'.$tt});
				}
				if(${'is_lantextarea_'.$tt}==1){//有多语言的 Textarea
					for($la=0;$la<count($langarr);$la++){//多语言
						${'lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post('lantextarea_'.$tt.$langarr[$la]['langtype']);
						$arr['lantextarea_'.$tt.$langarr[$la]['langtype']]=enbaseurlcontent(${'lantextarea_'.$tt.$langarr[$la]['langtype']});
					}
				}
			}
		//----获取数据--END-----//
		
		//----修改数据库--START-----//
			$this->ArticleModel->edit_article($id,$arr);
		//----修改数据库--END-----//
		
			
			
		for($tt=1;$tt<=5;$tt++){
			if(${'is_checkboxion_'.$tt}==1){//没有多语言的Input
				$checkboxion=$this->input->post('checkboxion_'.$tt);
				
				//后期修改成on  和 off
				$this->db->delete('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id));
				
				if(!empty($checkboxion)){
					for($ch=0;$ch<count($checkboxion);$ch++){
						$this->db->insert('gksel_article_checkboxion',array('checkboxion_num'=>$tt,'article_id'=>$id,'condition_id'=>$checkboxion[$ch]));
					}
				}
			}
		}
		
		//----修改图片路径--START-----//
			$arr_pic=array();
			for($tt=1;$tt<=5;$tt++){
				if(${'is_pic_'.$tt}==1){//图片$tt
					${'img'.$tt.'_gksel'}=$this->input->post('img'.$tt.'_gksel');
					$arr_pic[]=array('num'=>$tt,'item'=>'pic_'.$tt,'value'=>${'img'.$tt.'_gksel'});
				}
			}
			$arr_pic=autotofilepath('article',$arr_pic);
			if(!empty($arr_pic)){
				if($this->category_id==78){
					if(isset($arr_pic['pic_1'])){
						//添加水印
						$this->load->library('app');
						$this->app->imgwatermark($arr_pic['pic_1'],'themes/default/images/watermark_small.png');
					}
					if(isset($arr_pic['pic_2'])){
						$old_arr=explode('.',$arr_pic['pic_2']);
						$pic_type=end($old_arr);
						//
						$copy_url = "upload/article/".date('Y')."/".date('m').'/article_3_'.date('Y_m_d_H_i_s').'.'.$pic_type;
						$res=copy($arr_pic['pic_2'], $copy_url);
						$arr_pic['pic_3']=$copy_url;
						
						
						//添加水印
						$this->load->library('app');
						$this->app->imgwatermark($arr_pic['pic_2'],'themes/default/images/watermark_big.png');
					}
				}
				$this->ArticleModel->edit_article($id,$arr_pic);
			}
		//----修改图片路径--END-----//
		
		$backurl=$this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				redirect(base64_decode($backurl));
			}else{
				redirect('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key);
			}
		}else{
			redirect('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_id.'&first_id='.$first_id.'&tongji_split='.$tongji_split.'&key='.$key);
		}
	}
	
	

	

}

	