			<?php
			/**
			 * @Title: MisSystemPanelIfpAction
			 * @Package package_name
			 * @Description: todo(自定义小块面板（个人首页，公司首页）)";
			 * @author 管理员
			 * @company 重庆特米洛科技有限公司";
			 * @copyright 本文件归属于重庆特米洛科技有限公司";
			 * @date 2015-12-03 14:59:05
			 * @version V1.08
			*/
			class MisSystemPanelIfpAction extends AutoPanelAction{
				function __construct(){
					parent::__construct();
					$this->id=20; 
				}
				public function setting(){
				}
				/**
				 * 显示当前面板内容
				 * @Title: showPanel
				 * @Description: todo(页面展示)
				 * @author 管理员
				 * @date 2015-12-03 14:59:05
				 * @throws
				 */
				public function showPanel(){
					import ( '@.ORG.Browse' );
					$submodel=M("mis_system_panel_desing_sub");
					$sublist = $submodel->where("masid=20")->select();
					$scdmodel = D("SystemConfigDetail");
					$map["status"]=1;
					foreach($sublist as $key=>$val){
						$model = $val["modelname"];
						$fields = explode(",",$val["showtitle"]);
						$defaultwidth = (int)100/count($fields);
						$temp = explode(",",$val["showtitle"]);
							$newfields = array();
						foreach($temp as $tk=>$tv){
							$temparr = explode("|",$tv);
							$newfields[$temparr[0]]['name'] = $temparr[0];
							$newfields[$temparr[0]]['width'] = $temparr[1];
							$newfields[$temparr[0]]['sort'] = $temparr[2];									
								
						}
						sortArray($newfields , 'sort','asc','number');
						$detailList = $scdmodel->getDetail($model,false);
						$sublist[$key]['link'] = __APP__."/".$model."/index";
						$sublist[$key]['rel'] = $model;
						$newd = array();
						foreach($newfields as $k=>$v){
							foreach($detailList as $dk=>$dv){
								if($v['name']==$dv['name']){
									$newd[$k] = $dv;
									$newd[$k]['shows'] =1;
									$newd[$k]['sortnum'] = $v['sort'];
									if(strpos('px',$v['width'])>0||strpos('PX',$v['width'])>0||strpos('Px',$v['width'])>0){
										$newd[$k]['widths'] = $v['width'];
									}else{
										$newd[$k]['widths'] = $v['width']?$v['width']."%":$defaultwidth."%";
									}
									
								}
							}
						}
						$sublist[$key]["detailList"] = $newd;
						//具体数据1
						$listmodel = D($model);
						$val['num'] = $val['num']?$val['num']:5;
						$time2 = time();
						$part = array (
										'&quot;',
										'&#39;',
										'&lt;',
										'&gt;',
										'==' ,
										"\$time",
										"\$uid"
								);
						$replacepart = array (
										'"',
										"'",
										'<',
										'>',
										'=' ,
										$time2,
										$_SESSION[C("USER_AUTH_KEY")]
								);
						//面板条件
						if($val['map']){
							$val["map"] = str_replace($part,$replacepart, $val["map"] );
								// 把条件加入map 中
							$map["_string"] =$val["map"];
						}
						//更多按钮的条件
						if($val["morerules"]){
							$val["moresmap"] = str_replace ($part,$replacepart,$val["morerules"] );
						}						
						//验证浏览及权限 
						if( !isset($_SESSION['a']) ){
							$map=D('User')->getAccessfilter($model,$map);	
						}
						//获取当前模型数据权限 by renl 20150626
						$broMap = Browse::getUserMap ($model);
						if($broMap){
							if($map['_string']){
								$map['_string'].=" and ".$broMap;
							}else{
								$map['_string']=$broMap;
							}
						}
						if($val['showsort']){
							$order = $val['showsort'];
						}else{
							$order = 'id desc';
						}
						$list = $listmodel->where($map)->order($order)->limit($val['num'])->select();
						$sublist[$key]["list"] = $list;
						if( $val["moresmap"]){
							$sublist[$key]["moresmap"] = base64_encode( $val["moresmap"]);
						}else{
							$sublist[$key]["moresmap"] = '';
						}
						unset($map["_string"]);
					}
					$this->assign("sublist",$sublist);
					$this->display("MisSystemPanelDesingMas:news");
				}
			}
		