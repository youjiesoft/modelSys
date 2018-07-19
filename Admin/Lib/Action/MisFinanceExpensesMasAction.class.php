<?php
/**
 * @Title: MisFinanceExpensesMasAction
 * @Package 财务模块-费用报销：功能类
 * @Description: TODO(费用报销的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceExpensesMasAction extends CommonAuditAction {
	/** @Title: _filter
	 * @Description: (构造检索条件) 
	 * @author  
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/
    public function _filter(&$map){
		if ($_SESSION["a"] != 1){
		    $map['status']=array("gt",-1);
		}
    }
    public function _before_add(){
    	$this->comm();
    }
 	public function _before_edit(){
    	$this->comm();
    	$this->subcomm();
    }
    public function _before_auditEdit(){
    	$this->subcomm();
    }
    public function _before_auditView(){
    	$this->subcomm();
    }
    /**
	 * @Title: comm
	 * @Description: todo(公共查询)
	 * @author 
	 * @throws
	 */
    public function comm(){
		//付款方式
		$model=M("mis_payment_method");
		$list =$model->where("status =1")->field("id,code,name")->select();
		$this->assign("paymethodlist",$list);
		
		
		
		//人员id
		$uid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign("uid",$uid);
		//查询部门
		$DepartmentModel=D("MisSystemDepartment");
		$deptlist=$DepartmentModel->field("id,name")->where("status=1")->select();
		$this->assign("deptlist",$deptlist);
		//部门id
		$deptid=getFieldBy($uid, "id", "dept_id", "user");
		$this->assign("deptid",$deptid);
		//获取报销费用类别
		$ExpensesTypeModel=D("MisFinanceExpensesType");
		$ExpensesTypeList =$ExpensesTypeModel->where("status=1")->select();
		$this->assign('TypesList',$ExpensesTypeList);
		//制单人信息
		$this->assign("time",time());
    }
    public function subcomm(){
    	//查询 sublist
    	$ExpensesSubModel=D("MisFinanceExpensesSub");
    	$sublist=$ExpensesSubModel->where("masid=".$_REQUEST['id'])->select();
    	$this->assign("sublist",$sublist);
    	//计算总额
    	$grossamount="";
    	foreach ($sublist as $k=>$v){
    		$grossamount += $v['amount'];
    	}
    	$amountDX=$this->get_amount($grossamount);
    	$this->assign("grossamount",$grossamount);
    	$this->assign("amountDX",$amountDX);
    }
    /**
     * @Title: lookupgetamount 
     * @Description: todo(Ajax 获取金额大写)   
     * @author libo 
     * @date 2014-6-25 下午4:45:11 
     * @throws
     */
    public function lookupgetamount(){
    	$amount=$this->get_amount($_REQUEST['val']);
    	echo $amount;
    }
    /**
     * @Title: _after_insert 
     * @Description: todo(新增 插入sub表明细) 
     * @param unknown_type $list  
     * @author libo 
     * @date 2014-6-25 下午5:25:12 
     * @throws
     */
    public function _after_insert($list){
    	$ExpensesSubModel=D("MisFinanceExpensesSub");
    	if($_POST['arr_nd']){
    		foreach ($_POST['arr_nd'] as $k=>$v){
    			$data['masid']=$list;
    			$data['nd']=$v;
    			$data['typeid']=$_POST['arr_typeid'][$k];
    			$data['content']=$_POST['arr_content'][$k];
    			$data['amount']=floatval(str_replace(",","",$_POST['arr_apamount'][$k]));
    			$data['createid']=$_SESSION[C('USER_AUTH_KEY')];
    			$data['createtime']=time();
    			$re=$ExpensesSubModel->add($data);
    			$ExpensesSubModel->commit();
    		}
    	}
    }
    /**
     * @Title: _after_update 
     * @Description: todo(修改 sub明细) 
     * @param unknown_type $list  
     * @author libo 
     * @date 2014-6-26 上午9:44:37 
     * @throws
     */
    public function _after_update($list){
    	$ExpensesSubModel=D("MisFinanceExpensesSub");
    	//查询是否有明细
    	$ExpensesSublist=$ExpensesSubModel->where("masid=".$_POST['id'])->select();
    	if($ExpensesSublist){
    		//删除原始明细
    		$re=$ExpensesSubModel->where("masid=".$_POST['id'])->delete();
    		if($re===false){
    			$this->error("修改详细信息失败");
    		}
    	}
    	//新增 修改后的明细
    	if($_POST['arr_nd']){
    		foreach ($_POST['arr_nd'] as $k=>$v){
    			$data['masid']=$_POST['id'];
    			$data['nd']=$v;
    			$data['typeid']=$_POST['arr_typeid'][$k];
    			$data['content']=$_POST['arr_content'][$k];
    			$data['amount']=floatval(str_replace(",","",$_POST['arr_apamount'][$k]));
    			$data['createid']=$_SESSION[C('USER_AUTH_KEY')];
    			$data['createtime']=time();
    			$re=$ExpensesSubModel->add($data);
    			$ExpensesSubModel->commit();
    		}
    	}
    }
}
?>