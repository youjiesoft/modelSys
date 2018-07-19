<?php 
/**
 * @Title: MisOfficialdocumentTypeAction 
 * @Package action 
 * @Description: todo(收文流程配置控制器) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-11-18 下午2:28:17 
 * @version V1.0
 */
class MisOfficialdocumentInAuditorAction extends CommonAction{
	public function _filter(&$map) {
		$map['status'] = 1;
		$map['typeid'] = 2;
	}
	public function index(){
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
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
			$this->_list ( $name, $map ,'sort',false);
		}
		$scdmodel = D('SystemConfigDetail');
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
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		//首页跳转验证
		if ($_REQUEST['jump']) {
			$this->display ("indexview");exit;
		}
		$this->display ();
		return;
	}
	public function _after_list($voList){
		if($voList){
			foreach($voList as $key=>$val){
				//获取后台用户数据
				$map['id'] = array(' in ',$val['userid']);
				$map['status'] = 1;
				$UserDao = M('user');
				$userlist=$UserDao->where($map)->field('id,name')->select();
				$voList[$key]['userlist'] = $userlist;
			}
		}
	}
	public function update(){
		$name=$this->getActionName();
		$model = D ( $name );
		//获取需要修改的ID组
		$ids = $_POST['id'];
		foreach($ids as $key=>$val){
			$data['id'] = $val;
			$userarr=$_POST['lookupinAuditor'.$val];
			if(!$userarr){
				$this->error("批阅用户不能为空!");
			}
			$data['userid'] = implode(",",$userarr);
			// 更新数据
			$list=$model->save ($data);
			if(!$list){
				$this->error("修改人员失败");
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
}
?>