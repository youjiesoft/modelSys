<?php
/**
 * @Title: MisKnowledgeManageAction 
 * @Package package_name
 * @Description: todo(知识管理的知识库的文章管理的类) 
 * @author xiafengqin 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午5:22:51 
 * @version V1.0
 */
class MisKnowledgeManageAction extends  CommonAuditAction{
	/**
	 * @Title: _filter 
	 * @Description: todo(构造检索条件) 
	 * @param unknown_type $map  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:23:47 
	 * @throws
	 */
	public function _filter(& $map) {
		$map['type']="Q";
	}

	/**
	 * @Title: _before_add 
	 * @Description: todo(新增页面的前置函数)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:24:13 
	 * @throws
	 */
// 	public function _before_add(){
// 		$model   =M("mis_knowledge_type");
// 		$catalogotypes =$model->where("status=1")->select();
// 		$selecttree=$this->selectTree($catalogotypes);
// 		$this->assign('catalogolist',$selecttree);

// 		//订单号可写
// 		$scnmodel = D('SystemConfigNumber');
//    		$orderno = $scnmodel->GetRulesNO('mis_knowledge_list');
// 		$this->assign("orderno", $orderno);
// 		$this->assign("upload_path", date("Y/m/d",time())."/".$_SESSION[C('USER_AUTH_KEY')]);
// 	}

	/**
	 * @Title: _before_add 
	 * @Description: todo(知识库文章管理--限制顶级分类下面不能有文章)   
	 * @author yuansl 
	 * @date 2014-1-24 下午12:58:28 
	 * @throws
	 */
	public function _before_add(){
		$MisKnowledgeTypeModel   =D("MisKnowledgeType");
		//得到顶级分类
		$topTypeList = $MisKnowledgeTypeModel->where("status=1 and parentid = 0")->field('id,name')->select();
		//过滤除去没有子类的顶级分类
// 		dump($topTypeList);exit;
		$lssary = array();
		foreach($topTypeList as $vat){
			$counts = $MisKnowledgeTypeModel->where("status = 1 and parentid= ".$vat['id'])->count();
			if($counts > 0){
				array_push($lssary, $vat);
			}
		}
		$this->assign('topTypeList',$lssary);
		//默认子级下拉框分类
		$topid = $lssary[0][id];
		$sontypelist = $MisKnowledgeTypeModel->where("status = 1 and parentid = ".$topid)->field('id,name')->select();
		$this->assign('sontypelist',$sontypelist);
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
   		$orderno = $scnmodel->GetRulesNO('mis_knowledge_list');
		$this->assign("orderno", $orderno);
		$this->assign("upload_path", date("Y/m/d",time())."/".$_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('time',time());
	}
	/**
	 * @Title: _befor_edit 
	 * @Description: todo(编辑前置分类,获取分类)   
	 * @author yuansl 
	 * @date 2014-2-12 下午3:32:02 
	 * @throws
	 */
	public function _before_edit(){
		$id = $_REQUEST['id'];
		//echo "文章的id"."$id";
		$MisKnowledgeTypeModel  = D("MisKnowledgeType");
		$MisKnowledgeListModel = D("MisKnowledgeList");
		$stype = $MisKnowledgeListModel->where('id = '.$id)->field("id,categoryid")->find();
		$categoryid = $stype['categoryid'];
		$this->assign('categoryid',$categoryid);//文章所属的子级分类id
		//获取顶级分类id
		$tcategory = $MisKnowledgeTypeModel->where("id = ".$categoryid)->find();
		$tcategoryid = $tcategory['parentid'];
		$this->assign('tcategoryid',$tcategoryid);
		//得到顶级分类
		$topTypeList = $MisKnowledgeTypeModel->where("status=1 and parentid = 0")->field('id,name')->select();
		//过滤除去没有子类的顶级分类
		$lssary = array();
		foreach($topTypeList as $vat){
			$counts = $MisKnowledgeTypeModel->where("status = 1 and parentid= ".$vat['id'])->count();
			if($counts > 0){
				array_push($lssary, $vat);
			}
		}
		$this->assign('topTypeList',$lssary);
// 		dump($lssary);
		//默认子级下拉框分类
		$topid = $tcategoryid;
		$sontypelist = $MisKnowledgeTypeModel->where("status = 1 and parentid = ".$topid)->field('id,name')->select();
		$this->assign('sontypelist',$sontypelist);
		$this->assign('time',time());
	}
	/**
	 * @Title: getsontypelist 
	 * @Description: todo(得到该分类下面子分类)   
	 * @author yuansl 
	 * @date 2014-1-25 下午5:06:23 
	 * @throws
	 */
   public function lookupgetsontypelist(){
   		$topid = $_REQUEST['bepart'];
   		$MisKnowledgeTypeModel = M("MisKnowledgeType");
   		$sontypelist = $MisKnowledgeTypeModel->where("status = 1 and parentid = ".$topid)->field('id,name')->select();
   		echo  json_encode($sontypelist);
   }
   
	/**
	 * @Title: _before_insert 
	 * @Description: todo(插入前置函数)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:24:39 
	 * @throws
	 */
	public function _before_insert() {
		$_POST['content'] = htmlspecialchars(stripslashes($_POST['content']));
		$this->checkifexistcodeororder('mis_knowledge_list','orderno');
		$_POST['createid'] = $_SESSION[C('USER_AUTH_KEY')];
		$_POST['auth_dutyid'] = getFieldBy($_SESSION[C('USER_AUTH_KEY')], 'id', 'duty_id', 'user');
		$_POST['auth_deptid'] = getFieldBy($_SESSION[C('USER_AUTH_KEY')], 'id', 'dept_id', 'user');
		$_POST['top_categoryid'] = getFieldBy($_POST['categoryid'], 'id', 'parentid', 'mis_knowledge_type');
		
	}
	/**
	 * @Title: _before_auditEdit 
	 * @Description: todo(打开审核页面前置函数)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:25:12 
	 * @throws
	 */
	public function _before_auditEdit(){
		$this->_after_edit();
	}
	/**
	 * @Title: _before_auditView 
	 * @Description: todo(打开审核预览前置函数)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:25:16 
	 * @throws
	 */
	public function _before_auditView(){
		$this->_after_edit();
	}
	/**
	 * @Title: _after_edit 
	 * @Description: todo(修改的后置函数) 
	 * @param unknown_type $vo  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:25:23 
	 * @throws
	 */
public function _after_edit( $vo ){
		$model   =M("mis_knowledge_type");
		$catalogotypes =$model->where("status=1")->select();
		$selecttree=$this->selectTree($catalogotypes,0,0,$vo['categoryid']);
		$this->assign('catalogolist',$selecttree);
		$map["status"]  =1;
		$map["orderid"] =$_REQUEST["id"];
		$map["type"] =33;
		$m=M("mis_attached_record");
		$attarry=$m->where($map)->select();
		$this->assign('attarry',$attarry);
		$this->assign('attcount',count($attarry));
		//dirc yuansl 
// 		$this->assign("levels", array(1=>"A级",2=>"B级",3=>"C级",4=>"D级"));
		//获取等级  
		$model = D('MisKnowledgeLevelsVisibility');
		$levels = $model->where("status = 1")->field("title,id")->select();
		$this->assign('levels',$levels);
		$this->assign("upload_path", date("Y/m/d",time())."/".$_SESSION[C('USER_AUTH_KEY')]);
	}
	/*
	 * 附件上传文件。
	 */
	/**
	 * @Title: _after_insert 
	 * @Description: todo(插入的后置函数) 
	 * @param unknown_type $insertid  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:26:14 
	 * @throws
	 */
	function _after_insert($insertid){
		$this->swf_upload($insertid,33);
	}
	/**
	 * @Title: _after_update 
	 * @Description: todo(修改的后置函数) 
	 * @param unknown_type $re  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:26:31 
	 * @throws
	 */
	function _after_update($re){
		if($re) $this->swf_upload($_POST['id'],33);
	}

}
?>