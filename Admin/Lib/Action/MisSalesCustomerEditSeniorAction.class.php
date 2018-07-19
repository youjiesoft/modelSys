<?php
//Version 1.0
/**
 * @Title: MisSalesCustomerEditSeniorAction 
 * @Package package_name
 * @Description: todo(客户高级信息) 
 * @author laicaixia
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-2 上午9:12:27 
 * @version V1.0 
*/ 
class MisSalesCustomerEditSeniorAction extends CommonAction{
    /* (non-PHPdoc)列表
     * @see CommonAction::index()
     */
    public function index(){
    	$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail("MisSalesCustomer",false);
		if ($detailList) {
			$fieldsarr = array();
			foreach ($detailList as $k => $v) {
				if ($v['models']) {
					$showname = "<a rel='".$v['models']."' target='navTab' href='__APP__/".$v['models']."/index'>".$v['showname']."</a>";
				} else{
					$showname = $v['showname'];
				}
				$fieldsarr[$v['name']] = $showname;
			}
			$this->assign ( 'fields', $fieldsarr );
		}
		$id=$this->escapeStr($_GET['id']);
	    $model=D('MisSalesCustomer');
	    $customer=$model->where("id='".$id."'")->find();
	    $this->assign("vo",$customer);
		$this->assign("id",$id);
		//业务人员
		$uModel=D('User');
		$ulist=$uModel->where('status = 1')->select();
		$this->assign("ulist",$ulist);
		//获取销售区域
		$salesite=D('MisSalesSite');
		$sitelist=$salesite->where('status = 1')->select();
		$this->assign("sitelist",$sitelist);
		//交货方式
		$salesite=D('MisSystemTransport');
		$list1=$salesite->where('status = 1')->select();
		$this->assign("jhtype",$list1);
		$this->display();
    }
    /* (non-PHPdoc)保存
     * @see CommonAction::update()
     */
    public function update(){
		if( !isset($_POST['isonce']) )$_POST['isonce']=0;
		$model = D ("MisSalesCustomer");
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list=$model->save ();
		if (false !== $list) {
			$this->success ( L('_SUCCESS_') );
		} else {
			$this->error ( L('_ERROR_') );
		}
    }
}
?>
