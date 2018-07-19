<?php
/**
 * @Title: MisSalesMyProjectAction
 * @Package package_name
 * @Description: todo(项目管理 里的我的项目)
 * @author xiafengqin
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2013-6-1 上午9:31:36
 * @version V1.0
 */
class MisSalesMyProjectAction extends MisAutoEbmAction {
    public function _filter(&$map) {
        $MisWorkExecutingModel = D("MisWorkExecuting");
        $MisWorkExecutingModel->_filter("MisSalesMyProject",$map);
    }
    public function index() {
        // 获取当前控制器名称
        $name = $this->getActionName ();
        // 列表过滤器，生成查询Map对象
        $map = $this->_search ("MisAutoPvb");
        $type=$_REQUEST['type']?$_REQUEST['type']:1;
        $this->assign('type',$type);
        if($type){
        	switch ($type){
                case 2:
                    $map['xiangmujieduan']="h2";
                    break;
                case 3:
                    $map['xiangmujieduan']="h3";
                    break;
                case 4:
                    $map['xiangmujieduan']="h4";
                    break;
                case 5:
                    $map['xiangmujieduan']="h5";
                    break;
                case 6:
                    $map['xiangmujieduan']="h6";
                    break;
                case 7:
                    $map['xiangmujieduan']="h7";
                    break;
            }
        }
        if (!empty($_REQUEST['xiangmuleixing']) && $_REQUEST['xiangmuleixing']!=0) {
            $map['xiangmuleixing']=$_REQUEST['xiangmuleixing'];
        }
        $xmlxx=empty($map['xiangmuleixing'])?0:$_REQUEST['xiangmuleixing'];
        $this->assign('xiangmuleix',$xmlxx);
        if (method_exists ( $this, '_filter' )) {
            $this->_filter ( $map );
        }
        //列表页排序 ---开始-----2015-08-06 15:07 write by xyz
        $sortsorder = '';
        $sortsmap['modelname'] = "MisAutoPvb";
        $sortsmap['sortsorder'] = array("gt",0);
        //管理员读公共设置
        if($_SESSION['a']){
            $listincModel = M("mis_system_public_listinc");
            $sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
        }else{
            //个人先读个人设置、没有再读公共设置
            $sortsmap['userid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
            $listincModel = M("mis_system_private_listinc");
            $sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
            if(empty($sortslist)){
                unset($sortsmap['userid']);
                $listincModel = M("mis_system_public_listinc");
                $sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
            }
        }
        //如果在设置里有相关数据、提取排序字段组合order by
        if($sortslist){
            foreach($sortslist as $k=>$v){
                $sortsorder .= $v['fieldname'].' '.$v['sortstype'].',';
            }
            $sortsorder = substr($sortsorder,0,-1);
        }
        //列表页排序 ---结束-----
        $this->_list ( "MisAutoPvb", $map,'', false,'','',$sortsorder);
        // 查询数据
        //	$this->_list ( "MisAutoPvb", $map );
        // begin
        $scdmodel = D ( 'SystemConfigDetail' );
        // 读取列名称数据(按照规则，应该在index方法里面)
        $detailList = $scdmodel->getDetail ( "MisAutoPvb" );
        if ($detailList) {
            $this->assign ( 'detailList', $detailList );
        }
        // 扩展工具栏操作
        $toolbarextension = $scdmodel->getDetail ( $name, true, 'toolbar','sortnum','shows',true );
        if ($toolbarextension) {
            $this->assign ( 'toolbarextension', $toolbarextension );
        }
        // end
       
        // 获取输出到的html模板
        $jump = $_REQUEST ['jump'];
        if ($jump) {
            $this->display ( "indexview" );
        } else {
            $this->display ();
        }
    }
    function _before_add() {
        //业务类型表
        $mis_system_flow_typeDao = M("mis_system_flow_type");
        $map['outlinelevel'] = 1;
        $map['status'] = 1;
        $list = $mis_system_flow_typeDao->where($map)->field("id,orderno,name,cmpid")->select();
        //判断当前登录人是否为管理员
        if ($_SESSION["a"] != 1){
            //获取当前公司
            $companyid = $_SESSION['companyid'];
            foreach($list as $key=>$val){
                if(!in_array($companyid, explode(",", $val['cmpid']))){
                    unset($list[$key]);
                }
            }
        }
        //自动获取制单人（主调） 及部门$_SESSION['user_dep_id']
        //$this->assign('zddeptid',$_SESSION['user_dep_id']);
        //$this->assign('zd',$_SESSION[C("USER_AUTH_KEY")]);
        $this->assign("typelist",$list);
        //获取商机id
        $id = $_REQUEST ['bid'];
        //针对商机推送过来的rel刷新
        $rel=$_REQUEST['rel'];
        $this->assign('rel',$rel);
        if($id){
            $model = D ( "MisSaleBusiness" );
            $sjmap = array();
            $sjmap['id']=$id;
            $sjvo = $model->where($sjmap)->find();

            //获取客户名称和id
            $banmomodel = M('mis_auto_banmo');
            $banmo = $banmomodel->field('id,orderno,kehumingchen')->where("status=1 AND kehumingchen='".$sjvo['clientname']."'")->find();
            if(empty($banmo)){
                $this->error('该商机还没转客户，请先转为客户再转项目');
                exit;
            }else{
                $vo['bid']=$sjvo['id'];
                $vo['name']=$sjvo['clientname'];
                $vo['intentiontypesid']=$sjvo['intentiontypesid']; //业务类型
                $vo['customerid']=$banmo['orderno'];
                $vo['zt']=$sjvo['customertypeid'];
                $vo['hy']=$sjvo['professionid'];
                $vo['cyl']=$sjvo['industryid'];
                $vo['sjid']=$sjvo['orderno'];
                $vo['sjuserid']=$sjvo['userid'];
                $this->assign('vo',$vo);
            }
        }
    }
    /**
     * @Title: _before_insert
     * @Description: todo(插入的前置函数)
     * @author xiafengqin
     * @date 2013-6-1 上午9:35:49
     * @throws
     */
    public function _before_insert() {
        //获取项目组角色名称，需要项目组时打开
        if(!$_POST['prolineorderno']){
            $this->error("新建不成功，项目组角色必须！");
        }
        //验证项目编号是否重复，如果重复自动生成新的编码
        $this->checkifexistcodeororder('mis_auto_kimpu','orderno',$this->getActionName());
        //存储项目组配置过来的字段
        $deptjinli = $_POST['deptjinli'];
        //获取主调部门
        $deptment = $_POST['deptment'];
        //比如配置的主调，辅调
        $field = $_POST['field'];
        foreach($deptjinli as $key=>$val){
            if($val && $field[$key]){
                $_POST[$field[$key]] = $val;
                if($field[$key] == "zd"){
                    $_POST["zddeptid"] = $deptment[$key];
                }
            }
        }
    }

    function insert($isrelation=false) {
        $_POST['shoulidanhao']=$_POST['sjuserid'];
        $name=$this->getActionName();
        $model = D ($name);
        if (false === $model->create ()) {
            if(!$isrelation){
                $this->error ( $model->getError () );
            }else{
                throw new NullPointExcetion($model->getError () . ' ACTION: ' .$name);
                return false;
            }
        }
        //保存当前数据对象
        try {
            $list=$model->add ();

        }catch (Exception $e){
            $this->error($e->__toString());
        }
        if ($list!==false) {
        	//子流程数组反写主流程绑定ID @liminggang 2015-03-10
        	if ($_POST['auditFlowTuiTablename'] && $_POST['auditFlowTuiTableid'] && $_POST['auditZhuLicModel'] && $_POST['auditZhuLicId']) {
        		/*
        		 * 转子流程因为支持一对一、一对多
        		 * 升级日期 2015-11-20
        		 */
        		$map = array();
        		$map['tablename'] = $_POST['auditZhuLicModel'];
        		$map['tableid'] = $_POST['auditZhuLicId'];
        		$map['isauditmodel'] = "MisAutoXyc";//固定值，建立项目 ,因为你们的子任务挂的这个模型，必须写死
        		$map['doing'] = 1;
        		$process_relation_formDao = M("process_relation_form");
        		//查询当前审批节点表数据
        		$relation_formlist = $process_relation_formDao->where($map)->find();
        		if($relation_formlist && $relation_formlist['flowtype'] == 3){
        			//当前子流程审核完成，进行主流程当前节点通过
        			$mainProcessModel=A($relation_formlist['tablename']);
        			//旧的post值
        			$oldpost = $_POST;
        			unset($_POST);
        			$_POST ['id']=$relation_formlist['tableid'];
        			$_REQUEST['doinfo'] = "子流程单据完成";
        			C("TOKEN_ON",false);
        			$mainProcessModel->auditProcess(1);
        			C("TOKEN_ON",true);
        			//还原主数据的ID
        			unset($_POST);
        			//将旧的post内容。恢复到主数据上面
        			$_POST = $oldpost;
//         			//查询审批流功能
//         			$mis_work_monitoringDao = M("mis_work_monitoring");
//         			$map = array();
//         			$map['tablename'] = $_POST['auditZhuLicModel'];
//         			$map['tableid'] = $_POST['auditZhuLicId'];
//         			$map['ostatus'] = $relation_formlist['id'];
//         			$map['dostatus'] = array('neq',1);
//         			$moninfo = $mis_work_monitoringDao->where($map)->find();
//         			if($moninfo){
//         				$dt = array();
//         				$dt['dotime'] = time();
//         				$dt['dostatus'] = 1;
//         				$dt['userid'] = $moninfo['curAuditUser'];
//         				$dt['doinfo'] ="同意";
//         				//修改审批状态
//         				$bol = $mis_work_monitoringDao->where("id = {$moninfo['id']}")->save($dt);
//         				if($bol === false){
//         					$this->error ( "错误：".$mis_work_monitoringDao->getlastSql());
//         				}
//         			}
//         			$dat = array();
//         			$dat['alreadyAuditUser'] = $relation_formlist['curAuditUser'];
//         			$dat['auditState'] = 1;
//         			$dat['isaudittableid'] = $list;
//         			$process_relation_formDao->where("id = {$relation_formlist['id']}")->save($dat);
        		}
        		//end
        	}
            /*
             * 处理插入成功后，处理数据的后置函数
             */
            if (method_exists($this,"_after_insert")) {
                $this->_after_insert($list);
            }

            /*
             * _over_insert 方法，为静默插入生单。
             * 只有在终审后，才进行静默漫游生单
             */
            if (method_exists ( $this, '_over_insert' )) {
                $updateBackup=$this->setOldDataToCache($model,$name,$list,'insert');
                $this->_over_insert ( $name, $list,$updateBackup);
            }
            /*
             * startprocess,在页面是不存在。此参数是在启动流程startprocess方法中默认赋值的，为了关闭insert的成功success输出
            */
            $startprocess = $_POST ['startprocess'];

            if ($startprocess != 1) {
                if(!$isrelation){
                    try{
                        $this->success ( "表单数据保存成功！" ,'',$list);
                    }catch (Exception $e){
                        $this->error($e->__toString());
                    }
                }else{
                    return $list;
                }
                exit;
            }else{
                $_POST ['id'] = $list;
            }
        } else {
            if(!$isrelation){
                $this->error ( L('_ERROR_') );
            }else{
                throw new NullPointExcetion( $model->getDberror().L('_ERROR_'));
                return false;
            }
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see MisAutoEbmAction::_after_insert()
     */
    function _after_insert($list){
//        strtotime($_POST['lixiangriqi']);
//        exit;
        $lxrq['lixiangriqi']=strtotime($_POST['lixiangriqi']);
        $condition['id'] = $list;
        M('mis_auto_kimpu')->where($condition)->save($lxrq);
        //获取项目组编号
        $prolineorderno = $_POST['prolineorderno'];
        //存储项目组配置过来的字段
        $deptjinli = $_POST['deptjinli'];
        $leibie = $_POST['leibie'];
        $suoshujiaose = $_POST['suoshujiaose'];
        $data = array();
        foreach ($prolineorderno as $key=>$val){
            $data[] = array(
                'projectid'=>$list,
                'leibie'=>$leibie[$key],
                'suoshujiaose'=>$suoshujiaose[$key],
                'juese'=>$val,
                'userid'=>$deptjinli[$key],
                'createid'=>$_SESSION[C('USER_AUTH_KEY')],
                'createtime'=>time(),
            );
        }
//        $data1=$_POST;
//        var_dump($data1);
//        exit;
        //需要项目组时打开
        $mbool = M("mis_project_flow_manager")->addAll($data);
        unset($data);
        if($mbool == false){
            $this->error ( "项目组信息插入失败，请联系管理员" );
        }
        //修改projectid为本id
        $modelname=$this->getActionName();
        $model=D($modelname);
        $listInfo=$model->where(array('id'=>$list))->save(array('projectid'=>$list));
        //判定商机推送项目，才进行数据判定
        $id=$_REQUEST['bid'];
        if($id){
            //商机推送项目，才会出现此操作，反写商机数据信息。
            $name='MisSaleBusiness';
            $busModel=D($name);
            $busmap['id']=$id;
            $busdata['businessstatus']=4; //转项目
            $busdata['updateid']=$_SESSION[C('USER_AUTH_KEY')];
            $busdata['updatetime']=time();
            $busInfo=$busModel->where($busmap)->save($busdata);
            $allModel=D('MisSaleBusinessAllot');
            $allmap['bid']=$id;
            $alldata['turnstatus']=1;
            $alldata['updateid']=$_SESSION[C('USER_AUTH_KEY')];
            $alldata['updatetime']=time();
            $allInfo=$allModel->where($allmap)->save($alldata);
            if($busInfo == false || $allInfo == false){
                $this->error ( "商机数据处理失败" );
            }
        }
    }
    /**
     * @Title: lookupEdit
     * @Description: todo(项目执行)
     *
     * @param 跳转页面标记 $step
     *        	1,2
     * @author liminggang
     *         @date 2014-4-23 上午9:54:14
     * @throws
     *
     */
    public function lookupEdit() {
        //获取项目ID
        $projectid = $_REQUEST ['projectid'];
        $this->assign ( 'projectid', $projectid );
        //获取主要负责人(主调和副调)
        $usernameList = $this->getZYFZR($projectid);
        $this->assign("zfzr",$usernameList);

        //查询任务进行的所在阶段。
        $MisProjectFlowType = M("mis_project_flow_type");
        $where = array();
        $where['projectid'] = $projectid;
        $where['outlinelevel'] = 2; //节点
        $typelist = $MisProjectFlowType->where($where)->field("uid,id,name,complete")->order("sort asc")->select();
        unset($where);
        $bool = true; //阶段验证标志
        foreach($typelist as $key=>$val){
            if($val['complete'] == 2){
                if($bool){
                    $dfaultJd = $val ['id']; // 以及正在执行的阶段
                    $jd =$val['name'];
                    $bool = false;
                }
            }
        }
        if($bool){
            //表示项目已经完成。
            $jd="项目完结";
            $dfaultJd = 0;
        }
        $this->assign("jd",$jd);

        // 查询当前项目所有任务列表(此查询时未分页查询，数据量比较大)
        $where = array ();
        $where ['mis_project_flow_work.outlinelevel'] = 4;
        $where ['mis_project_flow_type.status'] = 1; // 类型正常
        $where ['mis_project_flow_work.projectid'] = $projectid;
        $where ['mis_project_flow_type.projectid'] = $projectid;
        if ($_SESSION ["a"] != 1) {
            //如果不是管理员，则只能查看自己执行的项目
            $where ['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',mis_project_flow_resource.executorid )';
            //查询有任务查看角色的人员
        }
        $MisProjectFlowTypeModel = D ( "MisProjectFlowType" );
        $rwlist = $MisProjectFlowTypeModel->join ( "mis_project_flow_form AS mis_project_flow_form  ON mis_project_flow_form.category = mis_project_flow_type.id" )
            ->join ( "mis_project_flow_form AS mis_project_flow_work ON mis_project_flow_work.parentid = mis_project_flow_form.id" )
            ->join ( "mis_project_flow_resource AS mis_project_flow_resource ON mis_project_flow_resource.id = mis_project_flow_work.id" )
            ->where ( $where )->field ( "mis_project_flow_type.uid as uid,mis_project_flow_type.id as id,mis_project_flow_type.name as name,
				mis_project_flow_form.id as form_id,mis_project_flow_form.name as form_name,mis_project_flow_work.id as work_id,
				mis_project_flow_work.name as work_name,  mis_project_flow_work.begintime AS begintime,mis_project_flow_work.endtime AS endtime,
  				mis_project_flow_work.formobj AS formobj,mis_project_flow_work.formtype AS formtype,mis_project_flow_work.projectid AS projectid,
  				mis_project_flow_work.complete AS complete,mis_project_flow_work.category AS category,
				mis_project_flow_resource.alloterid AS alloterid,mis_project_flow_resource.`executorid` AS executorid" )->order ( "mis_project_flow_type.sort,mis_project_flow_form.sort,mis_project_flow_work.sort asc" )->select ();
        //组装阶段和节点信息
        $data = array ();
        foreach ( $rwlist as $key => $val ) {
            $arr = array ();
            $arr [$val ['form_id']] = array (
                'form_id' => $val ['form_id'],
                'form_name' =>$val['form_name'],
            );
            if (in_array ( $val ['id'], array_keys ( $data ) )) {
                if (! in_array ( $val ['form_id'], array_keys ( $data [$val ['id']] ['sub'] ) )) {

                    $data [$val ['id']] ['sub'] [$val ['form_id']] = array (
                        'form_id' => $val ['form_id'],
                        'form_name' =>$val['form_name'],
                    );
                }
            } else {
                $data [$val ['id']] ['id'] = $val ['id'];
                $data [$val ['id']] ['name'] = $val ['name'];
                $data [$val ['id']] ['sub'] = $arr;
            }
        }
        $this->assign ( 'data', $data );

        //查询当前项目所有任务列表(此查询时未分页查询，数据量比较大)
        $MisProjectFlowFormModel = D ( "MisProjectFlowForm" );
        $list = $MisProjectFlowFormModel->getFormArr ( $rwlist,$dfaultJd);
        $this->assign ( 'list', $list );

        $this->display ( "lookupEdit" );
    }
    /**
     * @Title: _before_update
     * @Description: todo(修改保存前置函数)
     *
     * @author xiafengqin
     *         @date 2013-6-1 上午9:42:14
     * @throws
     *
     */
    public function _before_update() {
        $this->checkifexistcodeororder('mis_auto_kimpu','orderno',$this->getActionName(),1);
    }

    /**
     * lookupProjectEdit项目任务编辑
     */
    function lookupProjectEdit(){
        $projectid=$_REQUEST['id'];
        $typelist = $this->getType ($projectid);
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        $name = 'MisProjectFlowForm';

        // 列表过滤器，生成查询Map对象
        $map = $this->_search ( $name );
        $map['projectid']=$projectid;
        $this->assign('id',$projectid);
        // 获取点击的类型
        $supcategory = $_REQUEST ['supcategory'] = $_REQUEST ['supcategory']?$_REQUEST ['supcategory']:0;
        if ($supcategory) {
            $map ['supcategory'] = $supcategory;
            $this->assign ( 'supcategory', $supcategory );
        }
        // 获取点击的阶段
        $category = $_REQUEST ['category'] = $_REQUEST ['category']?$_REQUEST ['category']:0;
        if ($category) {
            $map ['category'] = $category;
            $this->assign ( 'category', $category );
        }
        // 获取点击的节点
        $pid = $_REQUEST ['pid'] = $_REQUEST ['pid']?$_REQUEST ['pid']:0;
        if ($pid) {
            $map ['parentid'] = $pid;
            $this->assign ( 'pid', $pid );
        }
        // 树形结构默认选中
        $this->assign ( "ztreeid", $typelist [0] ['id'] );
        // 第一次进入，默认查询第一个类型下面的所有任务
        if (! $supcategory && ! $category && ! $pid) {
            $map ['supcategory'] = $typelist [0] ['default'];
        }
        $map ['outlinelevel'] = 4; // 查询任务
        if (! empty ( $name )) {
            $this->_list ( $name, $map );
        }

        $scdmodel = D ( 'SystemConfigDetail' );
        $detailList = $scdmodel->getDetail ( $name );
        if ($detailList) {
            $this->assign ( 'detailList', $detailList );
        }
        // 扩展工具栏操作
        $toolbarextension = $scdmodel->getDetail ( $name, true, 'toolbar' );
        if ($toolbarextension) {
            $this->assign ( 'toolbarextension', $toolbarextension );
        }
        if ($_REQUEST ['jump'] == "jump") {
            $this->display ( 'lookupProjectEditView' );
        } else {
            $this->display ();
        }
    }
    private function getType($projectid) {
        $MisSystemFlowTypeDao = M ( "mis_project_flow_type" );
        $where ['status'] = 1;
        $where ['projectid'] = $projectid;
        $typelist = $MisSystemFlowTypeDao->order("sort asc")->where ( $where )->select ();
        // 任务节点
        $MisSystemFlowFormDao = M ( "mis_project_flow_form" );
        $where ['outlinelevel'] = 3;
        $formlist = $MisSystemFlowFormDao->order("sort asc")->where ( $where )->select ();

        $supcategory = 0;
        $jsonArr = array ();
        foreach ( $typelist as $key => $val ) {
            // 递归获取最小一层类型
            $supcategory = $this->abc ( $typelist, $val ['id'] );

            $typelist [$key] ['default'] = $supcategory;
            $array = array ();
            $array ['id'] = $val ['id'];
            $array ['name'] = missubstr($val['name'],18,true);
            $array ['title'] = $val ['name'];
            $array ['pId'] = $val ['parentid'];
            $array ['open'] = true;
            $array ['url'] = "__URL__/lookupProjectEdit/jump/jump/supcategory/" . $supcategory."/category/0/pid/0/id/".$projectid;
            $array ['rel'] = "lookupProjectEdit";
            $array ['type'] = 'post';
            $array ['target'] = 'ajax';
            // 阶段
            if ($val ['outlinelevel'] == 2) {
                $array ['url'] = "__URL__/lookupProjectEdit/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/0/id/".$projectid;
                $array ['rel'] = "lookupProjectEdit";
                $array ['type'] = 'post';
                $array ['target'] = 'ajax';
                $jsonArr [] = $array;
                foreach ( $formlist as $k => $v ) {
                    if ($val ['id'] == $v ['category']) {
                        $array = array ();
                        $array ['id'] = "999999" . $v ['id'];
                        $array ['name'] = missubstr($v['name'],18,true);
                        $array ['title'] = $v ['name'];
                        $array ['pId'] = $val ['id'];
                        $array ['url'] = "__URL__/lookupProjectEdit/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/" . $v ['id']."/id/".$projectid;
                        $array ['rel'] = "lookupProjectEdit";
                        $array ['type'] = 'post';
                        $array ['target'] = 'ajax';
                        $jsonArr [] = $array;
                    }
                }
            } else {
                $jsonArr [] = $array;
            }
        }
        $this->assign ( 'json_arr', json_encode ( $jsonArr ) );
        return $typelist;
    }
    public function abc($typelist, $id) {
        foreach ( $typelist as $key => $val ) {
            if ($id == $val ['parentid'] && $val ['outlinelevel'] == 1) {
                unset ( $typelist [$key] );
                $id = $this->abc ( $typelist, $val ['id'] );
            }
        }
        return $id;
    }

    function lookupprojectflowflowadd(){
        $this->display();
    }
    /**
     * @Title: lookupshowproline
     * @Description: todo(项目组信息获取)
     * @author 谢友志
     * @date 2015年4月7日 下午5:55:34
     * @throws
     */
    public function lookupshowproline(){
        //实例化项目组定义模型
        $model = D ( "MisAutoAhm" );
        $map2 ['status'] = 1;
        $map2 ['leibie'] = "组";
        //获取产品组数据
        $list = $model->where ( $map2 )->field("id,parentid,suoshujiaose,orderno,name,chanpinxian,zhuti,xingye,chanyelian,suoshubumen,jianyirenyuan,leibie,shifuzidonghuoquzhid,duiyingxiangmuziduan")->select ();
        foreach ( $list as $k => $v ) {
            if ($v ["chanpinxian"] && $_POST ['chanpinxian'] && $_POST ['chanpinxian'] != $v ["chanpinxian"]) {
                unset ( $list [$k] );
                continue;
            }
            if ($v ["zhuti"] && $_POST ['zhuti'] && $_POST ['zhuti'] != $v ["zhuti"]) {
                unset ( $list [$k] );
                continue;
            }
            if ($v ["xingye"] && $_POST ['xingye'] && $_POST ['xingye'] != $v ["xingye"]) {
                unset ( $list [$k] );
                continue;
            }
            if ($v ["chanyelian"] && $_POST ['chanyelian'] && $_POST ['chanyelian'] != $v ["chanyelian"]) {
                unset ( $list [$k] );
                continue;
            }
        }
        $zuArr = array();
        if($list){
            $list = array_merge($list);
            $zuArr = $list[0];
            //获取查询的部门经理
            $manager = "部门经理";
            if(file_exists(DConfig_PATH."/System/list.inc.php")){
                require DConfig_PATH."/System/list.inc.php";
                $manager = $aryRule['部门经理'];
            }
            //指定部门角色为“部门经理”，据此查询角色id
            $roleid = M ( "rolegroup" )->where ( "name='{$manager}' and status=1 and catgory=5" )->getField("id");
            //组获取到了。
            $map = array();
            $map['_string'] = "orderno like '".$zuArr['orderno']."%' and orderno != '".$zuArr['orderno']."'";
            $zulist = $model->where($map)->field("id,shifuzidongfenpei,shifupingfen,jiaoseshuxing,parentid,suoshujiaose,orderno,name,chanpinxian,zhuti,xingye,chanyelian,suoshubumen,jianyirenyuan,leibie,shifuzidonghuoquzhid,duiyingxiangmuziduan")->select();
            $arr = array();
            $arrid = array();
            foreach($zulist as $key=>$val){
                $val['shifuzidongfenpei'] = $val['shifuzidongfenpei']?$val['shifuzidongfenpei']:'';
                $org = "org".$key;
                //定义查找带回的锁定项
                $val['org'] = $org;
                $val['duiyingxiangmuziduan'] = $val['duiyingxiangmuziduan']?$val['duiyingxiangmuziduan']:'';
                $jyry = "";
                if($val['parentid'] == $zuArr['id']){
                    $deptid = 0;
                    $userid = 0;
                    //是否自动获取制单人部门信息
                    if($val['shifuzidonghuoquzhid'] == "是"){
                        //根据建单的人的部门和角色id查询 部门经理
                        $deptid = $_SESSION ['user_dep_id'];
                    }else{
                        //如果不是自动获取，则获取所属部门的部门经理
                        if($val['suoshubumen'])$deptid = getFieldBy($val['suoshubumen'], "orderno", "id", "mis_system_department");
                    }
                    //查询人员
                    if($deptid){
                        $userid = M ( "mis_organizational_recode" )->where ( "rolegroup_id={$roleid} and deptid={$deptid} and status=1" )->getField("userid");
                    }
                    //根据用户ID获取用户名称
                    if($userid){$jyry = getFieldBy ( $userid, "id", "name", "user" );}
                    //获取部门名称
                    if($deptid){$deptname = getFieldBy($deptid, "id", "name", "mis_system_department");}
                    $val['deptid'] = $deptid ? $deptid : 0;
                    $val['deptjinli'] = $userid ? $userid : 0;
                    $val['deptjinlichain'] = $jyry ? $jyry : '';
                    //存储分派角色组数据ID
                    array_push($arrid, $val['id']);

                    /*
                     * 组合承办部门
                     */
                    $arr[$val['id']][] = array(
                        'id' =>0,
                        'name'=>'承办部门',
                        'deptjinlichain'=>$deptname,
                        'deptid'=>$deptid,
                        'org'=>$org,
                    );
                    $arr[$val['id']][] = $val;
                }
                //验证执行人部分
                if(in_array($val['parentid'], $arrid)){
                    $val['deptjinli'] = 0;
                    $val['deptid'] = 0;
                    //自动获取制单人归属
                    if($val['shifuzidonghuoquzhid'] == "是"){
                        $jyry = getFieldBy ( $_SESSION[C('USER_AUTH_KEY')], "id", "name", "user" );
                        $val['deptjinli'] = $_SESSION[C('USER_AUTH_KEY')];
                        $val['deptid'] = $_SESSION['user_dep_id'];
                    }else{
                        if($val['jianyirenyuan']){
                            //存在建议人间。直接获取建议人员
                            $jyry = getFieldBy ( $val['jianyirenyuan'], "id", "name", "user" );
                            $val['deptjinli'] = $val['jianyirenyuan'];
                            $val['deptid'] = getFieldBy($val['jianyirenyuan'], "userid", "deptid", "user_dept_duty","companyid",$_SESSION['companyid']);
                        }
                    }
                    $val['zhixingren'] = 0;
                    $val['deptjinlichain'] = $jyry ? $jyry : '';
                    if($val['jiaoseshuxing'] == "执行人"){
                        $arr[$val['parentid']][1]['zhixingren'] = $val['deptjinli'];
                    }
                    //存储数据
                    array_push($arrid, $val['id']);
                    $arr[$val['parentid']] = array_merge($arr[$val['parentid']],array($val));
                }
            }
        }
        $zuArr['volist'] = $arr;
        exit ( json_encode ( $zuArr ) );
    }

    //归档
    function lookupisfile(){
        $projectid=$_REQUEST['id'];
        $typelist = $this->getFileType ($projectid);
        //dump($typelist);
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        $name = 'MisAttachedRecord';
        $name1='MisProjectAttachedTemplateSub';
        $name2='MisSystemFileList';
        $MisAttachedRecordModel=D($name);
        $MisProjectAttachedTemplateSubModel=D($name1);

        // 列表过滤器，生成查询Map对象
        $map = $this->_search ( $name2 );
        $FlowFormmap['_string']='isfile=1 or formtype=1';
        $FlowFormmap['projectid']=$projectid;
        $this->assign('id',$projectid);
        // 获取点击的类型
        $supcategory = $_REQUEST ['supcategory'] = $_REQUEST ['supcategory']?$_REQUEST ['supcategory']:0;
        if ($supcategory) {
            $FlowFormmap ['supcategory'] = $supcategory;
            $this->assign ( 'supcategory', $supcategory );
        }
        // 获取点击的阶段
        $category = $_REQUEST ['category'] = $_REQUEST ['category']?$_REQUEST ['category']:0;
        if ($category) {
            $FlowFormmap ['category'] = $category;
            $this->assign ( 'category', $category );
        }
        // 获取点击的节点
        $pid = $_REQUEST ['pid'] = $_REQUEST ['pid']?$_REQUEST ['pid']:0;
        if ($pid) {
            $FlowFormmap ['parentid'] = $pid;
            $this->assign ( 'pid', $pid );
        }
        // 树形结构默认选中
        $this->assign ( "ztreeid", $typelist [0] ['id'] );
        // 第一次进入，默认查询第一个类型下面的所有任务
        if (! $supcategory && ! $category && ! $pid) {
            $FlowFormmap ['supcategory'] = $typelist [0] ['default'];
        }
        $FlowFormmap ['outlinelevel'] = 4; // 查询任务
        $MisProjectFlowFormList=$MisProjectFlowFormModel->where($FlowFormmap)->select();
        //dump($MisProjectFlowFormList);
        //获取任务id查询附件信息
        foreach ($MisProjectFlowFormList as $k=>$v){
            if($v['formtype']==2){
                $danjuid[]=$v['id'];
            }else{
                $renwuid[]=$v['id'];
            }
        }
        //任务
        $projectworkid=$_REQUEST['projectworkid'];
        if ($projectworkid) {
            $where ['projectworkid'] = $projectworkid;
            $this->assign ( 'projectworkid', $projectworkid );
        }else{
            $where['projectworkid']=array('in',$renwuid);
        }
        $where['projectid']=$projectid;
        $where['status']=1;

        //资料
        $MisProjectAttachedTemplateModel=D('MisProjectAttachedTemplate');
        $MisProjectAttachedTemplateList=$MisProjectAttachedTemplateModel->where($where)->select();
        foreach ($MisProjectAttachedTemplateList as $patk=>$patv){
            $masid[]=$patv['id'];
        }
        $subwhere['masid']=array('in',$masid);
        $subwhere['isfile']=1;
        /* if (! empty ( $name )) {
            $this->_filelist( $name1, $subwhere,false,false,false,false,$danjuid );
        } */

        $MisProjectAttachedTemplateSubList=$MisProjectAttachedTemplateSubModel->where($subwhere)->select();

        foreach ($MisProjectAttachedTemplateSubList as $key=>$val){
            //查询对应阶段节点
            $masList=$MisProjectAttachedTemplateModel->where(array('id'=>$val['masid']))->find();
            $categoryList=$MisProjectFlowFormModel->where(array('id'=>$masList['projectworkid']))->find();
            //查询归档信息
            $MisSystemAttachFileModel=M('mis_system_attach_file');
            $fileList=$MisSystemAttachFileModel->where(array('attachid'=>$val['id'],'formtype'=>1))->find();
            $MisProjectAttachedTemplateSubList[$key]['bianhao']=$fileList['orderno'];
            $MisProjectAttachedTemplateSubList[$key]['fileid']=$fileList['id'];
            $MisProjectAttachedTemplateSubList[$key]['position']=$fileList['position'];
            $MisProjectAttachedTemplateSubList[$key]['page']=$fileList['page'];
            $MisProjectAttachedTemplateSubList[$key]['beizhu']=$fileList['remark'];
            $MisProjectAttachedTemplateSubList[$key]['formtype']=1;
            $MisProjectAttachedTemplateSubList[$key]['category']=$categoryList['category'];
            $MisProjectAttachedTemplateSubList[$key]['parentid']=$categoryList['parentid'];
        }
        //查询单据数据
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        $pffmap['id']=array('in',$danjuid);
        $MisProjectFlowFormList=$MisProjectFlowFormModel->where($pffmap)->select();
        foreach ($MisProjectFlowFormList as $key=>$val){
            //查询归档信息
            $MisSystemAttachFileModel=M('mis_system_attach_file');
            $fileList=$MisSystemAttachFileModel->where(array('attachid'=>$val['id'],'formtype'=>2))->find();
            $MisProjectFlowFormList[$key]['bianhao']=$fileList['orderno'];
            $MisProjectFlowFormList[$key]['fileid']=$fileList['id'];
            $MisProjectFlowFormList[$key]['position']=$fileList['position'];
            $MisProjectFlowFormList[$key]['page']=$fileList['page'];
            $MisProjectFlowFormList[$key]['beizhu']=$fileList['remark'];
            $MisProjectFlowFormList[$key]['formtype']=2;
        }
        if(empty($MisProjectAttachedTemplateSubList)){
            $vo=$MisProjectFlowFormList;
        }elseif(empty($MisProjectFlowFormList)){
            $vo=$MisProjectAttachedTemplateSubList;
        }else{
            $vo=array_merge($MisProjectAttachedTemplateSubList,$MisProjectFlowFormList);
        }

        $i=0;
        $list=array();
        $searchField = array();
        if($map['_complex']){
            // 做全检索
            $searchField = array_keys($map['_complex']);
            array_pop($searchField);
        }else{
            // 做指定字段的检索
            $searchField = array_keys($map);
        }
        //	dump($searchField);
        if($_POST['qkeysword']){
            $searchWord = $_POST['qkeysword'];
        }elseif($_REQUEST['quickname']){
            $searchWord = $_POST['quickname'];
        }elseif($_REQUEST['quickcategory']){
            $quickcategory=$_REQUEST['quickcategory'];
            $quickcategoryModel=M('mis_project_flow_type');
            $quickcategoryMap['_string']='`projectid`='.$projectid.' and name like \'%'.$quickcategory.'%\'';
            $quickcategoryList=$quickcategoryModel->where($quickcategoryMap)->find();
            $searchWord = $quickcategoryList['id'];
        }elseif($_REQUEST['quickparentid']){
            $quickparentid=$_REQUEST['quickparentid'];
            $quickparentidModel=M('mis_project_flow_form');
            $quickparentidMap['_string']='`projectid`='.$projectid.' and name like \'%'.$quickparentid.'%\'';
            $quickparentidList=$quickparentidModel->where($quickparentidMap)->find();
            $searchWord = $quickparentidList['id'];
        }elseif($_REQUEST['quickdatum']){
            $quickdatum=$_REQUEST['quickdatum'];
            $quickdatumModel=M('mis_auto_fkhvh');
            $quickdatumMap['_string']='name like \'%'.$quickdatum.'%\'';
            $quickdatumList=$quickdatumModel->where($quickdatumMap)->find();
            $searchWord = $quickdatumList['id'];
        }

        // 1: 先得到用户指定的查询条件。 查询字段 及 对应的 值。
        // 2: 在源数据遍历的时候 比较用户指定 字段 与 值的 关系 符合的要求的写入临时 数组
        $name=$_POST['name'][1];
        foreach ($vo as $k=>$v){
            $v['sort']=$i;
            $v['data']=implode(",", $v[$k]);
            $v['datum']=$v['datum'];
            $v['name']=$v['name'];
            $v['beizhu']=$v['beizhu'];
            $v['orderno']=$v['orderno'];
            $v['position']=$v['position'];
            $v['page']=$v['page'];
            //dump($v);
            if($searchWord){
                foreach($searchField as $key=>$val){
                    // || strpos($v[$val],$_POST['advanced'.$val])!==false  //高级检索
                    if(strpos($v[$val] , $searchWord) !== false ){
                        $list[][$k]=$v;
                    }
                }
            }else{
                $list[][$k]=$v;
            }
            $i++;
        }
        if($_POST['pageNum']){
            $pageNum=$_POST['pageNum'];
        }else{
            $pageNum=1;
        }
        $this->getPager($list,$pageNum,C("PAGE_LISTROWS"));




        $scdmodel = D ( 'SystemConfigDetail' );
        $detailList = $scdmodel->getDetail ( $name2 );
        if ($detailList) {
            $this->assign ( 'detailList', $detailList );
        }
        // 扩展工具栏操作
        $toolbarextension = $scdmodel->getDetail ('MisAttachedRecord', true, 'toolbar' );

        //dump($toolbarextension);
        if ($toolbarextension) {
            $this->assign ( 'toolbarextension', $toolbarextension );
        }
        if ($_REQUEST ['jump'] == "jump") {
            $this->display ( 'lookupisfileview' );
        } else {
            $this->display ();
        }
    }



    /**
     * 分页函数
     * @param array $data 所有数据
     * @param int $index 当前页
     * @param int $count 每页显示记录数
     * @exception
     * 		传入数据key 值为连续自增
     */
    function getPager($data , $index=1 , $count=3){
        $allcount = count($data); // 总记录数量
        $allPager = $allcount?ceil($allcount / $count):1;	// 总页数
        if($index <= 1){
            // 用户指定的页数最小为1
            $index = 1;
        }
        if($index > $allPager){
            $index = $allPager ; // 指定页最大为总页数
        }
        // 得到开始结束下标
        $start = ($index-1)*$count;
        $end = $index * $count;
        $curData=array();
        // 获取当前数据
        for($i =$start ; $i<count($data);$i++){
            if($i < $end){
                $curData[key($data[$i])] = reset($data[$i]);
            }
        }
        //给每条数据分配该有的toolbar操作按钮
        $this->setToolBorInVolist($curData);
        $this->assign("totalCount",count($data));
        $this->assign("currentPage",$index);
        $this->assign("numPerPage",$count);
        $this->assign("list",$curData);
    }



    public function lookupattched(){
        $formtype=$_REQUEST['formtype'];
        if($formtype==1){
            $masid=$_REQUEST['masid'];
            $id=$_REQUEST['id'];
            $recolist = $this->getAttachedRecordList($masid,true,true,"MisProjectAttachedTemplate",$id,false);
            if( ! empty($recolist)){
                foreach($recolist as $k => $v){
                    $recolist[$k]["createdate"] = date("Y-m-d H:i:s",$v["createtime"]);
                    $deptid = getFieldBy($v["createid"], "id", "dept_id", "user");
                    $zhname = getFieldBy($v["createid"], "id", "zhname", "user");
                    $recolist[$k]["userzhname"] = $zhname;
                    $deptname = getFieldBy($deptid, "id", "name", "mis_system_department");
                    $recolist[$k]["deptname"] = $deptname;
                    if($deptname){
                        $recolist[$k]["upuserinfo"] = $zhname."[".$deptname."]";
                    }else{
                        $recolist[$k]["upuserinfo"] = $zhname;
                    }

                }
            }
        }else{
            $id=$_REQUEST['id'];
            //查询模版
            $MisProjectFlowFormModel=D('MisProjectFlowForm');
            $LIST=$MisProjectFlowFormModel->where(array('id'=>$id))->find();

            $armodel = D('MisAttachedRecord');
            $armap['projectid'] = $LIST['projectid'];
            $armap['projectworkid'] = $id;
            $armap['status'] = 1;
            $armap['tablename'] = $LIST['formobj'];

            $attarry = $armodel->where($armap)->select();
            $filesArr = array('pdf','doc','docx','xls','xlsx','ppt','pptx','txt','jpg','jpeg','gif','png');
            foreach ($attarry as $key => $val) {
                $pathinfo = pathinfo($val['attached']);
                //获取除后缀的文件名称
                $upname = missubstr($val['upname'],18,true).".".$pathinfo['extension'];
                if (in_array(strtolower($pathinfo['extension']), $filesArr)) {
                    //在线查看，必须是指定的文件类型，才能在线查看。
                    $attarry[$key]['online'] = $online;  //在线查看按钮。
                }
                //URL传参。一定要将base64加密后生成的  ‘=’ 号替换掉
                $attarry[$key]['name'] = str_replace("=", '', base64_encode($val['attached']));
                //文件显示名称
                $attarry[$key]['filename'] = $upname;
                //文件下载名称
                $attarry[$key]['lookname'] = $val['upname'];
                //任何文件都可以归档
                $attarry[$key]['archived'] = $archived; //归档按钮
            }
            $uploadarry=array();
            foreach ($attarry as $akey=>$aval){
                $uploadarry[$aval['fieldname']][]=$aval;
            }
            $recolist = $attarry;
            if( ! empty($recolist)){
                foreach($recolist as $k => $v){
                    $recolist[$k]["createdate"] = date("Y-m-d H:i:s",$v["createtime"]);
                    $deptid = getFieldBy($v["createid"], "id", "dept_id", "user");
                    $zhname = getFieldBy($v["createid"], "id", "zhname", "user");
                    $recolist[$k]["userzhname"] = $zhname;
                    $deptname = getFieldBy($deptid, "id", "name", "mis_system_department");
                    $recolist[$k]["deptname"] = $deptname;
                    if($deptname){
                        $recolist[$k]["upuserinfo"] = $zhname."[".$deptname."]";
                    }else{
                        $recolist[$k]["upuserinfo"] = $zhname;
                    }

                }
            }
        }
        $this->assign("recolist",$recolist);
        $this->display();

    }

    private function getFileType($projectid) {
        $MisSystemFlowTypeDao = M ( "mis_project_flow_type" );
        $where ['status'] = 1;
        $where ['projectid'] = $projectid;
        $typelist = $MisSystemFlowTypeDao->order("sort asc")->where ( $where )->select ();
        //dump($typelist);
        // 节点
        $MisSystemFlowFormDao = M ( "mis_project_flow_form" );
        $where ['outlinelevel'] = 3;
        $formlist = $MisSystemFlowFormDao->order("sort asc")->where ( $where )->select ();
        //任务
        $renmap ['status'] = 1;
        $renmap ['projectid'] = $projectid;
        $renmap['outlinelevel']=4;
        $renmap['_string']='isfile=1 or formtype=1';
        $renList= $MisSystemFlowFormDao->order("sort asc")->where ( $renmap )->select ();
        //dump($renList);
        $supcategory = 0;
        $jsonArr = array ();
        foreach ( $typelist as $key => $val ) {
            // 递归获取最小一层类型
            $supcategory = $this->abc ( $typelist, $val ['id'] );

            $typelist [$key] ['default'] = $supcategory;
            $array = array ();
            $array ['id'] = $val ['id'];
            $array ['name'] = missubstr($val['name'],18,true);
            $array ['title'] = $val ['name'];
            $array ['pId'] = $val ['parentid'];
            $array ['open'] = true;
            $array ['url'] = "__URL__/lookupisfile/jump/jump/supcategory/" . $supcategory."/category/0/pid/0/id/".$projectid;
            $array ['rel'] = "lookupisfile";
            $array ['type'] = 'post';
            $array ['target'] = 'ajax';
            // 阶段
            if ($val ['outlinelevel'] == 2) {
                $array ['url'] = "__URL__/lookupisfile/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/0/id/".$projectid;
                $array ['rel'] = "lookupisfile";
                $array ['type'] = 'post';
                $array ['target'] = 'ajax';
                $jsonArr [] = $array;
                //节点
                foreach ( $formlist as $k => $v ) {
                    if ($val ['id'] == $v ['category']) {
                        $array = array ();
                        $array ['id'] =$v ['id'];
                        $array ['name'] = missubstr($v['name'],18,true);
                        $array ['title'] = $v ['name'];
                        $array ['pId'] = $val ['id'];
                        $array ['url'] = "__URL__/lookupisfile/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/" . $v ['id']."/id/".$projectid;
                        $array ['rel'] = "lookupisfile";
                        $array ['type'] = 'post';
                        $array ['target'] = 'ajax';
                        $jsonArr[] = $array;

                        //任务
                        foreach ($renList as $renk=>$renval){
                            if($v['id']==$renval['parentid']){
                                $array = array ();
                                $array ['id'] = $renval ['id'];
                                $array ['name'] = missubstr($renval['name'],18,true);
                                $array ['title'] = $renval ['name'];
                                $array ['pId'] = $renval['parentid'];
                                $array ['url'] = "__URL__/lookupisfile/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/" . $renval ['parentid']."/id/".$projectid.'/projectworkid/'.$renval['id'];
                                $array ['rel'] = "lookupisfile";
                                $array ['type'] = 'post';
                                $array ['target'] = 'ajax';
                                $jsonArr[] = $array;

                            }
                        }
                        /* if(!empty($renwujsonArr)){
                            $jsonArr []=array_merge($jsonArr,$jiedianjsonArr);
                            $jsonArr [] =array_merge($jsonArr,$renwujsonArr);
                        } */
                    }
                }
            } else {
                $jsonArr [] = $array;
            }
        }
        //dump($jsonArr);exit;
        $this->assign ( 'json_arr', json_encode ( $jsonArr ) );
        return $typelist;
    }

    //归档
    function lookupProjectAtta(){
        $step=$_REQUEST['step'];
        $formtype=$_REQUEST['formtype'];
        if($step==2){
            $FileModel=M('mis_system_attach_file');
            $fileid=$_REQUEST['fileid'];
            $id=$_REQUEST['id'];
            if($fileid){
                //修改
                $map['id']=$fileid;
                $data['attachid']=$id;
                $data['orderno']=$_REQUEST['orderno'];
                $data['position']=$_REQUEST['position'];
                $data['page']=$_REQUEST['page'];
                $data['remark']=$_REQUEST['remark'];
                $data['formtype']=$_REQUEST['formtype'];
                $list=$FileModel->where($map)->save($data);
                if($list){
                    $this->success ( L('_SUCCESS_'));
                }
            }else{
                //新增
                $data['attachid']=$id;
                $data['orderno']=$_REQUEST['orderno'];
                $data['position']=$_REQUEST['position'];
                $data['page']=$_REQUEST['page'];
                $data['remark']=$_REQUEST['remark'];
                $data['formtype']=$_REQUEST['formtype'];
                $list=$FileModel->add($data);
                if($list){
                    $this->success ( L('_SUCCESS_'));
                }
            }
        }else{
            $id=$_REQUEST['id'];
            if($formtype==1){
                $MisAttachModel=D('MisProjectAttachedTemplateSub');
                $MisAttachViewModel=D('MisProjectAttachedTemplateSubView');
            }else{
                $MisAttachModel=D('MisProjectFlowForm');
                $MisAttachViewModel=D('MisProjectFlowFormView');
            }
            $list=$MisAttachViewModel->where(array('attachid'=>$id))->find();
            if($list){
                $vo=$list;
            }else{
                $vo=$MisAttachModel->where(array('id'=>$id))->find();
            }
            $this->assign('formtype',$formtype);
            $this->assign('vo',$vo);
            $this->display();
        }
    }
    //添加资料
    function lookupfileadd(){
        $step=$_REQUEST['step'];
        if($step==2){
            $MisProjectAttachedTemplateSubModel=D('MisProjectAttachedTemplateSub');
            $data['masid']=$_REQUEST['masid'];
            $data['name']=$_REQUEST['name'];
            $data['datum']=$_REQUEST['datum'];
            $data['remark']=$_REQUEST['remark'];
            $data['isfile']=1;
            $data['type']=-1;
            $list=$MisProjectAttachedTemplateSubModel->add($data);
            //	echo $MisProjectAttachedTemplateSubModel->getlastsql();
            if($list){
                $this->success ( L('_SUCCESS_'));
            }else{
                $this->error ( '操作失败');
            }
        }else{
            $projectid=$_REQUEST['projectid'];
            $projectworkid=$_REQUEST['projectworkid'];
            //查询是不是单据
            $MisProjectFlowFormModle=D('MisProjectFlowForm');
            $formList=$MisProjectFlowFormModle->where(array('id'=>$projectworkid))->find();
            if($projectworkid==null){
                $this->error ('请选择添加资料的任务');
                exit;
            }elseif($formList['formtype']==2){
                $this->error ('此任务为单据不能添加资料');
                exit;
            }else{
                $MisProjectAttachedTemplateModel=D('MisProjectAttachedTemplate');
                $list=$MisProjectAttachedTemplateModel->where(array('projectid'=>$projectid,'projectworkid'=>$projectworkid,'status'=>1))->find();
                if($list==null){
                    $this->error ('未找到附件模板');
                    exit;
                }else{
                    $this->assign('masid',$list['id']);
                    $this->display();
                }
            }
        }

    }

    //列表数据直接保存
    function lookupAlldataSave(){
        $FileModel=M('mis_system_attach_file');
        $fileid=$_REQUEST['fileid'];
        $id=$_REQUEST['id'];
        if($fileid){
            //修改
            $map['id']=$fileid;
            $data['attachid']=$id;
            $data['orderno']=$_REQUEST['orderno'];
            $data['position']=$_REQUEST['position'];
            $data['page']=$_REQUEST['page'];
            $data['remark']=$_REQUEST['remark'];
            $data['formtype']=$_REQUEST['formtype'];
            $list=$FileModel->where($map)->save($data);
        }else{
            //新增
            $data['attachid']=$id;
            $data['orderno']=$_REQUEST['orderno'];
            $data['position']=$_REQUEST['position'];
            $data['page']=$_REQUEST['page'];
            $data['remark']=$_REQUEST['remark'];
            $data['formtype']=$_REQUEST['formtype'];
            $list=$FileModel->add($data);
        }
        echo json_encode($list);
    }

    public function checkopinion(){

        //带有审批的任务模板
        $actemp = D("node")->where("isprocess=1 and isprojectwork=1 and status=1")->select();
        $actempnew = array();
        foreach($actemp as $k=>$v){
            $actempnew[] = $v['name'];
        }
        //所有任务
        $model = M("mis_project_flow_form");
        $map['status'] = array("eq",1);
        $map['formobj'] = array("neq",'');
        $tasklist = $model->where($map)->select();
        //有对应模板的任务【项目-阶段-节点-任务】
        $tasklistnew = array();
        echo count($tasklist);
        foreach($tasklist as $k=>$v){
            if((int)$v['formobj']<1){
                $tasklistnew[$v['projectid']][$v['category']][$v['parentid']][$v['id']] = $v['formobj'];
            }
        }
        dump($tasklistnew);
    }

    //审批文档节点
    function lookupapprove(){
        $projectid=$_REQUEST['id'];
        $typelist = $this->getApproveType ($projectid);
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        // 列表过滤器，生成查询Map对象
        $map['projectid']=$projectid;
        // 获取点击的类型
        $supcategory = $_REQUEST ['supcategory'] = $_REQUEST ['supcategory']?$_REQUEST ['supcategory']:0;
        if ($supcategory) {
            $map ['supcategory'] = $supcategory;
            $this->assign ( 'supcategory', $supcategory );
        }
        // 获取点击的阶段
        $category = $_REQUEST ['category'] = $_REQUEST ['category']?$_REQUEST ['category']:0;
        if ($category) {
            $map ['category'] = $category;
            $this->assign ( 'category', $category );
        }
        // 获取点击的节点
        $pid = $_REQUEST ['pid'] = $_REQUEST ['pid']?$_REQUEST ['pid']:0;
        if ($pid) {
            $map ['parentid'] = $pid;
        }
        // 树形结构默认选中
        $this->assign ( "ztreeid", $typelist [0] ['id'] );
        // 第一次进入，默认查询第一个类型下面的所有任务
        if (! $supcategory && ! $category) {
            $map ['supcategory'] = $typelist [0] ['default']['supcategory'];
            //$map ['parentid'] = $typelist [0] ['default']['pid'];
        }
        if(! $category){
            $map ['category'] = $typelist [1] ['default']['category'];
        }
        $map ['outlinelevel'] = 4; // 查询任务

        $map['formtype']=2;
        $map['status']=1;
        //查询带审批的任务
        $flowformList=$MisProjectFlowFormModel->where($map)->select();
        //echo $MisProjectFlowFormModel->getlastsql();
        $nodeModel=D('Node');
        foreach ($flowformList as $rek=>$rev){
            $nmap['status']=1;
            $nmap['name']=$rev['formobj'];
            $nmap['isprocess']=1;
            $nodeList=$nodeModel->where($nmap)->select();
            if(empty($nodeList)){
                unset($flowformList[$rek]);
            }
        }

        //查询每个任务下面的审批节点
        $processInfoModel=D('ProcessInfo');
        $processRelationModel=D('ProcessRelation');
        foreach ($flowformList as $fk=>$fv){
            $infoMap['status']=1;
            $infoMap['nodename']=$fv['formobj'];
            $infoMap['catgory']=1;
            $processInfoList=$processInfoModel->where($infoMap)->find();
            //	echo $processInfoModel->getlastsql();
            $relationMap['status']=1;
            $relationMap['tablename']='process_info';
            $relationMap['pinfoid']=$processInfoList['id'];
            $relationMap['flowtype']=2;
            $relationList=$processRelationModel->where($relationMap)->select();
            $flowformList[$fk]['relation']=$relationList;
        }
        $this->assign('flowformList',$flowformList);

        //dump($flowformList);
        if ($_REQUEST ['jump'] == "jump") {
            $this->display ( 'lookupapproveView' );
        } else {
            $this->display ();
        }

    }

    function lookupApproveAdd(){
        $name=$_REQUEST['name'];
        $document=$_REQUEST['document'];
        $processRelationModel=D('ProcessRelation');
        foreach ($name as $nk=>$nv){
            $map['id']=$nv;
            if(array_key_exists($nv, $document)){
                $data['document']=1;
            }else{
                $data['document']=0;
            }
            $list=$processRelationModel->where($map)->save($data);
        }
        $this->success ( L('_SUCCESS_'));
    }

    /**
     * @Title: export_word_one
     * @Description: todo(导出word方法  new)
     * @author xiayuqin
     * @date 2015-6-29 下午5:00:51
     * @throws
     */
    public function export_word_one(){
        set_time_limit(0);
        if($export){
            $export = $export;
        }else{
            if($_REQUEST['export']){
                $export = $_REQUEST['export'];
            }else{
                $export = 'word';
            }
        }
        if($export == 'swf'){ //在线查看最新版本
            $swfmap['modelid']=$_REQUEST['id'];
            $swfmap['modelname']=$_REQUEST['modelname'];
            $templateModel = M("mis_system_template_saveword");
            $newrs = $templateModel->where($swfmap)->order("id desc")->find();
            //echo $templateModel->getlastsql();
            //print_r($newrs);
            //$file_path = preg_replace("/^([\s\S]+)\/Public/", "__PUBLIC__", $rs['swfurl']);
            /* if(!empty($newrs)){
                $file_path = "/Public/".$newrs['swfurl'];//暂时修改，等保存路径正常后直接取路径
                if($newrs['swfurl']){
                    $this->assign("file_name", $newrs['filename']);
                    $this->assign("file_type", 'file');
                    $this->assign('file_path', $file_path);
                    $this->display("Public:playswf");
                    exit;
                }
            } */
        }
        //exit;
        if($_GET['istrue'] == 1){
            $map['id'] = $_REQUEST['fileid'];
            $templateModel = M("mis_system_template_saveword");
            $rs = $templateModel->where($map)->find();
            $filenameUTF8 = preg_replace("/^([\s\S]+)\/Public\//", "", $rs['fileurl']);
            $filenameUTF8 = PUBLIC_PATH.$filenameUTF8;
            header("Cache-Control: public");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".basename($filenameUTF8));
            header("Content-Transfer-Encoding:­ binary");
            header("Content-Length: " . filesize($filenameUTF8));
            readfile($filenameUTF8);
        }else{
            //获取文件数据ID，判定存入的表
            $id=$_REQUEST['id'];
            $modelname=$this->getActionName();
            //获取数据
            $saveWordId=$_REQUEST['fileid'];
            if($export == 'swf'){
                $id = $newrs['modelid'];
                $saveWordId = $newrs["id"];
            }
            if($saveWordId){
// 				$randtable="mis_system_template_saveword_list".(fmod($id,10)+1);
// 				$savewordListModel=M($randtable);
// 				$swlMap['modelid']=$id;
// 				$swlMap['modelname']=$modelname;
// 				$swlMap['savewordid']=$saveWordId;
// 				$swlList=$savewordListModel->where($swlMap)->field('listdata')->find();
// 				$list=unserialize($swlList['listdata']);
                $list=$this->lookupGetList($id);
            }else{
                //z这种情况主要处理内嵌表导出问题。内嵌表导出无版本控制
                //$list = $this->get_export_label($id,$modelname);
                $list=$this->lookupGetList($id);
                //判断当前模型是否存在流程
                $process_relation_formDao =M("process_relation_form");
                $where = array();
                $where['tablename'] = $modelname;
                $where['tableid'] = $id;
                $relation_formlist = $process_relation_formDao->where($where)->field("id,relationid,name")->select();
                if(count($relation_formlist)>0){
                    foreach ($relation_formlist as $rk=>$rv){
                        //查询节点下面的审批记录
                        $ProcessInfoHistoryModel=D('ProcessInfoHistory');
                        $HistoryMap['tableid']=$id;
                        $HistoryMap['tablename']=$modelname;
                        $HistoryMap['ostatus']=$rv['id'];
                        $Historyvo=$ProcessInfoHistoryModel->where($HistoryMap)->field('id,tableid,tablename,ostatus,dotime,doinfo,userid')->find();
                        $list[substr(md5($rv['relationid']."HS_name"),0,8)] = array('name'=>$biaoqian,'showname'=>'','original'=>'','value'=>$rv['name']);
                        $list[substr(md5($rv['relationid']."HS_doinfo"),0,8)] = array('name'=>$biaoqian,'showname'=>'','original'=>'','value'=>$Historyvo['doinfo']);
                        $list[substr(md5($rv['relationid']."HS_dotime"),0,8)] = array('name'=>$biaoqian,'showname'=>'','original'=>'','value'=>transTime($Historyvo['dotime'],'Y/m/d H:i'));
                        $list[substr(md5($rv['relationid']."HS_userid"),0,8)] = array('name'=>$biaoqian,'showname'=>'','original'=>'','value'=>getFieldBy($Historyvo['userid'], 'id', 'name', 'user'));
                    }
                }
            }
            //end  获取数据结束
            //模板标签文件地址
            $template_word = UPLOAD_SampleWord.$modelname.".docx";
            /**
             * 参数一、$list 导出的数据源
             * 参数二、模板标签文件地址
             */
            $this->export_Word($list,$template_word,false,$export);
        }
    }

    function lookupGetList($id){
        $projectid=$id;
        $MisAutoPvbModel=D('MisAutoPvb');
        $MisAutoEbmModel=D('MisAutoEbm');
        $MisAutoZlcModel=D('MisAutoZlc');
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        $ProcessInfoHistoryModel = D("ProcessInfoHistory");
        //查询项目基本信息
        $MisAutoPvbList=$MisAutoPvbModel->where(array('projectid'=>$projectid))->find();
        // 	  	$MisAutoEbmList=$MisAutoEbmModel->where(array('id'=>$projectid))->find();
        //通过项目编码去项目审核流程表查询基本信息、
        // 	  	$MisAutoPvbList=$MisAutoZlcModel->where(array('xiangmubianma'=>$MisAutoEbmList['orderno']))->find();
        $map['projectid']=$projectid;
        $map ['outlinelevel'] = 4; // 查询任务
        $map['formtype']=2;
        $map['status']=1;
        //查询带审批的任务
        $flowformList=$MisProjectFlowFormModel->where($map)->select();
        $nodeModel=D('Node');
        foreach ($flowformList as $rek=>$rev){
            $nmap['status']=1;
            $nmap['name']=$rev['formobj'];
            $nmap['isprocess']=1;
            $nodeList=$nodeModel->where($nmap)->select();
            if(empty($nodeList)){
                unset($flowformList[$rek]);
            }
        }

        //查询每个任务下面要导出的审批节点
        $processInfoModel=D('ProcessInfo');
        $processRelationModel=D('ProcessRelation');

        foreach ($flowformList as $fk=>$fv){
            //查询项目组
            $ManageModel=M('mis_project_flow_manager');
            $manMap['projectid']=$projectid;
            $manMap['suoshujiaose']=$fv['xiangmujuese'];
            $manList=$ManageModel->where($manMap)->find();
            $MisAutoAhmModel=D('MisAutoAhm');
            $ahmMap['orderno']=$manList['juese'];
            $ahmMap['status']=1;
            $ahmList=$MisAutoAhmModel->where($ahmMap)->find();
            //dump($MisAutoAhmModel->getlastsql());
            $infoMap['status']=1;
            $infoMap['nodename']=$fv['formobj'];
            $infoMap['catgory']=1;
            $processInfoList=$processInfoModel->where($infoMap)->find();
            if($processInfoList){
                $ahmListInfo[$ahmList['orderno']]=$ahmList;
                $relationMap['status']=1;
                $relationMap['tablename']='process_info';
                $relationMap['pinfoid']=$processInfoList['id'];
                $relationMap['flowtype']=2;
                $relationMap['document']=1;
                $relationInfo=$processRelationModel->where($relationMap)->select();
                foreach ($relationInfo as $key=>$val){
                    $relationInfo[$key]['xiangmuzu']=$ahmList['orderno'];
                }

                if(empty($relationList)){
                    $relationList=$relationInfo;
                }elseif ($relationInfo && $relationList){
                    $relationList=array_merge($relationList,$relationInfo);
                }

            }
        }
        //查询审核历史记录
        foreach($relationList as $relak=>$relav){
            $historyMap['ostatus']=$relav['id'];
            $historyMap['status']=1;
            $historyMap['projectid']=$projectid;
            $historyList = $ProcessInfoHistoryModel->where($historyMap)->order('createtime asc')->select();
            foreach ($historyList as $hk=>$hv){
                //dump(getHrInfo($hv['userid'],"dutyid"));
                $historyList[$hk]['dutyname']=getFieldBy(getHrInfo($hv['userid'],"dutyid"), 'id', 'name', 'MisSystemDuty');
                $historyList[$hk]['username']=getFieldBy($hv['userid'], 'id', 'name', 'user');
            }
            $relationList[$relak]['history']=$historyList;
        }

        foreach ($ahmListInfo as $ak=>$av){
            foreach ($relationList as $rk=>$rv){
                if($rv['xiangmuzu']==$av['orderno']){
                    $ahmListInfo[$ak]['relation'][]=$rv;
                }
            }
        }
        //	dump($ahmListInfo);
        //dump($MisAutoPvbList);

        $projectList=array();
        $EndList=array();
        $scdmodel = D ( 'SystemConfigDetail' );
        // 获取配置文件list.inc.php,方便下面数据进行转换
        $detailList = $scdmodel->getDetail ('MisAutoPvb', false );
        $xiangmumingchenArr = array('name'=>'xiangmumingchen','showname'=>'项目名称','original'=>$MisAutoPvbList['xiangmumingchen'],'value'=>$MisAutoPvbList['xiangmumingchen']);
        $data['xiangmumingchen']= $xiangmumingchenArr;
        $ordernoArr = array('name'=>'orderno','showname'=>'项目编码','original'=>$MisAutoPvbList['xiangmubianma'],'value'=>$MisAutoPvbList['xiangmubianma']);
        $data['orderno']= $ordernoArr;
        $shenqingrenArr = array('name'=>'shenqingren','showname'=>'申请人','original'=>$MisAutoPvbList['kehumingchen'],'value'=>getFieldBy($MisAutoPvbList['kehumingchen'],'orderno', 'kehumingchen', 'mis_auto_banmo'));
        $data['shenqingren']= $shenqingrenArr;
        $shenqingjineArr = array('name'=>'shenqingjine','showname'=>'申请金额','original'=>$MisAutoPvbList['shenqingjine'],'value'=>unitExchange($MisAutoPvbList['shenqingjine'],'yuan','yuan',3));
        $data['shenqingjine']= $shenqingjineArr;
        $shenqingqixianArr = array('name'=>'shenqingqixian','showname'=>'申请期限','original'=>$MisAutoPvbList['shenqingyewuqixian'],'value'=>unitExchange($MisAutoPvbList['shenqingyewuqixian'],'months','months',3));
        $data['shenqingqixian']= $shenqingqixianArr;
        $yewuleixingArr = array('name'=>'yewuleixing','showname'=>'业务类型','original'=>$MisAutoPvbList['yewuleixing'],'value'=>getFieldBy($MisAutoPvbList['yewuleixing'],'orderno', 'name', 'mis_system_flow_type'));
        $data['yewuleixing']= $yewuleixingArr;
        $farendaibiaoArr = array('name'=>'farendaibiao','showname'=>'法定代表人','original'=>$MisAutoPvbList['fadingdaibiaoren'],'value'=>$MisAutoPvbList['fadingdaibiaoren']);
        $data['farendaibiao']= $farendaibiaoArr;
        $xiangmuleixing=getFieldBy($MisAutoPvbList['xiangmuleixing'], 'orderno', 'name', 'mis_auto_ocqwl');
        if($xiangmuleixing=='续保'){
            $cunliangkehu='是';
        }else{
            $cunliangkehu='否';
        }
        $cunliangkehuArr = array('name'=>'cunliangkehu','showname'=>'存量客户','original'=>$MisAutoPvbList['xiangmuleixing'],'value'=>$cunliangkehu);
        $data['cunliangkehu']= $cunliangkehuArr;
        $year=numToCh(date('Y',time()),1);
        $moth=numToCh(date('m',time()),1);
        $day=numToCh(date('d',time()),1);
        $yearmouthArr = array('name'=>'yearmouth','showname'=>'年月日','original'=>time(),'value'=>$year.'年'.$moth.'月'.$day.'日');
        $data['yearmouth']= $yearmouthArr;
        $projectList=$data;


        foreach($ahmListInfo as $ahmk=>$ahmv){
            $fielename = substr(md5($ahmv['orderno']),0,8);
            $ahmArr = array('name'=>$fielename,'showname'=>$ahmv['name'],'original'=>$ahmv['orderno'],'value'=>$ahmv['name'],'parectid'=>0,'id'=>$ahmv['orderno']);
            $reldata=array();
            $ahmArr['childvalue'] = null;
            foreach ($ahmv['relation'] as $relk=>$relv){
                $relname = substr(md5('rela'.$relv['id']),0,8);
                $relArr = array('name'=>$relname,'showname'=>$relv['name'],'original'=>$relv['id'],'value'=>$relv['name'],'parectid'=>$relv['xiangmuzu'],'id'=>$relv['id']);
                $hisdata=array();
                $relArr['message'] = null;
                foreach ($relv['history'] as $hisk=>$hisv){
                    $hisname = substr(md5('hist'.$hisv['id']),0,8);
                    $hisArr = array('name'=>$hisname,'showname'=>$hisv['doinfo'],'original'=>$hisv['doinfo'],'value'=>$hisv['doinfo'],'parectid'=>$hisv['ostatus'],'username'=>$hisv['username'],'createtime'=>transTime($hisv['createtime'],'Y-m-d H:i'),'id'=>$hisv['id']);
                    $hisdata[]= $hisArr;
                    $relArr['message'][]=$hisArr;

                }
                $ahmArr['childvalue'][]= $relArr;
            }
            $ahmdata[$ahmk][]= $ahmArr;
        }
        $EndList[]=$projectList;
        $EndList[]=$ahmdata;
        import('@.ORG.PHPWord', '', $ext='.php');
        $obPHPWord = new PHPWord();
        $section = $obPHPWord->createSection();
        $styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
        $fontStyle = array('align'=>'center');
        $obPHPWord->addTableStyle('myOwnTableStyle', $styleTable);
        $table = $section->addTable('myOwnTableStyle');
        $cellStyle = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
        $table->addRow(800);
        $ywjianyijine=numToCh(str_replace('万元','',unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','wan',3)),0).'万元整';
        $table->addCell(10000,array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80,'gridSpan' => 3))->addText("建议金额:".$ywjianyijine." （小写：".unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','yuan',3)." ）");
        $table->addRow(800);
        $table->addCell(10000,array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80,'gridSpan' => 3))->addText("建议期限:".unitExchange($MisAutoPvbList['yewuyuanjianyiqixian'],'months','months',3));
        $max_col_num = 2;
        $count_row = 0;
        if($EndList[1]){
            foreach($EndList[1] as $k => $v){
                if($v[0]["childvalue"]){
                    foreach($v[0]["childvalue"] as $kk => $vv){
                        $table->addRow(4500);
                        $arr = array(array('vMerge' => 'restart'),array('vMerge' => 'fusion'),array('vMerge' => ''));
                        $newcellStyle = array();
                        if($kk==0){
                            $newcellStyle = array_merge($cellStyle,$arr[0]);
                            $table->addCell(1750,$newcellStyle)->addText($v[0]["showname"]);
                        }elseif($kk==count($v[0]["childvalue"])-1){
                            $newcellStyle = array_merge($cellStyle,$arr[2]);
                            $table->addCell(1750,$newcellStyle);
                        }else{
                            $newcellStyle = array_merge($cellStyle,$arr[1]);
                            $table->addCell(1750,$newcellStyle);
                        }

                        $table->addCell(100,$cellStyle)->addText($vv["showname"]);
                        $message = "";
                        $cell = $table->addCell(5000,$cellStyle);
                        if($vv["message"]){
                            foreach($vv["message"] as $kkk => $vvv){
                                if($kkk>0){
                                    $cell->addTextBreak();
                                }
                                $cell->addText($vvv["value"]);
                                $cell->addText($vvv["username"]);
                                $cell->addText(date("Y年m月d日",strtotime($vvv["createtime"])));
                                $cell->addTextBreak();
                            }
                        }
                    }
                }else{
                    $table->addRow(4500);
                    $table->addCell(1750,$cellStyle)->addText($v[0]["showname"]);
                    $table->addCell(1750,$cellStyle);
                    $table->addCell(1750,$cellStyle);
                }
            }
        }
        $objWriter = PHPWord_IOFactory::createWriter($obPHPWord, 'Word2007');
        $sTableText = $objWriter->getWriterPart('document')->getObjectAsText($table);
        $EndList[0]["newTab"] = array(
            'name'=>'newTab',
            'showname'=>'表格',
            'original'=>$sTableText,
            'value'=>$sTableText
        );
        return $EndList[0];
    }


    /**
     * @Title: lookupexport
     * @Description: todo(导出项目审批意见，此方法目前乃定制)
     * @author liminggang
     * @date 2015-10-18 下午2:05:07
     * @throws
     */
    public function lookupexport(){
        //获取项目ID
        $projectid=$_REQUEST['id'];
        $MisAutoPvbModel=D('MisAutoPvb');
        //查询项目基本信息
        $MisAutoPvbList=$MisAutoPvbModel->where(array('projectid'=>$projectid))->find();

        $data = array();
        //组合其他信息数据
        $data['zhuti'] = array('name'=>'zhuti','showname'=>'客户类型','original'=>$MisAutoPvbList['zhuti'],'value'=>getFieldBy($MisAutoPvbList['zhuti'],'orderno', 'name', 'MisSaleClientType'));
        $data['xiangmumingchen'] = array('name'=>'xiangmumingchen','showname'=>'项目名称','original'=>$MisAutoPvbList['xiangmumingchen'],'value'=>$MisAutoPvbList['xiangmumingchen']);
        $data['orderno'] = array('name'=>'orderno','showname'=>'项目编码','original'=>$MisAutoPvbList['xiangmubianma'],'value'=>$MisAutoPvbList['xiangmubianma']);
        $data['shenqingren'] = array('name'=>'shenqingren','showname'=>'申请人','original'=>$MisAutoPvbList['kehumingchen'],'value'=>getFieldBy($MisAutoPvbList['kehumingchen'],'orderno', 'kehumingchen', 'mis_auto_banmo'));
        $data['shenqingjine'] = array('name'=>'shenqingjine','showname'=>'申请金额','original'=>$MisAutoPvbList['shenqingjine'],'value'=>unitExchange($MisAutoPvbList['shenqingjine'],'yuan','yuan',3));
        $data['shenqingqixian'] = array('name'=>'shenqingqixian','showname'=>'申请期限','original'=>$MisAutoPvbList['shenqingyewuqixian'],'value'=>unitExchange($MisAutoPvbList['shenqingyewuqixian'],'months','months',3));
        $data['yewuleixing'] = array('name'=>'yewuleixing','showname'=>'业务类型','original'=>$MisAutoPvbList['yewuleixing'],'value'=>getFieldBy($MisAutoPvbList['yewuleixing'],'orderno', 'name', 'mis_system_flow_type'));
        $data['farendaibiao'] = array('name'=>'farendaibiao','showname'=>'法定代表人','original'=>$MisAutoPvbList['fadingdaibiaoren'],'value'=>$MisAutoPvbList['fadingdaibiaoren']);
        $data['daikuanyongtumiaoshu'] = array('name'=>'daikuanyongtumiaoshu','showname'=>'备注','original'=>$MisAutoPvbList['daikuanyongtumiaoshu'],'value'=>$MisAutoPvbList['daikuanyongtumiaoshu']);
        $xiangmuleixing=getFieldBy($MisAutoPvbList['xiangmuleixing'], 'orderno', 'name', 'mis_auto_ocqwl');
        if($xiangmuleixing=='续保'){
            $cunliangkehu='是';
        }else{
            $cunliangkehu='否';
        }
        $data['cunliangkehu'] = array('name'=>'cunliangkehu','showname'=>'存量客户','original'=>$MisAutoPvbList['xiangmuleixing'],'value'=>$cunliangkehu);
        $year=numToCh(date('Y',time()),1);
        $moth=numToCh(date('m',time()),1);
        $day=numToCh(date('d',time()),1);
        $data['yearmouth'] = array('name'=>'yearmouth','showname'=>'年月日','original'=>time(),'value'=>$year.'年'.$moth.'月'.$day.'日');

        $ywjianyijine=numToCh(str_replace('万元','',unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','wan',3)),0).'万元整';
        $data['ywjianyijine'] = array('name'=>'ywjianyijine','showname'=>'建议金额','original'=>$ywjianyijine." （小写：".unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','wan',3)." ）",'value'=>$ywjianyijine." （小写：".unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','wan',3)." ）");
        $data['ywjianyiqixian'] = array('name'=>'ywjianyiqixian','showname'=>'建议期限','original'=>unitExchange($MisAutoPvbList['yewuyuanjianyiqixian'],'months','months',3),'value'=>unitExchange($MisAutoPvbList['yewuyuanjianyiqixian'],'months','months',3));
        //"建议金额:".$ywjianyijine." （小写：".unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','yuan',3)." ）";
        //$data['ywjianyijine'] = "建议期限:".unitExchange($MisAutoPvbList['yewuyuanjianyiqixian'],'months','months',3);
        //项目付掉
        $data['fudiao'] = array('name'=>'fudiao','showname'=>'辅调','original'=>$MisAutoPvbList['fudiao'],'value'=>getFieldBy($MisAutoPvbList['fudiao'], 'id', 'name', 'user'));
        $data['danbaojiekuanleixing'] = array('name'=>'danbaojiekuanleixing','showname'=>'担保借款类型','original'=>$MisAutoPvbList['danbaojiekuanleixing'],'value'=>getFieldBy($MisAutoPvbList['danbaojiekuanleixing'], 'orderno', 'name', 'MisAutoJgp'));
        $data['chanpinleixing'] = array('name'=>'chanpinleixing','showname'=>'产品类型','original'=>$MisAutoPvbList['chanpinleixing'],'value'=>getFieldBy($MisAutoPvbList['chanpinleixing'], 'orderno', 'name', 'MisAutoRpx'));

        /*
         * 构建专家评审会信息
         */
        $mis_auto_dzzvnDao = M("mis_auto_dzzvn");
        $where = array();
        $where['xiangmubianma'] = $MisAutoPvbList['orderno'];
        $where['pingshenhuileixing'] = 2;//专家评审会
        $list = $mis_auto_dzzvnDao->where($where)->order('id desc')->find();

        $data['pingshenhuishijian'] = array('name'=>'pingshenhuishijian','showname'=>'','original'=>transTime($list['pingshenshijian'],"Y年m月d日"),'value'=>transTime($list['pingshenshijian'],"Y年m月d日"));
        $data['zhaojidanhao'] = array('name'=>'zhaojidanhao','showname'=>'','original'=>$list['zhaojimingchen'],'value'=>$list['zhaojimingchen']);
        $data['pingshenyijian'] = array('name'=>'pingshenyijian','showname'=>'','original'=>$list['pingshenyijian'],'value'=>getSelectlistValue($list['pingshenyijian'],"AppraisalOpinion"));
        $data['jianyijine'] = array('name'=>'jianyijine','showname'=>'','original'=>$list['jianyijine'],'value'=>unitExchange($list['jianyijine'],'yuan','wan',3));
        $data['jianyiqixian'] = array('name'=>'jianyiqixian','showname'=>'','original'=>$list['jianyiqixian'],'value'=>unitExchange($list['jianyiqixian'],'months','months',3));
        //构建结束

        //---------------------------下面组合审批意见----------------------------

        //获取业务尽职调查审批信息
        /*
         * 1、获取业务尽职调查制单人，
        * 2、获取业务尽职调查部门负责人意见
        * 3、获取业务尽职调查分管领导意见
        */
        $map = array();
        $map['tablename'] = "MisAutoJck";
        $map['projectid'] = $projectid;
        $map['doing'] = 1;
        //实例化表单流程节点表
        $processRelationModel=D('process_relation_form');
        $relationlist = array();
        $relationlist = $processRelationModel->where($map)->select();
        $arr = array();
        //部门负责人意见
        foreach($relationlist as $kkk=>$vvv){
            if($vvv['name']=="业务部门负责人审批"){
                $arr[$vvv['id']] = "jzdcfzren";
                continue;
            }
            if($vvv['name']=="业务分管领导审核"){
                $arr[$vvv['id']] = "jzdcfgld";
                continue;
            }
        }
        //查询历史记录
        $ProcessInfoHistoryModel = D("ProcessInfoHistory");
        $historylist = array();
        $map = array();
        $map['tablename'] = "MisAutoJck";
        $map['projectid'] = $projectid;
        $historylist = $ProcessInfoHistoryModel->where($map)->select();
        $i = 1;
        foreach($historylist as $key1=>$val1){
            if($val1['dotype'] == 2){
                //流程启动人节点意见
                $data["jzdccreatedoinfo"] = array('name'=>"jzdccreatedoinfo",'showname'=>'','original'=>'','value'=>$val1['doinfo']);
                $data["jzdccreatedotime"] = array('name'=>"jzdccreatedotime",'showname'=>'','original'=>'','value'=>transTime($val1['dotime'],'Y/m/d H:i'));
                $data["jzdccreatedouserid"] = array('name'=>"jzdccreatedouserid",'showname'=>'','original'=>'','value'=>getFieldBy($val1['userid'], 'id', 'name', 'user'));
                continue;
            }
            //部门负责人意见 和 分管领导意见
            if($arr[$val1['ostatus']]){
                //流程启动人节点意见
                $data["{$arr[$val1['ostatus']]}doinfo{$i}"] = array('name'=>"{$arr[$val1['ostatus']]}doinfo{$i}",'showname'=>'','original'=>'','value'=>$val1['doinfo']);
                $data["{$arr[$val1['ostatus']]}dotime{$i}"] = array('name'=>"{$arr[$val1['ostatus']]}dotime{$i}",'showname'=>'','original'=>'','value'=>transTime($val1['dotime'],'Y/m/d H:i'));
                $data["{$arr[$val1['ostatus']]}douserid{$i}"] = array('name'=>"{$arr[$val1['ostatus']]}douserid{$i}",'showname'=>'','original'=>'','value'=>getFieldBy($val1['userid'], 'id', 'name', 'user'));
                continue;
            }
        }

        /*
         * 风险控制部
        */
        $map = array();
        $map['tablename'] = "MisAutoMcy";
        $map['projectid'] = $projectid;
        $map['doing'] = 1;
        //实例化表单流程节点表
        $relationlist = array();
        $relationlist = $processRelationModel->where($map)->select();
        $arr = array();
        foreach($relationlist as $kkkk=>$vvvv){
            if($vvvv['name']=="部门经理审批"){
                $arr[$vvvv['id']] = "fxkzfzren";
                continue;
            }
            if($vvvv['name']=="风控分管领导审批"){
                $arr[$vvvv['id']] = "fxkzfgld";
                continue;
            }
        }
        //查询历史记录
        $historylist = array();
        $map = array();
        $map['tablename'] = "MisAutoMcy";
        $map['projectid'] = $projectid;
        $historylist = $ProcessInfoHistoryModel->where($map)->select();
        $i = 1;
        foreach($historylist as $key2=>$val2){
            if($val2['dotype'] == 2){
                //流程启动人节点意见
                $data["fxkzcreatedoinfo"] = array('name'=>"fxkzcreatedoinfo",'showname'=>'','original'=>'','value'=>$val2['doinfo']);
                $data["fxkzcreatedotime"] = array('name'=>"fxkzcreatedotime",'showname'=>'','original'=>'','value'=>transTime($val2['dotime'],'Y/m/d H:i'));
                $data["fxkzcreatedouserid"] = array('name'=>"fxkzcreatedouserid",'showname'=>'','original'=>'','value'=>getFieldBy($val2['userid'], 'id', 'name', 'user'));
                continue;
            }
            //部门负责人意见 和 分管领导意见
            if($arr[$val2['ostatus']]){
                //流程启动人节点意见
                $data["{$arr[$val2['ostatus']]}doinfo{$i}"] = array('name'=>"{$arr[$val2['ostatus']]}doinfo{$i}",'showname'=>'','original'=>'','value'=>$val2['doinfo']);
                $data["{$arr[$val2['ostatus']]}dotime{$i}"] = array('name'=>"{$arr[$val2['ostatus']]}dotime{$i}",'showname'=>'','original'=>'','value'=>transTime($val2['dotime'],'Y/m/d H:i'));
                $data["{$arr[$val2['ostatus']]}douserid{$i}"] = array('name'=>"{$arr[$val2['ostatus']]}douserid{$i}",'showname'=>'','original'=>'','value'=>getFieldBy($val2['userid'], 'id', 'name', 'user'));
                continue;
            }
        }
        /*
         * 风险项目评审
         * MisAutoXco
         */
        $MisAutoXcoDao = D("MisAutoXco");
        //查询项目基本信息
        $MisAutoXcoList=$MisAutoXcoDao->where(array('projectid'=>$projectid))->find();
        //风险项目纪要编号
        $data['fengxianxiangmuhuiyi'] = array('name'=>'fengxianxiangmuhuiyi','showname'=>'','original'=>$MisAutoXcoList['fengxianxiangmuhuiyi'],'value'=>$MisAutoXcoList['fengxianxiangmuhuiyi']);
        $data['pingshenjine'] = array('name'=>'pingshenjine','showname'=>'','original'=>$MisAutoXcoList['pingshenjine'],'value'=>unitExchange($MisAutoXcoList['pingshenjine'],'yuan','wan',3));
        $data['pingshenqixian'] = array('name'=>'pingshenqixian','showname'=>'','original'=>$MisAutoXcoList['pingshenqixian'],'value'=>unitExchange($MisAutoXcoList['pingshenqixian'],'months','months',3));
        $data['fengxianpingshenjieg']= array('name'=>'fengxianpingshenjieg','showname'=>'','original'=>$MisAutoXcoList['fengxianpingshenjieg'],'value'=>$MisAutoXcoList['fengxianpingshenjieg']);
        $data['fengxiandanbaojiekuanleixing'] = array('name'=>'fengxiandanbaojiekuanleixing','showname'=>'担保借款类型','original'=>$MisAutoXcoList['danbaojiekuanleixing'],'value'=>getFieldBy($MisAutoXcoList['danbaojiekuanleixing'], 'orderno', 'name', 'MisAutoJgp'));
        /*
         * 批复审批意见
        * MisAutoDap
        */
        $map = array();
        $map['tablename'] = "MisAutoDap";
        $map['projectid'] = $projectid;
        $map['doing'] = 1;
        //实例化表单流程节点表
        $relationlist = array();
        $relationlist = $processRelationModel->where($map)->select();
        $arr = array();
        //部门负责人意见
        foreach($relationlist as $kk=>$vv){
            if($vv['name']=="业务员确认批复"){
                $arr[$vv['id']] = "pifufzren";
                continue;
            }
            if($vv['name']=="批复核稿"){
                $arr[$vv['id']] = "pifuhegao";
                continue;
            }
            if($vv['name']=="总经理审核批复"){
                $arr[$vv['id']] = "pifuzongjl";
                continue;
            }
            if($vv['name']=="董事长审核批复"){
                $arr[$vv['id']] = "pifudongshiz";
                continue;
            }
        }
        //查询历史记录
        $map = array();
        $map['tablename'] = "MisAutoDap";
        $map['projectid'] = $projectid;
        $historylist = $ProcessInfoHistoryModel->where($map)->select();
        $i = 1;
        foreach($historylist as $key=>$val){
            /* if($val['dotype'] == 2){
                //流程启动人节点意见
                $data["fxkzcreatedoinfo"] = array('name'=>"fxkzcreatedoinfo",'showname'=>'','original'=>'','value'=>$val['doinfo']);
                $data["fxkzcreatedotime"] = array('name'=>"fxkzcreatedotime",'showname'=>'','original'=>'','value'=>transTime($val['dotime'],'Y/m/d H:i'));
                $data["fxkzcreatedouserid"] = array('name'=>"fxkzcreatedouserid",'showname'=>'','original'=>'','value'=>getFieldBy($val['userid'], 'id', 'name', 'user'));
                continue;
            } */
            //部门负责人意见 和 分管领导意见
            if($arr[$val['ostatus']]){
                //流程启动人节点意见
                $data["{$arr[$val['ostatus']]}doinfo{$i}"] = array('name'=>"{$arr[$val['ostatus']]}doinfo{$i}",'showname'=>'','original'=>'','value'=>$val['doinfo']);
                $data["{$arr[$val['ostatus']]}dotime{$i}"] = array('name'=>"{$arr[$val['ostatus']]}dotime{$i}",'showname'=>'','original'=>'','value'=>transTime($val['dotime'],'Y/m/d H:i'));
                $data["{$arr[$val['ostatus']]}douserid{$i}"] = array('name'=>"{$arr[$val['ostatus']]}douserid{$i}",'showname'=>'','original'=>'','value'=>getFieldBy($val['userid'], 'id', 'name', 'user'));
                continue;
            }
        }
        if($MisAutoPvbList['yewuleixing']=="01" || $MisAutoPvbList['yewuleixing']=="02"){
            //1、信用担保（普通类）、委托贷款
            $template_word = UPLOAD_SampleWord."/MisSalesMyProject1.docx";
        }else if ($MisAutoPvbList['yewuleixing']=="08"){
            //2、信用担保（小微类）
            $template_word = UPLOAD_SampleWord."/MisSalesMyProject2.docx";
        }else if (in_array($MisAutoPvbList['yewuleixing'], array('13','11','10'))){
            //3风险业务类
            $template_word = UPLOAD_SampleWord."/MisSalesMyProjectfengxianyewulei.docx";
        }else{
            //3、其他业务线
            $template_word = UPLOAD_SampleWord."/MisSalesMyProject.docx";
        }//print_r($data);echo 23; echo $template_word;echo 333;exit;
        //执行导出
        $this->export_Word($data,$template_word,false);
    }

    //导出审批意见
    function lookupexportold(){
        $projectid=$_REQUEST['id'];
        $MisAutoPvbModel=D('MisAutoPvb');
        //$MisAutoEbmModel=D('MisAutoEbm');
        //$MisAutoZlcModel=D('MisAutoZlc');
        $MisProjectFlowFormModel=D('MisProjectFlowForm');
        $ProcessInfoHistoryModel = D("ProcessInfoHistory");
        //查询项目基本信息
        $MisAutoPvbList=$MisAutoPvbModel->where(array('projectid'=>$projectid))->find();
// 	  	$MisAutoEbmList=$MisAutoEbmModel->where(array('id'=>$projectid))->find();
        //通过项目编码去项目审核流程表查询基本信息、
// 	  	$MisAutoPvbList=$MisAutoZlcModel->where(array('xiangmubianma'=>$MisAutoEbmList['orderno']))->find();
        $map['projectid']=$projectid;
        $map ['outlinelevel'] = 4; // 查询任务
        $map['formtype']=2;
        $map['status']=1;
        //查询带审批的任务
        $flowformList=$MisProjectFlowFormModel->where($map)->select();

        $nodeModel=D('Node');
        foreach ($flowformList as $rek=>$rev){
            $nmap['status']=1;
            $nmap['name']=$rev['formobj'];
            $nmap['isprocess']=1;
            $nodeList=$nodeModel->where($nmap)->select();
            if(empty($nodeList)){
                unset($flowformList[$rek]);
            }
        }

        //查询每个任务下面要导出的审批节点
        $processInfoModel=D('process_info_form');
        $processRelationModel=D('process_relation_form');
        //查询项目人员
        $ManageModel=M('mis_project_flow_manager');
        //项目组
        $MisAutoAhmModel=D('MisAutoAhm');

        foreach ($flowformList as $fk=>$fv){

            $manMap['projectid']=$projectid;
            $manMap['suoshujiaose']=$fv['xiangmujuese'];
            $manList=$ManageModel->where($manMap)->find();

            $ahmMap['orderno']=$manList['juese'];
            $ahmMap['status']=1;
            $ahmList=$MisAutoAhmModel->where($ahmMap)->find();

            $ahmListInfo[$ahmList['orderno']]=$ahmList;

            //查询流程节点表
            $relationMap['tablename']=$fv['formobj'];
            $relationMap['flowtype']=2;
            $relationMap['document']=1;
            $relationMap['projectid']=$projectid;
            $relationInfo=$processRelationModel->where($relationMap)->select();
            foreach ($relationInfo as $key=>$val){
                $relationInfo[$key]['xiangmuzu']=$ahmList['orderno'];
            }

            if(empty($relationList)){
                $relationList=$relationInfo;
            }elseif ($relationInfo && $relationList){
                $relationList=array_merge($relationList,$relationInfo);
            }


            //dump($MisAutoAhmModel->getlastsql());
// 			$infoMap['status']=1;
// 			$infoMap['tablename']=$fv['formobj'];
// 			$infoMap['catgory']=1;
// 			$processInfoList=$processInfoModel->where($infoMap)->find();
// 			if($processInfoList){
// 				$ahmListInfo[$ahmList['orderno']]=$ahmList;
// 				$relationMap['status']=1;
// 				$relationMap['tablename']='process_info';
// 				$relationMap['pinfoid']=$processInfoList['id'];
// 				$relationMap['flowtype']=2;
// 				$relationMap['document']=1;
// 				$relationInfo=$processRelationModel->where($relationMap)->select();
// 				foreach ($relationInfo as $key=>$val){
// 					$relationInfo[$key]['xiangmuzu']=$ahmList['orderno'];
// 				}
// 				if(empty($relationList)){
// 					$relationList=$relationInfo;
// 				}elseif ($relationInfo && $relationList){
// 					$relationList=array_merge($relationList,$relationInfo);
// 				} 	
// 			}
        }
        //查询审核历史记录
        foreach($relationList as $relak=>$relav){
            $historyMap['ostatus']=$relav['id'];
            $historyMap['status']=1;
            $historyMap['projectid']=$projectid;
            $historyList = $ProcessInfoHistoryModel->where($historyMap)->order('createtime asc')->select();
            foreach ($historyList as $hk=>$hv){
                $historyList[$hk]['dutyname']=getFieldBy(getHrInfo($hv['userid'],"dutyid"), 'id', 'name', 'MisSystemDuty');
                $historyList[$hk]['username']=getFieldBy($hv['userid'], 'id', 'name', 'user');
            }
            $relationList[$relak]['history']=$historyList;
        }

        foreach ($ahmListInfo as $ak=>$av){
            foreach ($relationList as $rk=>$rv){
                if($rv['xiangmuzu']==$av['orderno']){
                    $ahmListInfo[$ak]['relation'][]=$rv;
                }
            }
        }

        $projectList=array();
        $EndList=array();
        $scdmodel = D ( 'SystemConfigDetail' );
        // 获取配置文件list.inc.php,方便下面数据进行转换
        $detailList = $scdmodel->getDetail ('MisAutoPvb', false );
        $xiangmumingchenArr = array('name'=>'xiangmumingchen','showname'=>'项目名称','original'=>$MisAutoPvbList['xiangmumingchen'],'value'=>$MisAutoPvbList['xiangmumingchen']);
        $data['xiangmumingchen']= $xiangmumingchenArr;
        $ordernoArr = array('name'=>'orderno','showname'=>'项目编码','original'=>$MisAutoPvbList['xiangmubianma'],'value'=>$MisAutoPvbList['xiangmubianma']);
        $data['orderno']= $ordernoArr;
        $shenqingrenArr = array('name'=>'shenqingren','showname'=>'申请人','original'=>$MisAutoPvbList['kehumingchen'],'value'=>getFieldBy($MisAutoPvbList['kehumingchen'],'orderno', 'kehumingchen', 'mis_auto_banmo'));
        $data['shenqingren']= $shenqingrenArr;
        $shenqingjineArr = array('name'=>'shenqingjine','showname'=>'申请金额','original'=>$MisAutoPvbList['shenqingjine'],'value'=>unitExchange($MisAutoPvbList['shenqingjine'],'yuan','yuan',3));
        $data['shenqingjine']= $shenqingjineArr;
        $shenqingqixianArr = array('name'=>'shenqingqixian','showname'=>'申请期限','original'=>$MisAutoPvbList['shenqingyewuqixian'],'value'=>unitExchange($MisAutoPvbList['shenqingyewuqixian'],'months','months',3));
        $data['shenqingqixian']= $shenqingqixianArr;
        $yewuleixingArr = array('name'=>'yewuleixing','showname'=>'业务类型','original'=>$MisAutoPvbList['yewuleixing'],'value'=>getFieldBy($MisAutoPvbList['yewuleixing'],'orderno', 'name', 'mis_system_flow_type'));
        $data['yewuleixing']= $yewuleixingArr;
        $farendaibiaoArr = array('name'=>'farendaibiao','showname'=>'法定代表人','original'=>$MisAutoPvbList['fadingdaibiaoren'],'value'=>$MisAutoPvbList['fadingdaibiaoren']);
        $data['farendaibiao']= $farendaibiaoArr;
        $xiangmuleixing=getFieldBy($MisAutoPvbList['xiangmuleixing'], 'orderno', 'name', 'mis_auto_ocqwl');
        if($xiangmuleixing=='续保'){
            $cunliangkehu='是';
        }else{
            $cunliangkehu='否';
        }
        $cunliangkehuArr = array('name'=>'cunliangkehu','showname'=>'存量客户','original'=>$MisAutoPvbList['xiangmuleixing'],'value'=>$cunliangkehu);
        $data['cunliangkehu']= $cunliangkehuArr;
        $year=numToCh(date('Y',time()),1);
        $moth=numToCh(date('m',time()),1);
        $day=numToCh(date('d',time()),1);
        $yearmouthArr = array('name'=>'yearmouth','showname'=>'年月日','original'=>time(),'value'=>$year.'年'.$moth.'月'.$day.'日');
        $data['yearmouth']= $yearmouthArr;
        $projectList=$data;


        foreach($ahmListInfo as $ahmk=>$ahmv){
            $fielename = substr(md5($ahmv['orderno']),0,8);
            $ahmArr = array('name'=>$fielename,'showname'=>$ahmv['name'],'original'=>$ahmv['orderno'],'value'=>$ahmv['name'],'parectid'=>0,'id'=>$ahmv['orderno']);
            $reldata=array();
            $ahmArr['childvalue'] = null;
            foreach ($ahmv['relation'] as $relk=>$relv){
                $relname = substr(md5('rela'.$relv['id']),0,8);
                $relArr = array('name'=>$relname,'showname'=>$relv['name'],'original'=>$relv['id'],'value'=>$relv['name'],'parectid'=>$relv['xiangmuzu'],'id'=>$relv['id']);
                $hisdata=array();
                $relArr['message'] = null;
                foreach ($relv['history'] as $hisk=>$hisv){
                    $hisname = substr(md5('hist'.$hisv['id']),0,8);
                    $hisArr = array('name'=>$hisname,'showname'=>$hisv['doinfo'],'original'=>$hisv['doinfo'],'value'=>$hisv['doinfo'],'parectid'=>$hisv['ostatus'],'username'=>$hisv['username'],'createtime'=>transTime($hisv['createtime'],'Y-m-d H:i'),'id'=>$hisv['id']);
                    $hisdata[]= $hisArr;
                    $relArr['message'][]=$hisArr;

                }
                $ahmArr['childvalue'][]= $relArr;
            }
            $ahmdata[$ahmk][]= $ahmArr;
        }
        $EndList[]=$projectList;
        $EndList[]=$ahmdata;
        import('@.ORG.PHPWord', '', $ext='.php');
        $obPHPWord = new PHPWord();
        $section = $obPHPWord->createSection();
        $styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
        $fontStyle = array('align'=>'center');
        $obPHPWord->addTableStyle('myOwnTableStyle', $styleTable);
        $table = $section->addTable('myOwnTableStyle');
        $cellStyle = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
        $table->addRow(800);
        $ywjianyijine=numToCh(str_replace('万元','',unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','wan',3)),0).'万元整';
        $table->addCell(10000,array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80,'gridSpan' => 3))->addText("建议金额:".$ywjianyijine." （小写：".unitExchange($MisAutoPvbList['yewuyuanjianyijine'],'yuan','yuan',3)." ）");
        $table->addRow(800);
        $table->addCell(10000,array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80,'gridSpan' => 3))->addText("建议期限:".unitExchange($MisAutoPvbList['yewuyuanjianyiqixian'],'months','months',3));
        $max_col_num = 2;
        $count_row = 0;
        if($EndList[1]){
            foreach($EndList[1] as $k => $v){
                if($v[0]["childvalue"]){
                    foreach($v[0]["childvalue"] as $kk => $vv){
                        $table->addRow(4500);
                        $arr = array(array('vMerge' => 'restart'),array('vMerge' => 'fusion'),array('vMerge' => ''));
                        $newcellStyle = array();
                        if($kk==0){
                            $newcellStyle = array_merge($cellStyle,$arr[0]);
                            $table->addCell(1750,$newcellStyle)->addText($v[0]["showname"]);
                        }elseif($kk==count($v[0]["childvalue"])-1){
                            $newcellStyle = array_merge($cellStyle,$arr[2]);
                            $table->addCell(1750,$newcellStyle);
                        }else{
                            $newcellStyle = array_merge($cellStyle,$arr[1]);
                            $table->addCell(1750,$newcellStyle);
                        }

                        $table->addCell(100,$cellStyle)->addText($vv["showname"]);
                        $message = "";
                        $cell = $table->addCell(5000,$cellStyle);
                        if($vv["message"]){
                            foreach($vv["message"] as $kkk => $vvv){
                                if($kkk>0){
                                    $cell->addTextBreak();
                                }
                                $cell->addText($vvv["value"]);
                                $cell->addText($vvv["username"]);
                                $cell->addText(date("Y年m月d日",strtotime($vvv["createtime"])));
                                $cell->addTextBreak();
                            }
                        }
                    }
                }else{
                    $table->addRow(4500);
                    $table->addCell(1750,$cellStyle)->addText($v[0]["showname"]);
                    $table->addCell(1750,$cellStyle);
                    $table->addCell(1750,$cellStyle);
                }
            }
        }
        $objWriter = PHPWord_IOFactory::createWriter($obPHPWord, 'Word2007');
        $sTableText = $objWriter->getWriterPart('document')->getObjectAsText($table);
        $EndList[0]["newTab"] = array(
            'name'=>'newTab',
            'showname'=>'表格',
            'original'=>$sTableText,
            'value'=>$sTableText
        );

        $template_word = UPLOAD_SampleWord."/MisSalesMyProject.docx";
        $this->export_Word($EndList[0],$template_word,false);
    }

    private function getApproveType($projectid) {
        $MisSystemFlowTypeDao = M ( "mis_project_flow_type" );
        $where ['status'] = 1;
        $where ['projectid'] = $projectid;
        $typelist = $MisSystemFlowTypeDao->order("sort asc")->where ( $where )->select ();
        // 任务节点
        $MisSystemFlowFormDao = M ( "mis_project_flow_form" );
        $where ['outlinelevel'] = 3;
        $formlist = $MisSystemFlowFormDao->order("sort asc")->where ( $where )->select ();

        $supcategory = 0;
        $jsonArr = array ();
        foreach ( $typelist as $key => $val ) {
            // 递归获取最小一层类型
            $supcategory = $this->abc ( $typelist, $val ['id'] );

            $typelist [$key] ['default']['supcategory'] = $supcategory;
            $array = array ();
            $array ['id'] = $val ['id'];
            $array ['name'] = missubstr($val['name'],18,true);
            $array ['title'] = $val ['name'];
            $array ['pId'] = $val ['parentid'];
            $array ['open'] = true;
            $array ['url'] = "__URL__/lookupapprove/jump/jump/supcategory/" . $supcategory."/category/0/pid/0/id/".$projectid;
            $array ['rel'] = "lookupapprove";
            $array ['type'] = 'post';
            $array ['target'] = 'ajax';
            // 阶段
            if ($val ['outlinelevel'] == 2) {
                $typelist [$key] ['default']['category'] = $val ['id'];
                $array ['url'] = "__URL__/lookupapprove/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/0/id/".$projectid;
                $array ['rel'] = "lookupapprove";
                $array ['type'] = 'post';
                $array ['target'] = 'ajax';
                $jsonArr [] = $array;
                //节点
                /* foreach ( $formlist as $k => $v ) {
                    if ($val ['id'] == $v ['category']) {
                        $typelist [$key] ['default']['category'] = $val ['id'];
                        $typelist [$key] ['default']['pid'] = $v ['id'];
                        $typelist [$key] ['default']['id'] = $projectid;
                        $array = array ();
                        $array ['id'] = "999999" . $v ['id'];
                        $array ['name'] = missubstr($v['name'],18,true);
                        $array ['title'] = $v ['name'];
                        $array ['pId'] = $val ['id'];
                        $array ['url'] = "__URL__/lookupapproveView/jump/jump/supcategory/" .$val['parentid']."/category/" . $val ['id']."/pid/" . $v ['id']."/id/".$projectid;
                        $array ['rel'] = "lookupapprove";
                        $array ['type'] = 'post';
                        $array ['target'] = 'ajax';
                        $jsonArr [] = $array;
                    }
                } */
            } else {
                $jsonArr [] = $array;
            }
        }
        $this->assign ( 'json_arr', json_encode ( $jsonArr ) );
        return $typelist;
    }
    function changeRoleOnlyOne(){
        $id = $_REQUEST['id'];
        $name = 'MisAutoPvb';//$this->getActionName();
        $model = D($name);
        $table = $model->getTableName();
        $this->assign('dataid',$id);
        $this->assign('modelname',$name);
        $this->assign('tablename',$table);
        $changeModel = M("mis_system_client_change_role");
        $map['modelname'] = $name;
        $map['_string'] = "find_in_set(".$id.",content)";
        $list = $changeModel->where($map)->select();
        $userids = array();
        foreach($list as $k){
            $userids[] = $k['userid'];
        }
        $this->assign('userids',$userids);
        $this->display();
    }
    function changeRoleOnlyOneEdit(){
        $data['modelname'] = $_POST['modelname'];
        $data['tablename'] = $_POST['tablename'];
        $data['fieldname'] = 'id';
        $data['createid'] = $_SESSION[C('USER_AUTH_KEY')];
        $data['companyid'] = getFieldBy($data['createid'],"userid","companyid","user_dept_duty");
        $data['createtime'] = time();
        $data['departmentid'] = getFieldBy($data['createid'],"userid","deptid","user_dept_duty");
        $dataid = $_POST['dataid'];
        if(!$_POST['copytopeopleid']) $this->error("没选择授权对象");
        $useridarr = $_POST['copytopeopleid'];//explode(",",$_POST['userids']);
        $model = M("mis_system_client_change_role");
        //获取该模型该转授人曾经的转授权数据，用于给用户添加数据权限
        $changeModel = M("mis_system_client_change_role");
        $cmap['status'] = 1;
        $cmap['modelname'] = $data['modelname'];
        $cmap['tablename'] = $data['tablename'];
        $cmap['fieldname'] = $data['fieldname'];
        $cmap['createid'] = $data['createid'];
        $cmap['_string'] = "find_in_set(".$dataid.",content)";
        $changeList = $changeModel->where($cmap)->getField("userid,content,id");
        foreach($useridarr as $key=>$val){
            $data['userid'] = $val;
            if($changeList[$val]){
                $data['id'] = $changeList[$val]['id'];
                //if($changeList[$val]['content']){
                $contentarr = explode(",",$changeList[$val]['content']);
                if(!in_array($dataid,$contentarr)){
                    $data['content'] = $changeList[$val]['content'].",".$dataid;
                    $ret = $changeModel->save($data);
                    if(false === $ret){
                        $this->error("修改转授数据失败");
                    }
                }
                //}
            }else{
                $data['content'] = $dataid;
                unset($data['id']);
                $ret = $changeModel->add($data);
                if(false === $ret){
                    $this->error("添加转授权数据失败");
                }
            }
        }
        $this->success("转授成功");
    }
    //获取客户所有关联的项目编码
    function lookupkufubianhaos(){
        $intnum = 0;
        //返回数组
        $listfanhui = array();
        $kufubianhao = $_POST['kufubianhao'];
        //实例化banmo和table37
        $banmoModel = M('mis_auto_banmo');
        $datatable37 = M('mis_auto_banmo_sub_datatable37');
        $map['orderno'] = $kufubianhao;
        //根据order查询到ID
        $list=$banmoModel->where($map)->field("id")->find();
        $mapa['masid'] = $list['id'];
        //根据masid查询到dable37下面的关联客户
        $list1 = $datatable37->where($mapa)->field("kehubianma")->select();
        //遍历第一次查询出的关联用户
        foreach($list1 as $key=>$val){
            $maps['orderno'] = $val['kehubianma'];
            //根据第一遍查询的关联客服查询出ID
            $lists=$banmoModel->where($maps)->field("id")->select();
            //遍历第一遍所有客户的关联客户
            foreach($lists as $key=>$val){
                //第二次重复操作
                $mapget['masid'] = $val['id'];
                $listxunhuan = $datatable37->where($mapget)->field("kehubianma")->select();
                foreach ($listxunhuan as $key=>$val){
                    if($val['kehubianma']){
                        $listfanhui[$intnum] =$val;
                        $intnum++;
                        $mapdiercis['orderno'] = $val['kehubianma'];
                        $listiddierci=$banmoModel->where($mapdiercis)->field("id")->select();
                        foreach ($listiddierci as $key=>$val){
                            $mapdierciget['masid'] = $val['id'];
                            $listdiercixunhuan = $datatable37->where($mapdierciget)->field("kehubianma")->select();
                            foreach ($listdiercixunhuan as $key=>$val){
                                if($val['kehubianma']){
                                    $listfanhui[$intnum] =$val;
                                    $intnum++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $listfanhui = array_merge($list1,$listfanhui);
        echo json_encode($listfanhui);
    }
}
?>
