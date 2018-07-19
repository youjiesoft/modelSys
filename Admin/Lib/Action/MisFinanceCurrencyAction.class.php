<?php
/**
 * @Title: MisFinanceCurrencyAction
 * @Package 财务配置-货币信息：功能类
 * @Description: TODO(货币的记录及维护)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceCurrencyAction extends CommonAction{
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
     * @Title: _before_index
     * @Description: todo(index方法前调用，获取默写数据到index内调用)
     * @return string
     * @author yangxi
     * @date 2013-5-31 下午3:59:44
     * @throws
     */
    public function _before_index() {
	$this->assign('searchbylist',$searchby);
	$this->assign('searchtypelist',$searchtype);
    }

    /**
     * @Title: index
     * @Description: todo(重写CommonAction的index方法，展示列表)
     * @return string
     * @author yangxi
     * @date 2013-5-31 下午3:59:44
     * @throws
     */
    public function insert(){
 	   	$model = M('mis_finance_currency');
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		//保存当前数据对象
		$list=$model->add ();
		//
		if ($list!==false) { //保存成功
			$m=M();
			$sql= "update mis_finance_currency set basecurr =0 where id<> ".$list;
			$m->query($sql);
			$this->success ( L('_SUCCESS_') ,'',$list);
		} else {
			$this->error ( L('_ERROR_') );
		}

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
 	   	$model = M('mis_finance_currency');
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		//保存当前数据对象
		$list=$model->save ();
		if ($list!==false) { //保存成功
			$m=M();
			$sql= "update mis_finance_currency set basecurr =0 where id<> ".$_POST[id];
			$m->query($sql);
			$this->success ( L('_SUCCESS_') ,'',$list);
		} else {
			$this->error ( L('_ERROR_') );
		}

    }
}
?>
