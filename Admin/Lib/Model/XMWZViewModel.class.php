<?php
/**
 * @Title: XMWZViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-项目完整视图-提供给合同)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-03-07 18:05:35
 * @version V1.0
*/
class XMWZViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_bklne'=>array('_as'=>'mis_auto_bklne','projectid','orderno'=>'xmbm','xiangmumingchen'=>'xmmc','kehumingchen'=>'khbm','yixiangyinxing'=>'yxyhbm','pingshenqixian'=>'psrq','pingshenjine'=>'psje','yewuleixing','daikuanyongtu','daikuanyongtumiaoshu','yixiangdanbaofeilv','zhengshidanbaofeilv','yinxinglilv','rongzifangan','shenqingjine','shenqingyewuqixian','zhuti','xingye','chanyelian','zhudiao','fudiao','_on'=>'mis_auto_bklne.yixiangyinxing=mis_auto_qbvxq.orderno -- 合作银行档案 LEFT JOIN mis_auto_wrmve AS mis_auto_wrmve'),
		''=>array('_as'=>'','yingfuyinxingbaozhen','yinxingmingchen'=>'yxyhmc','yingshoukehubaozheng','baozhengjinzhanghumi','baozhengjinzhanghao','danbizuigaoe','teshuwenbenjiyaoqiu','shouxinedu','shouxinqixian',),
		''=>array('_as'=>'','pifuqixian','pifujine',),
		''=>array('_as'=>'','orderno'=>'zhtbh','hezuoyinxing'=>'hzyh','jiekuanhetonghao'=>'jkhth','yongkuandanhao'=>'ykdh','jiekuanjine'=>'jkje','weituodaikuanjiekuanhetonghao'=>'wtdkjkhth','weituodaikuanweituohetonghao'=>'wtdkwthth','zhuangtai'=>'zuhtzt','baozhenghetonghao'=>'bzhth','beizhu'=>'zuhtbz','pifudanhao','fangkuancishu',),
		''=>array('_as'=>'','hetongleixing'=>'htlx','fenshu'=>'zhtfs','hetongzhuanyongzhangqueren'=>'htzyzqr','mingzhangqueren'=>'mzqr','zhuangtai'=>'zihtzt','beizhu'=>'zihtbz','fandanbaocuoshibianhao'=>'fdbcs','pifudanhao','fandanbaocuoshibianh','fangkuanjine','fandanbaocuoshiheton',),
		''=>array('_as'=>'','qyfr','dianhuahaoma','youzhengbianma','zhucedizhi','chuanzhen','zhuyaojingyingjigous','zhusuodi','kaihuyinxing','kaihuzhanghu',),
		''=>array('_as'=>'','farendaibiao'=>'yffrdb','zhucedizhi'=>'yfzhucedizhi','nashuirendengjihao'=>'yfnashuirendengjihao','dianhuahaoma'=>'yfdianhuahaoma','kaihuyinxing'=>'yfkaihuyinxing','kaihuyinxingzhanghao'=>'yfkaihuyinxingzhanghao','zhuyaojingyingjigous'=>'yfzhuyaojingyingjigous','yingyezhizhaozhuceha'=>'yfyingyezhizhaozhuceha','youbian'=>'yfyoubian','chuanzhen'=>'yfchuanzhen',),
);
}
?>