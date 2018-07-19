<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(selectlist配置文件维护) 
 * @author libo 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-28 下午1:47:28 
 * @version V1.0
 */
class CheckForObjAction extends CommonAction{
	/**
	 * 查找动态配置组里边可用的节点
	 */
	private $firstDetail = array();
	
	public function abcd(){
		$model=D('CheckForObj');
		$selectlist = require $model->GetFile();
		$model->startTrans();
		foreach($selectlist as $key=>$val){
			$val['id'] = $key;
			$val['fields'] = str_replace("&#39;", "'",html_entity_decode($val['fields']));
			$val['fields_arr'] = implode(",", $val['fields_arr']);
			$val['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$val['createtime'] = time();
			$model->add($val);
		}
		$model->addAll($selectlist);
// 		echo $model->getlastSql();
// 		echo 11;
		//提交事务
		$model->commit();
		$this->success("xx");
	}
	
	/**
	 * (non-PHPdoc)
	 * @Description: todo(首页输出模板方法)
	 * @see CommonAction::index()
	*/
	public function index() {		
		$map = $this->_search ();
		if (isset ($_SESSION[C('USER_AUTH_KEY')])) {
			//初始化生成左边树，默认打开节点，跳转不再刷新树
			$model = D('SystemConfigDetail');			
 			if($_REQUEST['jump']){
				$modelName = $_REQUEST['model'];				
			}else{
		       $models = D('SystemConfigNumber');
		       $returnarr = $models->getRoleTree('CheckForObjBox');//左边树
		       $firstDetail = $models->firstDetail;
		       $this->assign('returnarr',$returnarr);  
		       if($_REQUEST['model']){
		       	$check = getFieldBy($_REQUEST['model'], 'name', 'id', 'node');
		       	$this->assign('check',$check);
		       	$modelName = $_REQUEST['model'];
		       }else{
		       	$this->assign('check',$firstDetail['check']);
		        $modelName = $firstDetail['name'];
		       }		       
			}
			//查询配置文件
			$sublist = $model->getSubDetail($modelName,false);
			if ($sublist) {
				$this->assign('sublist', $sublist);
			}
			$detailList = $model->getDetail($this->getActionName(),false);
			$model2=D('CheckForObj');
			if(file_exists($model2->GetFile())){
				$selectlist = require $model2->GetFile();
			}
			$newselectlist = array();
			foreach ($selectlist as $k=>$v){
				if($selectlist[$k]['model']==$modelName){
					$newselectlist[$k]['title']=$v['title'];
					$newselectlist[$k]['fields']=implode(',',$this->getShownameByDetail($modelName,$v['fields_arr']));	
					$newselectlist[$k]['show_fields']=implode(',',$this->getShownameByDetail($modelName,$v['show_fields']));
					$newselectlist[$k]['hidden_field']=implode(',',$this->getShownameByDetail($modelName,$v['hidden_field']));
					$newselectlist[$k]['filter_condition']=base64_decode($v['showrules']);
					$strarr = array();
					$strarr = explode(' ',$v['sort_condition']);
					$newselectlist[$k]['sort_condition']=$strarr?implode(',',$this->getShownameByDetail($modelName,$strarr[0])):'';
					$newselectlist[$k]['status']=$v['status'];
				}
			}
			$list=array();
			$searchField = array();
			
			
			if($map['_complex']){
				// 做全检索
				$searchField = array_keys($map['_complex']);
				array_pop($searchField);
				$searchWord = $_POST['qkeysword'];
			}else{
				// 做指定字段的检索
				$searchField = array_keys($map);
				$keyname = 'quick'.end(explode('.',$searchField[0]));
				$searchWord = $_POST["$keyname"];
			}
			foreach($searchField as $k=>$v){
				$searchField[$k] = end(explode('.',$v));
			}
			$arr=array();			
			if($searchField){
				foreach($newselectlist as $key=>$val){
					foreach($searchField as $k=>$v){
						if(strpos($val[$v] , $searchWord) !== false ){
							$arr[][$key]=$selectlist[$key];
						}
					}
				}
			}else{
				foreach($newselectlist as $key=>$val){
					$arr[][$key] = $val;
				}
			}	
			//dump($arr);
			$this->assign("detailList",$detailList);
			$this->assign('model', $modelName);
			//分页getPager
			$SelectlistAction=A("Selectlist");
			if($_POST['pageNum']){
				$pageNum=$_POST['pageNum'];
			}else{
				$pageNum=1;
			}
			$SelectlistAction->getPager($arr,$pageNum,C("PAGE_LISTROWS"));			
			if ($_REQUEST['jump']){				
				$this->display("indexview");
			}else{
				$this->display();
			}
		}
	}
	/**
	 * (non-PHPdoc)新增类型
	 * @see CommonAction::insert()
	 */
	public function insert() {
		if(empty($_POST['fields'])){
			$this->error("选择列表显示字段不能为空");
		}
		if(empty($_POST['show_fields'])||!in_array($_POST['show_fields'],$_POST['fields'])){
			$this->error("显示字段必需存在 <br/>   &nbsp; &nbsp;选择列表显示字段必须包含有显示字段");
		}
		if(empty($_POST['hidden_field'])||!in_array($_POST['hidden_field'],$_POST['fields'])||!in_array($_POST['hidden_field'],array('id','orderno'))){
			$this->error("隐藏字段必需存在 <br/>   &nbsp; &nbsp;选择列表显示字段必须包含有隐藏字段<br/>   &nbsp; &nbsp;隐藏字段只能为id或者orderno");
		}
		//实例化系统checkfor表
		$MisSystemCheckForObjDao = D("CheckForObj");
		//验证title是否重复
		$title = $_POST['title'];
		$where['title'] = array('eq',$title);
		$vo = $MisSystemCheckForObjDao->where($where)->find();
		if($vo){
			$this->error("输入的标题存在重复，请重新输入！");
		}else{
			if(empty($_POST['show_fields'])) $this->error('显示字段不能为空！');
			//获取模型对应的数据库表
			//$modelquery=D($_POST['model']);
			//$trueTable = $modelquery->getTableName();
			//列表显示字段
			$fields = $_POST['fields'];
			$show_fields = "";
			$show_fields_china = "";
			$list = array();
			if($fields){
				$list2 = array();
				foreach($fields as $key=>$val){
// 					if($val == 'id'){
// 						continue;
// 					}
					$showname = $_POST['showname'][$key]; 
					if($_POST['show_fields'][$key]){
						$show_fields = $_POST['show_fields'];
						$show_fields_china =  $_POST['showname'][$key]; 
					}
					$list2[$key] = "'".$val."'=>'".$showname."'";
				}
				$list=$list2;
				//$list = array_merge($list2,array("'id'=>'0'"));
			}
			$list=implode(',',$list);
			//拼装数据库数据
			$data=array(
					'id'=>md5($_SESSION[C('USER_AUTH_KEY')].time()),
					'title'=>$title,
					'model'=>$_POST['model'],
					'fields'=>$list,
					'fields_arr'=>implode(",",$fields),
					'query_table' =>$_POST['model'],
					'show_fields'=>$show_fields,
					'show_fields_china'=>$show_fields_china,
					'hidden_field' => $_POST['hidden_field'],
					'filter_condition'=> $_POST['rules'],
					'sort_condition'=> $_POST['sort_condition']?$_POST['sort_condition'].' asc':'',
					'showrules'=>$_POST['showrules'],
					'rules'=>$_POST['rules'],
					'rulesinfo'=>$_POST['rulesinfo'],
					'status'=>1,
					'createid'=>$_SESSION[C('USER_AUTH_KEY')] ,
					'createtime'=>time(),
			);
			$result = $MisSystemCheckForObjDao->add($data);
			
			if($result){
				$where = array();
				$where['status'] = 1;
				$checkobjlist = $MisSystemCheckForObjDao->where($where)->select();
				//拼装checkforobj.inc.php文件内容
				$arr_data = array();
				foreach ($checkobjlist as $key=>$val){
					$arr_data[$val['id']]=array(
							'title'=>$val['title'],
							'model'=>$val['model'],
							'fields'=>str_replace("'", "&#39;",$val['fields']),
							'fields_arr'=>explode(",",$val['fields_arr']),
							'query_table' =>$val['query_table'],//$_POST['model'],
							'show_fields'=>$val['show_fields'],
							'hidden_field' =>$val['hidden_field'],
							'filter_condition'=> $val['filter_condition'],
							'sort_condition'=> $val['sort_condition'],
							'showrules'=>$val['showrules'],
							'rules'=>$val['rules'],
							'rulesinfo'=>$val['rulesinfo'],
							'status'=>1,
					);
				}
				$model=D('CheckForObj');
				$model->SetRules($arr_data);
				$this->success("数据保存成功");
			}else{
				$this->error("数据存储失败，请联系管理员");
			}
		}
	}
	/**
	 * (non-PHPdoc)编辑
	 * @see CommonAction::edit()
	 */
	public function edit(){
		if (isset ( $_SESSION [C ( 'USER_AUTH_KEY' )] )) {
			$model1 = D ( 'CheckForObj' );
			if (file_exists ( $model1->GetFile () )) {
				$selectlist = require $model1->GetFile ();
			}
			$vo = $selectlist [$_REQUEST ['id']];
			$a = array ();
			if ($vo ['sort_condition'])
				$a = explode ( ' ', $vo ['sort_condition'] );
			$vo ['sort_condition'] = $a [0];
			$vo ['fields'] = $vo ['fields_arr'];
			$this->assign ( 'vo', $vo );
			$this->assign ( 'id', $_REQUEST ['id'] );
			$modelName = $_REQUEST ['modelname'];
			$model = D ( 'SystemConfigDetail' );
			$list = $model->getDetail ( $modelName, false );
			$this->assign ( 'list', $list );
			$this->assign ( 'model', $vo ['model'] );
			// 加左边树
			$this->display ();
		}
	}
	
	function add(){
		if (isset ( $_SESSION [C ( 'USER_AUTH_KEY' )] )) {
			$modelName = $_GET ['modelname'];
			// 需过滤的model
			$model = D ( 'SystemConfigDetail' );
			//$filter = $model->getDCFilter ();
			$list = $model->getDetail ( $modelName ,false);
			//$name = $model->getTitleName ( $modelName );
			$sublist = $model->getSubDetail ( $modelName, false );
			if ($sublist) {
				$this->assign ( 'sublist', $sublist );
			}
			//$detailList = $model->getDetail ( $this->getActionName () );
			//$this->assign ( "detailList", $detailList );
			$this->assign ( 'model', $modelName );
			//$this->assign ( 'name', $name );
			$this->assign ( 'list', $list );
			$this->display ( "addview" );
		}
	}
	public function update(){
		if(empty($_POST['fields'])){
			$this->error("选择列表显示字段不能为空");
		}
		if(empty($_POST['show_fields'])||!in_array($_POST['show_fields'],$_POST['fields'])){
			$this->error("显示字段必需存在 <br/>  &nbsp; &nbsp;选择列表显示字段必须包含有显示字段");
		}
		if(empty($_POST['hidden_field'])||!in_array($_POST['hidden_field'],$_POST['fields'])||!in_array($_POST['hidden_field'],array('id','orderno'))){
			$this->error("隐藏字段必需存在 <br/>   &nbsp; &nbsp;选择列表显示字段必须包含有隐藏字段<br/>   &nbsp; &nbsp;隐藏字段只能为id或者orderno");
		}
		//实例化系统checkfor表
		$MisSystemCheckForOjbDao = M("mis_system_checkforobj");
		//验证title是否重复
		$arr_key = $_POST['id'];
		$title = $_POST['title'];
		$oldtitle = $_POST['oldtitle'];
		$bool = false;
		if($oldtitle != $title){
			$where['title'] = array('eq',$title);
			$bool = $MisSystemCheckForOjbDao->where($where)->count();
		}
		if($vo){
			$this->error("输入的标题存在重复，请重新输入！");
		}else{
			if(empty($_POST['show_fields'])) $this->error('显示字段不能为空！');
			//获取模型对应的数据库表
			//$modelquery=D($_POST['model']);
			//$trueTable = $modelquery->getTableName();
			//列表显示字段
			$fields = $_POST['fields'];
			$show_fields = "";
			$show_fields_china = "";
			$list = array();
			if($fields){
				$list2 = array();
				foreach($fields as $key=>$val){
// 					if($val == 'id'){
// 						continue;
// 					}
					$showname = $_POST['showname'][$key];
					if($_POST['show_fields'][$key]){
						$show_fields = $_POST['show_fields'];
						$show_fields_china =  $_POST['showname'][$key];
					}
					$list2[$key] = "'".$val."'=>'".$showname."'";
				}
				$list = $list2;
				//$list = array_merge($list2,array("'id'=>'0'"));
			}
			$list=implode(',',$list);
			//拼装插入数据的数据
			$data=array(
					'title'=>$title,
					'model'=>$_POST['model'],
					'fields'=>$list,
					'fields_arr'=>implode(",",$fields),
					'query_table' =>$_POST['model'],//$trueTable,//$_POST['model'],
					'show_fields'=>$show_fields,
					'show_fields_china'=>$show_fields_china,
					'hidden_field' => $_POST['hidden_field'],
					'filter_condition'=> $_POST['rules'],
					'sort_condition'=> $_POST['sort_condition']?$_POST['sort_condition'].' asc':'',
					'showrules'=>$_POST['showrules'],
					'rules'=>$_POST['rules'],
					'rulesinfo'=>$_POST['rulesinfo'],
					'status'=>1,
					'updateid'=>$_SESSION[C('USER_AUTH_KEY')] ,
					'updatetime'=>time(),
			);
			$where = array();
			$where['id'] = array('eq',$arr_key);
			$result = $MisSystemCheckForOjbDao->where($where)->save($data);
			
			if($result===false){
				$this->error("数据存储失败，请联系管理员");
			}else{
				$where = array();
				$where['status'] = 1;
				$checkobjlist = $MisSystemCheckForOjbDao->where($where)->select();
				//重新拼装配置文件checkforobj.inc.php
				$arr_data = array();
				foreach ($checkobjlist as $key=>$val){
					$arr_data[$val['id']]=array(
							'title'=>$val['title'],
							'model'=>$val['model'],
							'fields'=>str_replace("'", "&#39;",$val['fields']),
							'fields_arr'=>explode(",",$val['fields_arr']),
							'query_table' =>$val['query_table'],//$_POST['model'],
							'show_fields'=>$val['show_fields'],
							'hidden_field' =>$val['hidden_field'],
							'filter_condition'=> $val['filter_condition'],
							'sort_condition'=> $val['sort_condition'],
							'showrules'=>$val['showrules'],
							'rules'=>$val['rules'],
							'rulesinfo'=>$val['rulesinfo'],
							'status'=>1,
					);
				}
				$model=D('CheckForObj');
				$model->SetRules($arr_data);
				$this->success("数据保存成功");				
			}
		}
	}
 
	/**
	 * @Title: notice
	 * @Description: todo(根据配置文件的一个字段找另一个字段) 假想为根据name找showname
	 * @param $model string 模型名称（=配置文件夹名称）
	 * @param $name 源字段（根据此字段查找） 假想为逗号分隔的字符串类型或一维数组类型
	 * @param $showname 目标字段（查找出来的字段）
	 * @param $type 返回类型（false为标准数组，ture为格式化数组）
	 * @author xyz
	 * @date 2014-10-22 下午6:22:56
	 * @notice 字段是形象说法，指数组的值 
	 */
	private function getShownameByDetail($model,$names,$type=false,$name='name',$showname='showname'){
		if(!is_array($names)){
			$names = explode(',',$names);
		}
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($model,false);
		$shownames=array();
		$shownamelist=array();
		foreach ($names as $key1=>$val){
			foreach ($detailList as $dlist=>$dval){
				if($dval[$name]==$val){
					$shownamelist[]=$dval[$showname];
					$shownames[$key1]="&#39;".$dval[$name]."&#39;=>&#39;".$dval[$showname]."&#39;";
				}
			}
		}
		if($type){
			return $shownames;
		}else{
			return $shownamelist;
		}
	}
}

?>