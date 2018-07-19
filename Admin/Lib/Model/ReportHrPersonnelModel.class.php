<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(人事所有报表SQL集合模型)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-10-23 下午9:38:56
 * @version V1.0
 */
class ReportHrPersonnelModel extends CommonModel{
	/**
	 * @Title: getHrpersonnelInvitere
	 * @Description: todo(人事招聘统计报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrpersonnelInvitere($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_invitere_form.name LIKE '%".$v."%'";
					break;
				case 'sex':
					if($v=='男'){
						$wh.=" and mis_hr_invitere_form.sex=1";
					}else{
						$wh.=" and mis_hr_invitere_form.sex=0";
					}
					break;
				case 'professional':
					$wh .= " AND mis_hr_invitere_form.professional LIKE '%".$v."%'";
					break;
				case 'nativeplace':
					$wh .= " AND mis_hr_invitere_form.nativeplace LIKE '%".$v."%'";
					break;
				case 'inviteresources':
					$wh .= " AND mis_hr_invitere_form.inviteresources =".$v;
					break;
				case 'interviewposition':
					$wh .= " AND mis_hr_invitere_form.interviewposition LIKE '%".$v."%'";
					break;
				case 'senioritypay':
					$wh .= " AND mis_hr_invitere_form.senioritypay LIKE '%".$v."%'";
					break;
				case 'contacttel':
					$wh .= " AND mis_hr_invitere_form.contacttel LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$model=D("MisHrInvitereForm");
		$count=$model->where("status=1 $wh")->count("*");
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT * FROM mis_hr_invitere_form WHERE status = 1 $wh  ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//重构数组
		$arr=array();
		foreach ($result as $ks=>$vs){
			$arr[$ks]=$vs;
			$arr[$ks]['sex']=$vs['sex']==1?'男':'女';
			$arr[$ks]['inviteresources']=getFieldBy($vs['inviteresources'], "id", "name", "mis_hr_typeinfo");
			$arr[$ks]['education']=getFieldBy($vs['education'], "id", "name", "mis_hr_typeinfo");
			$arr[$ks]['joinedtime']=transTime($vs['joinedtime']);
			$arr[$ks]['interviewtim']=transTime($vs['interviewtim']);
			$arr[$ks]['datetime']=transTime($vs['datetime']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[name],$row[sex],$row[age],$row[education],$row[professional],$row[nativeplace],$row[inviteresources],$row[datetime],$row[interviewposition],$row[senioritypay],$row[contacttel],$row[interviewtim],$row[interviewfirst],$row[interviewagain],$row[joinedtime]);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * @Title: getReportProjectPerson
	 * @Description: todo(人事基本信息汇总表->人事，工作经验，教育背景等等)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author liminggang
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function hrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'ordernoid':
					$wh.=" and mis_hr_personnel_person_info.id=".$v;
					break;
				case 'name':
					$wh .= " AND mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'deptid':
					$wh .= " AND mis_hr_personnel_person_info.deptid=".$v;
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname ='".$v."'";
					break;
				case 'sex':
					$wh .= " AND mis_hr_personnel_person_info.sex=".$v;
					break;
				case 'workkid':
					$wh .= " AND mis_hr_personnel_person_info.workkind=".$v;
					break;
				case 'itemid':
					$wh .= " AND mis_hr_personnel_person_info.itemid LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				case 'positivestatus':
					$wh .= " AND mis_hr_personnel_person_info.positivestatus =".$v;
					break;
				case 'phone':
					$wh .= " AND mis_hr_personnel_person_info.phone LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		COUNT(DISTINCT mis_hr_personnel_person_info.id)
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_education_info mis_hr_personnel_education_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_family_info mis_hr_personnel_family_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_project_records mis_hr_personnel_project_records
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_contract.delstatus = 1
		AND mis_hr_personnel_person_contract.status = 1  $wh  GROUP  BY (mis_hr_personnel_person_info.id) ";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id, orderno,sex ,itemid, workkind, mis_hr_personnel_person_info.name,
		sex, birthday, native, politicsstatus, education, personcertificate, profession, dutylevelid,
		deptid, dutyname, mis_hr_personnel_person_info.projectid, mis_hr_personnel_person_info.istransfer,
		address, nativeaddress, mis_hr_personnel_person_info.school,
		email, chinaid, phone, indate, leavedate, transferprobationdate, transferdate, messagesource,
		infomationstatus, staffhandbook, staffcheck, working, positivestatus,
		mis_hr_personnel_education_info.school              AS mis_hr_personnel_education_info_school,
		mis_hr_personnel_education_info.skillAndCertificate AS mis_hr_personnel_education_info_skillAndCertificate,
		mis_hr_personnel_education_info.startDate           AS mis_hr_personnel_education_info_startDate,
		mis_hr_personnel_education_info.finishDate          AS mis_hr_personnel_education_info_finishDate,
		mis_hr_personnel_experience_info.company            AS mis_hr_personnel_experience_info_company,
		mis_hr_personnel_experience_info.position           AS mis_hr_personnel_experience_info_position,
		mis_hr_personnel_experience_info.telephone          AS mis_hr_personnel_experience_info_telephone,
		mis_hr_personnel_experience_info.startdate          AS mis_hr_personnel_experience_info_startdate,
		mis_hr_personnel_experience_info.finishdate         AS mis_hr_personnel_experience_info_finishdate,
		mis_hr_personnel_family_info.relation               AS mis_hr_personnel_family_info_relation,
		mis_hr_personnel_family_info.name                   AS mis_hr_personnel_family_info_name,
		mis_hr_personnel_family_info.company                AS mis_hr_personnel_family_info_company,
		mis_hr_personnel_family_info.telephone              AS mis_hr_personnel_family_info_telephone,
		mis_hr_personnel_introducer_info.name               AS mis_hr_personnel_introducer_info_name,
		mis_hr_personnel_introducer_info.relation           AS mis_hr_personnel_introducer_info_relation,
		mis_hr_personnel_introducer_info.telephone          AS mis_hr_personnel_introducer_info_telephone,

		mis_hr_personnel_project_records.projectid AS mis_hr_personnel_project_records_projectid,
		mis_hr_personnel_project_records.projectname AS mis_hr_personnel_project_records_projectname,

		mis_hr_personnel_project_records.pjposition AS mis_hr_personnel_project_records_pjposition,
		mis_hr_personnel_project_records.begindate AS mis_hr_personnel_project_records_begindate,
		mis_hr_personnel_project_records.enddate AS mis_hr_personnel_project_records_enddate,
		mis_hr_personnel_project_records.iscondition AS mis_hr_personnel_project_records_iscondition,
		mis_hr_personnel_project_records.remark AS mis_hr_personnel_project_records_remark,

		mis_hr_personnel_person_contract.agencyperson AS mis_hr_personnel_person_contract_agencyperson,
		mis_hr_personnel_person_contract.signdate AS mis_hr_personnel_person_contract_signdate,
		mis_hr_personnel_person_contract.enddate AS mis_hr_personnel_person_contract_enddate,
		mis_hr_personnel_person_contract.remark AS mis_hr_personnel_person_contract_remark,

		COUNT(DISTINCT mis_hr_personnel_person_info.id)
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_education_info mis_hr_personnel_education_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_family_info mis_hr_personnel_family_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_project_records mis_hr_personnel_project_records
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_contract.delstatus = 1
		AND mis_hr_personnel_person_contract.status = 1  $wh  GROUP  BY (mis_hr_personnel_person_info.id) ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//重构数组
		$arr=array();
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			// 			$arr[$key]['sex'] = $select_config['sex'][$val['sex']];
			$arr[$key]['sex']=$val['sex']==1?'男':'女';
			$arr[$key]['workkind'] = $select_config['workkind']['workkind'][$val['workkind']];
			$arr[$key]['positivestatus'] = $select_config['positivestatus']['positivestatus'][$val['positivestatus']];
			$arr[$key]['mis_hr_personnel_project_records_iscondition'] = $select_config['iscondition']['iscondition'][$val['mis_hr_personnel_project_records_iscondition']];
			$arr[$key]['working'] = $select_config['working']['working'][$val['working']];
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['transferprobationdate'] = transTime($val['transferprobationdate']);
			$arr[$key]['transferdate'] = transTime($val['transferdate']);
			$arr[$key]['leavedate'] = transTime($val['leavedate']);
			$arr[$key]['mis_hr_personnel_education_info_startDate'] = transTime($val['mis_hr_personnel_education_info_startDate']);
			$arr[$key]['mis_hr_personnel_education_info_finishDate'] = transTime($val['mis_hr_personnel_education_info_finishDate']);
			$arr[$key]['mis_hr_personnel_experience_info_startdate'] = transTime($val['mis_hr_personnel_experience_info_startdate']);
			$arr[$key]['mis_hr_personnel_experience_info_finishdate'] = transTime($val['mis_hr_personnel_experience_info_finishdate']);
			$arr[$key]['mis_hr_personnel_project_records_begindate'] = transTime($val['mis_hr_personnel_project_records_begindate']);
			$arr[$key]['mis_hr_personnel_project_records_enddate'] = transTime($val['mis_hr_personnel_project_records_enddate']);
			$arr[$key]['mis_hr_personnel_person_contract_signdate'] = transTime($val['mis_hr_personnel_person_contract_signdate']);
			$arr[$key]['mis_hr_personnel_person_contract_enddate'] = transTime($val['mis_hr_personnel_person_contract_enddate']);
			$arr[$key]['dutylevelid'] = getFieldBy($val['dutylevelid'],'id','name','duty');
			$arr[$key]['mis_hr_personnel_person_contract_agencyperson'] = getFieldBy($val['mis_hr_personnel_person_contract_agencyperson'],'id','name','mis_hr_personnel_person_info');
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $result;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[sex],$row[workkind],$row[itemid],$row[name],$row[deptid],$row[dutyname],$row[dutylevelid],
					$row[indate],$row[transferprobationdate],$row[transferdate],$row[positivestatus],$row[leavedate],$row[staffcheck],
					$row[working],$row[school],$row[chinaid],$row[phone],
					$row[mis_hr_personnel_education_info_school],$row[mis_hr_personnel_education_info_skillAndCertificate],
					$row[mis_hr_personnel_education_info_startDate],$row[mis_hr_personnel_education_info_finishDate],
					$row[mis_hr_personnel_experience_info_company],$row[mis_hr_personnel_experience_info_position],
					$row[mis_hr_personnel_experience_info_telephone],$row[mis_hr_personnel_experience_info_startdate],
					$row[mis_hr_personnel_experience_info_finishdate],$row[mis_hr_personnel_family_info_relation],
					$row[mis_hr_personnel_family_info_name],$row[mis_hr_personnel_family_info_company],
					$row[mis_hr_personnel_family_info_telephone],$row[mis_hr_personnel_introducer_info_name],
					$row[mis_hr_personnel_introducer_info_relation],$row[mis_hr_personnel_introducer_info_telephone],
					$row[mis_hr_personnel_project_records_projectid],
					$row[mis_hr_personnel_project_records_projectname],
					$row[mis_hr_personnel_project_records_pjposition],
					$row[mis_hr_personnel_project_records_begindate],
					$row[mis_hr_personnel_project_records_enddate],
					$row[mis_hr_personnel_project_records_iscondition],
					$row[mis_hr_personnel_project_records_remark],
					$row[mis_hr_personnel_person_contract_agencyperson],
					$row[mis_hr_personnel_person_contract_signdate],
					$row[mis_hr_personnel_person_contract_enddate],
					$row[mis_hr_personnel_person_contract_remark],
			);
			$i++;
		}
		return json_encode($responce);
	}
	
	/**
	 * @Title: getHrContractExtensionEport 
	 * @Description: todo(续约提醒报表) 
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author liminggang
	 * @date 2013-7-24 上午10:44:52 
	 * @throws
	 */
	function getHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr) {
		//部门表模型
		$MisSystemDepartmentModel=D('MisSystemDepartment');
		//查询提示状态为 0的部门ID 不提示
		$MisSystemDepartmentList=$MisSystemDepartmentModel->where(' isprompt=0 ')->getField('id,name');
		//获取一个月时间
		$time=time() + 2592000;
		//合同到期日期小于等于一个月
		$mapContract['delstatus']=1;
		$mapContract['status']=1;
		//人事合同模型
		$MisHrPersonnelPersonContractModel=D('MisHrPersonnelPersonContract');
		$MisHrPersonnelPersonContractList=$MisHrPersonnelPersonContractModel->where($mapContract)->group('personinfoid')->HAVING('MAX(enddate)<='.$time)->order('personinfoid')->getField('personinfoid,enddate,max(enddate)');
		//第一种情况，入职日期大于一个月，切没签合同的人员
		$MisHrPersonnelPersonInfoDAO=M('mis_hr_personnel_person_info');
		unset($map);
		//入职日期大于一个月
		$SignContract=$MisHrPersonnelPersonContractModel->where($mapContract)->getField('personinfoid,enddate');
		//$map['indate']=array('elt',$time);
		$map['working']=1; //职位状态 ：在职
		$map['id']=array('not in',array_unique(array_keys($SignContract)));
		$personidlist=$MisHrPersonnelPersonInfoDAO->where($map)->getField('id',true);
		$listarr=array_filter(array_merge(array_keys($MisHrPersonnelPersonContractList),$personidlist));
		unset($map);
		//第二种情况，签约合同人员合同到期时间小于一个月。
		if($MisHrPersonnelPersonContractList){
			$map['id']=array('in',$listarr);
		}
		//不在不提示部门的人员
		if($MisSystemDepartmentList!=null){
			$map['deptid']=array('not in',array_keys($MisSystemDepartmentList));
		}
		$idlist=implode(",",$listarr);
		$deptlist = implode(",",array_keys($MisSystemDepartmentList));
		$wh = " and mis_hr_personnel_person_info.id in (".$idlist.")";
		//不在不提示部门的人员
		if($MisSystemDepartmentList!=null){
			$wh .= " and mis_hr_personnel_person_info.deptid not in (".$deptlist.")";
		}
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		 $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,
		mis_system_department.name   as deptname
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1 $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[name],$row[deptname],$row[dutyname],$row[indate]);
			$i++;
		}
		return json_encode($responce);
	}
	
	/**
	 * @Title: getHrPersonnelPositiveInfo 
	 * @Description: todo(人事转正提醒报表) 
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author liminggang
	 * @date 2013-7-24 上午9:18:18 
	 * @throws
	 */
	function getHrPersonnelPositiveInfo($page,$limit,$sidx,$sord,$sarr) {
		//转正模型
		$MisHrPersonnelPositiveInfoModel=D('MisHrPersonnelPositiveInfo');
		$positivestatusmap['status']=1;
		//查询已填写转正申请单人员
		$MisHrPersonnelPositiveInfoList=$MisHrPersonnelPositiveInfoModel->where($positivestatusmap)->getField('personid',true);
		//获取一个月时间
		$time=time() - 2592000;
		$polist=implode(",",$MisHrPersonnelPositiveInfoList);
		$wh = " and mis_hr_personnel_person_info.id not in (".$polist.") and mis_hr_personnel_person_info.indate <=".$time;
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_info.positivestatus = 0 $wh";
		
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,
		mis_system_department.name   as deptname
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_info.positivestatus = 0  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[name],$row[deptname],$row[dutyname],$row[indate]);
			$i++;
		}
		return json_encode($responce);
	}
	
	/**
	 * @Title: getHrIntroducerInfoEport
	 * @Description: todo(人事介绍人信息报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_introducer_info.status = 1 and mis_system_department.status=1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,
		mis_system_department.name   as deptname,
		mis_hr_personnel_introducer_info.personinfoid               AS mis_hr_personnel_introducer_info_personid,
		mis_hr_personnel_introducer_info.name               AS mis_hr_personnel_introducer_info_name

		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_introducer_info.status = 1 and mis_system_department.status=1  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
			//介绍人部门
			$arr[$key]['jsdeptname'] =getFieldBy(getFieldBy($val['mis_hr_personnel_introducer_info_personid'],'id','deptid','mis_hr_personnel_person_info'),'id','name','mis_system_department'); ;
			//介绍人职位
			$arr[$key]['jsdutyname'] = getFieldBy($val['mis_hr_personnel_introducer_info_personid'],'id','dutyname','mis_hr_personnel_person_info');
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[name],$row[deptname],$row[dutyname],
					$row[indate],
					$row[mis_hr_personnel_introducer_info_name],
					$row[jsdeptname],
					$row[jsdutyname],
			);
			$i++;
		}
		return json_encode($responce);
	}
	
	/**
	 * @Title: getHrPersonContractEport
	 * @Description: todo(合同签订情况报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrPersonContractEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_contract.delstatus = 1  $wh  GROUP BY mis_hr_personnel_person_info.id";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS id, orderno,mis_hr_personnel_person_info.name,
		deptid,dutyname,indate,
		MAX(mis_hr_personnel_person_contract.enddate) AS mis_hr_personnel_person_contract_enddate,
		mis_hr_personnel_person_contract.remark AS mis_hr_personnel_person_contract_remark,
		mis_system_department.name   as deptname,
		mis_hr_personnel_person_contract.createtime AS mis_hr_personnel_person_contract_createtime,
		COUNT(*) AS counts
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_contract.delstatus = 1  $wh
		GROUP BY mis_hr_personnel_person_info.id
		ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = $this->query($sql);

		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['mis_hr_personnel_person_contract_enddate'] = transTime($val['mis_hr_personnel_person_contract_enddate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[name] ,$row[deptname],$row[dutyname],
					$row[indate],
					$row[counts],
					$row[mis_hr_personnel_person_contract_enddate],
					$row[mis_hr_personnel_person_contract_remark],
					$row[mis_hr_personnel_person_contract_createtime],
			);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * @Title: getHrProjectRecordsEport
	 * @Description: todo(所在项目报表情况)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_projectname':
					$wh .= " AND mis_hr_personnel_project_records.projectname  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_project_records_pjposition':
					$wh .= " AND mis_hr_personnel_project_records.pjposition LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_project_records_begindate':
					$wh .= " AND mis_hr_personnel_project_records.begindate =".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_enddate':
					$wh .= " AND mis_hr_personnel_project_records.enddate =".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_iscondition':
						$wh .= " AND mis_hr_personnel_project_records.iscondition =".$v;
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_project_records.id
		FROM mis_hr_personnel_project_records mis_hr_personnel_project_records
		LEFT JOIN   mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1
		AND mis_hr_personnel_person_info.status = 1    $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id              AS perid,
		mis_hr_personnel_person_info.name,
		dutyname,
		mis_hr_personnel_person_info.projectid,
		mis_hr_personnel_person_info.indate,
		mis_system_department.name                   AS deptname,
		mis_hr_personnel_project_records.projectid   AS mis_hr_personnel_project_records_projectid,
		mis_hr_personnel_project_records.projectname AS mis_hr_personnel_project_records_projectname,
		mis_hr_personnel_project_records.pjposition  AS mis_hr_personnel_project_records_pjposition,
		mis_hr_personnel_project_records.begindate   AS mis_hr_personnel_project_records_begindate,
		mis_hr_personnel_project_records.enddate     AS mis_hr_personnel_project_records_enddate,
		mis_hr_personnel_project_records.iscondition AS mis_hr_personnel_project_records_iscondition,
		mis_hr_personnel_project_records.remark      AS mis_hr_personnel_project_records_remark
		FROM mis_hr_personnel_project_records mis_hr_personnel_project_records
		LEFT JOIN   mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1
		AND mis_hr_personnel_person_info.status = 1    $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['mis_hr_personnel_project_records_begindate'] = transTime($val['mis_hr_personnel_project_records_begindate']);
			$arr[$key]['mis_hr_personnel_project_records_enddate'] = transTime($val['mis_hr_personnel_project_records_enddate']);
			$arr[$key]['mis_hr_personnel_project_records_iscondition'] = $select_config['iscondition']['iscondition'][$val['mis_hr_personnel_project_records_iscondition']];
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			//$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[perid],$row[name],$row[deptname],$row[dutyname],$row[indate],
					$row[mis_hr_personnel_project_records_projectid],
					$row[mis_hr_personnel_project_records_projectname],
					$row[mis_hr_personnel_project_records_pjposition],
					$row[mis_hr_personnel_project_records_begindate],
					$row[mis_hr_personnel_project_records_enddate],
					$row[mis_hr_personnel_project_records_iscondition],
					$row[mis_hr_personnel_project_records_remark],
			);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * @Title: getHrProjectRecordsEport
	 * @Description: todo(培训教育经历报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function gethrPersonEducationEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				case 'mis_hr_personnel_education_info_school':
					$wh .= " AND mis_hr_personnel_education_info.school  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_education_info_skillAndCertificate':
					$wh .= " AND mis_hr_personnel_education_info.skillAndCertificate LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_education_info_startDate':
					$wh .= " AND mis_hr_personnel_education_info.startDate =".strtotime($v);
					break;
				case 'mis_hr_personnel_education_info_finishDate':
					$wh .= " AND mis_hr_personnel_education_info.finishDate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_education_info.id
		FROM mis_hr_personnel_education_info mis_hr_personnel_education_info
		LEFT JOIN  mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id

		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid,  mis_hr_personnel_person_info.name,dutyname, mis_hr_personnel_person_info.projectid, mis_hr_personnel_person_info.istransfer,
		mis_hr_personnel_person_info. indate,

		mis_system_department.name                   AS deptname,
		mis_hr_personnel_education_info.school              AS mis_hr_personnel_education_info_school,
		mis_hr_personnel_education_info.skillAndCertificate AS mis_hr_personnel_education_info_skillAndCertificate,
		mis_hr_personnel_education_info.startDate           AS mis_hr_personnel_education_info_startDate,
		mis_hr_personnel_education_info.finishDate          AS mis_hr_personnel_education_info_finishDate

		FROM mis_hr_personnel_education_info mis_hr_personnel_education_info
		LEFT JOIN  mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id

		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['workkind'] = $select_config['workkind']['workkind'][$val['workkind']];
			$arr[$key]['positivestatus'] = $select_config['positivestatus']['positivestatus'][$val['positivestatus']];
			$arr[$key]['working'] = $select_config['working']['working'][$val['working']];
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['transferprobationdate'] = transTime($val['transferprobationdate']);
			$arr[$key]['transferdate'] = transTime($val['transferdate']);
			$arr[$key]['leavedate'] = transTime($val['leavedate']);
			$arr[$key]['dutylevelid'] = getFieldBy($val['dutylevelid'],'id','name','duty');
			$arr[$key]['mis_hr_personnel_education_info_startDate'] = transTime($val['mis_hr_personnel_education_info_startDate']);
			$arr[$key]['mis_hr_personnel_education_info_finishDate'] = transTime($val['mis_hr_personnel_education_info_finishDate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['cell'] =
			array( $row[perid] ,$row[name] ,$row[deptname],$row[dutyname] ,
					$row[indate],
					$row[mis_hr_personnel_education_info_school],$row[mis_hr_personnel_education_info_skillAndCertificate],
					$row[mis_hr_personnel_education_info_startDate],$row[mis_hr_personnel_education_info_finishDate],
			);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * @Title: gethrPersonExperienceEport
	 * @Description: todo(工作经验报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function gethrPersonExperienceEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				case 'mis_hr_personnel_experience_info_company':
					$wh .= " AND mis_hr_personnel_experience_info.company  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_position':
					$wh .= " AND mis_hr_personnel_experience_info.position LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_startdate':
					$wh .= " AND mis_hr_personnel_experience_info.startdate =".strtotime($v);
					break;
				case 'mis_hr_personnel_experience_info_finishdate':
					$wh .= " AND mis_hr_personnel_experience_info.finishdate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_experience_info.id
		FROM   mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid,
		mis_hr_personnel_person_info.name,dutyname,   indate,
		mis_system_department.name as deptname,
		mis_hr_personnel_experience_info.company            AS mis_hr_personnel_experience_info_company,
		mis_hr_personnel_experience_info.position           AS mis_hr_personnel_experience_info_position,
		mis_hr_personnel_experience_info.startdate          AS mis_hr_personnel_experience_info_startdate,
		mis_hr_personnel_experience_info.finishdate         AS mis_hr_personnel_experience_info_finishdate,
		mis_hr_personnel_experience_info.remark             AS mis_hr_personnel_experience_info_remark

		FROM   mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['mis_hr_personnel_experience_info_startdate'] = transTime($val['mis_hr_personnel_experience_info_startdate']);
			$arr[$key]['mis_hr_personnel_experience_info_finishdate'] = transTime($val['mis_hr_personnel_experience_info_finishdate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['cell'] =
			array($row[perid],$row[name],$row[deptname],$row[dutyname],
					$row[indate],
					$row[mis_hr_personnel_experience_info_company],$row[mis_hr_personnel_experience_info_position],
					$row[mis_hr_personnel_experience_info_startdate],$row[mis_hr_personnel_experience_info_finishdate],
					$row[mis_hr_personnel_experience_info_remark],
			);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * @Title: getHrPersonFamilyEport
	 * @Description: todo(家庭成员报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				case 'mis_hr_personnel_family_info_name':
					$wh .= " AND mis_hr_personnel_family_info.name  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_position':
					$wh .= " AND mis_hr_personnel_experience_info.position LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_relation':
					$wh .= " AND mis_hr_personnel_family_info.relation LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_company':
					$wh .= " AND mis_hr_personnel_family_info.company   LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_telephone':
					$wh .= " AND mis_hr_personnel_family_info.telephone  LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id
		FROM   mis_hr_personnel_family_info mis_hr_personnel_family_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department mis_system_department
		ON mis_system_department.id = mis_hr_personnel_person_info.deptid
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1 $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid, mis_hr_personnel_person_info.name,
		deptid, dutyname,   mis_hr_personnel_person_info.indate,
		mis_system_department.name                   AS deptname,
		mis_hr_personnel_family_info.relation               AS mis_hr_personnel_family_info_relation,
		mis_hr_personnel_family_info.name                   AS mis_hr_personnel_family_info_name,
		mis_hr_personnel_family_info.company                AS mis_hr_personnel_family_info_company,
		mis_hr_personnel_family_info.telephone              AS mis_hr_personnel_family_info_telephone
		FROM   mis_hr_personnel_family_info mis_hr_personnel_family_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department mis_system_department
		ON mis_system_department.id = mis_hr_personnel_person_info.deptid
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1 $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $arr;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['cell'] =
			array( $row[perid] ,$row[name] ,$row[deptname],$row[dutyname] ,
					$row[indate],
					$row[mis_hr_personnel_family_info_name],$row[mis_hr_personnel_family_info_relation],
					$row[mis_hr_personnel_family_info_company],$row[mis_hr_personnel_family_info_telephone]
			);
			$i++;
		}
		return json_encode($responce);
	}
}
?>