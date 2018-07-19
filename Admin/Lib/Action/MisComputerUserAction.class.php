<?php
class MisComputerUserAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		$searchby = $_POST["searchby"];
		$keyword=$_POST["keyword"];
		$searchtype = $_POST['searchtype'];
		$this->assign("ifhidden", 0);
		if($_POST["keyword"]){
			$this->assign("ifdatehidden", 1);
			$this->assign("ifhidden", 0);
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			$this->assign('keyword',$keyword);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchtypelist",$searchtype);
	}

	public function _before_edit(){
		$model=M("mis_system_user");
		$list =$model->field("id,manname")->select();
		$this->assign("employe_idlist",$list);
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
	}
	public function _before_add(){
		$showtpl=$_REQUEST["showtpl"];
		$this->assign("showtpl",$showtpl);

		$model=M("mis_system_user");
		$list =$model->field("id,manname")->select();
		$this->assign("employe_idlist",$list);
		
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
	}
	
	//查找用户名带回

	/**
	 * 查询员工信息
	 */
	public function lookup() {
		$searchby=array(
			array("id" =>"mis_hr_personnel_person_info-name","val"=>"按员工姓名"),
			array("id" =>"mis_hr_personnel_person_info-code","val"=>"按员工编号"),
		);
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		$this->assign("searchbylist",$searchby);
		//检索部分
		if(!empty($_POST['keyword'])){
			$searchtypes=	$_POST['searchtype'];
			$searchbys	= 	str_replace("-",".",$_POST['searchby']);
			$keywords	=	$_POST['keyword'];
			$map[$searchbys]=$searchtypes==2 ? array('like',"%".$keywords."%"):$keywords;
			//保留状态
			$this->assign('keyword',$keywords);
			$searchbys	= 	str_replace(".","-",$_POST['searchby']);
			$this->assign('searchby',$searchbys);
			$this->assign('searchtype',$searchtypes);
		}
		$map['mis_hr_personnel_person_info.status']=1;
		$this->_list('MisHrPersonnelAppraisalInfoView',$map);
		$this->display("lookup");
	}
}
?>