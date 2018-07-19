<?php
/**
 * @Title: MisFinanceCostCenterAction
 * @Package 财务配置-成本中心信息：功能类
 * @Description: TODO(成本中心的记录及维护)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceCostCenterAction extends CommonAction{
	/**
	 * @Title: _filter
	 * @Description: todo(重写CommonAction的_filter方法，传递过滤参数后返回列表页面)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}

	/**
	 * @Title: index
	 * @Description: todo(重写CommonAction的index方法，展示列表)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function index(){
		$map=array();
		$this->znodes( $map );
		$typeid = $_REQUEST['id'];
		$code=$_REQUEST['code'];
		if ($typeid) {
			$map['id'] = $typeid;
			$model=M("mis_finance_voucher_sub");
			$count=$model->where("costcentercode='".$code."' ")->count();
			if($count>0)
			{
			  $hasvoucher=1;
			  $this->assign("hasvoucher",$hasvoucher);
			}
		}
		$this->assign("valid",$map['id']);
		$name=$this->getActionName();
		$model = D ( $name );
		$vo=$model->where($map)->find();

		$this->assign("vo",$vo);
		if ($_REQUEST['jump']) {
			$this->display('unitlist');
		} else {
			$this->display();
		}
	}

	/**
	 * 获取树形结构的数据源
	 * @param array  $map  查询参数
	 * @return string
	 */	
	public function znodes( &$map ){
		$name=$this->getActionName();
		$model=D($name);
		$list=$model->where($map)->select();
		if($list ) $map['id']=$list[0]['id'];
		$treearr=$this->getTree($list);
		$this->assign("treearr",$treearr);
	}

	/**
	 * 构造树形结构
	 * @param array  $alldata  所有部门信息
	 * @param int $pid  部门节点ID
	 * @param int $i  节点等级
	 * @return string
	 */
	public function getTree($alldata,$pid=0,$i=0){
		$returnarr=array(array('id'=>0,'pId'=>0,'name'=>'成本中心分类','type'=>'post','url'=>'__URL__/index','target'=>'ajax','rel'=>'misfinancecostcentermodel','open'=>'true'));
		foreach($alldata as $k=>$v){
			$newv=array();
			$newv['id']=$v['id'];
			$newv['pId']=$v['parentid'];
			$newv['name']=$v['name'];
			$newv['type']='post';
			$newv['url']='__URL__/index/jump/1/id/'.$v['id'].'/code/'.$v['code'];
			$newv['target']='ajax';
			$newv['rel']='misfinancecostcenterBox';
			$newv['open']='true';
			array_push($returnarr,$newv);
		}
		return json_encode($returnarr);
	}

	/**
	 * @Title: _before_add
	 * @Description: todo(add页面打开前传递展示信息)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_add(){
		$pid = $_REQUEST['id'] ?$_REQUEST['id']:0;
		$this->assign('pid',$_GET['id']);
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
		//取得原父节点与现父节点值及当前操作节点
		$parentid=$_REQUEST["parentid"];
		$oldparentid=$_REQUEST["oldparentid"];
		$id=$_REQUEST["id"];
		//自己不能与自己调换
        if($id==$parentid){
               $this->error ("新上级节点不能是本身！");
        }
		//当存在父节点时验证
		if($parentid){
			if($oldparentid==0){
               $this->error ("顶级节点，不允许调换！");
			}else if($parentid==$oldparentid){
	           $this->error ("原父节点与调换节点相同，请检查！");
			}
		}
		else{
			//父节不变时，将父节点值赋为旧父节点值
			$_POST["parentid"]=$oldparentid;
		}
		$model = D ("MisFinanceCostCenter");
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list=$model->save ();
		//print_r($model->getLastSql());
		//exit;
		if (false !== $list) {
		//执行成功则对新父节点的父节点做更新
		//如果新父节点的父节点与当前操作节点相同则执行改变
		$sign= $model->where("id=".$parentid)->getField("parentid");
		if($sign==$id){
             $maps['parentid']=$oldparentid;
		     $model->where("id=".$parentid)->save($maps);
		}
//	    print_r($model->getLastSql());
//		exit;
          //成功提示，并提交事务
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}

	/**
	 * @Title: delete
	 * @Description: todo(重写CommonAction的delete方法，删除)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function delete(){
		$typeid=$_REQUEST['id'];
        $code=$_REQUEST['code'];
		$name=$this->getActionName();
		$model=D($name);
		//判断是否有下节点
		$list=$model->where("parentid=".$typeid)->select();
		$oldparentid=$model->where("id=".$typeid)->getField("parentid");
        //判断是否为顶级节点，顶级节点父节点为0
        if($oldparentid==0){
            $this->error("此类型为顶级节点，不能删除");
        }else if($list){
			$this->error("此类型下存在子类，不能删除");
		}else{
			$checkModel=M("mis_finance_voucher_sub");
			$count=$checkModel->where("costcentercode='".$code."'")->count();
			//print_r($fvsModel->getLastSql());
			if($count>0)
			{
			 //如果关联记录大于1，不允许删除请在这里处理
			 $this->error("删除失败,此类型下存在辅助账明细",true);
			}
			else{
				$model=M("mis_finance_cost_center");
				$as=$model->where("id=".$typeid)->setField("status","-1");
				if($as){
					$this->success("删除成功",true);
				}else{
					$this->error("删除失败",true);
				}
			}
		}
	}
}