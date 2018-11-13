<?php
/**
 * @Title: MisAutoVphModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-评审召集单_普通表单)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-17 16:20:47
 * @version V1.0
*/
class MisAutoZpgSubViewModel extends ViewModel {
	public $viewFields = array(
			"mis_auto_fuhhu_sub_datatable5"=>array('_as'=>'mis_auto_fuhhu_sub_datatable5','id','masid','pingshenhuiid','xiangmubianma','xiangmumingchen','kehumingchen','shenqingjine', 'shenqingqixian','lilv','pinggumoshi','neiburenyuan','neiburenyuanname','waiburenyuan','waiburenyuanname','pingshenjine','pingshenqixian','pingshenlilv','biaojueSatatus','shifoutongguo','userid','expertid','biaojuerennum','tongyiren','shanghuishunxu','pingshenjieguo','projectid','shifouhuizong','shifoujieshu','_type'=>'LEFT'),
			"mis_auto_fuhhu"=>array('_as'=>'mis_auto_fuhhu','id'=>'zhaojidanid','mingchen'=>'zhaojimingchen','pingshenshijian'=>'pingshenshijian','huiyishi'=>'huiyishi','beizhu'=>'beizhu','pingshenhuileixing'=>'pingshenhuileixing','conveneStatus'=>'conveneStatus','status'=>'status','_on'=>'mis_auto_fuhhu.id=mis_auto_fuhhu_sub_datatable5.masid'),
			"mis_auto_aaaak"=>array('_as'=>'mis_auto_aaaak','id'=>'biaojueid','orderno','xiangmumingchen'=>'biaojuemingchen','jianyijine'=>'jianyijine','jianyiqixian'=>'jianyiqixian','jianyililv'=>'jianyililv','zhaojidansubid'=>'zhaojidansubid','zhaojidanid'=>'zhaojidanid','pingshenyijian'=>'pingshenyijian','fengxiandingjiayijia'=>'fengxiandingjiayijia','fengxiandingjialiyou'=>'fengxiandingjialiyou','jianyi'=>'jianyi','userid'=>'buserid','expertid'=>'bexpertid','pingshenweiyuanleixi'=>'pingshenweiyuanleixi','fandanbaocuoshishifu'=>'fandanbaocuoshishifu','shifushoufei'=>'shifushoufei','pinggufeiyong'=>'pinggufeiyong','jianyidanbaolv'=>'jianyidanbaolv','shouqubaozhengjinbil'=>'shouqubaozhengjinbil','yewuleixing'=>'yewuleixing','zijinyongtu'=>'zijinyongtu','_on'=>'mis_auto_aaaak.zhaojidansubid=mis_auto_fuhhu_sub_datatable5.id'),

			);
}
?>