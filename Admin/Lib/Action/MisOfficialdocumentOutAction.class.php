<?php
/**
 * @Title: MisOfficialdocumentOutAction
 * @Package package_name
 * @Description: todo(公文管理-发文拟稿)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-11-14 下午2:28:16
 * @version V1.0
 */
class MisOfficialdocumentOutAction extends CommonAuditAction {
	public function _filter(&$map) {
		if ($_SESSION["a"] != 1){
			$map['status'] = 1;
		}
	}
	public function index(){
		//获取公文类型
		$MisOfficialdocumentTypeDao = M('mis_officialdocument_type');
		$typelist=$MisOfficialdocumentTypeDao->where('status = 1')->select();
		//构造公文类型结构树
		$margr[] = array(
				'id'=>0,
				'pId'=>0,
				'name'=>'公文类型',
				'title'=>'公文类型',
				'rel' => $rel,
				'target' => 'ajax',
				'icon' => "__PUBLIC__/Images/icon/order_user.png",
				'url' => "__URL__/index/jump/1",
				'open' => true
		);
		$param['url']="__URL__/index/jump/1/typeid/#id#";
		$param['rel']="MisOfficialdocumentOutindex";
			
		$ztree=$this->getTree($typelist,$param,$margr);
		$this->assign('ztree',$ztree);
		//获取当前控制器名称
		$name=$this->getActionName();
		//获取检索条件
		$map = $this->_search ($name);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			//获取公文类别ID
			$typeid=$_REQUEST['typeid']?$_REQUEST['typeid']:$typelist[0]['id'];
			$map['typeid']=$typeid;
			$_REQUEST['typeid'] = $typeid;
			$this->assign('typeid',$typeid);
			$this->_list($name,$map);
		}
			
		if($_REQUEST['jump']){
			$this->display('indexview');
		}else{
			$this->display("index");
		}
	}

	public function _before_add(){
		$typeid = $_GET['typeid'];
		//获取公司信息
		$this->getcompanyinfor();
		$this->assign('typeid',$typeid);
		if(!$typeid){
			$this->error("请选择左侧公文类型");
		}
		//实例化公文类型模型
		$MisOfficialdocumentTypeDao = M("mis_officialdocument_type");
		$map = array();
		$map['status'] = 1;
		$map['id'] = $typeid;
		$typelist=$MisOfficialdocumentTypeDao->where($map)->field("prefix,suffix,total")->find();

		$orderno = $typelist['total']+1;
		//判断获取文号前缀
		if($typelist['prefix']){
			$orderno = $typelist['prefix']."".$orderno;
		}
		if($typelist['suffix']){
			$orderno =$orderno."". $typelist['suffix'];
		}
		$this->assign('orderno',$orderno);
		$this->assign('employee',$_SESSION['user_employeid']);
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(修改当前类型下面的发文数量)
	 * @param unknown_type $id
	 * @author liminggang
	 * @date 2013-11-18 下午6:05:00
	 * @throws
	 */
	public function _after_insert($id){
		//获取公文类型
		$typeid=$_POST['typeid'];
		$MisOfficialdocumentTypeModel = D("MisOfficialdocumentType");
		$data = array();
		$num = 1;
		$data['id'] = $typeid;
		$data['total'] = array("exp","total+".$num);
		$result=$MisOfficialdocumentTypeModel->save($data);
		if(!$result){
			$this->error("修改同类型公文数量失败");
		}
		//上传附件信息
		$this->swf_upload($id,95);
	}
	public function _before_edit(){
		//获取公司信息
		$this->getcompanyinfor();
		//查询附件信息
		$this->getAttachedRecordList($_GET['id']);
	}

	public function _after_edit($vo){
		if($vo){
			//获取审核流程意见
			$MisDocumentHistoryDao = M("mis_officialdocument_process_info_history");
			$map['tablename'] = 'MisOfficialdocumentOutAudit';
			$map['tableid'] = $vo['id'];
			$historylist=$MisDocumentHistoryDao->where($map)->select();
			//查询流程节点名称
			$MisOfficialdocumentAuditorDao = M("mis_officialdocument_auditor");
			$arr = array();
			$z = 0;
			//构造一个html的审核内容
			for($i=0; $i<$vo['auditCount']; $i++){
				//1,2,3 对应流程节点ID
				$ptmptidArr=explode(",", $vo['ptmptidArr']);

				if($ptmptidArr){
					$auditor['id'] = $ptmptidArr[$i];
				}else{
					$auditor['id'] = 0;
				}
				$auditorlist=$MisOfficialdocumentAuditorDao->where($auditor)->find();
				//是否存在审核记录
				if($historylist){
					if($z != $i){
						$a = array();
						$z++;
					}
					//进行匹配
					foreach($historylist as $key=>$val){
						if($i+1 == $val['ostatus']){
							//当前的流程节点ID在数组中
							$a[] = $val;
							$size=count($a);
							$b=intval(100/$size);
							$arr[$z+1] = array(
									'id'=>$z+1,
									'bl'=>$b,
									'name'=>$val['pname'],
									'nextarr'=>$a,
							);
						}
					}
				}
			}
			array_multisort($arr,SORT_DESC); // 进行数组排序
			$this->assign('arr',$arr);
		}
	}
	public function _before_update(){
		$this->swf_upload($_POST['id'],95);
	}
	/**
	 * (non-PHPdoc)
	 * @ 流程启动
	 * @see CommonAuditAction::startprocess()
	 */
	function startprocess(){
		$modelname = $this->getActionName();
		
		//转核稿，选择第一个核稿人
		if($_POST['beforeInsert']) {
			$_POST['startprocess'] = 1;
			$module2=A($modelname);
			if (method_exists($module2,"_before_insert")) {
				//流程最后一步时入库或其他操作
				call_user_func(array(&$module2,"_before_insert"));
			}
			$module2->insert();
		}
		//判断是否为打回后重新启动流程。则清空以前的审核意见
		$auditState=$_POST['auditState'];
		if($auditState == -1){
			//打回后重新启动
			$MisDocumentHistoryDao = M("mis_officialdocument_process_info_history");
			$map['tablename'] = 'MisOfficialdocumentOutAudit';
			$map['tableid'] = $_POST['id'];
			$historyresult=$MisDocumentHistoryDao->where($map)->delete();
			if(!$historyresult){
				$this->error("删除原有的审核意见失败");
			}
		}
		//获取审核人员
		$useridArr = $_POST['useridArr'];
		
		$user=explode(",", $useridArr);
		$_POST['auditUser'] = $useridArr;
		$_POST['ptmptidArr'] = 1;
		$_POST['alreadyAuditUser'] = '';
		$_POST['noderule'] = implode(',',$noderule);
		$_POST['allnode'] = implode(',',$allnode);
		$_POST['curAuditUser'] = $useridArr;
		$_POST['auditState'] = 1;
		$_POST['auditCount'] = 1;
		$content="发文号：".$_POST['orderno']." 标题：".$_POST['title']."  承办人：".$_POST['employename']." 发文具体内容，<a rel='MisOfficialdocumentOutAuditauditEdit' target='navTab' href='__APP__/MisOfficialdocumentOutAudit/auditEdit/id/".$_POST['id']."'>请点此链接</a>";
		//推送系统消息给审核人
		$this->pushMessage($user,"系统消息，推送发文核稿消息  发文号：".$_POST['orderno'],$content);
		
		$this->update();
	}
	/**
	 * @Title: getcompanyinfor 
	 * @Description: todo(获取公司信息) 
	 * @param string $id  
	 * @author yuansl 
	 * @date 2014-6-11 下午1:54:57 
	 * @throws
	 */
	public  function getcompanyinfor($id){
		$model = D("MisSystemCompany");
		if($id){
			$COMPANY_INFOR = $model->where(" status = 1 and id = ".$id)->find();
		}else{
			$COMPANY_INFOR = $model->order("id asc")->find();
		}
		$this->assign("company_infor",$COMPANY_INFOR);
	}
}