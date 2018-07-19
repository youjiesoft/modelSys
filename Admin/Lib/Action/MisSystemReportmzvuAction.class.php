			<?php
				/**
				 * @Title: MisSystemReportmzvuAction
				 * @Package package_name
				 * @Description: todo(报表)";
				 * @author 管理员
				 * @company 重庆特米洛科技有限公司";
				 * @copyright 本文件归属于重庆特米洛科技有限公司";
				 * @date 2016-01-15 15:55:28
				 * @version V1.08
				*/
				class MisSystemReportmzvuAction extends AutoPanelAction{
					public function setting(){
					}
					public function getConfig(){
					}
					/**
					 * 显示当前面板内容
					 * @Title: showPanel
					 * @Description: todo(页面展示)
					 * @author 管理员
					 * @date 2016-01-15 15:55:28
					 * @throws
					 */
					public function showPanel(){
						$submodel=M("mis_system_panel_desing_sub");
						$sublist = $submodel->where("id=188")->find();
						$this->assign("sublist",$sublist);
						$this->display("MisSystemPanelDesingMas:report");
					}
					public function index(){
						$submodel=M("mis_system_panel_desing_sub");
						$sublist = $submodel->where("id=188")->find();
						$this->assign("sublist",$sublist);
						$this->display("MisSystemPanelDesingMas:reportindex");
					}
				}	
		