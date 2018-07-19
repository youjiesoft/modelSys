<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(人事所有相关报表信息控制器)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-22 下午9:36:51
 * @version V1.0
 */
class ReportHrPersonnelAction extends CommonAction{
	
	/**
	 * (non-PHPdoc)
	 * @Description: todo(人事招聘报表列表提示信息)
	 * @see CommonAction::index()
	 */
	public function index(){
		$this->error("请选择该模板下具体相应报表");
		exit;
	}
	/**
	 * @Title: hrContractExtensionEport 
	 * @Description: todo(人事考评提醒报表->方便工作人员导出)   
	 * @author liminggang 
	 * @date 2013-7-24 上午10:35:14 
	 * @throws
	 */
	public function hrContractExtensionEport(){
		//获取招聘报表是否需要输入检索条件状态值。
		$result=$this->isReportIssearch("hrContractExtensionEport");
		$this->assign('result',$result);
		//输入到招聘报表检索页面模板
		$this->display();
	}
	/**
	 * @Title: lookupHrContractExtensionEport
	 * @Description: todo(人事转正提醒报表显示)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function lookupHrContractExtensionEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrContractExtensionEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrContractExtensionEport');
		$suburl = str_replace('lookupHrContractExtensionEport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$model = D("ReportHrPersonnel");
			echo $model->getHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','员工编号','姓名','部门','岗位','入职日期'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->display();
		}
	}
	
	/**
	 * @Title: hrPersonnelPositiveInfo 
	 * @Description: todo(人事转正提醒报表->方便工作人员导出)   
	 * @author liminggang 
	 * @date 2013-7-22 上午10:56:36 
	 * @throws
	 */
	public function hrPersonnelPositiveInfoEport(){
		//获取招聘报表是否需要输入检索条件状态值。
		$result=$this->isReportIssearch("hrPersonnelPositiveInfoEport");
		$this->assign('result',$result);
		//输入到招聘报表检索页面模板
		$this->display();
	}
	/**
	 * @Title: lookupHrInviteRereport
	 * @Description: todo(人事转正提醒报表显示)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function lookupHrPersonnelPositiveInfo(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonnelPositiveInfoEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonnelPositiveInfo');
		$suburl = str_replace('lookupHrPersonnelPositiveInfo','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$model = D("ReportHrPersonnel");
			echo $model->getHrPersonnelPositiveInfo($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','员工编号','姓名','部门','岗位','入职日期'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->display();
		}
	}
	/**
	 * @Title: hrInviteRereport
	 * @Description: todo(人事招聘分析报表判断是否必须输入检索条件)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrInviteRereport(){
		//获取招聘报表是否需要输入检索条件状态值。
		$result=$this->isReportIssearch("hrInviteRereport");
		$this->assign('result',$result);
		//输入到招聘报表检索页面模板
		$this->display();
	}
	/**
	 * @Title: lookupHrInviteRereport
	 * @Description: todo(人事招聘分析报表显示)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function lookupHrInviteRereport(){
		//用于导出数据传参
		$this->assign('reporttype','hrInviteRereport');
		$page = $_REQUEST['page'];
		$limit = $_REQUEST['rows'];
		$sidx = $_REQUEST['sidx'];
		$sord = $_REQUEST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;                      
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrInviteRereport');
		$suburl = str_replace('lookupHrInviteRereport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->getHrpersonnelInvitere($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'编号','姓名','性别','年龄','学历','专业','籍贯','招聘渠道','预约时间','应聘岗位','工作年限','联系方式','面试时间','初试结果','复式结果','待入职时间'
			);
			$colModel = array(
					array('name'=>'id','index'=>'id','align'=>'center','hidden'=>true),
					array('name'=>'name','index'=>'name','align'=>'center'),
					array('name'=>'sex','index'=>'sex','align'=>'center'),
					array('name'=>'age','index'=>'age','align'=>'center'),
					array('name'=>'education','index'=>'education','align'=>'center'),
					array('name'=>'professional','index'=>'professional','align'=>'center'),
					array('name'=>'nativeplace','index'=>'nativeplace','align'=>'center'),
					array('name'=>'inviteresources','index'=>'inviteresources','align'=>'center'),
					array('name'=>'datetime','index'=>'datetime','align'=>'center'),
					array('name'=>'interviewposition','index'=>'interviewposition','align'=>'center'),
					array('name'=>'senioritypay','index'=>'senioritypay','align'=>'center'),
					array('name'=>'contacttel','index'=>'contacttel','align'=>'center'),
					array('name'=>'interviewtim','index'=>'interviewtim','align'=>'center'),
					array('name'=>'interviewfirst','index'=>'interviewfirst','align'=>'center','formatter'=>'select',
							'editoptions'=>array('value'=>array('0'=>'不合格','1'=>'合格','2'=>'放入人才库','3'=>'待定'))),
					array('name'=>'interviewagain','index'=>'interviewagain','align'=>'center','formatter'=>'select',
							'editoptions'=>array('value'=>array('0'=>'不合格','1'=>'合格','2'=>'放入人才库','3'=>'待定'))),
					array('name'=>'joinedtime','index'=>'joinedtime','align'=>'center'),
			);
			$colNames = json_encode($colNames);
			$colModel = json_encode($colModel);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 *
	 * @Title: hrPersonnelBasisEport
	 * @Description: todo(人事基本信息报表输出模板)
	 * @author liminggang
	 * @date 2013-4-22 下午10:20:26
	 * @throws
	 */
	public function hrPersonnelBasisEport(){
		$userTypeArray=array(
				array('id'=>1,'name'=>'技术'),
				array('id'=>2,'name'=>'非技'),
				array('id'=>3,'name'=>'实习'),
				array('id'=>4,'name'=>'普工'),
		);
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrPersonnelBasisEport");
		$this->assign('result',$result);
		$this->assign("userTypeArray",$userTypeArray);
		$this->display();
	}
	/**
	 * @Title: lookuphrPersonnelBasisEport
	 * @Description: todo(人事基本信息 显示)
	 * @author renling
	 * @date 2013-5-13 上午11:32:08
	 * @throws
	 */
	public  function lookupHrPersonnelBasisEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonnelBasisEport');
		$page = $_REQUEST['page'];
		$limit = $_REQUEST['rows'];
		$sidx = $_REQUEST['sidx'];
		$sord = $_REQUEST['sord'];
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonnelBasisEport');
		$suburl = str_replace('lookupHrPersonnelBasisEport','',$suburl);
		$this->assign("suburl",$suburl);
		$sarr = $_REQUEST;
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->hrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','员工编号','性别','工种','内部编号','姓名','部门','职务',
					'职级','入职日期','转试用日期','转正日期','是否转正','离职日期',
					'员工考核','职位状态','毕业学院','身份证','联系电话','培训机构',
					'专业与技能','开始时间','结束时间','工作单位','职业','联系电话',
					'开始时间','结束时间','家属关系','姓名','工作单位','联系电话',
					'介绍人','关系','联系电话','项目编号','所在项目','项目职位',
					'开始时间','结束时间','是否可调动','备注','代办人','签订时间','结束时间','备注'
			);
			// 			$colModel = array(
			// 					array('name'=>'id','index'=>'id'),
			// 					array('name'=>'deptname','index'=>'deptname'),
			// 					array('name'=>'dutyname','index'=>'dutyname'),
			// 					array('name'=>'indate','index'=>'indate'),




			// 			);
			$colNames = json_encode($colNames);
			// 			$colModel = json_encode($colModel);
			$this->assign("colNames",$colNames);
			// 			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: hrIntroducerInfoEport
	 * @Description: todo(介绍人信息报表检索输出模板)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrIntroducerInfoEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrIntroducerInfoEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookupHrIntroducerInfoEport
	 * @Description: todo(介绍人信息报表)
	 * @author liminggang
	 * @date 2013-4-24 下午9:47:31
	 * @throws
	 */
	public function lookupHrIntroducerInfoEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrIntroducerInfoEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrIntroducerInfoEport');
		$suburl = str_replace('lookupHrIntroducerInfoEport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$model = D("ReportHrPersonnel");
			echo $model->getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','员工编号','姓名','部门','岗位','入职日期','介绍人姓名','介绍人部门','介绍人职位'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->display();
		}
	}
	/**
	 * @Title: hrIntroducerInfoEport
	 * @Description: todo(合同签订情况报表检索输出模板)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrPersonContractEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrPersonContractEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookupHrPersonContractEport
	 * @Description: todo(合同签订情况报表)
	 * @author liminggang
	 * @date 2013-4-24 下午9:48:08
	 * @throws
	 */
	public function lookupHrPersonContractEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonContractEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonContractEport');
		$suburl = str_replace('lookupHrPersonContractEport','',$suburl);

		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->getHrPersonContractEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','员工编号','姓名','部门','职务','入职日期','签订次数','上次终止日期','备注','签约时间'
			);
			$colModel = array(
					array('name'=>'id','index'=>'id','align'=>'center','hidden'=>true),
					array('name'=>'orderno','index'=>'orderno','align'=>'center','hidden'=>true),
					array('name'=>'name','index'=>'name','align'=>'center'),
					array('name'=>'deptname','index'=>'deptname','align'=>'center'),
					array('name'=>'dutyname','index'=>'dutyname','align'=>'center'),
					array('name'=>'indate','index'=>'indate','align'=>'center'),
					array('name'=>'counts','index'=>'counts','align'=>'center'),
					array('name'=>'mis_hr_personnel_person_contract_enddate','index'=>'mis_hr_personnel_person_contract_enddate','align'=>'center'),
					array('name'=>'mis_hr_personnel_person_contract_remark','index'=>'mis_hr_personnel_person_contract_remark','align'=>'center'),
					array('name'=>'mis_hr_personnel_person_contract_createtime','index'=>'mis_hr_personnel_person_contract_createtime','hidden'=>true),
			);
			$colNames = json_encode($colNames);
			$colModel = json_encode($colModel);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: hrProjectRecordsEport
	 * @Description: todo(所在项目报表检索输出模板)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrProjectRecordsEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrProjectRecordsEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookupHrProjectRecordsEport
	 * @Description: todo(所在项目显示数据)
	 * @author renling
	 * @date 2013-5-9 下午5:01:31
	 * @throws
	 */
	public function lookupHrProjectRecordsEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrProjectRecordsEport');
		$page = $_REQUEST['page'];
		$limit = $_REQUEST['rows'];
		$sidx = $_REQUEST['sidx'];
		$sord = $_REQUEST['sord'];
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrProjectRecordsEport');
		$suburl = str_replace('lookupHrProjectRecordsEport','',$suburl);
		$this->assign("suburl",$suburl);
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','姓名','部门','岗位','入职日期','项目编号','所在项目','项目职位',
					'开始时间','结束时间','是否可调动','备注'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: hrPersonEducationEport
	 * @Description: todo(培训和教育经历报表检索输出模板方法)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrPersonEducationEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrPersonEducationEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookupHrPersonEducationEport
	 * @Description: todo(培训和教育经历报表数据显示 )
	 * @author renling
	 * @date 2013-5-10 上午11:27:49
	 * @throws
	 */
	public function lookupHrPersonEducationEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonEducationEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonEducationEport');
		$suburl = str_replace('lookupHrPersonEducationEport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->gethrPersonEducationEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','姓名' ,'部门','职务',
					'入职日期','培训机构',
					'专业与技能','开始时间','结束时间'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: hrPersonExperienceEport
	 * @Description: todo(工作经验报表检索输出模板方法)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrPersonExperienceEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrPersonExperienceEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookuphrPersonExperienceEport
	 * @Description: todo(工作经验数据展示输出模板方法)
	 * @author renling
	 * @date 2013-5-10 下午2:42:36
	 * @throws
	 */
	public function lookupHrPersonExperienceEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonExperienceEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonExperienceEport');
		$suburl = str_replace('lookupHrPersonExperienceEport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->gethrPersonExperienceEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','姓名' ,'部门','职务',
					'入职日期' ,'工作单位','职业',
					'开始时间','结束时间' ,'备注'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: hrPersonExperienceEport
	 * @Description: todo(家庭成员报表检索输出模板方法)
	 * @author renling
	 * @date 2013-5-9 上午10:04:30
	 * @throws
	 */
	public function hrPersonFamilyEport(){
		//判断是否必须输入检索条件
		$result=$this->isReportIssearch("hrPersonFamilyEport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookuphrPersonFamilyEport
	 * @Description: todo(家庭成员报表显示)
	 * @author renling
	 * @date 2013-5-10 下午3:31:16
	 * @throws
	 */
	public function lookupHrPersonFamilyEport(){
		//用于导出数据传参
		$this->assign('reporttype','hrPersonFamilyEport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupHrPersonFamilyEport');
		$suburl = str_replace('lookupHrPersonFamilyEport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$m = D('ReportHrPersonnel');
			echo $m->getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'ID','姓名' ,'部门','职务','入职日期','家属姓名','家属关系','工作单位','联系电话',
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->assign("colModel",$colModel);
			$this->display();
		}
	}
	/**
	 * @Title: isReportIssearch 
	 * @Description: todo(此方法为通用方法，判断报表是否输入检索条件) 
	 * @param varchar $name 报表名称
	 * @return Ambigous <number, multitype:, mixed, boolean>  
	 * @author liminggang 
	 * @date 2013-5-31 下午4:16:34 
	 * @throws
	 */
	private function  isReportIssearch($name){
		//报表条件检索模型
		$misReportConfigurationModel=D('MisReportConfiguration');
		$sql="SELECT mis_report_configuration.issearch FROM node LEFT JOIN mis_report_configuration  ON mis_report_configuration.reportid=node.id WHERE node.name='".$name."'  AND node.status=1 AND mis_report_configuration.status=1";
		$result=$misReportConfigurationModel->query($sql);
		if($result[0]['issearch']!=0){
			$result=1;
		}else{
			$result=0;
		}
		return $result;
	}
}
?>
