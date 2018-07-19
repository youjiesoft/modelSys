<?php
/**
 * @Title: MisFinanceOrgcertifMasAutoAction
 * @Package package_name
 * @Description: todo(支出证明[自动那块])
 * @author xiafengqin
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-3-27 下午12:05:17
 * @version V1.0
 */
class MisFinanceOrgcertifMasAutoAction extends CommonAction{
	/** @Title: _filter
	 * @Description: (构造检索条件) 
	 * @author  
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/
	public function _filter(&$map){
		if(!$_SESSION["user_knowledgedisplay"]) {
			$map['status']=array("egt",$_SESSION['user_knowledgedisplay']);
		}
		$map['status']=1;
		$map['auditState'] = 3;//待审状态为审核完毕
		$map['iforgcertif'] = 0;//
		if($typeid=$_REQUEST['typeid'] ? $_REQUEST['typeid']:2 ){
			$mf=M("mis_finance_orgcertif_mas");
		}
		$typelist = $mf->where("status=1")->getField("id,name");
		$param['url']="__URL__/index/frame/1/typeid/#id#";
		$param['rel']="orgcertifmasauto";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>-1,
				'name'=>'所有类别',
				'rel'=>'orgcertifmasauto',
				'target'=>'ajax',
				'url'=>'__URL__/index/frame/1',
				'open'=>true
		);
		$model=M("mis_finance_order_types");
		$maps["type"]="MisFinanceOrgcertifMas";
		$maps['status'] = 1;
		$list =$model->where($maps)->select();
		$typeTree = $this->getTree($list,$param,$treemiso);
		$this->assign('typeTree',$typeTree);
	}
	/** @Title: index
	 * @Description: (index) 
	 * @author  
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/
	public function index(){
		$MisInventoryIntoMasDAO = M("mis_finance_order_types");//示例化mis_finance_order_types表
		$scdmodel = D('SystemConfigDetail');
		$typeid=$_REQUEST['typeid'] ? $_REQUEST['typeid']:2;
		$this->assign("typeid",$typeid);
		if($typeid==2){//判断是验收单列表
			$name = $MisInventoryIntoMasDAO->where("id=$typeid")->getField("modelname");
		}elseif ($typeid==1){
			//判断是否费用类 单据
			$name = $MisInventoryIntoMasDAO->where("id=$typeid")->getField("modelname");
		}elseif ($typeid==3){//判断是否是运费凭证
			$name = $MisInventoryIntoMasDAO->where("id=$typeid")->getField("modelname");
		}elseif ($typeid==4){//判断是否是施工进度单
			$name = $MisInventoryIntoMasDAO->where("id=$typeid")->getField("modelname");
		}elseif ($typeid==5){//施工结算单
			$name = $MisInventoryIntoMasDAO->where("id=$typeid")->getField("modelname");
		}
		$map = $this->_search($name);
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
			$this->_list ( $name, $map );
		}
		if (! empty ( $name )) {
			$this->_list ( $name, $map );
		}
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		
		if( $_REQUEST['frame']==1){
			$this->display("index_notcat");
		}else{
			$this->display();
		}
		return;
	}
	/**
	 * @Title: inventory
	 * @Description: todo(验收单的自动生成支出证明)
	 * @author xiafengqin
	 * @date 2013-3-30 下午06:16:03
	 * @throws
	 */
	private function inventory(){
		$typeid=$_GET['typeid'];
		$idstr=$_POST['id'];//获取页面的节点ID(类型)
		$idary=explode(",",$idstr);
		//所有的数据都要查到那个表mis_finance_orgcertif_mas
		$model=M("mis_inventory_into_mas");//物料入库表
		foreach ($idary as $idval){
			//自动生成订单编号
			$scnmodel = D('SystemConfigNumber');
			$ordernoMFOM = $scnmodel->GetRulesNO('mis_finance_orgcertif_mas');
			$is=$model->where("id=".$idval)->field('iforgcertif,porderid,orderno,amount,typeid')->find();
			if ( $is['iforgcertif']==0 ){
				//到单据类型表中找到单据ID对应的单据名称
				$data['typeid']=$typeid;
				$data['ordermasorderno']  = $is['orderno'];//凭证编号
				$data['tableid'] = $idval;
				$typeModel = M("mis_finance_order_types");
				$data['modelname'] =  $typeModel->where('id='.$typeid)->getField("modelname");
				
				$model_proderid = M("mis_purchase_ordermas");
				$orderno = $model_proderid->where("id=".$is['porderid'])->getField("orderno");//关联单据
				$modelsu=M("mis_purchase_ordermas");
				$projectid  = $modelsu->where('orderno='."\"$orderno\"")->getField("projectid");//项目ID"orderno="."\"$orderno\""
				//获取供应商
				$mpoVo = $model_proderid->where("id=".$is['porderid'])->field('orderno,supplierid')->find();
				$modelsupplier = M("mis_purchase_supplier");
				$mspVo=$modelsupplier->where("id=".$mpoVo['supplierid'])->field("bankid,name")->find();
				//开户行、卡号
				$misfinancebankaccountDAO = M("mis_finance_bank_account");
				$mfbaVo = $misfinancebankaccountDAO->where("bankid=".$mspVo['bankid'])->field("code")->find();//收款方帐号
				$mdb = M('mis_finance_bank');
				$name = $mdb->where("id=".$mspVo['bankid'])->getfield("name");//开户行
				$userid = $_SESSION[C('USER_AUTH_KEY')];
				$userModel = D('User');
				$deptid = $userModel->where("id=".$userid)->getField('dept_id');
				//科目，摘要
				$motModel = M("mis_order_types");
				$amountid = $motModel->where("id=".$is['typeid'])->getField("accountid");//科目ID
				$mfatModel = M("mis_finance_amount_title");
				$summary = $mfatModel->where("id=".$amountid)->getField("name");//摘要
				//获取所有物料组
				$modelgroup =M("mis_product_group");
				$groulist =$modelgroup->select();
				$newgrouplist=array();
				$modelS = D("MisInventoryIntoSub");
				$modelamount = M("mis_finance_amount_title");
				$modelp=M("mis_product_code");
				
				$map["masid"]=$idval;
				$list = $modelS->where($map)->select();
// 				echo $modelS->getlastsql();exit;
				foreach( $list as $k=>$v ){
					$map=array();
					$map["id"]=$v["prodid"];//产品编号
					$typeMPC = $modelp->where($map)->getField("typeid");//产品组ID
					if(isset($newgrouplist[$typeMPC])){
						$newgrouplist[$typeMPC]["totalamount"]+=$v["taxamount"];//总金额+入库含税金额
					}else{
						$newgrouplist[$typeMPC]["totalamount"]   =$v["taxamount"];
						$newgrouplist[$typeMPC]["supplierid"]    =$mpoVo['supplierid'];
						$newgrouplist[$typeMPC]["unitname"]=$mspVo['name'];
						foreach($groulist as $k2=>$v2){
							if( $v2['id']==$typeMPC ){
								
								$newgrouplist[$typeMPC]["accountid"]=$v2["accountid"];
								$map["id"]=$v2["accountid"];
								$newgrouplist[$typeMPC]["accountname"]=$modelamount->where($map)->getField("name");
								break;
							}
						}
					}
				}
				$re=array();
				foreach($newgrouplist as $k=>$v){
					$re[]=$v;
				}
				//所有摘要的总金额
				foreach ($re as $va){
					$data['totalamount'] += $va['totalamount'];
				}
				$model_sub =M("mis_finance_orgcertif_sub");
				$insertsubid = $model_sub->add($data);
				if ($insertsubid !==false){
					$modelmas = M('mis_finance_orgcertif_mas');
					$con_link = $modelmas->Distinct(true)->field('con_link')->select();
					$con_link =count($con_link)+1;//获得mis_finance_orgcertif_mas表里最大的con_link+1
					$i=1;
					if ($re == false){
						$masdata['con_link']=$con_link;
						$masdata['fnum']=$i;
						$masdata['subid'] = $insertsubid;
						$masdata['handledate'] = time();
						$masdata['typeid'] = $typeid;
						$masdata['amountid'] = $amountid;
						$masdata['summary'] = $summary;
						$masdata['unitname']=$mspVo['name'];
						$masdata['bankaccount']=$mfbaVo['code'];
						$masdata['supplierid']=$mpoVo['supplierid'];
						$masdata['bankname'] = $name;
						$masdata['totalamount'] = $data['totalamount'];//总金额
						//自动生成订单编号
						$masdata['orderno'] = $ordernoMFOM;
						//userid和部门ID
						$masdata['userid'] = $_SESSION[C('USER_AUTH_KEY')];
						$userModel = D('User');
						$masdata['deptid'] = $deptid;
						$masdata['projectid'] = $projectid;//项目id
						$masdata['supplierid'] = $mpoVo['supplierid'];//项目id
						$insertmasid = $modelmas->add($masdata);
// 						echo 1111;
// 						echo $modelmas->getLastSql();exit;
						if($insertmasid===false)$this->error( L("_ERROR_"));
					}else {
						foreach ($re as $val){
							$masdata['con_link']=$con_link;
							$masdata['fnum']=$i;
							$masdata['subid']=$insertsubid;
							//自动生成订单编号
							$masdata['orderno'] = $ordernoMFOM;
							$masdata['handledate']=time();
							$masdata['typeid']=$data['typeid'];
							$masdata['unitname']=$val['unitname'];
							$masdata['summary']=$val['accountname'];
							$masdata['amountid']=$val['accountid'];
							$masdata['totalamount']=$val['totalamount'];
							$masdata['supplierid']=$mpoVo['supplierid'];
							$masdata['projectid']=$projectid;
							$masdata['deptid']=$deptid;
							$masdata['userid']=$userid;
							$masdata['bankname']=$name;
							$masdata['bankaccount']=$mfbaVo['code'];
							foreach ($masdata as $masdatakey=>$masdataval){
								if (!$masdataval){
									$this->error( L("$masdatakey".'为空,不能自动生成自出证明,请联系相关人员！'));
								}
							}
							$insertmasid = $modelmas->add($masdata);
							$i++;
// 							echo $modelmas->getlastsql();
// // 							dump($i.'------'.$insertmasid); 
							if(!$insertmasid){
								$this->error( L("_ERROR_"));
							}
						}
					} 
				}else{
					$this->error( L("_ERROR_"));
				}
				$re = $model->where("id=".$idval)->setField('iforgcertif',"1");
				if(!$re) $this->error(  L("_ERROR_") ); 
			}
		}
	}
	/**
	 * @Title: automatic
	 * @Description: todo(点击自动生成支出证明)
	 * @author xiafengqin
	 * @date 2013-3-29 上午10:36:08
	 * @throws
	 */
	public function automatic(){
		$typeid=$_GET['typeid'];
		$typeid=$_REQUEST['typeid'] ? $_REQUEST['typeid']:2;
		if ($typeid==2){
			$this->inventory();
			//第一个foreach结束
			$this->success(L('_SUCCESS_'));
		}else if ($typeid == 4){
			$this->payment();
			//第一个foreach结束
			$this->success(L('_SUCCESS_'));
		}else if ($typeid ==5){
			$this->closeout();
			//第一个foreach结束
			$this->success(L('_SUCCESS_'));
		}else if ($typeid == 1){
			$this->expenses();
			$this->success(L('_SUCCESS_'));
		}else {
			$this->delivery();
			$this->success(L('_SUCCESS_'));
		}
	}
	/**
	 * @Title: delivery 
	 * @Description: todo(运费凭证的自动生成支出证明)   
	 * @author xiafengqin 
	 * @date 2013-4-7 上午09:36:46 
	 * @throws
	 */
	private function delivery(){
		$typeid=$_GET['typeid'];
		$idstr=$_POST['id'];//获取页面的节点ID(类型)
		$idary=explode(",",$idstr);
		$model = M("mis_delivery_into_mas");
		foreach ($idary as $valid){
			$delivery = $model->where("id=".$valid)->field('iforgcertif,orderno,amount,typeid,projectid,supplierid')->find();
			if ($delivery['iforgcertif'] ==0){
				//自动生成订单编号
				$scnmodel = D('SystemConfigNumber');
				$ordernoMFOM = $scnmodel->GetRulesNO('mis_finance_orgcertif_mas');
				$data['ordermasid']=$valid;
				$data['ordermasorderno']=$delivery['orderno'];
				$data['typeid']=$typeid;
				$data['totalamount']=$delivery['amount'];
				$model_sub =M("mis_finance_orgcertif_sub");
				$insertsubid = $model_sub->add($data);
				if ($insertsubid !== false){
					$modelmas = M('mis_finance_orgcertif_mas');
					$con_link = $modelmas->Distinct(true)->field('con_link')->select();
					$masdata['con_link'] =count($con_link)+1;//获得mis_finance_orgcertif_mas表里最大的con_link+1
					$masdata['fnum'] =1;
					$masdata['subid'] = $insertsubid;
					$masdata['orderno'] = $data['ordermasorderno'];
					$masdata['handledate'] = time();
					$masdata['typeid'] = $typeid;
					$motModel = M("mis_order_types");
					$masdata['amountid'] = $motModel->where("id=".$delivery['typeid'])->getField("accountid");//科目ID
					$mfatModel = M("mis_finance_amount_title");
					$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
					$mpsModel = M("mis_purchase_supplier");
					$mpsVo = $mpsModel->where("id=".$delivery['supplierid'])->field('name,bankid')->find();//bankid和单位名称
					$masdata['unitname']=$mpsVo['name'];
					$mfbaModel = M("mis_finance_bank_account");
					$code = $mfbaModel->where("bankid=".$mpsVo['bankid'])->field('code')->find();//帐号
					$mdb = M('mis_finance_bank');
					$name = $mdb->where("id=".$mpsVo['bankid'])->getfield("name");//开户行
					$masdata['bankname'] = $name;
					$masdata['bankaccount'] = $code['code'];
					$masdata['totalamount'] = $data['totalamount'];//总金额
					//userid和部门ID
					$masdata['userid'] = $_SESSION[C('USER_AUTH_KEY')];
					$userModel = D('User');
					$masdata['deptid'] = $userModel->where("id=".$masdata['userid'])->getField('dept_id');
					$masdata['projectid'] = $delivery['projectid'];//项目id
					//自动生成订单编号
					$masdata['orderno'] = $ordernoMFOM;
					foreach ($masdata as $masdatakey=>$masdataval){
						if (!$masdataval){
							$this->error( L("$masdatakey".'为空,不能自动生成自出证明,请联系相关人员！'));
						}
					}
					$insertmasid = $modelmas->add($masdata);
					if($insertmasid===false)$this->error( L("_ERROR_"));
				}else{
					$this->error( L("_ERROR_"));
				}
				$re = $model->where("id=".$valid)->setField('iforgcertif',"1");
				if(!$re) $this->error(  L("_ERROR_") );
			}
		}
	}
	/**
	 * @Title: expenses 
	 * @Description: todo(费用类单据的自动生成支出证明)   
	 * @author xiafengqin 
	 * @date 2013-4-2 下午06:03:41 
	 * @throws
	 */
	private function expenses(){
		$typeid=$_GET['typeid'];
		$idstr=$_POST['id'];//获取页面的节点ID(类型)
		$idary=explode(",",$idstr);
		$model = M("mis_finance_expenses_mas");
		foreach($idary as $valid){
			$expenses = $model->where("id=".$valid)->field('iforgcertif,orderno,amount,typeid,projectid,supplierid')->find();
			//自动生成订单编号
			$scnmodel = D('SystemConfigNumber');
			$ordernoMFOM = $scnmodel->GetRulesNO('mis_finance_orgcertif_mas');
			if ($expenses['iforgcertif'] == 0){
				$data['ordermasid']=$valid;
				$data['ordermasorderno']=$expenses['orderno'];
				$data['typeid']=$typeid;
				$data['totalamount']=$expenses['amount'];
				$model_sub =M("mis_finance_orgcertif_sub");
				$insertsubid = $model_sub->add($data);
				if ($insertsubid !== false){
					$modelmas = M('mis_finance_orgcertif_mas');
					$con_link = $modelmas->Distinct(true)->field('con_link')->select();
					$masdata['con_link'] =count($con_link)+1;//获得mis_finance_orgcertif_mas表里最大的con_link+1
					$masdata['fnum'] =1;
					$masdata['subid'] = $insertsubid;
					$masdata['orderno'] = $data['ordermasorderno'];
					$masdata['handledate'] = time();
					$masdata['typeid'] = $typeid;
					
					$motModel = M("mis_finance_expenses_type");
					$masdata['amountid'] = $motModel->where("id=".$expenses['typeid'])->getField("accountid");//科目ID
					$mfatModel = M("mis_finance_amount_title");
					$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
					$masdata['totalamount'] = $data['totalamount'];//总金额
					//userid和部门ID
					$masdata['userid'] = $_SESSION[C('USER_AUTH_KEY')];
					$userModel = D('User');
					$masdata['deptid'] = $userModel->where("id=".$masdata['userid'])->getField('dept_id');
					$masdata['projectid'] = $expenses['projectid'];//项目id
					$masdata['supplierid'] = $expenses['supplierid'];
					$mpsModel = M("mis_purchase_supplier");
					$mpsVo = $mpsModel->where("id=".$expenses['supplierid'])->field('name,bankid')->find();//bankid和单位名称
					$masdata['unitname']=$mpsVo['name'];
					$mfbaModel = M("mis_finance_bank_account");
					$code = $mfbaModel->where("bankid=".$mpsVo['bankid'])->field('code')->find();//帐号
					$mdb = M('mis_finance_bank');
					$name = $mdb->where("id=".$mpsVo['bankid'])->getfield("name");//开户行
					$masdata['bankname'] = $name;
					$masdata['bankaccount'] = $code['code'];
					//自动生成订单编号
					$masdata['orderno'] = $ordernoMFOM;
					foreach ($masdata as $masdatakey=>$masdataval){
						if (!$masdataval){
							$this->error( L("$masdatakey".'为空,不能自动生成自出证明,请联系相关人员！'));
						}
					}
					$insertmasid = $modelmas->add($masdata);
					if($insertmasid===false)$this->error( L("_ERROR_"));
				}else {
					$this->error( L("_ERROR_"));
				}
				$re = $model->where("id=".$valid)->setField('iforgcertif',"1");
				if(!$re) $this->error(  L("_ERROR_") ); 	
			}
		}
	}
	/**
	 * @Title: closeout 
	 * @Description: todo(施工结算单的自动生成支出证明)   
	 * @author xiafengqin 
	 * @date 2013-4-2 下午04:23:36 
	 * @throws
	 */
	private function closeout(){
		$typeid=$_GET['typeid'];
		$idstr=$_POST['id'];//获取页面的节点ID(类型)
		$idary=explode(",",$idstr);
		$model = M("mis_project_closeout_mas");
		foreach ($idary as $valid){
			//自动生成订单编号
			$scnmodel = D('SystemConfigNumber');
			$ordernoMFOM = $scnmodel->GetRulesNO('mis_finance_orgcertif_mas');
			$closeout = $model->where("id=".$valid)->field('iforgcertif,orderno,avamount,projectid,typeid,teamid')->find();
			if ($closeout['iforgcertif'] == 0){
				$data['ordermasid']=$valid;
				$data['ordermasorderno']=$closeout['orderno'];
				$data['typeid']=$typeid;
				$data['totalamount']=$closeout['avamount'];
				$model_sub =M("mis_finance_orgcertif_sub");
				$insertsubid = $model_sub->add($data);
				if ($insertsubid !== false){
					$modelmas = M('mis_finance_orgcertif_mas');
					$con_link = $modelmas->Distinct(true)->field('con_link')->select();
					$masdata['con_link'] =count($con_link)+1;//获得mis_finance_orgcertif_mas表里最大的con_link+1
					$masdata['fnum'] =1;
					$masdata['subid'] = $insertsubid;
					$masdata['orderno'] = $data['ordermasorderno'];
					$masdata['handledate'] = time();
					$masdata['typeid'] = $typeid;
					$motModel = M("mis_order_types");
					$masdata['amountid'] = $motModel->where("id=".$closeout['typeid'])->getField("accountid");//科目ID
					
					$mfatModel = M("mis_finance_amount_title");
					$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
					$mctModel = M("mis_construction_team");
					$supplierid = $mctModel->where("id=".$closeout['teamid'])->getField("supplierid");//供应商ID
					$mpsModel = M("mis_purchase_supplier");
					$mpsVo = $mpsModel->where("id=".$supplierid)->field('name,bankid')->find();//单位名称
					$masdata['unitname']=$mpsVo['name'];
					$mfbaModel = M("mis_finance_bank_account");
					$mfbaVo = $mfbaModel->where("bankid=".$mpsVo['bankid'])->field('code')->find();
					
					$mdb = M('mis_finance_bank');
					$name = $mdb->where("id=".$mpsVo['bankid'])->getfield("name");//开户行
					$masdata['bankname'] = $name;//开户行
					$masdata['bankaccount'] = $mfbaVo["code"];//z帐号
					$masdata['totalamount'] = $data['totalamount'];//总金额
					$masdata['supplierid'] = $supplierid;//供应商编号
					//userid和部门ID
					$masdata['userid'] = $_SESSION[C('USER_AUTH_KEY')];
					$userModel = D('User');
					$masdata['deptid'] = $userModel->where("id=".$masdata['userid'])->getField('dept_id');
					$masdata['projectid'] = $closeout["projectid"];//项目id
					//自动生成订单编号
					$masdata['orderno'] = $ordernoMFOM;
					foreach ($masdata as $masdatakey=>$masdataval){
						if (!$masdataval){
							$this->error( L("$masdatakey".'为空,不能自动生成自出证明,请联系相关人员！'));
						}
					}
					$insertmasid = $modelmas->add($masdata);
					if($insertmasid===false)$this->error( L("_ERROR_"));
				}else {
					$this->error( L("_ERROR_"));
				}
				$re = $model->where("id=".$valid)->setField('iforgcertif',"1");
				if(!$re) $this->error(  L("_ERROR_") ); 
			}
		}
		
	}
	/**
	 * @Title: payment 
	 * @Description: todo(施工进度单的自动生成支出证明)   
	 * @author xiafengqin 
	 * @date 2013-4-1 下午4:59:03 
	 * @throws
	 */
	private function payment(){
		$typeid=$_GET['typeid'];
		$idstr=$_POST['id'];//获取页面的节点ID(类型)
		$idary=explode(",",$idstr);
		$model=M("mis_project_payment_mas");
		foreach ($idary as $valid){
			//自动生成订单编号
			$scnmodel = D('SystemConfigNumber');
			$ordernoMFOM = $scnmodel->GetRulesNO('mis_finance_orgcertif_mas');
			$is=$model->where("id=".$valid)->field('iforgcertif,orderno,avamount,typeid,projectid,teamid')->find();
				if ( $is['iforgcertif']==0 ){
				$data['ordermasid']=$valid;
				$data['ordermasorderno'] = $is['orderno'];
				$data['typeid']=$typeid;
				$data['totalamount'] = $is['avamount'];
				$model_sub =M("mis_finance_orgcertif_sub");
				$insertsubid = $model_sub->add($data);
				if ($insertsubid !== false){
					$modelmas = M('mis_finance_orgcertif_mas');
					$con_link = $modelmas->Distinct(true)->field('con_link')->select();
					$masdata['con_link'] =count($con_link)+1;//获得mis_finance_orgcertif_mas表里最大的con_link+1
					$masdata['fnum'] =1;
					$masdata['subid'] = $insertsubid;
					$masdata['orderno'] = $data['ordermasorderno'];
					$masdata['handledate'] = time();
					$masdata['typeid'] = $typeid;
					$model=M("mis_project_payment_mas");
					$motId = $model->where("id=".$valid)->getField("typeid");
					$motModel = M("mis_order_types");
					$masdata['amountid'] = $motModel->where("id=".$motId)->getField("accountid");//科目ID
					$mfatModel = M("mis_finance_amount_title");
					$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
					$mctModel = M("mis_construction_team");
					$supplierid = $mctModel->where("id=".$is['teamid'])->getField("supplierid");//供应商ID
					$mpsModel = M("mis_purchase_supplier");
					$mpsVo = $mpsModel->where("id=".$supplierid)->field('bankid,name')->find();
					$masdata['unitname'] = $mpsVo['name'];//单位名称
					$mfbaModel = M("mis_finance_bank_account");
					$mfbaVo = $mfbaModel->where("bankid=".$mpsVo['bankid'])->field('code')->find();
					
					$mdb = M('mis_finance_bank');
					$name = $mdb->where("id=".$mpsVo['bankid'])->getfield("name");//开户行
					$masdata['bankname'] = $name;//开户行
					
					$masdata['bankaccount'] = $mfbaVo["code"];//z帐号
					$masdata['totalamount'] = $data['totalamount'];//总金额
					//userid和部门ID
					$masdata['userid'] = $_SESSION[C('USER_AUTH_KEY')];
					$userModel = D('User');
					$masdata['deptid'] = $userModel->where("id=".$masdata['userid'])->getField('dept_id');
					$masdata['projectid'] = $is["projectid"];//项目id
					$masdata['supplierid'] = $supplierid;//supplierid
					//自动生成订单编号
					$masdata['orderno'] = $ordernoMFOM;
					foreach ($masdata as $masdatakey=>$masdataval){
						if (!$masdataval){
							$this->error( L("$masdatakey".'为空,不能自动生成自出证明,请联系相关人员！'));
						}
					}
					$insertmasid = $modelmas->add($masdata);
				 	if($insertmasid===false)$this->error( L("_ERROR_"));
				}else{
					$this->error( L("_ERROR_"));
				}
				$model=M("mis_project_payment_mas");
				$re = $model->where("id=".$valid)->setField('iforgcertif',"1");
				if(!$re) $this->error(  L("_ERROR_") ); 
			}
		}
	}
}