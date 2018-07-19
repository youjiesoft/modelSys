<?php
// Version 1.0
/**
 * @Title: MisSalesCustomerFinanceAction 
 * @Package package_name
 * @Description: todo(客户财务信息) 
 * @author laicaixia
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-2 上午9:12:59 
 * @version V1.0 
*/ 
class MisSalesCustomerFinanceAction extends CommonAction {
	/* (non-PHPdoc)列表
	 * @see CommonAction::index()
	 */
	public function index() {
		$scdmodel = D ( 'SystemConfigDetail' );
		$detailList = $scdmodel->getDetail ( "MisSalesCustomer", false );
		if ($detailList) {
			$fieldsarr = array ();
			foreach ( $detailList as $k => $v ) {
				if ($v ['models']) {
					$showname = "<a rel='" . $v ['models'] . "' target='navTab' href='__APP__/" . $v ['models'] . "/index'>" . $v ['showname'] . "</a>";
				} else {
					$showname = $v ['showname'];
				}
				$fieldsarr [$v ['name']] = $showname;
			}
			$this->assign ( 'fields', $fieldsarr );
		}
		$id = $this->escapeStr ( $_GET ['id'] );
		// 获取客户代码
		$model = D ( 'MisSalesCustomer' );
		$customer = $model->where ( "id='" . $id . "'" )->find ();
		$this->assign ( "vo", $customer );
		// 获取币种代码
		$model2 = D ( 'MisFinanceCurrency' );
		$list = $model2->where ( "status =1" )->select ();
		$this->assign ( "moneytype", $list );
		// 结算方式
		$model3 = D ( 'MisPaymentSettlemethod' );
		$list2 = $model3->where ( "status =1" )->select ();
		$this->assign ( "paytype", $list2 );
		// 付款方式
		$model3 = D ( 'MisPaymentmethod' );
		$list3 = $model3->where ( "status =1" )->select ();
		$this->assign ( "paymethod", $list3 );
		// 税金组
		$model3 = D ( 'MisTaxGroup' );
		$list4 = $model3->where ( "status =1" )->select ();
		$this->assign ( "sjtype", $list4 );
		// 开户银行
		$model4 = D ( 'MisFinanceBank' );
		$list5 = $model4->where ( "status =1" )->select ();
		$this->assign ( "bktype", $list5 );
		// 银行账户
		$model5 = D ( 'MisFinanceBankAccount' );
		$list6 = $model5->where ( "status =1" )->getField("id,code");
		$this->assign ( "bkcode", $list6 );

		$this->assign ( "id", $id );
		$this->display ();
	}
	/**
	 * @Title: lookupBank 
	 * @Description: todo(查找带回银行账户)   
	 * @author laicaixia 
	 * @date 2013-6-2 上午9:13:22 
	 * @throws 
	*/  
	public function lookupBank() {
		$cookie_bankid=Cookie::get('MisSalesCustomerFinanceedit');
		$searchby=array(
			array("id" =>"name","val"=>"按银行名称"),
			array("id" =>"sname","val"=>"按开户姓名")
		);
		$searchtype=array(
			array("id" =>"2","val"=>"模糊查找"),
			array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		$this->assign("searchbylist",$searchby);
		if(!empty($_POST['keyword'])){
			$searchtypes=	$_POST['searchtype'];
			$searchbys	= 	$_POST['searchby'];
			$keywords	=	$_POST['keyword'];
            $map[$searchbys]=$searchtypes==2 ? array('like',"%".$keywords."%"):$keywords;
	        //保留状态
	        $this->assign('keyword',$keywords);
	        $this->assign('searchby',$searchbys);
	        $this->assign('searchtype',$searchtypes);
    	}
    	/*必须先带客户的条件才能查询其他条件*/
    	if( $cookie_bankid ){
    		$map["bankid"]=array(" in ",$cookie_bankid);
    		$this->assign("bankid",$map["bankid"]);
    	}
		$name = "MisFinanceBankAccount";
		$map['status'] = 1;
		$action=A("Common");
		$action->_list ( $name, $map );
		$this->display();
	}
//	function getBankAccount(){
//		  $bankid = $this->escapeStr($_POST['bankid']);
//		  $model=D("MisFinanceBankAccount");
//		  $arr=array(array("","请选择银行账户"));
//		  $list=$model->where("bankid=".$bankid)->getField("id,code");
//		   foreach($list as $k=>$v){
//		   	    $arr2=array();
//		   	    $arr2[]=$k;
//		   	    $arr2[]=$v;
//			    array_push($arr,$arr2);
//		   }
//		  echo json_encode($arr);
//	 }
	/* (non-PHPdoc)保存
	 * @see CommonAction::update()
	 */
	public function update() {
		if (! isset ( $_POST ['usecredit'] ))
			$_POST ['usecredit'] = 0;
		$_POST ['invoicid'] = $_POST ['dwz_org_invoicid'];
		$_POST['bank']=$this->escapeChar($_POST['dwz_org_bank']);
		$model = D ( "MisSalesCustomer" );
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list = $model->save ();
		if (false !== $list) {
			$this->success ( L ( '_SUCCESS_' ) );
		} else {
			$this->error ( L ( '_ERROR_' ) );
		}
	}
	/**
	 * @Title: lookup 
	 * @Description: todo(查找带回)   
	 * @author laicaixia 
	 * @date 2013-6-2 上午9:13:42 
	 * @throws 
	*/  
	public function lookup() {
		$id = $this->escapeStr ( $_GET ['id'] );
		$map ['id'] = array (
				"neq",
				$id
		);
		if ($_POST ['name'])
			$map ['name'] = array (
					"like",
					"%" . $_POST ['name'] . "%"
			);
		if ($_POST ['typeid'])
			$map ['typeid'] = $_POST ['typeid'];
		$map ['status'] = 1;
		$name = "MisSalesCustomer";
		if (! empty ( $name )) {
			$this->_list ( $name, $map );
		}
		$model = D ( 'MisSalesCustmertype' );
		$tlist = $model->where ( "status = 1" )->findAll ();
		$this->assign ( "tlist", $tlist );
		$this->assign ( "name", $_POST ['name'] );
		$this->assign ( "id", $_POST ['id'] );
		$this->assign ( "typeid", $_POST ['typeid'] );
		$this->display ();
	}
}
?>