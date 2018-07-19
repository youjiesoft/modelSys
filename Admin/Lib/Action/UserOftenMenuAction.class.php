<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of UserOftenMenu
 *
 * @author Administrator
 */
class UserOftenMenuAction extends CommonAction {

    public function getConfig(){}


    public function index(){
        $name=$this->getActionname();
        $model=D($name);
        $map['status']=1;
        $map['uid']=$_SESSION[C('USER_AUTH_KEY')];
        $list=$model->where($map)->order("sort desc")->select();
        $this->assign("list",$list);
        $this->display();
    }
    public function update(){
        $name=$this->getActionname();
        $model=D($name);
        $data=array();
        foreach($_REQUEST['id'] as $key=>$val){
            $data=array(
                'name'=>$_REQUEST['name'][$key],
                'url'=>$_REQUEST['url'][$key],
                'sort'=>$_REQUEST['sort'][$key],
            );
            $list=$model->where("id='".$val."'")->save($data);
        }
        if ($list!==false) { //保存成功
            $this->success ( L('_SUCCESS_') ,'',$list);
        } else {
            $this->error ( L('_ERROR_') );
        }
    }
    //添加常用菜单，只能存在七个
    public function insert(){
        //新增常用功能
        $uommodel = D("UserOftenMenu");
        //查询当前用户是否已添加6个常用
        $umap['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $umap['status'] = 1;
        $workoftenList = $uommodel->where($umap)->order("createtime asc")->select();
        if(count($workoftenList)>6){
            $this->error("常用菜单已存在7个,请删除后再添加！");
            exit;
        }
        //新增常用功能
        $url = $_POST['url'];
        $list = $uommodel->where("uid='".$_SESSION[C('USER_AUTH_KEY')]."' and url='".$_POST['url']."'")->count('*');
        if($list){
            $this->error("已经存在相同菜单！");
            exit;
        }
        $nodeModel = D('Node');
        $nodeArr = explode('/', $url);
        $nodeVO = $nodeModel->where("name = '".$nodeArr[0]."'")->find();
        if(!$_POST['rel'] || !$_POST['title'] || !$nodeVO['icon'] || !$url){
            $this->error("常用菜单添加失败！");
            exit;
        }
        $data['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $data['rel'] = $_POST['rel'];
        $data['title'] = $_POST['title'];
        $data['url'] = $url;
        $data['icon'] = "MisLogisticsFixLog.png";
        $data['createtime'] = time();
        $uommodel->startTrans();
        $uommodel->data($data);
        $res = $uommodel->add($data);
        $uommodel->commit();
        if ($res!==false) { //保存成功
            $this->success ( L('_SUCCESS_'));
        } else {
            $this->error ( L('_ERROR_') );
        }
        exit;
    }
    /**
     *
     * @Title: oftenindex
     * @Description: todo(移除常用后的刷新首页常用显示)
     * @author renling
     * @date 2014-9-2 上午9:42:44
     * @throws
     */
    public function oftenindex(){
        //获取用户常用模块
        $UserOftenMenuModel = D("UserOftenMenu");
        $userMenus=$UserOftenMenuModel->getUserMenu();
        $this->assign('workoftenList',$userMenus);
        $this->display();
    }
    /**
     *
     * @Title: delOften
     * @Description: todo(删除常用功能)
     * @author renling
     * @date 2014-9-2 上午10:02:17
     * @throws
     */
    public function delOften(){
        //删除常用功能
        $uommodel = D("UserOftenMenu");
        $uommap['id'] = $_POST['id'];
        $uommodel->startTrans();
        $res = $uommodel->where($uommap)->delete();
        $uommodel->commit();
        echo $res;
    }

    /**
     * @Title: oftenadd
     * @Description: todo(常用功能添加)
     * @author 杨东
     * @date 2013-3-11 下午3:33:02
     * @throws
     */
    public  function oftenadd(){
        $UserOftenMenuModel=D("UserOftenMenu");
        $model = M("group");
        $list = $model->where("status=1")->order("sorts asc")->select();
        //获取系统授权
        $model_syspwd=D('SerialNumber');
        $modules_sys=$model_syspwd->checkModule();
        $m_list = explode(",",$modules_sys);
        $tree[] = array(
            'id'=>0,
            'pId'=> -1,
            'name'=> '功能组',
            'title'=>'功能组',
            'open'=>true
        );
        $oftenList = array();
        $valid = '';
        foreach ($list as $k => $v) {
            $oftenaddtree = $UserOftenMenuModel->oftenaddtree($v['id'],$m_list);
            if ($oftenaddtree) {
                $tree[] = array(
                    'id'=>$v['id'],
                    'pId'=> 0,
                    'name'=>$v['name'],
                    'title'=>$v['name'],
                    'rel'=>'indexOften',
                    'target'=>'ajax',
                    'url'=>'__URL__/oftenlist/gid/'.$v['id'],
                    'open'=>true
                );
                if(!$oftenList){
                    $oftenList = $oftenaddtree;
                    $valid = $v['id'];
                }
            }
        }
        $this->assign('valid',$valid);
        $this->assign('oftenList',$oftenList);
        $this->assign('tree', json_encode($tree));
        $this->assign("mdname",$_REQUEST['mdname']);
        $this->display('oftenadd');
    }
    /**
     *
     * @Title: oftenlist
     * @Description: todo(常用添加树节点刷新)
     * @author renling
     * @date 2014-9-2 上午10:27:35
     * @throws
     */
    public function oftenlist(){
        $UserOftenMenuModel=D("UserOftenMenu");
        //获取系统授权
        $model_syspwd=D('SerialNumber');
        $modules_sys=$model_syspwd->checkModule();
        $m_list = explode(",",$modules_sys);
        $oftenList = $UserOftenMenuModel->oftenaddtree($_GET['gid'],$m_list);
        $this->assign('oftenList',$oftenList);
        $this->display('oftenlist');
        exit;
    }

    public function getOftenList(){
        //获取我的常用功能模块
        $UserOftenMenuModel = D("UserOftenMenu");
        $userMenus=$UserOftenMenuModel->getUserMenu();
        $this->assign('workoftenList',$userMenus);
        $this->display("UserOftenMenu:oftenindexshow");
    }
    public function lookupworkinfo(){
        //获取业务受理数据
        /* $MisOaItemsModel = D("MisOaItems");
        $userOaitemlist = $MisOaItemsModel->getUserOaItemsList(); */
        $MisOaItemsModel = M("mis_auto_lrauz");
        $deptModel = M("user_dept_duty");
        $mapUserid['userid']=$_SESSION[C('USER_AUTH_KEY')];
        if($mapUserid['userid'] == 1){
            $userOaitemlist['list'] = $MisOaItemsModel->select();
            $userOaitemlist['count']=count($userOaitemlist['list']);
            $this->assign("userOaitemlist",$userOaitemlist);
        }else{
            $deptResult = $deptModel->field("deptid")->where($mapUserid)->select();
            $MisOaItemsMap['departmentid']=$deptResult[0]['deptid'];
            $MisOaItemsMap['auditstate'] = array('lt',3);
            $userOaitemlist['list'] = $MisOaItemsModel->where($MisOaItemsMap)->select();
            $userOaitemlist['count']=count($userOaitemlist['list']);
            $this->assign("userOaitemlist",$userOaitemlist);
        }
        //获取工作审批数据
//         $MisOaItemsModel1 = M("mis_auto_bklne");
//         $userOaitemlist1['list'] = $MisOaItemsModel1->select();
//         $userOaitemlist1['count']=count($userOaitemlist1['list']);
//         $this->assign("userOaitemlist1",$userOaitemlist1);
        $map="";
        $MisWorkExecutingModel = D("MisWorkExecuting");
        $MisWorkExecutingModel->_filter("MisSalesMyProject",$map);
        $projectModel = D("MisAutoPvb");
        $userOaitemlist1['count'] = $projectModel->where ( $map )->count ( '*' );
        $this->assign("userOaitemlist1",$userOaitemlist1);

        $MisWorkMonitoringModel = D("MisWorkMonitoring");
        $userAuditlist = $MisWorkMonitoringModel->getUserAuditList();
        $this->assign("userAuditlist",$userAuditlist);
        //获取项目执行数据(项目分派，项目执行，表决)
        $MisWorkExecutingModel = D("MisWorkExecuting");
        $userWorkExecutList = $MisWorkExecutingModel->getUserWorkExecutList();
        $this->assign("userWorkExecutList",$userWorkExecutList);
        //评审会管理未表决统计
        $ModelAction = M("MisAutoSam");
        $subModel=M('mis_auto_fuhhu_sub_datatable5');
        $subList=$subModel->select();
        $weibiaojuemap['conveneStatus']=2;
        $weibiaojuemap['shifoujieshu']=0;
        $weibiaojuemap['pingshenhuileixing']=5;
        foreach ($subList as $k=>$val){
            //查询是否该用户是否在需要表决里面
            $neibuArr= explode(',',$val['neiburenyuan']);
            $neibiaojueArr=explode(',',$val['userid']);
            $waibuArr= explode(',',$val['waiburenyuan']);
            $waibiaojueArr=explode(',',$val['expertid']);
            $waibulist=in_array($_SESSION[C('USER_AUTH_KEY')],$waibuArr);
            $waibiaojuelist=in_array($_SESSION[C('USER_AUTH_KEY')],$waibiaojueArr);
            $neibulist=in_array($_SESSION[C('USER_AUTH_KEY')],$neibuArr);
            $neibiaojuelist=in_array($_SESSION[C('USER_AUTH_KEY')],$neibiaojueArr);
            //查询该用户是否已经表决
            $model=D($ModelAction);
            $biaojueMap['pingshenhuiid']=$val['pingshenhuiid'];
            $biaojueMap['zhaojidanid']=$val['masid'];
            $biaojueMap['zhaojidansubid']=$val['id'];
            $biaojueMap['_string']='userid='.$_SESSION[C('USER_AUTH_KEY')].' or expertid='.$_SESSION[C('USER_AUTH_KEY')];
            $biaojuelist=$model->where($biaojueMap)->select();
            if(($neibulist && !$neibiaojuelist) || ($waibulist && !$waibiaojuelist)){
                if(empty($biaojuelist)){
                    $subId[]=$val['id'];
                }
            }
        }
        $weibiaojuemap['id']=array('in',$subId);
        $this->_list("MisAutoVphSubView",$weibiaojuemap,'',false,'','',"");
        //综合计算所有代办条数(在index页面显示)
        $workCount = $userOaitemlist['count']+$userAuditlist['count']+$userWorkExecutList['count'];
        $this->assign("workCount",$workCount);

        //工作只会数据
        $notifyModel=D('MisNotify');
        $nmap ['_string'] = 'FIND_IN_SET(  ' . $_SESSION [C ( 'USER_AUTH_KEY' )] . ',recipient )';
        $nmap['isread']=0;
        $userZhuilist['count'] =$notifyModel->where ( $nmap )->count ( '*' );;
        $this->assign("userZhuilist",$userZhuilist);
        $this->display("UserOftenMenu:lookupworkinfo");
    }
}

?>
