<?php
/**
 * @Title: MisFinanceOrgcertifMasAction.php
 * @Package 财务模块-原始凭证：功能类
 * @Description: TODO(原始凭证的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-14 09:18:54
 * @version V1.0
*/
class MisFinanceOrgcertifMasAction extends CommonAuditAction {
	/** @Title: _filter
	 * @Description: (构造检索条件) 
	 * @author  
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		/* $searchby = $_POST["searchby"];
		$keyword=$_POST["keyword"];
		$searchtype = $_POST['searchtype'];
		$this->assign('searchby',$searchby);
		$this->assign("ifhidden", 0);
		if($searchby=='handledate'){
			$this->assign("ifdatehidden", 0);
			$this->assign("ifhidden", 1);
			$datestart = $_POST['datestart'];
			$dateend = $_POST['dateend'];
			if ($datestart && !$dateend) {
				$map['handledate'] = array ('egt',strtotime($datestart));
				$this->assign('datestart', $datestart);
			} else if (!$datestart && $dateend){
				$map['handledate'] = array ('elt',strtotime($dateend));
				$this->assign('dateend', $dateend);
			} else if ($datestart && $dateend){
				$map['handledate'] = array(array ('egt',strtotime($datestart)), array ('elt',strtotime($dateend)));
				$this->assign('datestart', $datestart);
				$this->assign('dateend', $dateend);
			}
			
		}else  if($searchby=='unitname'){
			$this->assign("ifdatehidden", 1);
			$this->assign("ifhidden", 0);
			if($_POST["keyword"]){
				$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
				$this->assign('keyword',$keyword);
				$this->assign('searchtype',$searchtype);
			}
		}
		
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchtypelist",$searchtype); */
	}
	/** @Title: edit
	 * @Description: (打开修改页面函数) 
	 * @author  
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/
	function edit() {
		$name=$this->getActionName();
		$model = D ( $name );
		$id =  $_GET['id'];
		$map['id']=$id;
		if ($_SESSION["a"] != 1) $map['status']=1;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		$scdmodel = D('SystemConfigDetail');
		$modelname = $this->getActionName();
		$detailList = $scdmodel->getDetail($modelname,false);
		if ($detailList) {
			$fieldsarr = array();
			foreach ($detailList as $k => $v) {
				$showname = "";
				if($v['status'] != -1){
					$showMethods = "";
					if($v['methods']){
						$methods = explode(';', $v['methods']);// 分解所有方法
						$normArray = $sclmodel->getNormArray();// 中文解析
						$showMethods .= "<span class='xyminitooltip'><span class='xyminitooltip_con'>";
						//$showname .= "<span class='xyminitooltip'><span class='xyminitooltip_con'>";
						$isfalse = false;
						foreach ($methods as $key => $vol) {
							if ($isfalse) {
								//$showname .= " | ";
								$showMethods .= " | ";
							}
							$volarr = explode(',', $vol);// 分解target和方法
							$target = $volarr[0];// 弹出方式
							$method = $volarr[1];// 方法名称
							$modelarr = explode('/', $method);// 分解方法0：model；1：方法
							if ($_SESSION[strtolower($modelarr[0].'_'.$modelarr[1])] || $_SESSION["a"]) {
								$showMethods .= "<a rel='".$modelarr[0].$modelarr[1]."' target='".$target."' href='__APP__/".$method."' mask='true'>".$normArray[$modelarr[1]]."</a>";
								$isfalse = true;
							}
							//$showname .= "<a rel='".$modelarr[0].$modelarr[1]."' target='".$target."' href='__APP__/".$method."' mask='true'>".$normArray[$modelarr[1]]."</a>";
							$isfalse = true;
						}
						if($showMethods){
							$showMethods .= "<span class='xyminitooltip_arrow_outer'></span><span class='xyminitooltip_arrow'></span></span></span>";
						}
					}
					if($showMethods){
						$showname .= $showMethods;
					}
					if ($v['models']) {
						if ($_SESSION[strtolower($v['models'].'_index')] || $_SESSION["a"]) {
							$showname .= "<a rel='".$v['models']."' target='navTab' href='__APP__/".$v['models']."/index'>".$v['showname']."</a>";
						} else {
							$showname .= $v['showname'];
						}
					} else{
						$showname .= $v['showname'];
					}
				}
				$fieldsarr[$v['name']] = $showname;
			}
			$this->assign ( 'fields', $fieldsarr );
		}
		$subdetailList = $scdmodel->getSubDetail($modelname);
		if ($subdetailList) {
			$this->assign ( 'subdetailList', $subdetailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getSubDetail($modelname,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//判断系统授权
		//$vo=$this->process_filter($vo);
		//lookup带参数查询
		$ordermasModel=M("mis_purchase_ordermas");
		$ordermasMap['projectid']=$vo["projectid"];
		$ordermasMap['supplierid']=$vo["supplierid"];
		$porderid = $ordermasModel->where($ordermasMap)->getField("id");
		$this->assign('porderid',$porderid);
		
		$mctModel = M("mis_construction_team");
		$teamid = $mctModel->where("supplierid=".$vo["supplierid"])->getField("teamid");//teamID
		$this->assign('teamid',$teamid);
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
		if ($vo['auditState']>=1) {
			$this->display ('auditView');
		} else {
			$this->display ();
		}
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(打开修改页面后置函数)   
	 * @author  
	 * @date 2013-5-31 下午4:11:26 
	 * @throws 
	*/ 
	public function _after_edit( $vo ){
		$model=M("mis_finance_orgcertif_mas");
		$modelsub=M("mis_finance_orgcertif_sub");
		$map["con_link"]=$vo['con_link'];
		$map["status"]=array("gt",0);
		$maslist = $model->where($map)->select();
		$totalamout=0;
		$all=array();
		$i=1;
		foreach($maslist as $k=>$v ){
			$totalamout+=$v["totalamount"];
			if( isset($all[$v['subid']]) ){
				$v['keynum']=$i;
				array_push($all[$v['subid']]["sublist"],$v);
			}else{
				$all[$v['subid']]=$modelsub->find($v['subid']);
				$v['keynum']=$i;
				$all[$v['subid']]["sublist"][]=$v;
			}
			$i++;
		}
		$all=array_values($all);
		$this->assign("maslist",$all);
		$this->assign("totalamout",$totalamout);
		
		$orderno = $all[0]['ordermasorderno'];
		$colseout = M("mis_project_closeout_mas");
		$panduan = $colseout->where('orderno='.$orderno)->field('teamid','projectid')->find();
		$paiment = M("mis_project_payment_mas");
		$panduan = $paiment->where('orderno='.$orderno)->field('teamid','projectid')->find();
		$this->assign('panduan',$panduan);
		$this->common();
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开页面前置函数)
	 * @author 
	 * @throws
	 */
	public function _before_add(){
		$userid = $_SESSION[C('USER_AUTH_KEY')];
		$this->assign('userid',$userid);
		$this->common();
	}
	/**
	 * @Title: common 
	 * @Description: todo(公共调用函数)   
	 * @author  
	 * @date 2013-5-31 下午4:07:47 
	 * @throws 
	*/ 
	private function common(){
		//类型
		$model=M("mis_finance_order_types");
		$map["type"]="MisFinanceOrgcertifMas";
		$list =$model->where($map)->getField("id,name");
		$modellist =$model->where($map)->getField("id,modelname");
		$this->assign("ftypelistjson",json_encode($modellist));
		$this->assign("ftypelist",$list);
		//部门
		$model=M("mis_system_department");
		$map=array();
		$map["status"]=1;
		$deplist = $model->where($map)->getField("id,name");
		$this->assign("deplist", $deplist);
		
		//开户行
		$model2	=M("mis_finance_bank");
		$list2	=$model2->where("status=1")->getField("id,name");
		$this->assign('bktype',$list2);
	}
	/**
	 * @Title: insert 
	 * @Description: todo(插入函数)   
	 * @author  
	 * @date 2013-5-31 下午4:07:47 
	 * @throws 
	*/
	public function insert(){
		$model = D ("MisFinanceOrgcertifMas");
		$model_sub =M("mis_finance_orgcertif_sub");
		//sub
		$fnumarr=$_POST['fnumarr'];
		$ordermasidarr=$_POST['ordermasidarr'];
		$ordermasordernoarr=$_POST['ordermasordernoarr'];
		$typeid = $_POST["typeid"];
		$typeModel = M("mis_finance_order_types");
		$modelName =  $typeModel->where('id='.$typeid)->getField("modelname");
		$mastotalsubamountarr=$_POST['mastotalsubamountarr'];
		
		//mas
		$projectid = $_POST["projectid"];
		$deptid = $_POST["deptid"];
		$userid = $_POST["userid"];
		$bankaccount = $_POST["bankaccount"];
		$orderno = $_POST['orderno'];
		$bankname = $_POST["bankname"];
		
		$handledate=strtotime($_POST["handledate"]);
		$fsubnumarr=$_POST['fsubnumarr'];
		$fsubnumshowarr=$_POST['fsubnumshowarr'];
		$fsummarysubarr=$_POST['fsummarysubarr'];//摘要[科目名称]
		$fsubamountarr= $_POST['fsubamountarr'];//金额
		$accountidarr=$_POST['accountidarr'];//科目id
		$unitnamearr=$_POST['unitnamearr'];//单位名称
		
		$con_link = $model->Distinct(true)->field('con_link')->select();
		$con_link =count($con_link)+1;
		$i=1;
		foreach($fnumarr as $k => $v){
			$data=array();
			//sub_base
			$data['tableid']=$ordermasidarr[$k];
			$data['ordermasorderno']=$ordermasordernoarr[$k];
			$data['modelname']=$modelName;
			$data['typeid']=$typeid;
			$data['totalamount']=str_replace(",","",$mastotalsubamountarr[$k]);
			
			if( $data["totalamount"]<=0 ){
				$this->error("金额为0");
			}
			$insertsubid = $model_sub->add($data);
			//sub arr
			if(  $insertsubid!==false  ){
				foreach($fsubnumarr as $k2=>$v2){
					if($v2==$v){
						$masdata=array();
// 						$masdata['ostatus']=-2;
						$masdata['con_link']=$con_link;
						$masdata["fnum"] = $i;
						$masdata["subid"] = $insertsubid;
						$masdata["summary"]=$fsummarysubarr[$k2];
						$masdata["amountid"]=$accountidarr[$k2];
						$masdata["totalamount"]=str_replace(",","",$fsubamountarr[$k2]);
						$masdata["unitname"]=$unitnamearr[$k];
						
						$masdata["handledate"]=$handledate;
						$masdata["orderno"]=$orderno;
						$masdata["typeid"]=$typeid;
						$masdata["projectid"]=$projectid;
						$masdata["supplierid"]= $_POST["supplierids"];
						$masdata["deptid"] = $deptid;
						$masdata["userid"] = $userid;
						$masdata["bankaccount"] = $bankaccount;
						$masdata["bankname"] = $bankname;
						if ( $_POST['isadvance'] == 1 ){
							$masdata['isadvance'] = $_POST['isadvance'];
							$masdata['advanceunit'] = $_POST['advanceunit'];//预付款单位
							$masdata['advance'] = $_POST['advance'];//预付款金额
						}else {
							$masdata['isadvance'] = $_POST['isadvance'];
						}
						if ( $_POST['isbalance'] ==1 ){
							$masdata['isbalance'] =$_POST['isbalance'];
							$masdata['balanceid'] =$_POST['balanceid'];//冲账人
							$masdata['balamount'] =$_POST['balamount'];//冲账金额
						}else {
							$masdata['isbalance'] = $_POST['isbalance'];
						}
						$masdata['openticketunit'] = $_POST['openticketunit'];//开票单位
						$masdata['invocontent'] = $_POST['invocontent'];//发票内容
						$masdata['attachmentsum'] = $_POST['attachmentsum'];//发票张数
						$masdata['invoamount'] = $_POST['invoamount'];//发票金额
						$insertmasid = $model->add($masdata);
// 						echo $model->getLastSql();exit;
						if (!$insertmasid) {
							$this->error ( L('_ERROR_') );
						}else {//修改类型表里ModelName对应表的已经生成了支出证明的数据
							$orderTypeModel = M("mis_finance_order_types");
							if($typeid == 1 || $typeid == 2 || $typeid == 3 || $typeid == 4 || $typeid == 5){
								$modelNameType = $orderTypeModel->where('id='.$typeid)->getfield('modelname');
								$waiModel = D("$modelNameType");
								$re = $waiModel->where("id=".$data['tableid'])->setField('iforgcertif',"1");
								if(!$re) $this->error(  L("_ERROR_") );
							}
						}
						$i++;
					}
				}
			}else{
				$this->error ( L('_ERROR_') );
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
	/**
	 * @Title: update 
	 * @Description: todo(修改函数)   
	 * @author  
	 * @date 2013-5-31 下午4:07:47 
	 * @throws 
	*/
	public function update(){
		$name=$this->getActionName();
		$model = D ($name);
		$model_sub =M("mis_finance_orgcertif_sub");
		//sub
		$fnumarr=$_POST['fnumarr'];
		$ordermasidarr=$_POST['ordermasidarr'];
		$ordermasordernoarr=$_POST['ordermasordernoarr'];
		$typeid = $_POST["typeid"];
		$typeModel = M("mis_finance_order_types");
		$modelName =  $typeModel->where('id='.$typeid)->getField("modelname");
		$mastotalsubamountarr=$_POST['mastotalsubamountarr'];
		
		//mas
		$projectid = $_POST["projectid"];
		$deptid = $_POST["deptid"];
		$userid = $_POST["userid"];
		$bankaccount = $_POST["bankaccount"];
		$bankname = $_POST["bankname"];
		$orderno = $_POST['orderno'];
		$handledate=strtotime($_POST["handledate"]);
		
		$fsubnumarr=$_POST['fsubnumarr'];
		$fsubnumshowarr=$_POST['fsubnumshowarr'];
		$fsummarysubarr=$_POST['fsummaryarr'];//摘要[科目名称] 
		$fsubamountarr= $_POST['fsubamountarr'];//金额
		$accountidarr=$_POST['accountidarr'];//科目id
		$unitnamearr=$_POST['unitnamearr'];//单位名称
		
		$subidarr=$_POST["subidarr"];
		$masidarr=$_POST["masidarr"];
		$con_link =$_POST["con_link"];
// 		var_dump($_POST);exit;
		$i=1;
		foreach($fnumarr as $k => $v){
			$data=array();
			$data['tableid']=$ordermasidarr[$k];
			$data['ordermasorderno']=$ordermasordernoarr[$k];
			$data['modelname']=$modelName;
			$data['typeid']=$typeid;
			$data['totalamount']=$mastotalsubamountarr[$k];
			//save sub arr
			if( $subidarr[$k] ){
				$result= $subidarr[$k];
			}else{
				$result = $model_sub->add($data);
// 				echo $model_sub->getlastsql();exit;
			}
			//save mas arr
			if( $result ){
				foreach($fsubnumarr as $k2=>$v2){
					if($v2==$v){
						$masdata=array();
						if( $masidarr[$k2] ){
							$masdata['id']=$masidarr[$k2];
						}else{
							$masdata['con_link']=$con_link;
							$masdata["fnum"] = $i;
							$masdata["subid"] = $result;
							$masdata["amountid"]=$accountidarr[$k2];
							$masdata["totalamount"]=$fsubamountarr[$k2];
							$masdata["unitname"]=$unitnamearr[$k2];
							$masdata["typeid"]=$typeid;
						}	
						$masdata["summary"]=$fsummarysubarr[$k2];
						$masdata["orderno"]=$orderno;
						$masdata["handledate"]=$handledate;
						$masdata["projectid"]=$projectid;
						$masdata["deptid"] = $deptid;
						$masdata["userid"] = $userid;
						$masdata["bankaccount"] = $bankaccount;
						$masdata["bankname"] = $bankname;
						$masdata['isadvance'] = $_POST['isadvance'];
						$masdata['advanceunit'] = $_POST['advanceunit'];//预付款单位
						if ( $_POST['isadvance'] == 1 ){
							$masdata['isadvance'] = $_POST['isadvance'];
							$masdata['advanceunit'] = $_POST['advanceunit'];//预付款单位
							$masdata['advance'] = $_POST['advance'];//预付款金额
						}else {
							$masdata['isadvance'] = $_POST['isadvance'];
						}
						if ( $_POST['isbalance'] ==1 ){
							$masdata['isbalance'] =$_POST['isbalance'];
							$masdata['balanceid'] =$_POST['balanceid'];//冲账人
							$masdata['balamount'] =$_POST['balamount'];//冲账金额
						}else {
							$masdata['isbalance'] = $_POST['isbalance'];
						}
						
						$masdata['ptmptid'] = $_POST['ptmptid'];
						$masdata['auditstatus'] = $_POST['auditstatus'];
						$masdata['ostatus'] = $_POST['ostatus'];
						$masdata['auditUser'] = $_POST['auditUser'];
						$masdata['noderule'] = $_POST['noderule'];
						$masdata['allnode'] = $_POST['allnode'];
						$masdata['curAuditUser'] = $_POST['curAuditUser'];
						$masdata['curNodeUser'] = $_POST['curNodeUser'];
						$masdata['auditState'] = $_POST['auditState'];
						$masdata['alreadyAuditUser'] = $_POST['alreadyAuditUser'];
						
						$flowdata['ptmptid'] = $_POST['ptmptid'];
						$flowdata['auditstatus'] = $_POST['auditstatus'];
						$flowdata['ostatus'] = $_POST['ostatus'];
						$flowdata['auditUser'] = $_POST['auditUser'];
						$flowdata['noderule'] = $_POST['noderule'];
						$flowdata['allnode'] = $_POST['allnode'];
						$flowdata['curAuditUser'] = $_POST['curAuditUser'];
						$flowdata['curNodeUser'] = $_POST['curNodeUser'];
						$flowdata['auditState'] = $_POST['auditState'];
						$flowdata['alreadyAuditUser'] = $_POST['alreadyAuditUser'];
						
						$masdata['openticketunit'] = $_POST['openticketunit'];//开票单位
						$masdata['invocontent'] = $_POST['invocontent'];//发票内容
						$masdata['attachmentsum'] = $_POST['attachmentsum'];//发票张数
						$masdata['invoamount'] = $_POST['invoamount'];//发票金额
						
						
						if( $masdata['id'] ){
							$resultmas = $model->where('id='.$masdata['id'])->save($masdata);
							$con_linkOne = $model->where('id='.$masdata['id'])->getField("con_link");
							$flowRow = $model->where('con_link='.$con_linkOne)->save($flowdata);
							
						}else{
							$resultmas = $model->add($masdata);
						}
						$i++;
						if(!$resultmas){
							$this->error ( L('_ERROR_') );
						}
						if ($$flowRow){
							$this->error ( L('_ERROR_') );
						}
					}
				}
			}else{
// 				echo $model_sub->getlastsql();exit;
				$this->error ( L('_ERROR_') );
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
	/**
	 * @Title: printer 
	 * @Description: todo(查看支出证明)   
	 * @author  
	 * @date 2013-5-31 下午4:07:47 
	 * @throws 
	*/
	public function printer(){
		$id = $_GET['id'];
		$name=$this->getActionName();
		$model = D ($name);
		$record = $model->where('id='.$id)->Field("subid,handledate,projectid,bankname,bankaccount,cntamount,apamount,con_link,orderno")->find();
		$this->assign("record",$record);
		$recordList = $model->where('subid='.$record['subid'])->select();
		$this->assign("recordList",$recordList);
		$handledate=transTime($record['handledate']);
		$handledateList=explode('-',$handledate);
		$this->assign("handledateList",$handledateList);
		
		//sub表的总金额
		
		$subModel = M("mis_finance_orgcertif_sub");
		$totalamount = $subModel->where('id='.$record['subid'])->getField("totalamount");
		$totalamountArr = explode('.',$totalamount);
		$subJiaoFen = substr($totalamountArr[1],0,2);//角  分
		for ($i=0;$i<strlen($subJiaoFen);$i++){
			$subJiaoFenArr[]=substr($subJiaoFen,$i,1);
		}
		$this->assign("subJiaoFenArr",$subJiaoFenArr);
		$masMoney = (int)$totalamountArr[0];//字符转换成数组 mas表总金额的整数部分
		$masmoneystr = strval($masMoney);
		$strlen = strlen($masmoneystr);
		$arr = array(
				'7'=>'baiwan','6'=>'shiwan','5'=>'wan',
				'4'=>'qian','3'=>'bai','2'=>'shi','1'=>'ge'
		);
		for ($i=7;$i>0;$i--) {
			$a = 1;
			for($j = 1; $j<$i; $j++){
				$a*=10;
			}
			if ($strlen >= $i) {
				if($i==7){
					$yuanMoreArr[$arr[$i]] =(int)($masMoney/$a);
					switch ((int)($masMoney/$a)){
						case 0:
							$daxieArr[] = "零";
							break;
						case 1:
							$daxieArr[] = "壹";
							break;
						case 2:
							$daxieArr[] = "贰";
							break;
						case 3:
							$daxieArr[] = "叁";
							break;
						case 4:
							$daxieArr[] = "肆";
							break;
						case 5:
							$daxieArr[] = "伍";
							break;
						case 6:
							$daxieArr[] = "陆";
							break;
						case 7:
							$daxieArr[] = "柒";
							break;
						case 8:
							$daxieArr[] = "捌";
							break;
						case 9:
							$daxieArr[] = "玖";
							break;
					}
				} else {
					$yuanMoreArr[$arr[$i]] =(int)(($masMoney % ($a*10))/$a);
					switch ((int)(($masMoney % ($a*10))/$a)){
						case 0:
							$daxieArr[] = "零";
							break;
						case 1:
							$daxieArr[] = "壹";
							break;
						case 2:
							$daxieArr[] = "贰";
							break;
						case 3:
							$daxieArr[] = "叁";
							break;
						case 4:
							$daxieArr[] = "肆";
							break;
						case 5:
							$daxieArr[] = "伍";
							break;
						case 6:
							$daxieArr[] = "陆";
							break;
						case 7:
							$daxieArr[] = "柒";
							break;
						case 8:
							$daxieArr[] = "捌";
							break;
						case 9:
							$daxieArr[] = "玖";
							break;
					}
				}
			} else{
				$yuanMoreArr[$arr[$i]] = '';
				$daxieArr[] = "";
			}	
		}
		foreach ($subJiaoFenArr as $value){
			switch ($value){
				case 0:
					$daxieArr[] = "零";
					break;
				case 1:
					$daxieArr[] = "壹";
					break;
				case 2:
					$daxieArr[] = "贰";
					break;
				case 3:
					$daxieArr[] = "叁";
					break;
				case 4:
					$daxieArr[] = "肆";
					break;
				case 5:
					$daxieArr[] = "伍";
					break;
				case 6:
					$daxieArr[] = "陆";
					break;
				case 7:
					$daxieArr[] = "柒";
					break;
				case 8:
					$daxieArr[] = "捌";
					break;
				case 9:
					$daxieArr[] = "玖";
					break;
			}
		}
		$this->assign("daxieArr",$daxieArr); 
		$this->assign("yuanMoreArr1",$yuanMoreArr);
		$this->display();
	}
	/**
	 * @Title: lookupCountAmounttitle
	 * @Description: todo(lookupCountAmounttitle)   
	 * @author  
	 * @date 2013-5-31 下午4:11:26 
	 * @throws 
	*/ 
	public function lookupCountAmounttitle(){
		$type=$_POST["moduelname"];
		if($type=="MisFinanceOrgcertifMas_MisInventoryIntoMas"){
			$masid=$_POST["id"];
			//获取供应商
			$model=M("mis_inventory_into_mas");
			$orderinfo = $model->find($masid);//查找对应验收单信息
			$model=M("mis_purchase_ordermas");
			$supplierid = $model->where("id=".$orderinfo["porderid"])->getField("supplierid");
			$projectid = $model->where("id=".$orderinfo["porderid"])->getField("projectid");
			
			$MisSaleProjectModel=M("mis_sales_project");
			$projectname=$MisSaleProjectModel->where("id=".$projectid)->getField("name");
			$model=M("mis_purchase_supplier");
			$supplieridname = $model->where("id=".$supplierid)->getField("name");
			$supplieridcode = $model->where("id=".$supplierid)->getField("code"); //供应商编码
			//获取所有物料组
			$modelgroup =M("mis_product_group");
			$groulist =$modelgroup->select();
			$newgrouplist=array();
			$model = D("MisInventoryIntoSub");
			$modelamount = M("mis_finance_amount_title");
			$modelp=M("mis_product_code");
			$map["masid"]=$masid;
			//获取验证单下面所有明细
			$list = $model->where($map)->select();
			foreach( $list as $k=>$v ){
				$map=array();
				$map["id"]=$v["prodid"];
				$typeid = $modelp->where($map)->getField("typeid");
				if(isset($newgrouplist[$typeid])){
					$newgrouplist[$typeid]["totalamount"]+=$v["taxamount"];
				}else{
					$newgrouplist[$typeid]["totalamount"]   =$v["taxamount"];
					$newgrouplist[$typeid]["supplierid"]    =$supplierid;
					$newgrouplist[$typeid]["unitname"]=$supplieridname;
					$newgrouplist[$typeid]["unitcode"]=$supplieridcode;
					$newgrouplist[$typeid]["projectid"]=$projectid;
					$newgrouplist[$typeid]["projectname"]=$projectname;
					$newgrouplist[$typeid]["porderid"]=$orderinfo["porderid"];//用于前台同项目同供应商
					$newgrouplist[$typeid]["misType"]="MisFinanceOrgcertifMas_MisInventoryIntoMas";//用于前台是哪个类型
					foreach($groulist as $k2=>$v2){
						if( $v2['id']==$typeid ){
							$newgrouplist[$typeid]["accountid"]=$v2["accountid"];
							$map["id"]=$v2["accountid"];
							$newgrouplist[$typeid]["accountname"]=$modelamount->where($map)->getField("name");
							//echo $modelamount->getlastsql()."<br />";
							break;
						}
					}
				}
			}
			$re=array();
			foreach($newgrouplist as $k=>$v){
				$re[]=$v;
			}
			echo json_encode($re);
		}else if ($type=="MisFinanceOrgcertifMas_MisProjectPaymentMas"){
			$masid=$_POST["id"];
			//获取供应商
			$model=M("mis_project_payment_mas");
			$orderinfo = $model->find($masid);//查找对应验收单信息
			$MisSaleProjectModel=M("mis_sales_project");
			$projectname=$MisSaleProjectModel->where("id=".$orderinfo['projectid'])->getField("name");//projectname
			$mctModel = M("mis_construction_team");
			$supplierid = $mctModel->where("id=".$orderinfo['teamid'])->getField("supplierid");//供应商ID
			$mpsModel = M("mis_purchase_supplier");
			$supplieridname = $mpsModel->where("id=".$supplierid)->getField("name");
			$supplieridcode = $mpsModel->where("id=".$supplierid)->getField("code");
			$map["masid"]=$masid;
			$motModel = M("mis_order_types");
			$masdata['amountid'] = $motModel->where("id=".$orderinfo['typeid'])->getField("accountid");//科目ID
			$mfatModel = M("mis_finance_amount_title");
			$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
			$newgrouplist['totalamount'] = $orderinfo['avamount'];
			$newgrouplist["supplierid"]    =$supplierid;
			$newgrouplist["teamid"]    =$orderinfo['teamid'];
			$newgrouplist["supplieridcode"]    =$supplieridcode;
			$newgrouplist["projectid"]    =$orderinfo['projectid'];
			$newgrouplist["projectname"]    =$projectname;
			$newgrouplist["misType"]    ="MisFinanceOrgcertifMas_MisProjectPaymentMas";
			$newgrouplist["unitname"]=$supplieridname;//单位名称
			$newgrouplist["accountid"]=$masdata['amountid'];
			$newgrouplist["accountname"] = $masdata['summary'];
			$re[]=$newgrouplist;
			echo json_encode($re);
		}else if ($type=="MisFinanceOrgcertifMas_MisFinanceExpensesMas"){//没有特amId找不到单位名称13年5.7加了supplierid字段
			$masid=$_POST["id"];
			//获取供应商
			$model=M("mis_finance_expenses_mas");
			$orderinfo = $model->find($masid);//查找对应验收单信息
			$map["masid"]=$masid;
			$MisSaleProjectModel=M("mis_sales_project");
			$projectname=$MisSaleProjectModel->where("id=".$orderinfo['projectid'])->getField("name");//projectname
			$mpsModel = M("mis_purchase_supplier");
			$supplieridname = $mpsModel->where("id=".$orderinfo['supplierid'])->getField("name");
			$supplieridcode = $mpsModel->where("id=".$orderinfo['supplierid'])->getField("code");
			$motModel = M("mis_order_types");
			$masdata['amountid'] = $motModel->where("id=".$orderinfo['typeid'])->getField("accountid");//科目ID
			$mfatModel = M("mis_finance_amount_title");
			$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
			$newgrouplist['totalamount'] = $orderinfo['amount'];
			$newgrouplist["supplierid"]    =$orderinfo['supplierid'];
			$newgrouplist["unitname"]=$supplieridname;
			$newgrouplist["unitcode"]=$supplieridcode;
			$newgrouplist["projectid"]=$orderinfo['projectid'];
			$newgrouplist["projectname"]=$projectname;
			$newgrouplist["accountid"]=$masdata['amountid'];
			$newgrouplist["accountname"] = $masdata['summary'];
			$newgrouplist["misType"] = 'MisFinanceOrgcertifMas_MisFinanceExpensesMas';
			$re[]=$newgrouplist;
			echo json_encode($re);
		}else if ($type=="MisFinanceOrgcertifMas_MisDeliveryIntoMas"){
			$masid=$_POST["id"];
			//获取供应商
			$model=M("mis_delivery_into_mas");
			$orderinfo = $model->find($masid);//查找对应验收单信息
			$MisSaleProjectModel=M("mis_sales_project");
			$projectname=$MisSaleProjectModel->where("id=".$orderinfo['projectid'])->getField("name");//projectname
			$mpsModel = M("mis_purchase_supplier");
			$supplieridname = $mpsModel->where("id=".$orderinfo['supplierid'])->getField("name");
			$supplieridcode = $mpsModel->where("id=".$orderinfo['supplierid'])->getField("code");
			$map["masid"]=$masid;
			$motModel = M("mis_order_types");
			$masdata['amountid'] = $motModel->where("id=".$orderinfo['typeid'])->getField("accountid");//科目ID
			$mfatModel = M("mis_finance_amount_title");
			$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
			$newgrouplist['totalamount'] = $orderinfo['amount'];
			$newgrouplist["supplierid"]    =$orderinfo['supplierid'];
			$newgrouplist["unitname"]=$supplieridname;
			$newgrouplist["unitcode"]=$supplieridcode;
			$newgrouplist["projectid"]=$orderinfo['projectid'];
			$newgrouplist["projectname"]=$projectname;
			$newgrouplist["accountid"]=$masdata['amountid'];
			$newgrouplist["accountname"] = $masdata['summary'];
			$newgrouplist["misType"]    ="MisFinanceOrgcertifMas_MisDeliveryIntoMas";
			$re[]=$newgrouplist;
			echo json_encode($re);
		}else if($type=="MisFinanceOrgcertifMas_MisProjectCloseoutMas"){
			$masid=$_POST["id"];
			//获取供应商
			$model=M("mis_project_closeout_mas");
			$orderinfo = $model->find($masid);//查找对应验收单信息
			$MisSaleProjectModel=M("mis_sales_project");
			$projectname=$MisSaleProjectModel->where("id=".$orderinfo['projectid'])->getField("name");//projectname
			$mctModel = M("mis_construction_team");
			$supplierid = $mctModel->where("id=".$orderinfo['teamid'])->getField("supplierid");//供应商ID
			$mpsModel = M("mis_purchase_supplier");
			$supplieridname = $mpsModel->where("id=".$supplierid)->getField("name");
			$supplieridcode = $mpsModel->where("id=".$supplierid)->getField("code");
			$map["masid"]=$masid;
			$motModel = M("mis_order_types");
			$masdata['amountid'] = $motModel->where("id=".$orderinfo['typeid'])->getField("accountid");//科目ID
			$mfatModel = M("mis_finance_amount_title");
			$masdata['summary'] = $mfatModel->where("id=".$masdata['amountid'])->getField("name");//摘要
			$newgrouplist['totalamount'] = $orderinfo['avamount'];
			$newgrouplist["supplierid"]    =$supplierid;
			$newgrouplist["unitname"]=$supplieridname;//单位名称
			$newgrouplist["unitcode"]=$supplieridcode;
			$newgrouplist["projectid"]=$orderinfo['projectid'];
			$newgrouplist["projectname"]=$projectname;
			$newgrouplist["teamid"]=$orderinfo['teamid'];
			$newgrouplist["accountid"]=$masdata['amountid'];
			$newgrouplist["accountname"] = $masdata['summary'];
			$newgrouplist["misType"]    ="MisFinanceOrgcertifMas_MisProjectCloseoutMas";
			$re[]=$newgrouplist;
			echo json_encode($re);
		}
	}
	/**
	 * @Title: comboxGetUser
	 * @Description: todo(comboxGetUser)   
	 * @author  
	 * @date 2013-5-31 下午4:11:26 
	 * @throws 
	*/ 
	function comboxGetUser( $t="" ){
		  $model=M("user");
		  if( $t=="" ){
			$dep_id = $this->escapeStr($_POST['dep_id']);
		  }else{
			$dep_id = $t;
		  }
		  $arr=array(array("","请选择用户"));
		  if ($dep_id!='') {
			$map["dept_id"]=$dep_id;
			$userlist = $model->where($map)->getField("id,name");
			foreach($userlist as $k=>$v){
				array_push($arr,array($k, $v));
			}
		  }
		  if( $t=="" ){
			  echo json_encode($arr);
		  }else{
			   return $arr;
		  }
	}
}
?>
