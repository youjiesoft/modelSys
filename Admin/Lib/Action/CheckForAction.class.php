<?php
/**
 * @Title:自动匹配类
 * @Package 基类
 * @Description: 自动匹配所选择数据，并且能给其他页面元素赋值
 * @author 钟勇
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012年12年12日
 * @version V1.0
 */
class CheckForAction extends CommonAction{

	function check() {
		$con = $_POST['con'];
		$checkfor = $_POST['checkfor'] ? $_POST['checkfor'] : '';
		$limit = $_POST['limit'] ? $_POST['limit'] : 20;
		$order = $_POST['order'] ? $_POST['order'] : 'id asc';

		/*查询对象命名规范：
		 *@yangxi
		 *@data 2013/1/7
		 *类型①
		 *针对当前模型调用当前表的搜索——命名方法为：当前模型名称
		 *（首字母大写的驼峰写法，例如MisSalesProject；且在case块上要加入注释告知：谁创建的，谁修改的，得到搜索结果用于什么）
		 *类型②
		 *针对通用单表搜索——表命名方法为：去掉下划线的当前表名称
		 *（当前表首字母大写-与模型名称相同，例如MisSalesProject；且在case块上要加入注释告知：谁创建的，谁修改的，得到搜索结果用于什么）
		 *类型③
		 *针对通用多表搜索——表命名方法为：去掉下划线的主表名称
		 *（主表首字母小写:例如misSalesProject;且在case块上要加入注释告知：谁创建的，谁修改的，哪几个表联合搜索，得到搜索结果用于什么）
		 *类型④
		 *针对单独模块调用其他单表的搜索——命名方法为：当前模型名称+下划线+搜索表名
		 *（表名称首字母大写-与模型名称相同，例如MisSalesProject_User;且在case块上要加入注释告知：谁创建的，谁修改的，得到搜索结果用于什么)
		 *类型⑤
		 *针对单独模块调用其他多表的搜索——命名方法为：当前模型名称+下划线+搜索表名
		 *（表名称首字母小写,例如MisSalesProject_misProductCode;且在case块上要加入注释告知：谁创建的，谁修改的，哪几个表联合搜索，得到搜索结果用于什么）
		 *
		 */

		switch($checkfor){
			/*
			 *@创建人：arrowing
			 *@创建日期：2012/1/12
			 *类型一：通用的模型
			 *模型对象：搜索模板——Search
			 *作用：获取搜索模板的中英文名称
			 *@修改人：
			 *@修改日期：
			 *@修改目的：
			 */
			case 'searchTpl' :
				$fields = array(
				'id' => '0',
				'ename' => '模板英文名',
				'cname' => '模板中文名',
				);

				$dao = M('search');
				$map['_string'] = " ename like '%{$con}%' or cname like '%{$con}%' ";
				break;
				/*
				 *@创建人：arrowing
				 *@创建日期：2012/1/12
				 *类型一：通用的模型
				 *模型对象：项目类型——MisSalesProjectUser模型
				 *作用：获取项目
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'projectSearch' :
				$fields = array(
				'id' => '0',
				'name' => '项目名称',
				'startdate'=>'开始时间',
				'enddate'=>'竣工日期',
				'limittime'=>'合同工期',
				'principalcost'=>'0',
				'uname'=>'负责人'
				);
				$other = array(
								'projectname'=>'name',
								'startdate'=>'startdate',
								'enddate'=>'enddate',
								'limittime'=>'limittime',
								'createid'=>'uname',
								'principalcost'=>'principalcost',
				);
				$dao = M('mis_sales_project_user');
				$map['_string'] = "user.id=".$_SESSION[C('USER_AUTH_KEY')]." and mis_sales_project_user.condition=1 and mis_sales_project.name like '%{$con}%'";
				$join = 'left join user on mis_sales_project_user.uid=user.id
								left join  mis_sales_project  on mis_sales_project_user.projectid =mis_sales_project.id';
				$join_field = "mis_sales_project.name,mis_sales_project.id,FROM_UNIXTIME( mis_sales_project.startdate , '%Y-%m-%d' ) as startdate,FROM_UNIXTIME( mis_sales_project.enddate , '%Y-%m-%d' ) as enddate,mis_sales_project.limittime,user.name as uname ,mis_sales_project.principalcost as principalcost";
				break;
			case 'user':
				$fields = array(
					'id' => '0',
					'name' => '姓名',
					'orderno' => '工号',
					'departname' => '部门',
					'dutyname' => '职位'
					);
					$other = array(
					'name'=>'name',
					);
					$dao = M('user');
					$map['_string'] = "user.status=1 and (user.name like '%{$con}%' or mis_hr_personnel_person_info.name like '%{$con}%' or mis_system_department.name like '%{$con}%' or mis_hr_personnel_person_info.dutyname like '%{$con}%')";
					$join = ' left join mis_hr_personnel_person_info as mis_hr_personnel_person_info ON mis_hr_personnel_person_info.id = user.employeid left join mis_system_department as mis_system_department ON mis_system_department.id = mis_hr_personnel_person_info.deptid';
					$join_field = 'user.id,user.name,mis_hr_personnel_person_info.orderno,mis_hr_personnel_person_info.dutyname,mis_system_department.name as departname';
					break;
					/*
					 *@创建人：renling
					 *@创建日期：2013/3/28
					 *类型二：通用的多表模型
					 *作用：根据项目ID来查询里程碑名称，
					 *@修改人：
					 *@修改日期：
					 *@修改目的：
					 */
			case 'misProjectMilestoneMas' :
				$fields = array(
				'id' => '0',
				'name' => '里程碑名称',
				);
					
				$dao = M('mis_project_milestone_mas');
				$map['_string'] = "mis_sales_project.status=1 and (mis_project_milestone_sub.name like '%{$con}%')  and mis_project_milestone_sub.status=1 ";
				$join = ' left join mis_sales_project ON mis_project_milestone_mas.projectid= mis_sales_project.id left join mis_project_milestone_sub   ON mis_project_milestone_mas.id = mis_project_milestone_sub.masid';
				$join_field = '   mis_project_milestone_sub.name,mis_project_milestone_sub.id';
					
				break;
				/*
				 *@创建人：renling
				 *@创建日期：2013/7/13
				 *类型一：通用的模型
				 *模型对象：供应商——MisHrRegularEmployee模型
				 *作用：获取人事基本信息；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisHrRegularEmployee':
				$fields = array(
					'id'=>'0',
					'deptid' => '0',
					'sex'=>'0',
					'dutylevelid'=>'0',
					'chinaid'=>'0',
					'email'=>'0',
					'worktype'=>'0',
					'phone'=>'0',
					'orderno' => '员工编号',
					'name' => '员工名称',
				);
				$other = array(
							'username' =>'name',
							'otherdeptid' =>'deptid',
							'othersex' =>'sex',
							'otheremail' =>'email',
							'otherdutylevelid'=>'dutylevelid',
							'otherworktype'=>'worktype',
							'otherchinaid'=>'chinaid',
							'othermobilephone'=>'phone',
				);
				$dao = M('mis_hr_personnel_person_info');
				$map['_string'] = "status=1 and ( orderno like '%{$con}%' or name like '%{$con}%' )  and workstatus=2";
				break;
			case 'userandMisHR':
				$fields = array(
							'id'=>'0',
							'deptid' => '0',
							'sex'=>'0',
							'dutylevelid'=>'0',
							'chinaid'=>'0',
							'email'=>'0',
							'worktype'=>'0',
							'rolegroup_id'=>'0',
							'phone'=>'0',
							'orderno' => '员工编号',
							'name' => '员工名称',
				);
				$other = array(
							'username' =>'name',
							'otherdeptid' =>'deptid',
							'othersex' =>'sex',
							'otheremail' =>'email',
							'otherdutylevelid'=>'dutylevelid',
							'otherworktype'=>'worktype',
							'otherrolegroup_id'=>'rolegroup_id',
							'otherchinaid'=>'chinaid',
							'othermobilephone'=>'phone',
				);
				$dao = M('mis_hr_personnel_person_info');
				$map['_string'] = "mis_hr_personnel_person_info.status=1 and ( mis_hr_personnel_person_info.orderno like '%{$con}%' or mis_hr_personnel_person_info.name like '%{$con}%' )  and mis_hr_personnel_person_info.working=1";
				$join = ' left join mis_hr_job_info as mis_hr_job_info ON mis_hr_job_info.id = mis_hr_personnel_person_info.worktype ';
				$join_field ='rolegroup_id,email,orderno,phone,worktype,sex,chinaid,dutylevelid,mis_hr_personnel_person_info.id as id,mis_hr_personnel_person_info.deptid as deptid,mis_hr_personnel_person_info.name as name';
					
				break;
				/*
				 *@创建人：renling
					*@创建日期：2013/7/13
					*类型一：通用的模型
					*模型对象：正式员工——MisHrPersonnelManagement模型
					*作用：获取人事正式员工基本信息；可以继续添加
					*@修改人：
					*@修改日期：
					*@修改目的：
					*/
			case 'MisHrPersonnelManagement':
				$fields = array(
							'id'=>'0',
							'deptid' => '0',
							'sex'=>'0',
							'dutylevelid'=>'0',
							'deptname'=>'0',
							'dutyname'=>'0',
							'chinaid'=>'0',
							'worktype'=>'0',
							'worktypename'=>'0',
							'phone'=>'0',
							'email'=>'0',
							'indate'=>'0',
							'transferdate'=>'0',
							'dutyname'=>'0',
							'employeeheight'=>'0',
							'orderno' => '员工编号',
							'name' => '员工名称',
				);
				$other = array(
							'otherdeptid' =>'deptid',
							'othersex' =>'sex',
							'otherdutyname'=>'dutyname',
							'otherdutylevelid'=>'dutylevelid',
							'otherindate'=>'indate',
							'otherworktypename'=>'worktypename',
							'otherdeptname'=>'deptname',
							'othertransferdate'=>'transferdate',
							'otherworktype'=>'worktype',
							'otherchinaid'=>'chinaid',
							'othermobilephone'=>'phone',
							'otheremail'=>'email',
							'otherdutyname'=>'dutyname',
							'otheremployeeheight'=>'employeeheight',
				);
				$dao = M('mis_hr_personnel_person_info');
				$map['_string'] = "mis_hr_personnel_person_info.status=1 and ( mis_hr_personnel_person_info.orderno like '%{$con}%' or mis_hr_personnel_person_info.name like '%{$con}%' )  and working=1";
				$join = ' left join mis_system_department as mis_system_department ON mis_system_department.id = mis_hr_personnel_person_info.deptid left join  duty as duty ON duty.id = mis_hr_personnel_person_info.dutylevelid  left join  mis_hr_job_info as mis_hr_job_info ON mis_hr_job_info.id = mis_hr_personnel_person_info.worktype  ';
				$join_field = "mis_hr_personnel_person_info.status,mis_hr_personnel_person_info.orderno,mis_hr_personnel_person_info.id,mis_hr_personnel_person_info.name,mis_hr_personnel_person_info.deptid,mis_hr_personnel_person_info.sex,
							mis_hr_personnel_person_info.dutylevelid,mis_hr_personnel_person_info.chinaid,mis_hr_personnel_person_info.worktype,mis_hr_personnel_person_info.phone
							,mis_system_department.name as 'deptname',mis_hr_job_info.name as 'worktypename',duty.name as 'dutyname',mis_hr_personnel_person_info.phone,mis_hr_personnel_person_info.email,mis_hr_personnel_person_info.employeeheight,FROM_UNIXTIME(indate,'%Y-%m-%d') as 'indate',FROM_UNIXTIME(transferdate,'%Y-%m-%d') as 'transferdate'  ";
				break;
			case 'projectBudgetSearch' :
				$fields = array(
				'id' => '项目编号',
				'name' => '项目名称',
				);

				$dao = M('mis_sales_project');
				$map['_string'] = "mis_sales_project.status=1 and (mis_sales_project.name like '%{$con}%')  and mis_sales_project_budget.status=1   ";
				$join = ' left join mis_sales_project_budget  ON mis_sales_project_budget.projectid=mis_sales_project.id  ';
				$join_field = '  DISTINCT mis_sales_project.name,mis_sales_project.id   ';
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型二：通用的多表模型
				 *模型对象：后台用户——采购员
				 *作用：获取产品类型的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'user_purchaser' :
				$fields = array(
				'id' => '0',
				'name' => '姓名',
				'orderno' => '工号',
				'departname' => '部门',
				'dutyname' => '职位'
				);

				$dao = M('user');
				$map['_string'] = "user.status=1 and user.ispur=1 and (user.name like '%{$con}%' or mis_hr_personnel_person_info.orderno like '%{$con}%' or mis_system_department.name like '%{$con}%' or mis_hr_personnel_person_info.dutyname like '%{$con}%')";
				$join = ' left join mis_hr_personnel_person_info as mis_hr_personnel_person_info ON mis_hr_personnel_person_info.id = user.employeid left join mis_system_department as mis_system_department ON mis_system_department.id = mis_hr_personnel_person_info.deptid';
				$join_field = 'user.id,user.name,mis_hr_personnel_person_info.orderno,mis_hr_personnel_person_info.dutyname,mis_system_department.name as departname';

				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：产品类型——MisProductType模型
				 *作用：获取产品类型的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisProductType' :
				$fields = array(
				'id'=>'0',
				'code' => '类型编号',
				'name' => '类型名称',
				);

				$dao = M('mis_product_type');
				$map['_string'] = "status=1 and (name like '%{$con}%' or code like '%{$con}%')";
				break;
			case 'misInventoryWarehouse' :
				$fields = array(
				'id'=>'0',
				'code' => '仓库编号',
				'name' => '仓库名称',
				);
				$dao = M('mis_inventory_warehouse');
				$map['_string'] = "status=1 and (name like '%{$con}%' or code like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：采购申请单——MisPurchaseApplymas模型
				 *作用：获取采购申请单的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisPurchaseApplymas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '采购申请编号',
				);

				$dao = M('mis_purchase_applymas');
				$map['_string'] = "status=1 and ( orderno like '%{$con}%')";
				$join_field=" id,orderno,oamount as ctamount";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：采购合同——MisPurchaseContractmas模型
				 *作用：获取采购合同的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisPurchaseContractmas' :
				$fields = array(
					'id'=>'id',
					'orderno' => '采购合同编号',
					'name' => '采购合同名称',
					'ctamount' => '0',
				);
				$other = array(
						'purchasecontractmasname'=>'name'
						);
						$dao = M('mis_purchase_contractmas');
						$map['_string'] = "status=1 and (name like '%{$con}%' or orderno like '%{$con}%')";
						break;
						/*
						 *@创建人：yangxi
						 *@创建日期：2012/12/25
						 *类型一：通用的模型
						 *模型对象：采购订单——MisPurchaseOrdermas模型
						 *作用：获取采购订单的编码，名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisPurchaseOrdermas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '采购订单编号',
				'ctamount' => '0'
				);
				$other = array(
								'ctamount'=>'oamount'
								);


								$dao = M('mis_purchase_ordermas');
								$map['_string'] = "status=1 and ( orderno like '%{$con}%')";
								$join_field=" id,orderno,oamount as ctamount";
								break;
								/*
								 *@创建人：yangxi
								 *@创建日期：2012/12/25
								 *类型一：通用的模型
								 *模型对象：项目纵览——MisSalesProject模型
								 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
								 *@修改人：
								 *@修改日期：
								 *@修改目的：
								 */
			case 'MisSalesProject' :
				$fields = array(
				'id'=>'0',
				'code' => '项目编号',
				'name' => '项目名称',
				);
				$other = array(
						'projectcode'=>'code',
						'projectname'=>'name'
						);
						$dao = M('mis_sales_project');
						$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
						break;
						/*
						 *@创建人：lcx
						 *@创建日期：2013/7/15
						 *类型一：通用的模型
						 *模型对象：项目纵览——MisSalesContractmas模型
						 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisSalesContractmas' :
				$fields = array(
				'id'=>'0',
				'code' => '合同编号',
				'name' => '合同名称',
				'projectid'=>'0'
				);
				$other = array(
						'salescontractmasname'=>'name',
						'sacnoid'=>'id',
						'projectid'=>'projectid'
						);
						$dao = D('MisSalesContractmas');
						$map['_string'] = "status=1 and auditstate=3 and ( code like '%{$con}%' or name like '%{$con}%' )";
						break;
						/*
						 *@创建人：lcx
						 *@创建日期：2013/7/15
						 *类型一：通用的模型
						 *模型对象：项目纵览——MisSalesCustomer模型
						 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
						 *@修改人：rl
						 *@修改日期：2013/10/7
						 *@修改目的：不需要外联查找银行账户
						 */
			case 'MisSalesCustomer' :
				$fields = array(
				'id'=>'0',
				'code' => '客户编号',
				'name' => '客户名称',
				'taxno'=>'0',
				'caddr'=>'0',
				'tel'=>'0',
				'linkman'=>'0',
				'linktel'=>'0',
				'bankname'=>'0',
				'bank'=>'0'
				);
				$other = array(
						'salescustomername'=>'name',
						'taxno'=>'taxno',
						'caddr'=>'caddr',
						'tel'=>'tel',
						'linkman'=>'linkman',
						'linktel'=>'linktel',
						'caddr'=>'caddr',
						'bankname'=>'bankname',
						'bank'=>'bank'
						);
						$dao = D('MisSalesCustomer');
						$map['_string'] = "mis_sales_customer.status=1 and ( mis_sales_customer.code like '%{$con}%' or mis_sales_customer.name like '%{$con}%' )";
						break;
						/*
						 *@创建人：lcx
						 *@创建日期：2013/7/15
						 *类型一：通用的模型
						 *模型对象：项目纵览——MisProductCode模型
						 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisProductCode' :
				$fields = array(
				'id'=>'0',
				'code' => '产品编号',
				'name' => '产品名称',
				);
				$other = array(
						'productcodename'=>'name'
						);
						$dao = D('MisProductCode');
						$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
						break;
						/*
						 *@创建人：lcx
						 *@创建日期：2013/7/15
						 *类型一：通用的模型
						 *模型对象：项目纵览——MisConstructionTeam模型
						 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisConstructionTeam' :
				$fields = array(
				'id'=>'0',
				'code' => '班组编号',
				'name' => '班组名称',
				'managername' => '施工班组负责人',
				'placemanagername' => '现场施工员',
				);
				$other = array(
						'constructionteamname'=>'name',
						'managername'=>'managername',
						'placemanagername'=>'placemanagername',
				);
				$dao = D('MisConstructionTeam');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' or managername like '%{$con}%' or placemanagername like '%{$con}%' )";
				break;
				/*
				 *@创建人：lcx
				 *@创建日期：2013/7/15
				 *类型一：通用的模型
				 *模型对象：项目纵览——MisPurchaseConstructionContract模型
				 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisPurchaseConstructionContract' :
				$fields = array(
				'id'=>'0',
				'code' => '合同编号',
				'name' => '合同名称',
				);
				$other = array(
						'purchaseractname'=>'name'
						);
						$dao = D('MisPurchaseConstructionContract');
						$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
						break;
						/*
						 *@创建人：lcx
						 *@创建日期：2013/7/15
						 *类型一：通用的模型
						 *模型对象：银行账户——MisFinanceBankAccount模型
						 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinanceBankAccount' :
				$fields = array(
				'id'=>'0',
				'code' => '银行账号',
				'name' => '银行全称',
				);
				/* $other = array(
				 'purchaseractname'=>'name'
				 ); */
				$dao = D('MisFinanceBankAccount');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：供应商——MisPurchaseSupplier模型
				 *作用：获取供应商的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisPurchaseSupplier' :
				$fields = array(
				'id'=>'0',
				'code' => '供应商编号',
				'name' => '供应商名称',
				'sitename'=>'区域',
				);
				//这里与多元素联动相关，元素check_key属性值对应数组名suppliername的值
				//元素value赋值对应数组名name的值
				$other = array(
						'suppliername'=>'name',
						'suppliersitename'=>'sitename'
						);
						$dao = M('mis_purchase_supplier');
						$map['_string'] = "mis_purchase_supplier.status=1 and ( mis_purchase_supplier.code like '%{$con}%' or mis_purchase_supplier.name like '%{$con}%')";
						$join = ' left join mis_sales_site as s ON s.id = mis_purchase_supplier.siteid';
						$join_field = 'mis_purchase_supplier.id,mis_purchase_supplier.code,mis_purchase_supplier.name,s.name as sitename';
						break;
						/*
						 *@创建人：liminggang
						 *@创建日期：2012/12/25
						 *类型一：通用的模型
						 *模型对象：物资信息——misProductCode模型
						 *作用：获取物资编号和名称；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'misProductCode' :
				$fields = array(
					'id'=>'0',
					'code' => '苗木编号',
					'name' => '苗木名称',
					'prodsize'=>'规格',
					'baseunitname'=>'基本单位',
					'typename'=>'物料类型',
					'baseunitid'=>'0',
					'produtypeid'=>'0'
					);
					//这里与多元素联动相关，元素check_key属性值对应数组名neniuyproductname的值
					//元素value赋值对应数组名name的值
					$other = array(
					'neniuyproductname'=>'name',
					'neniuyproductsize'=>'prodsize',
					'neniuyproductunit'=>'baseunitid',
					'neniuyproductunitname'=>'baseunitname',
					'neniuyproducttypeid'=>'produtypeid',
					'neniuyproducttypename'=>'typename',
					);
					$dao = M('mis_product_code');
					$map['_string'] = "mis_product_code.status=1 and ( mis_product_code.code like '%{$con}%' or mis_product_code.name like '%{$con}%' or mis_product_code.prodsize like '%{$con}')";
					$join=' left join mis_product_unit as mis_product_unit ON mis_product_code.baseunitid = mis_product_unit.id left join mis_product_type as mis_product_type ON mis_product_type.id = mis_product_code.typeid';
					$join_field =' mis_product_code.id,mis_product_code.code,mis_product_code.name,mis_product_code.prodsize,mis_product_unit.name as baseunitname,mis_product_code.baseunitid,mis_product_type.id as produtypeid , mis_product_type.name as typename';
					break;
					/*
					 *@创建人：liminggang
					 *@创建日期：2013/05/20
					 *类型四：特殊模型
					 *模型对象：物资信息——MisProductType_MisProductCodeGoods模型
					 *作用：获取除苗木外的物资信息
					 *@修改人：
					 *@修改日期：
					 *@修改目的：
					 */
			case 'MisProductType_MisProductCodeGoods' :
				$fields = array(
				'id'=>'0',
				'code' => '物资编号',
				'name' => '物资名称',
				'prodsize'=>'规格',
				'baseunitid'=>'0',
				'baseunitname'=>'基本单位',
				);
				$other = array(
						'neniuyproductsize'=>'prodsize',
				);
				$dao = M('mis_product_code');
				$map['_string'] = "mis_product_code.status=1 and mis_product_type.typeid =1 and ( mis_product_code.code like '%{$con}%' or mis_product_code.name like '%{$con}%' or mis_product_code.prodsize like '%{$con}')";
				$join=' left join mis_product_unit as mis_product_unit ON mis_product_code.baseunitid = mis_product_unit.id
						left join mis_product_type as mis_product_type ON mis_product_type.id = mis_product_code.typeid';
				$join_field =' mis_product_code.id,mis_product_code.code,mis_product_code.name,mis_product_code.prodsize,mis_product_unit.name as baseunitname,mis_product_code.baseunitid as baseunitid';
				break;
				/*
				 *@创建人：liminggang
				 *@创建日期：2013/05/20
				 *类型四：特殊模型
				 *模型对象：物资信息——MisProductType_MisProductCodeNursery模型
				 *作用：获取苗木信息
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisProductType_MisProductCodeNursery' :
				$fields = array(
				'id'=>'0',
				'code' => '苗木编号',
				'name' => '苗木名称',
				'expend01'=>'高度',
				'expend02'=>'杆高',
				'expend03'=>'冠幅',
				'expend04'=>'胸径',
				'baseunitid'=>'0',
				'baseunitname'=>'基本单位',
				);
				$other = array(
						'productexpend01'=>'expend01',
						'productexpend02'=>'expend02',
						'productexpend03'=>'expend03',
						'productexpend04'=>'expend04',
				);
				$dao = M('mis_product_code');
				$map['_string'] = "mis_product_code.status=1 and mis_product_type.typeid =2 and ( mis_product_code.code like '%{$con}%' or mis_product_code.name like '%{$con}%')";
				$join=' left join mis_product_unit as mis_product_unit ON mis_product_code.baseunitid = mis_product_unit.id
						left join mis_product_type as mis_product_type ON mis_product_type.id = mis_product_code.typeid';
				$join_field =' mis_product_code.id,mis_product_code.code,mis_product_code.name,mis_product_code.expend01,mis_product_code.expend02,mis_product_code.expend03,mis_product_code.expend04,mis_product_unit.name as baseunitname,mis_product_code.baseunitid as baseunitid';
				break;
					
				/*
				 *@创建人：liminggang
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：员工基础信息——misHrPersonnelPersonInfo模型
				 *作用：获取员工姓名和ID；因为是通用的；可以继续添加
				 *@修改人：jiangx
				 *@目标： 查找人事表misHrPersonnelPersonInfo
				 *@修改日期：2012-10-25
				 *@修改目的：表改动 mis_hr_personnel_person_info
				 */
			case 'MisHrBasicEmployee' :
				$fields = array(
				'id'=>'0',
				'deptid' => '0',
				'name' => '姓名',
				'orderno' => '工号',
				);
				$other = array(
						'deptname'=>'deptid',
				);
				$dao = M('mis_hr_personnel_person_info');
				$map['_string'] = "status=1 and ( name like '%{$con}%')";
				break;
				/*
				 *@创建人：liminggang
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：员工基础信息——MisHrPersonnelPersonInfotwo模型
				 *作用：获取员工姓名和ID；因为是通用的；可以继续添加
				 *@修改人：
				 *@目标： 查找人事表misHrPersonnelPersonInfo 这里重复写了一个一样的。是因为页面2个调用同一个checkfor 而且查找带回来也是一样的。
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisHrPersonnelPersonInfotwo' :
				$fields = array(
				'id'=>'0',
				'deptid' => '0',
				'name' => '姓名',
				'orderno' => '工号',
				);
				$dao = M('mis_hr_personnel_person_info');
				$map['_string'] = "status=1 and ( name like '%{$con}%')";
				$join_field=' id,name,orderno,deptid';
				break;
				/*
				 *@创建人：wangcheng
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：会计科目——MisFinanceAmountTitle模型
				 *作用：获取会计科目的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisFinanceAmountTitle':
				$fields = array(
				'id'=>'0',
				'code' => '科目代码',
				'name' => '科目名称',
				'atype' => '科目类别',
				'debit'=> '借方',
				'credit' => '贷方',
				);
				$other = array(
						'accountcode'=>'code',
						'accountname'=>'name',
						'fdebit'=>'debit',
						'fcredit'=>'credit',
				);
				$dao = M('mis_finance_amount_title');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：成本中心——MisFinanceCostCenter模型
				 *作用：获取成本中心名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisFinanceCostCenter':
				$fields = array(
				'id'=>'0',
				'code' => '编码',
				'name' => '名称',
				'sname' => '搜索名称',
				);
				$other = array(
						'costcentercode'=>'code',
						'costcentername'=>'name',
				);
				$dao = M('mis_finance_cost_center');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2013/05/28
				 *类型一：通用的模型
				 *模型对象：公司对象——misSystemCompany模型
				 *作用：获取公司名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'misSystemCompany' :
				$fields = array(
				'id'=>'0',
				'name' => '公司名称',
				);
				$dao = M('mis_system_company');
				$map['_string'] = "status=1 and ( name like '%{$con}%')";
				break;
				/*
				 *@创建人：liminggang
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：销售区域对象——misSalesSite模型
				 *作用：获取销售区域名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'misSalesSite' :
				$fields = array(
				'id'=>'0',
				'name' => '区域名称',
				);
				$dao = M('mis_sales_site');
				$map['_string'] = "status=1 and ( name like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2013/01/14
				 *类型一：通用的模型
				 *模型对象：产品组对象——MisProductGroup模型
				 *作用：获产品组名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisProductGroup' :
				$fields = array(
				'id'=>'0',
				'name' => '物料组编码',
				'name' => '物料组名称',
				);
				$dao = M('mis_product_group');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：项目纵览——MisFinanceOrgcertifMas_MisInventoryIntoMas模型
				 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisFinanceOrgcertifMas_MisInventoryIntoMas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '验收单编号',
				'occurdate' => '到货日期',
				'amount' => '验收单金额',

				);
				$other = array(
						'intooccurdate'=>'occurdate',
						'intoamount'=>'amount'
						);
						$dao = M('mis_inventory_into_mas');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' ) and iforgcertif=0";
						$join_field=" id,orderno,FROM_UNIXTIME( occurdate, '%Y年%m月%d' ) as occurdate,amount ";
						break;
						/*
						 *@创建人：xiafengqin
						 *@创建日期：2013/04/08
						 *类型五：特殊的模型
						 *模型对象：费用类单据——MisFinanceOrgcertifMas_MisDeliveryIntoMas模型
						 *作用：获取费用类单据编号，单据日期，总金额；因为是通用的；可以继续添加，iforgcertif：支出证明已经生成
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinanceOrgcertifMas_MisDeliveryIntoMas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '单据编号',
				'handledate' => '单据日期',
				'amount' => '总金额',

				);
				$other = array(
						'intooccurdate'=>'handledate',
						'intoamount'=>'amount'
						);
						$dao = M('mis_delivery_into_mas');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' ) and iforgcertif=0";
						$join_field=" id,orderno,FROM_UNIXTIME( handledate, '%Y年%m月%d' ) as handledate,amount  ";
						break;
						/*
						 *@创建人：xiafengqin
						 *@创建日期：2013/04/08
						 *类型五：特殊的模型
						 *模型对象：费用类单据——MisFinanceOrgcertifMas_MisFinanceExpensesMas模型
						 *作用：获取费用类单据编号，单据日期，总金额；因为是通用的；可以继续添加iforgcertif：支出证明已经生成
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinanceOrgcertifMas_MisFinanceExpensesMas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '单据编号',
				'handledate' => '单据日期',
				'amount' => '总金额',

				);
				$other = array(
						'intooccurdate'=>'handledate',
						'intoamount'=>'amount'
						);
						$dao = M('mis_finance_expenses_mas');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' ) and iforgcertif=0";
						$join_field=" id,orderno,FROM_UNIXTIME( handledate, '%Y年%m月%d' ) as handledate,amount  ";
						break;
						/*
						 *@创建人：xiafengqin
						 *@创建日期：2013/04/08
						 *类型五：特殊的模型
						 *模型对象：费用类单据——MisFinanceOrgcertifMas_MisProjectPaymentMas模型
						 *作用：获取费用类单据编号，单据日期，总金额；因为是通用的；可以继续添加iforgcertif：支出证明已经生成
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinanceOrgcertifMas_MisProjectPaymentMas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '单据编号',
				'handeldate' => '截止日期',
				'avamount' => '审批支付金额',

				);
				$other = array(
						'intooccurdate'=>'handeldate',
						'intoamount'=>'avamount'
						);
						$dao = M('mis_project_payment_mas');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' ) and iforgcertif=0";
						$join_field=" id,orderno,FROM_UNIXTIME( handeldate, '%Y年%m月%d' ) as handeldate,avamount  ";
						break;
						/*
						 *@创建人：xiafengqin
						 *@创建日期：2013/04/08
						 *类型五：特殊的模型
						 *模型对象：费用类单据——MisFinanceOrgcertifMas_MisProjectCloseoutMas模型
						 *作用：获取费用类单据编号，单据日期，总金额；因为是通用的；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinanceOrgcertifMas_MisProjectCloseoutMas' :
				$fields = array(
				'id'=>'0',
				'orderno' => '单据编号',
				'handeldate' => '截止日期',
				'avamount' => '审批支付金额',

				);
				$other = array(
						'intooccurdate'=>'handeldate',
						'intoamount'=>'avamount'
						);
						$dao = M('mis_project_closeout_mas');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' ) and iforgcertif=0";
						$join_field=" id,orderno,FROM_UNIXTIME( handeldate, '%Y年%m月%d' ) as handeldate,avamount  ";
						break;
						/*
						 *@创建人：liminggang
						 *@创建日期：2013/1/16
						 *类型一：通用的模型
						 *模型对象：项目纵览之预算清单物资采购 —— MisSalesProjectBudget模型
						 *作用：获取预算清单分项项目名称，序号，编号，通用型。可以继续在后部追加字段。
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisSalesProjectBudget':
				$fields = array(
				'id'=>'序号',
				'c' => '分项项目编号',
				'd' => '分项项目名称',
				'g' => '单位',

				);
				$other = array(
						'nd'=>'id',
						'code'=>'c',
						'name'=>'d',
						'unit'=>'g',
				);
				$dao = M('mis_sales_project_budget');
				$map['_string'] = "status=1 and parentid = 0 and ( c like '%{$con}%' )";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2013/1/16
				 *类型四：
				 *模型对象：项目纵览之预算清单物资采购 —— MisFinanceBorrowsub_MisFinanceOrderTypes模型
				 *作用：在借款申请里面选取财务订单表里预先设置好的对应的单据，并获取到相关的值
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisFinanceBorrowsub_MisFinanceOrderTypes':
				$fields = array(
				'id'=>'id',
				'name' =>'单据类型',
				'modelname' => '0',

				);
				$other = array(
						'modelname'=>'modelname',
				//开启-关闭check_key功能，往前端页面赋值
				//0为开启，其他值为关闭，不写默认开启
						'no_set_key' => '1'
						);
						$dao = M('mis_finance_order_types');
						$map['_string'] = " type='MisFinanceBorrowmas' and status=1 and ( name like '%{$con}%' )";
						break;
						/*
						 *@创建人：yangxi
						 *@创建日期：2013/1/25
						 *类型四：
						 *模型对象：项目纵览之预算清单物资采购 —— MisFinanceBorrowsub_MisFinanceOrderTypes模型
						 *作用：在借款申请里面选取财务订单表里预先设置好的对应的单据，并获取到相关的值
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisFinancePayapplysub_MisFinanceOrderTypes':
				$fields = array(
				'id'=>'0',
				'name' =>'单据类型',
				'modelname' => '0',

				);
				$other = array(
						'modelname'=>'modelname',
				);
				$dao = M('mis_finance_order_types');
				$map['_string'] = " type='MisFinancePayapplyMas' and status=1 and ( name like '%{$con}%' )";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：费用类型——MisFinanceExpensesType模型
				 *作用：获取费用类型名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */

			case 'MisFinanceExpensesType':
				$fields = array(
				'id'=>'0',
				'code' => '费用类别编码',
				'name' => '费用类别名称',
				);
				$other = array(
						'code'=>'code',
						'name'=>'name',
				);
				$dao = M('mis_finance_expenses_type');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：费用类型——MisProductUnit模型
				 *作用：获取费用类型名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisProductUnit':
				$fields = array(
				'id'=>'0',
				'code' => '编码',
				'name' => '名称',
				);
				$dao = M('mis_product_unit');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%')";
				break;
				/*
				 *@创建人：liminggang
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：费用类型——MisProductType模型
				 *作用：获取费用类型名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisProductType':
				$fields = array(
				'id'=>'0',
				'code' => '分类编码',
				'name' => '分类名称',
				);
				$dao = M('mis_product_type');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' or sname like '%{$con}%')";
				break;

			case 'select_modele':
				$fields =array(
				'title' => '名称',
				'name' => '模块名称',);
				$dao = M('node');
				$map['_string'] = "type=3 and status=1 and ( title like '%{$con}%' or name like '%{$con}%')";
				break;
				/*
				 *@创建人：yangxi
				 *@创建日期：2012/12/25
				 *类型一：通用的模型
				 *模型对象：费用类型——MisFinanceExpensesType模型
				 *作用：获取费用类型名称；因为是通用的；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */

			case 'MisHrTypeinfo':
				$fields = array(
				'id'=>'0',
				'code' => '类别编码',
				'name' => '类别名称',
				);
				$other = array(
						'code'=>'code',
						'name'=>'name',
				);
				$dao = M('mis_hr_typeinfo');
				$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%')";
				break;

				/*
				 *@创建人：liminggang
				 *@创建日期：2013/3/20
				 *类型一：特殊模型
				 *模型对象：仓库和物料ID对实时库存的可用数量进行查询
				 *作用：获取仓库名称和实时库存可用数量
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisInventoryWarehouse_MisInventoryRealinfo':
				$fields = array(
				'id'=>'0',
				'name' => '名称',
				'doqty'=>'可用数量',
				);
				$other = array(
						'MisInventoryRealinfo_doqty'=>'doqty',
				//开启-关闭check_key功能，往前端页面赋值
				//0为开启，其他值为关闭，不写默认开启
						'no_set_key' => '1'
						);
						$dao = M('mis_inventory_warehouse');
						$map['_string'] = "mis_inventory_warehouse.status=1 and ( mis_inventory_warehouse.code like '%{$con}%' or mis_inventory_warehouse.name like '%{$con}%')";
						$join = ' left join mis_inventory_realinfo as mis_inventory_realinfo ON mis_inventory_realinfo.whid = mis_inventory_warehouse.id';
						$join_field = 'mis_inventory_warehouse.id,mis_inventory_warehouse.name,mis_inventory_realinfo.doqty';
						break;
						/*
						 *@创建人：renlin
						 *@创建日期：2013/5/14
						 *类型一：特殊模型
						 *模型对象：人事
						 *作用： 人事招聘信息报表招聘渠道检索
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'HrInviteresourcesSearch':
				$fields = array(
				'id'=>'0',
				'name' => '招聘渠道',
				);
				$dao = M('mis_hr_invitere_form');
				$map['_string'] = " mis_hr_typeinfo.status=1   and mis_hr_invitere_form.status=1  and   mis_hr_typeinfo.name like '%{$con}%'   and mis_hr_typeinfo.name<>'' ";
				$join = ' left join mis_hr_typeinfo as mis_hr_typeinfo ON mis_hr_typeinfo.id = mis_hr_invitere_form.inviteresources  ';
				$join_field = "mis_hr_typeinfo.name, mis_hr_typeinfo.id";
				break;
				/*
				 *@创建人：lcx
				 *@创建日期：2013/7/15
				 *类型一：特殊模型
				 *模型对象： 工程
				 *作用：
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisPrincipalInput':
				$fields = array(
				'id'=>'0',
				'orderno' => '项目编号',
				'name' => '项目名称',
				);
				$other = array(
						'projectname'=>'name'
						);
						$dao = M('mis_principal_input');
						$map['_string'] = " mis_principal_input.status=1 and mis_principal_input.auditstate=3 and mis_principal_input.orderno like '%{$con}%'   and mis_principal_input.orderno<>'' ";
						break;
						/*
						 *@创建人：renlin
						 *@创建日期：2013/5/14
						 *类型一：特殊模型
						 *模型对象： 采购
						 *作用： 采购报表采购订收货统计表存货分类名称检索
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'PurchaseReceiptproducttypecodeSearch':
				$fields = array(
				'id'=>'0',
				'code' => '存货分类编码',
				'name' => '存货分类名称',
				);
				$dao = M('mis_product_type');
				$map['_string'] = " mis_product_type.status=1  and     mis_product_type.name like '%{$con}%'   and mis_product_type.name<>'' ";
				$join_field = " DISTINCT mis_product_type.code ,mis_product_type.name";
				break;
			case 'PurchaseprodsizeSearch':
				$fields = array(
				'id'=>'0',
				'prodsize' => '物质规格',
				);
				$dao = M('mis_product_code');
				$map['_string'] = " mis_product_code.status=1  and     mis_product_code.prodsize like '%{$con}%'   and mis_product_code.prodsize<>'' ";
				$join_field = " DISTINCT  mis_product_code.prodsize";
				break;
				/*
				 *@创建人：renlin
				 *@创建日期：2013/5/14
				 *类型一：特殊模型
				 *模型对象： 物料入库
				 *作用： 仓储报表入库流水账 入库编号查询
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisInventoryIntoMas':
				$fields = array(
				'id'=>'0',
				'orderno' => '单据编号',
				);
				$dao = M('mis_inventory_into_mas');
				$map['_string'] = " mis_inventory_into_mas.status=1  and     mis_inventory_into_mas.orderno like '%{$con}%'  ";
				$join_field = " DISTINCT mis_inventory_into_mas.orderno";
				break;
			case 'Exnt_Tables':
				$database = C ('DB_NAME');
				$fields = array(
						'TABLE_NAME'=>'表名',
						'TABLE_COMMENT' => '表备注',
				);
				$dao = M("INFORMATION_SCHEMA.TABLES",'','',1);
				$join_field = "`TABLE_NAME`, IF(TABLE_COMMENT ='',TABLE_NAME,TABLE_COMMENT) AS `TABLE_COMMENT`";
				$map['_string'] = " TABLE_SCHEMA = '".$database."' AND (TABLE_NAME like '%{$con}%' OR TABLE_COMMENT like '%{$con}%')";
				$limit = false;
				$order = false;
				break;
			case 'Exnt_Table_column':
				$database = C ('DB_NAME');
				$fields = array(
						'COLUMN_NAME'=>'列名',
						'COLUMN_COMMENT' => '列备注',
				);
				$dao = M("INFORMATION_SCHEMA.columns",'','',1);
				$join_field = "`COLUMN_NAME`, IF(COLUMN_COMMENT ='',COLUMN_NAME,COLUMN_COMMENT) AS `COLUMN_COMMENT`";
				$map['_string'] = " TABLE_SCHEMA = '".$database."' AND (COLUMN_NAME like '%{$con}%' OR COLUMN_COMMENT like '%{$con}%')";
				$limit = false;
				$order = false;
				break;
			case 'isDynamic_Allocation':
				if($con == '- 动态配置名称列表 -'){
					$con = '';
				}
				$con = trim($con);
				$fields = array(
						'en'=>'动态配置名称',
						'ch' => '中文名称',
				);
				$dynamic_models = DConfig_PATH . "/Models/";
				$keys = scandir($dynamic_models);
				// 所有文件夹的名称中去掉头两项，即 .(当前文件夹) ..(上一级)
				$keys = array_slice($keys, 2);
				$values = array();
				foreach($keys as  $k => $v){
					$model = D('SystemConfigDetail');
					// 获取动态配置对应的中文名称
					$name = $model->getTitleName($v);
					if($name == ''){
						$name = "- 暂无命名 - ({$v}) ";
					}
					if ($con == ' - 动态配置名称列表 - '){
						$con = '';
					}
					if ($con){
						if (preg_match('/'.$con.'/',$name) || preg_match('/'.$con.'/',$v)) {
							$values[$k]['en'] = $v;
							$values[$k]['ch'] = $name;
						}
					} else {
						$values[$k]['en'] = $v;
						$values[$k]['ch'] = $name;
					}
				}
				//标示，标示为不一般情况
				$marking = true;
				break;
				/*
				 *@创建人：xiafengqin
				 *@创建日期：2013/8/22
				 *类型一：通用的模型
				 *模型对象：站内信——MisMessage模型
				 *作用：获取user表基本信息；可以继续添加
				 *@修改人：
				 *@修改日期：
				 *@修改目的：
				 */
			case 'MisMessage':
				$fields = array(
					'id' => '0',
					'name' => '姓名',
					'email' =>'邮箱',
					'mobile' => '电话',
					'departname' => '部门',
					'dutyname' => '岗位'
					);
					$other = array(
					'otherid' => 'id',
					'othername' => 'name',
					'otheremail' => 'email',
					'otheremail' => 'mobile',
					);
					$dao = M('user');
					$map['_string'] = "user.status=1 and (user.name like '%{$con}%' OR user.pinyin LIKE '%{$con}%' or mis_hr_personnel_person_info.name like '%{$con}%' or mis_system_department.name like '%{$con}%' or mis_hr_job_info.name like '%{$con}%')";
					$join = ' left join mis_hr_personnel_person_info as mis_hr_personnel_person_info ON mis_hr_personnel_person_info.id = user.employeid left join mis_system_department as mis_system_department ON mis_system_department.id = mis_hr_personnel_person_info.deptid  left join mis_hr_job_info as mis_hr_job_info ON mis_hr_job_info.id = mis_hr_personnel_person_info.worktype';
					$join_field = 'user.id,user.name,user.email,user.mobile,mis_hr_personnel_person_info.orderno,mis_hr_job_info.name as dutyname,mis_system_department.name as departname';
					break;
			case 'MisCystemSpecialCar':
				$fields = array(
				'id'=>'0',
				'code' => '车辆编号',
				'name' => '车辆名称',
				);
				$other = array(
						'specialcarname'=>'name'
						);
						$dao = D('MisSystemCar');
						$map['_string'] = "status=1 and ( code like '%{$con}%' or name like '%{$con}%' )";
						break;

						/*
						 *@创建人：xiafengqin
						 *@创建日期：2013/9/23
						 *类型一：通用的模型
						 *模型对象：办公设备异动——MisWorkFacilityAbnormalmove模型
						 *作用：获取user表基本信息；可以继续添加
						 *@修改人：
						 *@修改日期：
						 *@修改目的：
						 */
			case 'MisWorkFacilityAbnormalmove':
				$fields = array(
				'id'=>'0',
				'equipmenttypename' => '设备类型名称',
				'equipmentname'=>'设备名称',
				'equipmenttype'=>'0',
				'version'=>'0',
				'unit'=>'0',
				'qty'=>'0',
				'departmentid'=>'0',
				'departmentname'=>'0',
				'unitname'=>'0'
				);
				$other = array(
						'id'=>'id',
						'version'=>'version',
						'equipmenttype'=>'equipmenttype',
						'qty'=>'qty',
						'unit'=>'unit',
						'departmentid'=>'departmentid',
						'equipmentname'=>'equipmentname',
						'unitname'=>'unitname',
						'departmentname'=>'departmentname',
				);
				$dao = D('MisWorkFacilityManage');
				$map['_string'] = "mis_work_facility_manage.status=1 and ( mis_work_facility_type.name like '%{$con}%' )";
				$join = ' left join mis_work_facility_type  ON mis_work_facility_manage.equipmenttype=mis_work_facility_type.id  left join mis_system_department  ON mis_system_department.id=mis_work_facility_manage.departmentid  left join mis_product_unit  ON mis_product_unit.id=mis_work_facility_manage.unit';
				$join_field=" mis_work_facility_manage.id ,mis_work_facility_type.name  as 'equipmenttypename',equipmenttype,unit,mis_work_facility_manage.equipmentname  ,
						mis_work_facility_manage.version,mis_work_facility_manage.qty,mis_work_facility_manage.departmentid,mis_system_department.name as 'departmentname',mis_product_unit.name as 'unitname'";
				break;
				/*
				 *@创建人：jiangx
				 *@创建日期：2013/10/12
				 *类型一：通用的模型
				 *模型对象：民爆合同——MisBusinessContractCivilianBlasting模型
				 *作用：获取项目的编码，名称；因为是通用的；可以继续添加
				 *@修改人：rl
				 *@修改日期：2013/10/7
				 *@修改目的：不需要外联查找银行账户
				 */
			case 'MisBusinessContractCivilianBlasting' :
				$fields = array(
				'id'=>'0',
				'orderno' => '合同编号',
				'customerid' => '0',
				'customercode' => '0',
				'customername' => '客户名称',
				'taxno'=>'0',
				'caddr'=>'0',
				'tel'=>'0',
				'bankname'=>'0',
				'bank'=>'0'
				);
				$other = array(
						'Contractorderno'=>'orderno',
						'taxno'=>'taxno',
						'caddr'=>'caddr',
						'tel'=>'tel',
						'bankname'=>'bankname',
						'bank'=>'bank'
						);
						$dao = D('MisBusinessContractCivilianBlasting');
						$map['_string'] = "status=1 and ( orderno like '%{$con}%' )";
						break;
						/*
						 *@创建人：libo
						 *@创建日期：2014/3/11
						 *类型一：通用的模型
						 *模型对象：员工管理岗位——MisHrJobInfo模型
						 *作用：获取员工岗位基本信息；可以继续添加
						 */
			case 'MisHrJobInfo':
				$fields = array(
					'id' => '0',
					'deptid'=>'0',
					'name'=>'名称',
				);
				$other = array(
							'JobInfoid' => 'id',
							'JobInfoname' => 'name',
				);
				$dao = M('mis_hr_job_info');
				$map['_string'] = "mis_hr_job_info.status=1 and (mis_hr_job_info.name like '%{$con}%')";
				break;
			default:
				/*
				 * 这里是默认的checkfor，
				 * 重点：因为前面已经写了很多case必须保证default里面的checkfor不能和前面的case重复，不然是不会进入default
				 * 如果用这个默认的checkfor的话。必须保证checkfor为需要查询的表名
				 * fields:是在前端html以数组形式传入过来的显示字段，下拉列表里的字段
				 */
				$fields = array();
				$_POST['fields'] && eval("\$fields = ".str_replace("&#39;", "'", html_entity_decode($_POST['fields'])));
				$other = array();
				$_POST['other'] && eval("\$other = ".str_replace("&#39;", "'", html_entity_decode($_POST['other'])));
				//在这里组合一下本身有的条件
				$where = array();
				if($con){
					foreach($fields as $key=>$val){
						if($key != 'id'){
							$where[$key] = array("exp","like '%{$con}%'");
						}
					}
					$where['_logic']='or';
					$map['_complex']=$where;
				}
				//这里执行以下判断，如果传入过来的fields字段为空的话，直接不查询数据
				if(!$fields){
					$this->assign('notfound','<p>未配置查询字段！</p>');
				}
				//$dao=M($checkfor); // 原来的写法，nbmxkj@2014-11-04
				// 通过Model名获取真实表名
				$dao=M(D($checkfor)->getTableName());
		}

		if(isset($fields)){
			$field = implode(', ', array_keys($fields));
			//前端传参
			$map_arg = array();
			$_POST['map'] && eval("\$map_arg = ".str_replace("&#39;", "'", html_entity_decode($_POST['map'])));
			if(!$map){
				$map['_string'] = "status=1";
			}
			if($_POST['newconditions']){
				$newmap= str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),$_POST['newconditions']);
				if($map['_string']){
					$map['_string'].=" and ".$newmap;
				}else{
					$map['_string']="status=1 and ".$newmap;
				}
			}
			$map = array_merge($map, $map_arg);
			//测试点：前端传参
			//print_r($map);
			if(isset($join_field)){
				$field = $join_field;
			}
			if(isset($join)){
				$dao = $dao->join($join);
			}
			if ($marking) {
				//特殊情况 (当$checkfor === 'isDynamic_Allocation'时运用 )
				$checklist = $values;
			} else {
				//一般情况
				if(false === $limit && false === $order){
					//用于语句中没有要求限制条数和排序字段
					$checklist = $dao->where($map)->field($field)->select();
				}else{
					$checklist = $dao->where($map)->field($field)->order($order)->limit($limit)->select();
				}
				//调试点
				print_r($dao->getLastSql());
			}
		}

		if(count($checklist) > 0 && $checklist != false){
			$this->assign('fields',$fields);
			$this->assign('checklist',$checklist);
			$this->assign('other',json_encode($other));
		}else{
			$this->assign('notfound','<p>查不到记录！</p>');
		}
		if($_REQUEST['accesstype']='plugs')
		$this->display('CheckFor:plugsCheck');
		else
		$this->display();
	}

}
?>