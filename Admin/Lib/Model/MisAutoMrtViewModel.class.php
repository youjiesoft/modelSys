<?php
/**
 * @Title: MisAutoMrtModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-专家评审会申请)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-09-23 14:11:25
 * @version V1.0
*/
class MisAutoMrtViewModel extends ViewModel {
			
	function __construct(){
		parent::__construct();
		$arr = getModelFilterByNodeSetting();
		if(is_array($arr)){
			$this->_filter = $arr;
		}
	}
	// 字段权限过滤
	protected $_filter = array();
		public $viewFields = array(
	'mis_auto_sdkln'=>array('id','xiangmubianhao','xiangmumingchen','kehumingchen','canpingjine','pingshenjine','pingshenjianyijine','pingshenleixing','canpinglilv','canpingqixian','pingshenlilv','pingshenqixian','huizongshuoming','shenqingjine','shenqingqixian','yewubujianyijine','fengkongbujianyijine','yewubujianyiqixian','fengkongbujianyiqixi','shifufuyixiangmu','danbaofeilv','yewuleixing','zijinyongtu','shifupingshen','pingshenhuiyijiyaona','yewurenyuanyijian','yewurenyuanjianyijin','yewurenyuanjianyiqix','fengkongrenyuanyijia','fengkongrenyuanjiany','fengkongrenyuanjianyf','yewubuyijian','fengkongbuyijian','pingshenmoshi','jiekuanzhuti','weidaifeilv','baozhengjinlv','dangqianfengxiandeng','pingshenjiyaoyinyong','pingshenfujian','shifushanghui','shanghuishijian','zhaojidanhao','jianyidanbaofeilv','danbaojiekuanleixing','pingshenhuibeizhu','zhuanjiajianyizhitou','zhuanjiajianyizhitoub','zhuanjiayijian','rugubili','peiyumubiao','zhuanjiajianyizongji','yewurenyuanjianyizhi','yewurenyuanjianyizhib','fengkongrenyuanjianyfg','fengkongrenyuanjianyk','yewurenyuanjianyizon','fengkongrenyuanjianyr','zhudiao','fengkongrenyuan','baozhengjinjianmianl','yixiangdanbaofeilv','touzirennianhuashouy','kehujichuxinyonglian','yewurenyuanjianyijie','yewurenyuanjianyijiet','fengkongrenyuanjianyq','fengkongrenyuanjianyn','chanpinleixing','jijianfuwufeilv','shifusanchanronghexi','bushanghuimiaoshu','upload64','bindid','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','relationmodelname','auditUser','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','allnode','informpersonid','parentid','name','_type'=>'LEFT'),
);
}
?>