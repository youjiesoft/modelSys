<?php
/**
 * @Title: MisAutoAamAction
 * @Package package_name
 * @Description: todo(动态表单_扩展类。本类为用户代码注入入口，系统一旦生成将不再重复生成。
 * 						但当用户选为组合表单方案后会更新该文件，请做好备份)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-03-20 10:10:40
 * @version V1.0
*/
class MisAutoAamExtendAction extends CommonAction {
	public function _extend_filter(&$map){
	}
	/**
	 * @Title: _extend_before_index
	 * @Description: todo(扩展前置index函数)
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws 
	*/
	function _extend_before_index() {
	}
	/**
	 * @Title: _extend_before_edit
	 * @Description: todo(扩展的前置编辑函数)
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws 
	*/
	function _extend_before_edit(){
	}
	/**
	 * @Title: _extend_before_insert
	 * @Description: todo(扩展的前置添加函数)
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws 
	*/
	function _extend_before_insert(){
		$model=M('mis_auto_fuhhu_sub_datatable5');
		$map['id']=$_REQUEST['zhaojidansubid'];
		$vo = $model->where($map)->find();
		
		//查询用户是内部评审还是外部评审
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$neibuArr= explode(',',$vo['neiburenyuan']);
		$waibuArr= explode(',',$vo['waiburenyuan']);
		$waibulist=in_array($userid,$waibuArr);
		$neibulist=in_array($userid,$neibuArr);
		if($waibulist){
			$_POST['expertid']=$_SESSION[C('USER_AUTH_KEY')] ;
		}else{
			$_POST['userid']=$_SESSION[C('USER_AUTH_KEY')] ;
		}
		$_POST['biaojueren']=$_SESSION[C('USER_AUTH_KEY')];
		$_POST['operateid']=1;
	}
	/**
	 * @Title: _extend_before_update
	 * @Description: todo(扩展前置修改函数)  
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws
	*/
	function _extend_before_update(){
	$model=D($this->getActionName());
		$id = $_REQUEST [$model->getPk ()];
		$list=$model->where('id='.$id)->find();
		//查询召集单子表表决人，评审模式
		 $Vphsubmodel=M('mis_auto_fuhhu_sub_datatable5');
		$vphModel=M('mis_auto_fuhhu');
		$subList=$Vphsubmodel->where('id='.$list['zhaojidansubid'])->find();
		//查询模式中值
		$moshiModel=M('mis_auto_svsxe');
		$moshiId=$subList['pinggumoshi'];
		$moshiList=$moshiModel->where('id='.$moshiId)->find();
		$number=$moshiList['neiburenyuanrenshu']+$moshiList['waiburenyuanrenshu'];
		if($list['pingshenyijian']==1){
			if($_REQUEST['pingshenyijian']!=1){
				 if($subList['tongyiren']!=null){
					 $data['tongyiren']=$subList['tongyiren']-1;
				}
				if($data['tongyiren']>=$moshiList['pingshentongguopanding']){
						$data['shifoutongguo']=1;
				}else{
						$data['shifoutongguo']=0;
				}  
				if($subList['tongyiren']>=$moshiList['pingshentongguopanding']){
					$data['shifoutongguo']=1;
				}else{
					$data['shifoutongguo']=0;
				}
			}
		}else{
			if($_REQUEST['pingshenyijian']==1){
				 if($subList['tongyiren']!=null){
					$data['tongyiren']=$subList['tongyiren']+1;
				}else{
					$data['tongyiren']=1;
				}
				if($data['tongyiren']>=$moshiList['pingshentongguopanding']){
					$data['shifoutongguo']=1;
				}else{
					$data['shifoutongguo']=0;
				} 
				if($subList['tongyiren']>=$moshiList['pingshentongguopanding']){
					$data['shifoutongguo']=1;
				}else{
					$data['shifoutongguo']=0;
				}
			}
		}
		$Vphsubmodel->where('id='.$list['zhaojidansubid'])->save($data);
		//查询当前召集单所有子表
		$vphsubInfo=$Vphsubmodel->where('masid='.$list['zhaojidanid'])->select();
		foreach ($vphsubInfo as $key=>$val){
			$biaojueStatus[]=$val['biaojueSatatus'];
		}
		if(!in_array(0,$biaojueStatus)&& !in_array(null,$biaojueStatus)){
			$vphModel->where('id='.$list['zhaojidanid'])->save(array('conveneStatus'=>'3'));
		} 
		$_POST['operateid']=1;
	}
	/**
	 * @Title: _extend_after_edit
	 * @Description: todo(扩展后置编辑函数)
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws 
	*/
	function _extend_after_edit($vo){
	}
	/**
	 * @Title: _extend_after_list
	 * @Description: todo(扩展前置List)
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws 
	*/
	function _extend_after_list(){
	}
	/**
	 * @Title: _extend_after_insert
	 * @Description: todo(扩展后置insert函数)  
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws
	*/
	function _extend_after_insert($id){
		$model=D($this->getActionName());
		$list=$model->where('id='.$id)->find();
		//查询召集单子表表决人，评审模式
		$Vphsubmodel=M('mis_auto_fuhhu_sub_datatable5');
		$vphModel=M('mis_auto_fuhhu');
		$subList=$Vphsubmodel->where('id='.$list['zhaojidansubid'])->find();
		//查询模式中值
		$moshiModel=M('mis_auto_svsxe');
		$moshiId=$subList['pinggumoshi'];
		$moshiList=$moshiModel->where('id='.$moshiId)->find();
		$number=$moshiList['neiburenyuanrenshu']+$moshiList['waiburenyuanrenshu'];
		if($list['pingshenyijian']==1){
			if($subList['tongyiren']!=null){
				$data['tongyiren']=$subList['tongyiren']+1;
			}else{
				$data['tongyiren']=1;
			}
			if($data['tongyiren']>=$moshiList['pingshentongguopanding']){
				$data['shifoutongguo']=1;
			}else{
				$data['shifoutongguo']=0;
			}
			if($subList['tongyiren']>=$moshiList['pingshentongguopanding']){
				$data['shifoutongguo']=1;
			}else{
				$data['shifoutongguo']=0;
			}
		}
		//查询用户是内部评审还是外部评审
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$neibuArr= explode(',',$subList['neiburenyuan']);
		$waibuArr= explode(',',$subList['waiburenyuan']);
		$waibulist=in_array($userid,$waibuArr);
		$neibulist=in_array($userid,$neibuArr);
		if($waibulist){
			if($subList['expertid']!=null){
				$subArr=explode(',',$subList['expertid']);
				$subArr[]=$_SESSION[C('USER_AUTH_KEY')];
				$data['expertid']=implode(',',$subArr);
			}else{
				$data['expertid']=$_SESSION[C('USER_AUTH_KEY')];
			}
		}else{
			if($subList['userid']!=null){
				$subArr=explode(',',$subList['userid']);
				$subArr[]=$_SESSION[C('USER_AUTH_KEY')];
				$data['userid']=implode(',',$subArr);
			}else{
				$data['userid']=$_SESSION[C('USER_AUTH_KEY')];
			}
		}
		
		$data['biaojuerennum']=$subList['biaojuerennum']+1;
		//查询当前项目表决数
		$bmap['zhaojidansubid']=$list['zhaojidansubid'];
		$bmap['zhaojidanid']=$list['zhaojidanid'];
		$bcount=$model->where($bmap)->count();
		if($data['biaojuerennum']==$number || $bcount==$number){
			$data['biaojueSatatus']=1;
		}
			
		$vlist=$Vphsubmodel->where('id='.$list['zhaojidansubid'])->save($data);
		if($vlist===false){
			logs($Vphsubmodel->getLastSql() , 'MisAutoAam_after_insert_'.date('Y-m-d-H' , time()) ,'',__CLASS__,__FUNCTION__,__METHOD__);
			$this->error('回写召集表决人失败');
		}
		//查询当前召集单所有子表
		$vphsubInfo=$Vphsubmodel->where('masid='.$list['zhaojidanid'])->select();
		foreach ($vphsubInfo as $key=>$val){
			$biaojueStatus[]=$val['biaojueSatatus'];
		}
		if(!in_array(0,$biaojueStatus) && !in_array(null,$biaojueStatus)){
			$vphModel->where('id='.$list['zhaojidanid'])->save(array('conveneStatus'=>'3'));
		}
	}
	/**
	 * @Title: _extend_before_add
	 * @Description: todo(扩展前置add函数)  
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws
	*/
	function _extend_before_add(&$vo){
		$this->getFormIndexLoad($vo);
	}
	/**
	 * @Title: _extend_after_update
	 * @Description: todo(扩展后置update函数)  
	 * @author 管理员
	 * @date 2015-03-20 10:10:40
	 * @throws
	*/
	function _extend_after_update(){
	}
	/**
	 * 表单参数重写
	 * @Title: rebuildSetting
	 * @Description: todo(表单参数重写)
	 * @param array $setting 原始配置值
	 * @return array
	 * @author quqiang
	 * @date 2016年1月6日 下午5:28:55
	 * @throws
	 */
	function rebuildSetting(){
		$setting=array();
		$setting['hiddens']="<input type=hidden value=MisAutoAam name=jumpaction />"
				."<input type=hidden name=refreshtabs[data] value=1 />"
				."<input type=hidden name=callbackType value=closeCurrent />";
		$setting['callback']=array(
				// 套表时二开使用的
				'common'=>'return validateCallback(this, navTabAjaxDone)', // 普通表单时使用回调
				'audit'=>'return validateCallback(this, navTabAjaxDone)',// 审批表时使用的回调
	
				// 非套表时二开使用
				'callback'=>'return iframeCallback(this, navTabAjaxDone)',
		);
		$setting['url']=array(
				'add' =>'updateControll', 	// 新增页面操作提交地址
				'edit' =>'updateControll', 	// 修改页面操作提交地址
				'add' =>'updateControll', 	// 查看页面操作提交地址
		);
		// 地址栏附加参数
		$setting['urlparame']='/rel/MisAutoZpgindexview';
		return $setting;
	}
}
?>