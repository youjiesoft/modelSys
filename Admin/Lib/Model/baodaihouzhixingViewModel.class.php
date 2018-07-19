<?php
/**
 * @Title: baodaihouzhixingViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-保贷后执行视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-11-13 11:56:57
 * @version V1.0
*/
class baodaihouzhixingViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_wmahy'=>array('_as'=>'mis_auto_wmahy','orderno','fengxiandengji'=>'daihoufengxiandengji','baohouleixing','jihuakaishiriqi','jihuawanchengriqi','shifuyouyanqishenqin','shenqingyanqiriqi','baohoubaogaodanhao','jihuadanhao','_type'=>'LEFT'),
		'system_info_xiangmu'=>array('_as'=>'system_info_xiangmu','projectid','xiangmubianma','xiangmumingchen','kehumingchen','dangqiankehmc','zhuti','xingye','chanyelian','yewuleixing','shangjibianhao','canzhaoxiangmubianha','zixunxiangmubianma','zhudiao','fudiao','daikuanyongtu','daikuanyongtumiaoshu','rongzifangan','zaibaojine','shenqingjine','shenqingyewuqixian','yifangkuanjine','shengyujine','pifuqixian','pifujine','lixiangbumen','lixiangren','fengxiandengji','fengxianxiangmuzhuan','fengxianxiangmulixia','lixiangriqi','kehudizhi','youbian','xiangmujieduan','yewujianyijine','yewujianyiqixian','fengkongjianyijine','fengkongjianyiqixian','zhuanjiajianyijine','zhuanjiajianyililv','pifuchujuriqi','canzhaoxiangmuyewule','canzhaoxiangmufengxi','zhutileixing','zhuanjiajianyiqixian','yewuyuanjianyijine','yewuyuanjianyiqixian','fengkongyuanjianyiji','fengkongyuanjianyiqi','yewuyuanyijian','fengkongyuanyijian','yewubuyijian','fengkongbuyijian','zhuanjiayijian','xiangmuleixing','pifudanhao','jiekuanzhuti','zhuanjiajianyishouqu','zhuanjiajianyiweidai','baodaihourenyuan','fengxianpingshenreny','xiangmudangqianfengx','xiangmujingli','fengkongjingli','baohoujingli','caiwuguwenfei','yixiangyinxing','baodaihoufudiao','yixiangdanbaofeilv','danbaojiekuanleixing','chanpinleixing','shijikongzhiren','shijikongzhirenshenf','quyu','areainfo33','areainfo34','youzhengbianma','zhuyaolianxirendianh','chuanzhen','farendaibiao','kaihuyinxing','kaihuzhanghu','nashuirendengjihao','chengliriqi','zhuceziben','_on'=>'system_info_xiangmusystem_info_xiangmu.projectid=mis_auto_wmahysystem_info_xiangmu.projectid'),
);
}
?>