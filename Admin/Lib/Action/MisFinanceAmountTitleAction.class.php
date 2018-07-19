<?php
/**
 * @Title: MisFinanceAmountTitleAction
 * @Package 财务配置-会计科目信息：功能类
 * @Description: TODO(会计科目的记录及维护)
 * @author wangcheng
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceAmountTitleAction extends CommonAction {
	//私有变量，初始化会计科目分类
	private $typelist = array("资产","负债","所有者权益","成本","损益");
	/**
	 * @Title: _filter
	 * @Description: todo(重写CommonAction的_filter方法，传递过滤参数后返回列表页面)
	 * @return string
	 * @author 王成
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		if ( !isset ( $_REQUEST ['orderDirection'] )) {
			$_REQUEST ['orderDirection']="asc";
		}
	}

	/**
	 * @Title: getFinanceAmountTitleTree
	 * @Description: todo(生成左边树结构)
	 * @return json
	 * @author 王成
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	private function getFinanceAmountTitleTree(){
		$model = M('mis_finance_amount_title');
		$list = $model->where("status=1")->order("id asc")->select();
		
		$typelist = $this->typelist;
		$treemiso[]=array('id'=>0,'pId'=>-1,'name'=>'科目类别','url'=>'__URL__/index/jump/1','target'=>'ajax','open'=>true,'rel'=>"misfinaceamounttitle_right_content");
		foreach($typelist as $k=>$v ){
			$a=array();
			$a['id']=$k+10000000000;
			$a['pId']=0;
			$a['name']=$v;
			$a['target']='ajax';
			$a['title']=$v;
			$a['type']="post";
			$a['rel']="misfinaceamounttitle_right_content";
			$a['url']= '__URL__/index/jump/1/atype/'.$a['name'];
			$a['open']='false';
			$a['icon']="__PUBLIC__/Images/icon/folder_s.png";
			array_push($treemiso,$a);
			foreach( $list as $k2=>$v2 ){
				if($v2['atype']==$v){
					$b=array();
					$b['id']=$v2['id'];
					if( $v2['parentid'] ){
						$b['pId']=$v2['parentid'];
					}else{
						$b['pId']=$a['id'];
					}
					$b['name']= missubstr($v2['name'],20,true);
					$b['title']=$v2['name'];
					$b['target']="ajax";
					$b['type']="post";
					$b['rel']="misfinaceamounttitle_right_content";
					$b['url']= '__URL__/index/jump/1/id/'.$v2['id'].'/pid/'.$v2['id'];
					$b['open']='false';
					$a['icon']="__PUBLIC__/Images/icon/folder_s_n.png";
					array_push($treemiso,$b);
				}
			}
		}
		$typeTree = json_encode($treemiso);
		$this->assign('amounttitletree',$typeTree);
	}

	/**
	 * @Title: index
	 * @Description: todo(重写CommonAction的index方法，展示列表)
	 * @return string
	 * @author 王成
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function index(){
		$map=$this->_search();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$atype=$_REQUEST['atype'];
		$id=$_REQUEST['id'];
		$pid=$_REQUEST['pid'];
		
		if($_REQUEST['atype']){
			$map['atype'] = $atype;
			$this->assign('atype',$atype);
		}
		if($id && isset($pid)){
			//根据ID或者父节点查询数据。
			$where['id'] = $id;
			$where['parentid'] = $pid;
			$where['_logic'] = "or";
			$map['_complex']=$where;
			$this->assign('id',$id);
			$this->assign('pid',$pid);
		}
		$this->getFinanceAmountTitleTree();
		$name = $this->getActionName();
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
		
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//searchby搜索扩展
		$searchby = $scdmodel->getDetail($name,true,'searchby');
		if ($searchby && $detailList) {
			$searchbylist=array();
			foreach( $detailList as $k=>$v ){
				if(isset($searchby[$v['name']])){
					$arr['id']= $searchby[$v['name']]['field'];
					$arr['val']= $v['showname'];
					array_push($searchbylist,$arr);
				}
			}
			$this->assign("searchbylist",$searchbylist);
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		if( $_REQUEST['jump']==1){
			$this->display("unitlist");
		}else{
			$this->display();
		}
	}

	/**
	 * @Title: _before_insert
	 * @Description: todo(插入方法insert前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_insert(){
		//借方
		if($_POST['debit']){
			$_POST['debit']=1;
		}else{
			$_POST['debit']=0;
		}
		//贷方
		if($_POST['credit']){
			$_POST['credit']=1;
		}else{
			$_POST['credit']=0;
		}
		if($_POST['code']){
			$code= explode(".",$_POST['code']);
			if( count($code)>1 ){
				$_POST['levels']=count($code);
				$model=M("mis_finance_amount_title");
				array_pop($code);
				$map['code'] = implode(".",$code);
				$pid = M("mis_finance_amount_title")->where($map)->getField("id");
				if(!$pid){
					$this->error("父级科目不存在,请重新输入");
				}
				$_POST['parentid']=$pid;
			}
		}
	}

	/**
	 * @Title: _before_update
	 * @Description: todo(更新方法update前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_update(){
		//借方
		if($_POST['debit']){
			$_POST['debit']=1;
		}else{
			$_POST['debit']=0;
		}
		//贷方
		if($_POST['credit']){
			$_POST['credit']=1;
		}else{
			$_POST['credit']=0;
		}
		if($_POST['code']!=$_POST['oldcode']){
			$code= explode(".",$_POST['code']);
			if( count($code)>1 ){
				$_POST['levels']=count($code);
				$model=M("mis_finance_amount_title");
				array_pop($code);
				$map['code'] = implode(".",$code);
				$pid = M("mis_finance_amount_title")->where($map)->getField("id");
				if(!$pid){
					$this->error("父级科目不存在,请重新输入");
				}
				$_POST['parentid']=$pid;
			}
		}
	}
	
	/**
	 * @Title: lookupproject
	 * @Description: todo(弹出选择项目窗口)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function lookupproject(){
		$keyword=$_REQUEST['keyword'];
		$searchtype=$_POST['searchtype'];
		$searchby=$_POST['searchby'];
		if($keyword){
			$map[$searchby]=($searchtype==2) ? array('like',"%".$keyword."%"):$keyword;
			$this->assign("keyword",$keyword);
			$this->assign("searchtype",$searchtype);
			$this->assign("searchby",$searchby);
		}
		$searchby=array(array("id" =>"code","val"=>"项目编码"),array("id" =>"name","val"=>"项目名称"));
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign('searchbylist',$searchby);
		$this->assign('searchtypelist',$searchtype);
		$action=A("Common");
		$name ="MisSalesProject";
		$map["status"] = 1;
		$action->_list ( $name, $map );
		$this->display ();
	}
}
?>