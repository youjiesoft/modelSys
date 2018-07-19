<?php 
class MisSaleProjectProgressModel extends CommonModel{
	
	protected $trueTableName = 'user';
    public function abc(){
    	
    	echo 124;
    }
    /**
	 * @Title: getBusinessCaseAnalysis
	 * @Description: 项目经营情况分析_项目笔数
	 * @return data  
	 * @author 王昭侠
	 * @date 2015年05月08日上午10:30:00 
	 * @throws
	 */
	public function getProjectNumber(){
		$sql = "SELECT lx.count AS lx,fx.count AS fx,zcb.count AS zcb,cjpf.count AS cjpf,fk.count AS fk,xz.count AS xz,xd.count AS xd From 
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND xiangmujieduan='01001')lx,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND xiangmujieduan='01003')fx,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(shifuzhuanchubei,'否')='是')zcb,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(pifujine,0)>0)cjpf,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(yifangkuanjine,0)>0)fk,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(xiangmuleixing,'')='01')xz,
(SELECT COUNT(xiangmubianma) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(xiangmuleixing,'')='02')xd";
		$row = $this->query($sql);
		return $row?$row[0]:array();
	}
	
	/**
	 * @Title: getBusinessCaseAnalysis
	 * @Description: 项目经营情况分析_项目金额
	 * @return data
	 * @author 王昭侠
	 * @date 2015年05月08日上午10:30:00
	 * @throws
	 */
	public function getItemAmount(){
		$sql = "SELECT lx.count AS lx,fx.count AS fx,zcb.count AS zcb,cjpf.count AS cjpf,fk.count AS fk,xz.count AS xz,xd.count AS xd From
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND xiangmujieduan='01001')lx,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND xiangmujieduan='01003')fx,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(shifuzhuanchubei,'否')='是')zcb,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(pifujine,0)>0)cjpf,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(yifangkuanjine,0)>0)fk,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(xiangmuleixing,'')='01')xz,
(SELECT SUM(shenqingjine) AS count FROM mis_auto_bklne WHERE IFNULL(xiangmubianma,'')<>'' AND IFNULL(xiangmuleixing,'')='02')xd";
		$row = $this->query($sql);
		return $row?$row[0]:array();
	}
	public function getProgressList($companyid){
		$listArr=array();
		$list=array();
		$deptlist=array();
		//查询人员
		$usersql="SELECT
 user.id,
 user.name,
 user_dept_duty.`deptid`
FROM
  user_dept_duty user_dept_duty
  LEFT JOIN user
    ON user_dept_duty.`userid`= user.id
WHERE (user.id <> ''
    OR user.id <> 0)
  AND (user_dept_duty.status = 1)
  AND (user_dept_duty.companyid = '{$companyid}')
  ORDER BY deptid
	";
		$userlist=$this->query($usersql);
		$count=0;
		//立项
		$lxcount=0;
		$lxsum=0;
		//尽职
		$jzcount=0;
		$jzsum=0;
		//风控
		$fkcount=0;
		$fksum=0;
		//风险
		$fxcount=0;
		$fxsum=0;
		//企业
		$qycount=0;
		$qysum=0;
		//批复
		$pfcount=0;
		$pfsum=0;
		$bhcount=0;
		$bhsum=0;
		foreach ($userlist as $key=>$val){ 
			//查询当前人员负责项目
			$projectsql="SELECT lx.lxcount,lx.lxsum,jz.jzcount,jz.jzsum,fk.fkcount,fk.fksum,fx.fxcount,fx.fxsum,qy.qycount,qy.qysum,pf.pfcount,pf.pfsum,bh.bhcount,bh.bhsum FROM (SELECT COUNT(xiangmubianma) AS lxcount,SUM(shenqingjine) AS lxsum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND xiangmujieduan='01001' AND IFNULL(xiangmubianma,'')<>'')lx,
(SELECT COUNT(xiangmubianma) AS jzcount,SUM(shenqingjine) AS jzsum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND xiangmujieduan='01002' AND IFNULL(xiangmubianma,'')<>'')jz,
 (SELECT COUNT(xiangmubianma) AS fkcount,SUM(shenqingjine) AS fksum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND   IFNULL(yifangkuanjine,0)>0 AND IFNULL(xiangmubianma,'')<>'')fk,
 (SELECT COUNT(xiangmubianma) AS fxcount,SUM(shenqingjine) AS fxsum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND   xiangmujieduan='01003' AND IFNULL(xiangmubianma,'')<>'')fx,
  (SELECT COUNT(xiangmubianma) AS qycount,SUM(shenqingjine) AS qysum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND   xiangmujieduan='01004' AND IFNULL(xiangmubianma,'')<>'')qy,
   (SELECT COUNT(xiangmubianma) AS pfcount,SUM(shenqingjine) AS pfsum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND    IFNULL(pifujine,0)>0   AND IFNULL(xiangmubianma,'')<>'')pf,
      (SELECT COUNT(xiangmubianma) AS bhcount,SUM(shenqingjine) AS bhsum  FROM `mis_auto_bklne`  WHERE mis_auto_bklne.`lixiangren`=".$val['id']."  AND     xiangmujieduan='01006'    AND IFNULL(xiangmubianma,'')<>'')bh
"; 
			$projectlist=$this->query($projectsql);
			$sqllist=reset($projectlist);
			if($deptlist[$val['deptid']]){
				$count++;
			}else{
				$count=0;
				//立项
				$lxcount=0;
				$lxsum=0;
				//尽职
				$jzcount=0;
				$jzsum=0;
				//风控
				$fkcount=0;
				$fksum=0;
				//风险
				$fxcount=0;
				$fxsum=0;
				//企业
				$qycount=0;
				$qysum=0;
				//批复
				$pfcount=0;
				$pfsum=0;
				$bhcount=0;
				$bhsum=0;
				$sqllist['isline']=1;
				$deptlist[$val['deptid']]=$val['deptid'];
			}
			$sqllist['userid']=$val['id'];
			$list[$val['deptid']][$val['id']]=$sqllist;
			//立项
			$lxcount+=$sqllist['lxcount'];
			$lxsum+=$sqllist['lxsum'];
			//尽职
			$jzcount+=$sqllist['jzcount'];
			$jzsum+=$sqllist['jzsum'];
			//风控
			$fkcount+=$sqllist['fkcount'];
			$fksum+=$sqllist['fksum'];
			//风险
			$fxcount+=$sqllist['fxcount'];
			$fxsum+=$sqllist['fxsum'];
			//企业
			$qycount+=$sqllist['qycount'];
			$qysum+=$sqllist['qysum'];
			//批复
			$pfcount+=$sqllist['pfcount'];
			$pfsum+=$sqllist['pfsum'];
			
			$bhcount+=$sqllist['bhcount'];
			$bhsum+=$sqllist['bhsum'];
			if($userlist[$key+1]['deptid']!=$val['deptid']){
				$list[$val['deptid']]['sumcount']=array(
						'count'=>$count,
						'lxcount'=>$lxcount,
						'lxsum'=>$lxsum,
						'jzcount'=>$jzcount,
						'jzsum'=>$jzsum,
						'fxcount'=>$fxcount,
						'fxsum'=>$fxsum,
						'fkcount'=>$fkcount,
						'fksum'=>$fksum,
						'qycount'=>$qycount,
						'qysum'=>$qysum,
						'pfcount'=>$pfcount,
						'pfsum'=>$pfsum,
						'bhsum'=>$bhsum,
				);
			}
		}
		$listArr['dept']=$deptlist;
		$listArr['list']=$list;
		return $listArr;
	}
	/**
	 * 
	 * @Title: getProgressMessage
	 * @Description: todo(获取项目详细信息)   
	 * @author renling 
	 * @date 2015年5月13日 下午2:10:34 
	 * @throws
	 */
	public function getProgressMessage(){
		//组装条件
		 $where="";
		 if($_REQUEST['uid']){
		 	$where.=" and mis_auto_bklne.`lixiangren`={$_REQUEST['uid']}";
		 }
		 if($_REQUEST['deptid']){
		 	$where.=" and mis_auto_bklne.`lixiangbumen`={$_REQUEST['deptid']}";
		 }
		 if($_REQUEST['jieduan']){
		 	$where.=" and xiangmujieduan='{$_REQUEST['jieduan']}'";
		 }
		 if($_REQUEST['pf']){//出具批复数
		 	$where.=" and IFNULL(pifujine,0)>0";
		 }
		 if($_REQUEST['fk']){//放款项目数
		 	$where.=" and IFNULL(yifangkuanjine,0)>0"; 
		 }
		$sql="SELECT 
  mis_auto_bklne.xiangmubianma xiangmubianma,
  mis_auto_bklne.dangqiankehmc AS kehumingchen,
  mis_auto_bklne.xiangmumingchen AS xiangmumingchen,
  mis_auto_bklne.zhudiao AS zhudiao,
  mis_sale_profession.name AS hangye,
  mis_sale_industry.name AS chanyelian,
  mis_system_flow_type.name AS jieduan,
  ROUND(mis_auto_bklne.pifujine / 1000, 2) AS amount,
  ROUND(
    mis_auto_bklne.yifangkuanjine / 1000,
    2
  ) AS yiamount,
  ROUND(
    mis_auto_bklne.zaibaojine / 1000,
    2
  ) AS zaiamout,
  ROUND(
    mis_auto_bklne.shenqingjine / 1000,
    2
  ) AS shenamount,
  mis_auto_bklne.shenqingyewuqixian AS shenqixian 
FROM
  mis_auto_bklne 
  INNER JOIN mis_sale_profession 
    ON mis_auto_bklne.xingye = mis_sale_profession.orderno 
  INNER JOIN mis_sale_industry 
    ON mis_auto_bklne.chanyelian = mis_sale_industry.orderno 
  INNER JOIN mis_system_flow_type 
    ON mis_auto_bklne.xiangmujieduan = mis_system_flow_type.orderno 
WHERE IFNULL(
    mis_auto_bklne.xiangmujieduan,
    ''
  ) <> '' {$where} ";
		$list=$this->query($sql);
		return $list;
	}
}
?>