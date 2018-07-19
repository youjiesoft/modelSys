<?php
//Version 1.0
// 系统流程节点
class ProcessTemplateModel extends CommonModel {
    protected $trueTableName = 'process_template';
    public $_auto	=array(
    		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
    		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
    		array('createtime','time',self::MODEL_INSERT,'function'),
    		array('updatetime','time',self::MODEL_UPDATE,'function'),
    	   array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),

    );
    public function getprocessuser(){
        $model=D("Role");
        $arylist=array();
        $list=$model->where("status>0")->select();
        foreach($list as $key=>$val){
            $arylist[$val['id']]['sub']=$this->getuserByRole($val['id']);
            $arylist[$val['id']]['name']=$val['name'];
            $arylist[$val['id']]['id']=$val['id'];
        }
        return $arylist;
    }
    protected function getuserByRole($Roleid=0){
        $user=array();
        $sql="select * from role_user ru,user u where ru.user_id=u.id and ru.role_id='".intval($Roleid)."'";
        $user=$this->db->query($sql);
        return $user;
    }
    public function getnodeByid($id=0){
        $node=array();
        $where=" status>0 and id='".intval($id)."'";
        $node=$this->where($where)->find();
        return $node;
    }
    public function getnodeByuid(){
        $node=$arynode=array();
        $where=" status>0 and role in(".$_SESSION['role'].") and userid in(".$_SESSION[C('USER_AUTH_KEY')].") ";
        $node=$this->where($where)->field('ptmptid,id')->select();
        foreach($node as $key=>$val){
            $arynode[]="'".implode(",",$val)."'";
        }
        return $arynode;
    }
    public function getnodeBypid($pid){
        $sql="select r.tid as id,r.pid,r.sort,r.userid, t.name,t.sort from process_template t,process_relation r where t.id=r.tid ";
        if($pid>0){
            $sql.=" and r.pid='".$pid."' order by r.sort ASC";
            $arynode=$this->db->query($sql);
        }
        else{
            $arynode=$this->select();
        }
        return $arynode;
    }
}
?>