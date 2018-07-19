<?php
/**
 * @Title: MisFinanceVoucherMasAction.php
 * @Package 财务模块-凭证分录：功能类
 * @Description: TODO(凭证分录的处理)
 * @author wangcheng
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceVoucherMasAction extends CommonAction {
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
		$this->assign("ifhidden", 1);
		$this->assign("ifdatehidden", 0);
		$this->assign('keyword',$keyword);
		$this->assign('searchby',$searchby);
		$this->assign('searchtype',$searchtype);
		if($searchby=='fdate'){
			$keyword='';
			$datestart = $_POST["datestart"];
			$dateend = $_POST["dateend"];
			$map1 = $map2 = array ();
			if($datestart || $dateend){
				if ($datestart) $map1 = array (array ("egt",strtotime($datestart)));
				if ($dateend) $map2 = array (array ("elt",strtotime($dateend)));
				$map[$searchby] = array_merge($map1, $map2);
				$this->assign("datestart", $datestart);$this->assign("dateend", $dateend);
			}
		}elseif($_POST["keyword"]){
			$this->assign("ifdatehidden", 1);
			$this->assign("ifhidden", 0);
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
		}
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchtypelist",$searchtype); */
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(打开修改页面后置函数)   
	 * @author  
	 * @date 2013-5-31 下午4:11:26 
	 * @throws 
	*/ 
	public function _after_edit( $vo ){
		$model=M("mis_finance_voucher_type");
		$list =$model->field("name,name")->select();
		$this->assign("ftypelist",$list);
		$model=M("mis_finance_currency");
		$list =$model->field("id,name,code")->select();
		$this->assign("currencycodelist",$list);

		$model=M("mis_finance_voucher_mas");
		$modelsub=M("mis_finance_voucher_sub");
		$map["con_link"]=$vo['con_link'];
		$map["status"]=array("gt",0);
		$maslist = $model->where($map)->select();
		$sub=array();
		$subnum=0;
		foreach($maslist as $k=>$v ){
			$map1['masid']=$v['id'];
			$map1["status"]=array("gt",0);
			$sublist=$modelsub->where($map1)->select();
			foreach($sublist as $k2=>$v2){
				$sublist[$k2]['keynum'] = $subnum;
				$subnum++;
			}
			$maslist[$k]["vouchersub"]=$sublist;
		}
		$this->assign("maslist",$maslist);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开页面前置函数)
	 * @author 
	 * @throws
	 */
	public function _before_add(){
		$showtpl=$_REQUEST["showtpl"];
		$this->assign("showtpl",$showtpl);
		$model=M("mis_finance_voucher_type");
		$list =$model->field("name,name")->select();
		$this->assign("ftypelist",$list);
		$model=M("mis_finance_currency");
		$list =$model->field("id,name,code")->select();
		$this->assign("currencycodelist",$list);
	}
	
/**
	 * @Title: insert
	 * @Description: todo(重写CommonAction的index方法，插入)
	 * @return string
	 * @author:jiangxiong
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function insert(){
		$model = D ("MisFinanceVoucherMas");
		$model_sub =M("mis_finance_voucher_sub");
		//mas
		$fnumarr=$_POST['fnumarr'];
		$fsummaryarr=$_POST['fsummaryarr'];
		$faccountnumarr=$_POST['faccountnumarr'];
		$faccountnamearr=$_POST['faccountnamearr'];
		$fdebitarr=$_POST['fdebitarr'];
		$fcreditarr=$_POST['fcreditarr'];
		$currencycodearr=$_POST['currencycodearr'];
		$famountarr=$_POST['famountarr'];

		//sub
		$fsubnumarr=$_POST['fsubnumarr'];
		$fsummarysubarr=$_POST['fsummarysubarr'];
		$costcenternamearr=$_POST['costcenternamearr'];
		$costcentercodearr=$_POST['costcentercodearr'];
		$fsubamountarr=$_POST['fsubamountarr'];
		$con_link = $model->Distinct(true)->field('con_link')->select();
		$con_link =count($con_link)+1;
		if($con_link==1)$con_link=1;
		$c1=$c2=0;
		foreach($fdebitarr as $k => $v){
			$c1+=$v;
			$c2+=$fcreditarr[$k];
		}
		if($c1!=$c2){
			$this->error("借贷不平,请查证.");
		}
		
		$i=1;
		foreach($fnumarr as $k => $v){
			$data=array();
			$data['fnum']=$v;
			//base
			$data['con_link']=$con_link;
			$data['fdate']=$_POST["fdate"];
			$data['fyear']=$_POST['fyear'];
			$data['fperiod']=$_POST["fperiod"];
			$data['ftype']=$_POST["ftype"];

			//mas arr
			$data['fnum']=$i;
			$data['fsummary']=$fsummaryarr[$k];
			$data['faccountnum']=$faccountnumarr[$k];
			$data['faccountname']=$faccountnamearr[$k];
			$data['fdebit']=$fdebitarr[$k];
			$data['fcredit']=$fcreditarr[$k];
			$a= explode("----",$currencycodearr[$k]);
			$data['currencycode']=$a[0];
			$data['currencyname']=$a[1];
			$data['fcredit']=$fcreditarr[$k];
			$data['famount']=$famountarr[$k];
			if(C('TOKEN_NAME')) $data[C('TOKEN_NAME')]= $_POST[C('TOKEN_NAME')];
			if (false === $model->create ($data)) {
				$this->error ( $model->getError () );
			}
			$insertmasid = $model->add($data);

			//sub arr
			if( $insertmasid ){
				foreach($fsubnumarr as $k2=>$v2){
					if($v2==$v){
						$subdata=array();
						$subdata["masid"]=$insertmasid;
						$subdata["fsummary"]=$fsummarysubarr[$k2];
						$subdata["costcentername"]=$costcenternamearr[$k2];
						$subdata["costcentercode"]=$costcentercodearr[$k2];
						$subdata["famount"]=$fsubamountarr[$k2];

						if(!$subdata["fsummary"] || !$subdata["famount"] ){
							$this->error("辅助帐信息不完整");
						}
						$insertsubid = $model_sub->add($subdata);
					}
				}
			}
			$i++;
		}
		$this->success ( L('_SUCCESS_'));
	}
	
    /**
     * @Title: update
     * @Description: todo(重写CommonAction的update方法，更新)
     * @return string
     * @author yangxi
     * @date 2013-5-31 下午3:59:44
     * @throws
     */    
	public function update(){
		$model = D ("MisFinanceVoucherMas");
		$model_sub =M("mis_finance_voucher_sub");
		//mas
		$fnumarr=$_POST['fnumarr'];
		$fsummaryarr=$_POST['fsummaryarr'];
		$faccountnumarr=$_POST['faccountnumarr'];
		$faccountnamearr=$_POST['faccountnamearr'];

		$fdebitarr=$_POST['fdebitarr'];
		$fcreditarr=$_POST['fcreditarr'];
		$currencycodearr=$_POST['currencycodearr'];
		$famountarr=$_POST['famountarr'];
		$masidarr=$_POST['idarr'];
		$subidarr=$_POST['fidarr'];

		//sub
		$fsubnumarr=$_POST['fsubnumarr'];
		$fsummarysubarr=$_POST['fsummarysubarr'];
		$costcenternamearr=$_POST['costcenternamearr'];
		$costcentercodearr=$_POST['costcentercodearr'];
		$fsubamountarr=$_POST['fsubamountarr'];
		
		$c1=$c2=0;
		foreach($fdebitarr as $k => $v){
			$c1+=$v;
			$c2+=$fcreditarr[$k];
		}
		if($c1!=$c2){
			$this->error("借贷不平,请查证.");
		}
		
		$i=1;
		foreach($fnumarr as $k => $v){
			$data=array();
			$data['fnum']=$v;
			//base
			$data['fdate']=$_POST["fdate"];
			$data['fyear']=$_POST['fyear'];
			$data['fperiod']=$_POST["fperiod"];
			$data['ftype']=$_POST["ftype"];
			$data['con_link']=$_POST['con_link'];

			//mas arr
			if( $masidarr[$k] ){
				$data['id']= $masidarr[$k];
			}
			$data['fnum']=$i;
			$data['fsummary']=$fsummaryarr[$k];
			$data['faccountnum']=$faccountnumarr[$k];
			$data['faccountname']=$faccountnamearr[$k];
			$data['fdebit']=$fdebitarr[$k];
			$data['fcredit']=$fcreditarr[$k];
			$a= explode("----",$currencycodearr[$k]);
			$data['currencycode']=$a[0];
			$data['currencyname']=$a[1];
			$data['fcredit']=$fcreditarr[$k];
			$data['famount']=$famountarr[$k];
			if(C('TOKEN_NAME')) $data[C('TOKEN_NAME')]= $_POST[C('TOKEN_NAME')];
			if (false === $model->create ($data)) {
				$this->error ( $model->getError () );
			}
			if( $data['id'] ){
				$result = $model->save($data);
			}else{
				$result = $model->add($data);
			}

			//sub arr
			if( $result ){
				foreach($fsubnumarr as $k2=>$v2){
					if($v2==$v){
						$subdata=array();
						if( $subidarr[$k2] ){
							$subdata['id']= $subidarr[$k2];
						}
						if($data['id']){
							$subdata["masid"]=$data['id'];
						}else{
							$subdata["masid"]=$result;
						}

						$subdata["fsummary"]=$fsummarysubarr[$k2];
						$subdata["costcentername"]=$costcenternamearr[$k2];
						$subdata["costcentercode"]=$costcentercodearr[$k2];
						$subdata["famount"]=$fsubamountarr[$k2];
						if(!$subdata["fsummary"] || !$subdata["famount"] ){
							$this->error("辅助帐信息不完整");
						}

						if( $subdata['id'] ){
							$resultsub = $model_sub->save($subdata);
						}else{
							$resultsub = $model_sub->add($subdata);
						}
					}
				}
			}
			$i++;
		}
		$this->success ( L('_SUCCESS_'));
	}
	/**
	 * @Title: lookupSuggest
	 * @Description: todo(查找会计科目)
	 * @author 
	 * @throws
	 */
	public function lookupSuggest(){
		$model = M('mis_finance_amount_title');
		$map=array();
		if($_POST["inputValue"]) $map['name']=array('exp',"like '%".$_POST['inputValue']."%' or code like '%".$_POST['inputValue']."%'");
		$list = $model->where($map)->limit("0,20")->select();
		 header("Content-Type:text/html; charset=utf-8");
		 foreach($list as $k=>$v){
			$list[$k]["namearr"]=$v["name"];
		 }
		 exit(json_encode($list));
	}
}
?>