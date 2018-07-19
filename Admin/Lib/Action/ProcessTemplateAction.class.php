<?php
//Version 1.0
/*
 * 系统流程节点
 * author mashihe
*/
class ProcessTemplateAction extends CommonAction {
    public function getnode(){
        $str="";
        $model=D("ProcessTemplate");
        $info=$model->getnodeBypid($_REQUEST['ptid']);
        foreach($info as $key=>$val){
            $str.='<li class="itemID" onmouseover="tips_over(this);" onmouseout="tips_out(this);">
                        <b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
                        <div class="b d1 k" >
                            <input type="hidden" name="ids[]" value="'.$val['id'].'"/>
                            '.$val['name'].'
                        </div>
                        <b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b>
                        <span><a href="__APP__/ProcessTemplate/edit/id/'.$val['id'].'" target="dialog"  width="800" height="500" title="编辑流程节点">编辑</a>|<a a warn="请选择库区" title="你确定要删除吗？" target="ajaxTodo" callback="navTabAjaxMiwh" href="__APP__/ProcessTemplate/delete/id/'.$val['id'].'" class="delete">删除</a></span>
                    </li>';
        }
        echo $str;
    }
    public function getuser(){
        $model=D("ProcessTemplate");
        $user=$model->getprocessuser();
        $this->assign("user", $user);
        $this->display();
    }
    public function _empty(){
        $this->error("您访问的页面不存在！");
    }
/*
	public function delete(){
		$condition['pid'] = $_REQUEST['pid'];
		$condition['tid'] = $_REQUEST['tid'];
		//Session::set('ProcessNowSelected',$pid);
		$data['status'] = '-1';
		$model = M('ProcessRelation');
		$result = $model->where($condition)->save($data);
		if($result !== false){
			$this->success( L('_SUCCESS_') );
		}else{
			$this->success( L('_ERROR_') );
		}
		//print_r($condition);exit;
		//$this->success("123123");
	}
*/
}
?>