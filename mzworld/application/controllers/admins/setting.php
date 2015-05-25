<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->session->set_userdata('menu','setting');
		$this->themes=$this->config->item('themes');//加载主题
		$this->langtype='_en';
	}
	
    function index(){
    	$this->load->view('admin/sys_setting');
    }
	
	function save_sys_setting(){
		$company_name=$this->input->post('company_name');
    	$this->WelModel->editsettingval('company_name',array('val'=>$company_name));
    	redirect('admins/setting/index');
	}
	
	function toedit_parameter(){
		$con=array('parent'=>0,'orderby'=>'category_id','orderby_res'=>'ASC');
		$data['categorylist']=$this->ArticleModel->getarticle_categorylist($con);
		$this->load->view('admin/sys_parameter',$data);
	}
	
	function edit_parameter($id){
		$langarr=languagelist();//多语言
		$parameter_list='';
		
		$sectionandname=array();//模块和名称
		$sectionandname[]=array('code'=>'name','name'=>'标题');
		$sectionandname[]=array('code'=>'add','name'=>'添加');
		$sectionandname[]=array('code'=>'edit','name'=>'修改');
		for($sn=0;$sn<count($sectionandname);$sn++){
			${'list_'.$sectionandname[$sn]['code']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code']);
			if(${'list_'.$sectionandname[$sn]['code']}!=""){
				for($la=0;$la<count($langarr);$la++){//多语言
					${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']);
				}
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$sectionandname[$sn]['code'];
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_list .='-'.$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_'.${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']};
				}
			}
		}
		//图片,没有多语言的Input,有多语言的Input,没有多语言的Textarea,有多语言的Textarea,管理
		$con=array('pic','nolaninput','laninput','nolantextarea','lantextarea','manage');
		for($a=0;$a<count($con);$a++){
			for($tt=1;$tt<=5;$tt++){
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				if(${'list_'.$con[$a].'_'.$tt}!=""){
					for($la=0;$la<count($langarr);$la++){//多语言
						${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']);
					}
					if($parameter_list!=""){$parameter_list .='-';}
					$parameter_list .=$con[$a].'_'.$tt;
					for($la=0;$la<count($langarr);$la++){//多语言
						$parameter_list .='-'.$con[$a].'_'.$tt.$langarr[$la]['langtype'].'_'.${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']};
					}
				}
			}
		}
		//      跳到下一级    创建时间    修改时间         作者          删除    批量删除
		$con=array('next','created','edited','author','del','muldel','selection_1','selection_2','selection_3','checkboxion_1','checkboxion_2','checkboxion_3');
		for($i=0;$i<count($con);$i++){
			${'list_'.$con[$i]}=$this->input->post($id.'list_'.$con[$i]);
			if(${'list_'.$con[$i]}!=""){
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$con[$i];
			}
		}
		//排序
		$list_orderby=$this->input->post($id.'list_orderby');
		if($list_orderby!=""){
			//orderby-orderby_move-orderby_res_ASC
			$list_orderby=$this->input->post($id.'list_orderby');
			$list_orderby_res=$this->input->post($id.'list_orderby_res');
			if($parameter_list!=""){$parameter_list .='-';}
			$parameter_list .='orderby-orderby_'.$list_orderby.'-orderby_res_'.$list_orderby_res;
		}
//		print_r($parameter_list);exit;
		
		
		
		$parameter_post='';
		//名称
		$post_name=$this->input->post($id.'post_name');
		if($post_name!=""){
			$post_name_width=$this->input->post($id.'post_name_width');
			$post_name_required=$this->input->post($id.'post_name_required');
			if($post_name_required==""){
				$post_name_required=0;
			}
			for($la=0;$la<count($langarr);$la++){//多语言
				${'post_name'.$langarr[$la]['langtype']}=$this->input->post($id.'post_name'.$langarr[$la]['langtype']);
			}
			if($parameter_post!=""){$parameter_post .='-';}
			$parameter_post .='name-name_width_'.$post_name_width.'-name_required_'.$post_name_required;
			for($la=0;$la<count($langarr);$la++){//多语言
				$parameter_post .='-name'.$langarr[$la]['langtype'].'_'.${'post_name'.$langarr[$la]['langtype']};
			}
		}
		//Select 下拉
		for($tt=1;$tt<=5;$tt++){
			${'post_selection_'.$tt}=$this->input->post($id.'post_selection_'.$tt);
			if(${'post_selection_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='selection_'.$tt;
			}
		}
		//Checkbox 多选
		for($tt=1;$tt<=5;$tt++){
			${'post_checkboxion_'.$tt}=$this->input->post($id.'post_checkboxion_'.$tt);
			if(${'post_checkboxion_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='checkboxion_'.$tt;
			}
		}
		//图片
		for($tt=1;$tt<=5;$tt++){
			${'post_pic_'.$tt}=$this->input->post($id.'post_pic_'.$tt);
			if(${'post_pic_'.$tt}!=""){
				${'post_pic_'.$tt.'_showtype'}=$this->input->post($id.'post_pic_'.$tt.'_showtype');
				${'post_pic_'.$tt.'_width'}=$this->input->post($id.'post_pic_'.$tt.'_width');
				${'post_pic_'.$tt.'_height'}=$this->input->post($id.'post_pic_'.$tt.'_height');
				${'post_pic_'.$tt.'_required'}=$this->input->post($id.'post_pic_'.$tt.'_required');
				if(${'post_pic_'.$tt.'_required'}==""){
					${'post_pic_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_pic_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_pic_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='pic_'.$tt.'-pic_'.$tt.'_showtype_'.${'post_pic_'.$tt.'_showtype'}.'-pic_'.$tt.'_width_'.${'post_pic_'.$tt.'_width'}.'-pic_'.$tt.'_height_'.${'post_pic_'.$tt.'_height'}.'-pic_'.$tt.'_required_'.${'post_pic_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-pic_'.$tt.$langarr[$la]['langtype'].'_'.${'post_pic_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_nolaninput_'.$tt}=$this->input->post($id.'post_nolaninput_'.$tt);
			if(${'post_nolaninput_'.$tt}!=""){
				${'post_nolaninput_'.$tt.'_width'}=$this->input->post($id.'post_nolaninput_'.$tt.'_width');
				${'post_nolaninput_'.$tt.'_required'}=$this->input->post($id.'post_nolaninput_'.$tt.'_required');
				if(${'post_nolaninput_'.$tt.'_required'}==""){
					${'post_nolaninput_'.$tt.'_required'}=0;
				}
				${'post_nolaninput_'.$tt.'_format'}=$this->input->post($id.'post_nolaninput_'.$tt.'_format');
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolaninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolaninput_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolaninput_'.$tt.'-nolaninput_'.$tt.'_width_'.${'post_nolaninput_'.$tt.'_width'}.'-nolaninput_'.$tt.'_required_'.${'post_nolaninput_'.$tt.'_required'}.'-nolaninput_'.$tt.'_format_'.${'post_nolaninput_'.$tt.'_format'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolaninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolaninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_laninput_'.$tt}=$this->input->post($id.'post_laninput_'.$tt);
			if(${'post_laninput_'.$tt}!=""){
				${'post_laninput_'.$tt.'_width'}=$this->input->post($id.'post_laninput_'.$tt.'_width');
				${'post_laninput_'.$tt.'_required'}=$this->input->post($id.'post_laninput_'.$tt.'_required');
				if(${'post_laninput_'.$tt.'_required'}==""){
					${'post_laninput_'.$tt.'_required'}=0;
				}
				if($parameter_post!=""){$parameter_post .='-';}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_laninput_'.$tt.$langarr[$la]['langtype']);
				}
				$parameter_post .='laninput_'.$tt.'-laninput_'.$tt.'_width_'.${'post_laninput_'.$tt.'_width'}.'-laninput_'.$tt.'_required_'.${'post_laninput_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-laninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_laninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_nolantextarea_'.$tt}=$this->input->post($id.'post_nolantextarea_'.$tt);
			if(${'post_nolantextarea_'.$tt}!=""){
				${'post_nolantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_showtype');
				${'post_nolantextarea_'.$tt.'_width'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_width');
				${'post_nolantextarea_'.$tt.'_height'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_height');
				${'post_nolantextarea_'.$tt.'_required'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_required');
				if(${'post_nolantextarea_'.$tt.'_required'}==""){
					${'post_nolantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolantextarea_'.$tt.'-nolantextarea_'.$tt.'_showtype_'.${'post_nolantextarea_'.$tt.'_showtype'}.'-nolantextarea_'.$tt.'_width_'.${'post_nolantextarea_'.$tt.'_width'}.'-nolantextarea_'.$tt.'_height_'.${'post_nolantextarea_'.$tt.'_height'}.'-nolantextarea_'.$tt.'_required_'.${'post_nolantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_lantextarea_'.$tt}=$this->input->post($id.'post_lantextarea_'.$tt);
			if(${'post_lantextarea_'.$tt}!=""){
				${'post_lantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_lantextarea_'.$tt.'_showtype');
				${'post_lantextarea_'.$tt.'_width'}=$this->input->post($id.'post_lantextarea_'.$tt.'_width');
				${'post_lantextarea_'.$tt.'_height'}=$this->input->post($id.'post_lantextarea_'.$tt.'_height');
				${'post_lantextarea_'.$tt.'_required'}=$this->input->post($id.'post_lantextarea_'.$tt.'_required');
				if(${'post_lantextarea_'.$tt.'_required'}==""){
					${'post_lantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_lantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='lantextarea_'.$tt.'-lantextarea_'.$tt.'_showtype_'.${'post_lantextarea_'.$tt.'_showtype'}.'-lantextarea_'.$tt.'_width_'.${'post_lantextarea_'.$tt.'_width'}.'-lantextarea_'.$tt.'_height_'.${'post_lantextarea_'.$tt.'_height'}.'-lantextarea_'.$tt.'_required_'.${'post_lantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-lantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_lantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		$this->ArticleModel->edit_category($id,array('parameter_list'=>$parameter_list,'parameter_post'=>$parameter_post));
		redirect('admins/setting/toedit_parameter');
		
	}
	
	function toedit_subcategoryparameter($category_id=0){
		$data['categoryinfo']=$this->ArticleModel->getarticle_categoryinfo($category_id);
		$con=array('parent'=>$category_id,'orderby'=>'category_id','orderby_res'=>'ASC');
		$data['subcategorylist']=$this->ArticleModel->getarticle_categorylist($con);
		$this->load->view('admin/sys_parameter_subcategory',$data);
	}
	
	function edit_subcategoryparameter($category_id,$id){
		$langarr=languagelist();//多语言
		$parameter_list='';
		
		$sectionandname=array();//模块和名称
		$sectionandname[]=array('code'=>'name','name'=>'标题');
		$sectionandname[]=array('code'=>'add','name'=>'添加');
		$sectionandname[]=array('code'=>'edit','name'=>'修改');
		for($sn=0;$sn<count($sectionandname);$sn++){
			${'list_'.$sectionandname[$sn]['code']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code']);
			if(${'list_'.$sectionandname[$sn]['code']}!=""){
				for($la=0;$la<count($langarr);$la++){//多语言
					${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']);
				}
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$sectionandname[$sn]['code'];
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_list .='-'.$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_'.${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']};
				}
			}
		}
		
		//图片,没有多语言的Input,有多语言的Input,没有多语言的Textarea,有多语言的Textarea, 管理
		$con=array('pic','nolaninput','laninput','nolantextarea','lantextarea','manage');
		for($a=0;$a<count($con);$a++){
			for($tt=1;$tt<=5;$tt++){
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				if(${'list_'.$con[$a].'_'.$tt}!=""){
					for($la=0;$la<count($langarr);$la++){//多语言
						${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']);
					}
					if($parameter_list!=""){$parameter_list .='-';}
					$parameter_list .=$con[$a].'_'.$tt;
					for($la=0;$la<count($langarr);$la++){//多语言
						$parameter_list .='-'.$con[$a].'_'.$tt.$langarr[$la]['langtype'].'_'.${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']};
					}
				}
			}
		}
		//      跳到下一级    创建时间    修改时间         作者          删除    批量删除
		$con=array('next','created','edited','author','del','muldel','selection_1','selection_2','selection_3','checkboxion_1','checkboxion_2','checkboxion_3');
		for($i=0;$i<count($con);$i++){
			${'list_'.$con[$i]}=$this->input->post($id.'list_'.$con[$i]);
			if(${'list_'.$con[$i]}!=""){
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$con[$i];
			}
		}
		//排序
		$list_orderby=$this->input->post($id.'list_orderby');
		if($list_orderby!=""){
			//orderby-orderby_move-orderby_res_ASC
			$list_orderby=$this->input->post($id.'list_orderby');
			$list_orderby_res=$this->input->post($id.'list_orderby_res');
			if($parameter_list!=""){$parameter_list .='-';}
			$parameter_list .='orderby-orderby_'.$list_orderby.'-orderby_res_'.$list_orderby_res;
		}
//		print_r($parameter_list);exit;
		
		
		
		$parameter_post='';
		//名称
		$post_name=$this->input->post($id.'post_name');
		if($post_name!=""){
			$post_name_width=$this->input->post($id.'post_name_width');
			$post_name_required=$this->input->post($id.'post_name_required');
			if($post_name_required==""){
				$post_name_required=0;
			}
			for($la=0;$la<count($langarr);$la++){//多语言
				${'post_name'.$langarr[$la]['langtype']}=$this->input->post($id.'post_name'.$langarr[$la]['langtype']);
			}
			if($parameter_post!=""){$parameter_post .='-';}
			$parameter_post .='name-name_width_'.$post_name_width.'-name_required_'.$post_name_required;
			for($la=0;$la<count($langarr);$la++){//多语言
				$parameter_post .='-name'.$langarr[$la]['langtype'].'_'.${'post_name'.$langarr[$la]['langtype']};
			}
		}
		//Select 下拉
		for($tt=1;$tt<=5;$tt++){
			${'post_selection_'.$tt}=$this->input->post($id.'post_selection_'.$tt);
			if(${'post_selection_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='selection_'.$tt;
			}
		}
		//Checkbox 多选
		for($tt=1;$tt<=5;$tt++){
			${'post_checkboxion_'.$tt}=$this->input->post($id.'post_checkboxion_'.$tt);
			if(${'post_checkboxion_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='checkboxion_'.$tt;
			}
		}
		//图片
		for($tt=1;$tt<=5;$tt++){
			${'post_pic_'.$tt}=$this->input->post($id.'post_pic_'.$tt);
			if(${'post_pic_'.$tt}!=""){
				${'post_pic_'.$tt.'_showtype'}=$this->input->post($id.'post_pic_'.$tt.'_showtype');
				${'post_pic_'.$tt.'_width'}=$this->input->post($id.'post_pic_'.$tt.'_width');
				${'post_pic_'.$tt.'_height'}=$this->input->post($id.'post_pic_'.$tt.'_height');
				${'post_pic_'.$tt.'_required'}=$this->input->post($id.'post_pic_'.$tt.'_required');
				if(${'post_pic_'.$tt.'_required'}==""){
					${'post_pic_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_pic_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_pic_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='pic_'.$tt.'-pic_'.$tt.'_showtype_'.${'post_pic_'.$tt.'_showtype'}.'-pic_'.$tt.'_width_'.${'post_pic_'.$tt.'_width'}.'-pic_'.$tt.'_height_'.${'post_pic_'.$tt.'_height'}.'-pic_'.$tt.'_required_'.${'post_pic_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-pic_'.$tt.$langarr[$la]['langtype'].'_'.${'post_pic_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_nolaninput_'.$tt}=$this->input->post($id.'post_nolaninput_'.$tt);
			if(${'post_nolaninput_'.$tt}!=""){
				${'post_nolaninput_'.$tt.'_width'}=$this->input->post($id.'post_nolaninput_'.$tt.'_width');
				${'post_nolaninput_'.$tt.'_required'}=$this->input->post($id.'post_nolaninput_'.$tt.'_required');
				if(${'post_nolaninput_'.$tt.'_required'}==""){
					${'post_nolaninput_'.$tt.'_required'}=0;
				}
				${'post_nolaninput_'.$tt.'_format'}=$this->input->post($id.'post_nolaninput_'.$tt.'_format');
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolaninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolaninput_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolaninput_'.$tt.'-nolaninput_'.$tt.'_width_'.${'post_nolaninput_'.$tt.'_width'}.'-nolaninput_'.$tt.'_required_'.${'post_nolaninput_'.$tt.'_required'}.'-nolaninput_'.$tt.'_format_'.${'post_nolaninput_'.$tt.'_format'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolaninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolaninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_laninput_'.$tt}=$this->input->post($id.'post_laninput_'.$tt);
			if(${'post_laninput_'.$tt}!=""){
				${'post_laninput_'.$tt.'_width'}=$this->input->post($id.'post_laninput_'.$tt.'_width');
				${'post_laninput_'.$tt.'_required'}=$this->input->post($id.'post_laninput_'.$tt.'_required');
				if(${'post_laninput_'.$tt.'_required'}==""){
					${'post_laninput_'.$tt.'_required'}=0;
				}
				if($parameter_post!=""){$parameter_post .='-';}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_laninput_'.$tt.$langarr[$la]['langtype']);
				}
				$parameter_post .='laninput_'.$tt.'-laninput_'.$tt.'_width_'.${'post_laninput_'.$tt.'_width'}.'-laninput_'.$tt.'_required_'.${'post_laninput_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-laninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_laninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_nolantextarea_'.$tt}=$this->input->post($id.'post_nolantextarea_'.$tt);
			if(${'post_nolantextarea_'.$tt}!=""){
				${'post_nolantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_showtype');
				${'post_nolantextarea_'.$tt.'_width'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_width');
				${'post_nolantextarea_'.$tt.'_height'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_height');
				${'post_nolantextarea_'.$tt.'_required'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_required');
				if(${'post_nolantextarea_'.$tt.'_required'}==""){
					${'post_nolantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolantextarea_'.$tt.'-nolantextarea_'.$tt.'_showtype_'.${'post_nolantextarea_'.$tt.'_showtype'}.'-nolantextarea_'.$tt.'_width_'.${'post_nolantextarea_'.$tt.'_width'}.'-nolantextarea_'.$tt.'_height_'.${'post_nolantextarea_'.$tt.'_height'}.'-nolantextarea_'.$tt.'_required_'.${'post_nolantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_lantextarea_'.$tt}=$this->input->post($id.'post_lantextarea_'.$tt);
			if(${'post_lantextarea_'.$tt}!=""){
				${'post_lantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_lantextarea_'.$tt.'_showtype');
				${'post_lantextarea_'.$tt.'_width'}=$this->input->post($id.'post_lantextarea_'.$tt.'_width');
				${'post_lantextarea_'.$tt.'_height'}=$this->input->post($id.'post_lantextarea_'.$tt.'_height');
				${'post_lantextarea_'.$tt.'_required'}=$this->input->post($id.'post_lantextarea_'.$tt.'_required');
				if(${'post_lantextarea_'.$tt.'_required'}==""){
					${'post_lantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_lantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='lantextarea_'.$tt.'-lantextarea_'.$tt.'_showtype_'.${'post_lantextarea_'.$tt.'_showtype'}.'-lantextarea_'.$tt.'_width_'.${'post_lantextarea_'.$tt.'_width'}.'-lantextarea_'.$tt.'_height_'.${'post_lantextarea_'.$tt.'_height'}.'-lantextarea_'.$tt.'_required_'.${'post_lantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-lantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_lantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		$this->ArticleModel->edit_category($id,array('parameter_list'=>$parameter_list,'parameter_post'=>$parameter_post));
		redirect('admins/setting/toedit_subcategoryparameter/'.$category_id);
		
	}
	
	
	function toedit_articleparameter($category_id=0,$subcategory_id=0){
		$data['categoryinfo']=$this->ArticleModel->getarticle_categoryinfo($category_id);
		$data['subcategoryinfo']=$this->ArticleModel->getarticle_categoryinfo($subcategory_id);
		$con=array('parent'=>0,'category_id'=>$category_id,'subcategory_id'=>$subcategory_id);
		//排序--开始
			$actionorderby=doactionorderby($data['subcategoryinfo']['parameter_list']);
			if($actionorderby['orderby']=='move'){
				$con['orderby']='sort';
				$con['orderby_res']=$actionorderby['orderby_res'];
			}else{
				$con['orderby']='category_id';
				$con['orderby_res']='DESC';
			}
		//排序--结束
		$data['articlelist']=$this->ArticleModel->getarticlelist($con);
		$this->load->view('admin/sys_parameter_article',$data);
	}
	
	function edit_articleparameter($category_id,$subcategory_id,$id){
		$langarr=languagelist();//多语言
		$parameter_list='';
		
		$sectionandname=array();//模块和名称
		$sectionandname[]=array('code'=>'name','name'=>'标题');
		$sectionandname[]=array('code'=>'add','name'=>'添加');
		$sectionandname[]=array('code'=>'edit','name'=>'修改');
		for($sn=0;$sn<count($sectionandname);$sn++){
			${'list_'.$sectionandname[$sn]['code']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code']);
			if(${'list_'.$sectionandname[$sn]['code']}!=""){
				for($la=0;$la<count($langarr);$la++){//多语言
					${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']);
				}
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$sectionandname[$sn]['code'];
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_list .='-'.$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_'.${'list_'.$sectionandname[$sn]['code'].$langarr[$la]['langtype']};
				}
			}
		}
		//图片,没有多语言的Input,有多语言的Input,没有多语言的Textarea,有多语言的Textarea, 管理
		$con=array('pic','nolaninput','laninput','nolantextarea','lantextarea','manage');
		for($a=0;$a<count($con);$a++){
			for($tt=1;$tt<=5;$tt++){
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				${'list_'.$con[$a].'_'.$tt}=$this->input->post($id.'list_'.$con[$a].'_'.$tt);
				if(${'list_'.$con[$a].'_'.$tt}!=""){
					for($la=0;$la<count($langarr);$la++){//多语言
						${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']);
					}
					if($parameter_list!=""){$parameter_list .='-';}
					$parameter_list .=$con[$a].'_'.$tt;
					for($la=0;$la<count($langarr);$la++){//多语言
						$parameter_list .='-'.$con[$a].'_'.$tt.$langarr[$la]['langtype'].'_'.${'list_'.$con[$a].'_'.$tt.$langarr[$la]['langtype']};
					}
				}
			}
		}
		//      跳到下一级    创建时间    修改时间         作者         删除    批量删除
		$con=array('next','created','edited','author','del','muldel','selection_1','selection_2','selection_3','checkboxion_1','checkboxion_2','checkboxion_3');
		for($i=0;$i<count($con);$i++){
			${'list_'.$con[$i]}=$this->input->post($id.'list_'.$con[$i]);
			if(${'list_'.$con[$i]}!=""){
				if($parameter_list!=""){$parameter_list .='-';}
				$parameter_list .=$con[$i];
			}
		}
		//排序
		$list_orderby=$this->input->post($id.'list_orderby');
		if($list_orderby!=""){
			//orderby-orderby_move-orderby_res_ASC
			$list_orderby=$this->input->post($id.'list_orderby');
			$list_orderby_res=$this->input->post($id.'list_orderby_res');
			if($parameter_list!=""){$parameter_list .='-';}
			$parameter_list .='orderby-orderby_'.$list_orderby.'-orderby_res_'.$list_orderby_res;
		}
//		print_r($parameter_list);exit;
		
		
		
		$parameter_post='';
		//名称
		$post_name=$this->input->post($id.'post_name');
		if($post_name!=""){
			$post_name_width=$this->input->post($id.'post_name_width');
			$post_name_required=$this->input->post($id.'post_name_required');
			if($post_name_required==""){
				$post_name_required=0;
			}
			for($la=0;$la<count($langarr);$la++){//多语言
				${'post_name'.$langarr[$la]['langtype']}=$this->input->post($id.'post_name'.$langarr[$la]['langtype']);
			}
			if($parameter_post!=""){$parameter_post .='-';}
			$parameter_post .='name-name_width_'.$post_name_width.'-name_required_'.$post_name_required;
			for($la=0;$la<count($langarr);$la++){//多语言
				$parameter_post .='-name'.$langarr[$la]['langtype'].'_'.${'post_name'.$langarr[$la]['langtype']};
			}
		}
		//Select 下拉
		for($tt=1;$tt<=5;$tt++){
			${'post_selection_'.$tt}=$this->input->post($id.'post_selection_'.$tt);
			if(${'post_selection_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='selection_'.$tt;
			}
		}
		//Checkbox 多选
		for($tt=1;$tt<=5;$tt++){
			${'post_checkboxion_'.$tt}=$this->input->post($id.'post_checkboxion_'.$tt);
			if(${'post_checkboxion_'.$tt}!=""){
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='checkboxion_'.$tt;
			}
		}
		//图片
		for($tt=1;$tt<=5;$tt++){
			${'post_pic_'.$tt}=$this->input->post($id.'post_pic_'.$tt);
			if(${'post_pic_'.$tt}!=""){
				${'post_pic_'.$tt.'_showtype'}=$this->input->post($id.'post_pic_'.$tt.'_showtype');
				${'post_pic_'.$tt.'_width'}=$this->input->post($id.'post_pic_'.$tt.'_width');
				${'post_pic_'.$tt.'_height'}=$this->input->post($id.'post_pic_'.$tt.'_height');
				${'post_pic_'.$tt.'_required'}=$this->input->post($id.'post_pic_'.$tt.'_required');
				if(${'post_pic_'.$tt.'_required'}==""){
					${'post_pic_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_pic_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_pic_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='pic_'.$tt.'-pic_'.$tt.'_showtype_'.${'post_pic_'.$tt.'_showtype'}.'-pic_'.$tt.'_width_'.${'post_pic_'.$tt.'_width'}.'-pic_'.$tt.'_height_'.${'post_pic_'.$tt.'_height'}.'-pic_'.$tt.'_required_'.${'post_pic_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-pic_'.$tt.$langarr[$la]['langtype'].'_'.${'post_pic_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_nolaninput_'.$tt}=$this->input->post($id.'post_nolaninput_'.$tt);
			if(${'post_nolaninput_'.$tt}!=""){
				${'post_nolaninput_'.$tt.'_width'}=$this->input->post($id.'post_nolaninput_'.$tt.'_width');
				${'post_nolaninput_'.$tt.'_required'}=$this->input->post($id.'post_nolaninput_'.$tt.'_required');
				if(${'post_nolaninput_'.$tt.'_required'}==""){
					${'post_nolaninput_'.$tt.'_required'}=0;
				}
				${'post_nolaninput_'.$tt.'_format'}=$this->input->post($id.'post_nolaninput_'.$tt.'_format');
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolaninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolaninput_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolaninput_'.$tt.'-nolaninput_'.$tt.'_width_'.${'post_nolaninput_'.$tt.'_width'}.'-nolaninput_'.$tt.'_required_'.${'post_nolaninput_'.$tt.'_required'}.'-nolaninput_'.$tt.'_format_'.${'post_nolaninput_'.$tt.'_format'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolaninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolaninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Input
		for($tt=1;$tt<=5;$tt++){
			${'post_laninput_'.$tt}=$this->input->post($id.'post_laninput_'.$tt);
			if(${'post_laninput_'.$tt}!=""){
				${'post_laninput_'.$tt.'_width'}=$this->input->post($id.'post_laninput_'.$tt.'_width');
				${'post_laninput_'.$tt.'_required'}=$this->input->post($id.'post_laninput_'.$tt.'_required');
				if(${'post_laninput_'.$tt.'_required'}==""){
					${'post_laninput_'.$tt.'_required'}=0;
				}
				if($parameter_post!=""){$parameter_post .='-';}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_laninput_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_laninput_'.$tt.$langarr[$la]['langtype']);
				}
				$parameter_post .='laninput_'.$tt.'-laninput_'.$tt.'_width_'.${'post_laninput_'.$tt.'_width'}.'-laninput_'.$tt.'_required_'.${'post_laninput_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-laninput_'.$tt.$langarr[$la]['langtype'].'_'.${'post_laninput_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//没有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_nolantextarea_'.$tt}=$this->input->post($id.'post_nolantextarea_'.$tt);
			if(${'post_nolantextarea_'.$tt}!=""){
				${'post_nolantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_showtype');
				${'post_nolantextarea_'.$tt.'_width'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_width');
				${'post_nolantextarea_'.$tt.'_height'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_height');
				${'post_nolantextarea_'.$tt.'_required'}=$this->input->post($id.'post_nolantextarea_'.$tt.'_required');
				if(${'post_nolantextarea_'.$tt.'_required'}==""){
					${'post_nolantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_nolantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='nolantextarea_'.$tt.'-nolantextarea_'.$tt.'_showtype_'.${'post_nolantextarea_'.$tt.'_showtype'}.'-nolantextarea_'.$tt.'_width_'.${'post_nolantextarea_'.$tt.'_width'}.'-nolantextarea_'.$tt.'_height_'.${'post_nolantextarea_'.$tt.'_height'}.'-nolantextarea_'.$tt.'_required_'.${'post_nolantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-nolantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_nolantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		//有多语言的Textarea
		for($tt=1;$tt<=5;$tt++){
			${'post_lantextarea_'.$tt}=$this->input->post($id.'post_lantextarea_'.$tt);
			if(${'post_lantextarea_'.$tt}!=""){
				${'post_lantextarea_'.$tt.'_showtype'}=$this->input->post($id.'post_lantextarea_'.$tt.'_showtype');
				${'post_lantextarea_'.$tt.'_width'}=$this->input->post($id.'post_lantextarea_'.$tt.'_width');
				${'post_lantextarea_'.$tt.'_height'}=$this->input->post($id.'post_lantextarea_'.$tt.'_height');
				${'post_lantextarea_'.$tt.'_required'}=$this->input->post($id.'post_lantextarea_'.$tt.'_required');
				if(${'post_lantextarea_'.$tt.'_required'}==""){
					${'post_lantextarea_'.$tt.'_required'}=0;
				}
				for($la=0;$la<count($langarr);$la++){//多语言
					${'post_lantextarea_'.$tt.$langarr[$la]['langtype']}=$this->input->post($id.'post_lantextarea_'.$tt.$langarr[$la]['langtype']);
				}
				if($parameter_post!=""){$parameter_post .='-';}
				$parameter_post .='lantextarea_'.$tt.'-lantextarea_'.$tt.'_showtype_'.${'post_lantextarea_'.$tt.'_showtype'}.'-lantextarea_'.$tt.'_width_'.${'post_lantextarea_'.$tt.'_width'}.'-lantextarea_'.$tt.'_height_'.${'post_lantextarea_'.$tt.'_height'}.'-lantextarea_'.$tt.'_required_'.${'post_lantextarea_'.$tt.'_required'};
				for($la=0;$la<count($langarr);$la++){//多语言
					$parameter_post .='-lantextarea_'.$tt.$langarr[$la]['langtype'].'_'.${'post_lantextarea_'.$tt.$langarr[$la]['langtype']};
				}
			}
		}
		$this->ArticleModel->edit_article($id,array('parameter_list'=>$parameter_list,'parameter_post'=>$parameter_post));
		redirect('admins/setting/toedit_articleparameter/'.$category_id.'/'.$subcategory_id);
		
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */