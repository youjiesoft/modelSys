			
<?php
/**
 * @Title: MisSystemPanelNivAction
 * @Package package_name
 * @Description: todo(自定义小块面板（个人首页，公司首页）)";
 * @author 管理员
 * @company 重庆特米洛科技有限公司";
 * @copyright 本文件归属于重庆特米洛科技有限公司";
 * @date 2016-03-15 09:45:11
 * @version V1.08
*/
class MisSystemPanelNivAction extends AutoPanelAction{
	function __construct(){
					parent::__construct();
					$this->id=74; 
				}
	public function setting(){
	}

	/**
	 * 显示当前面板内容
	 * @Title: showPanel
	 * @Description: todo(页面展示)
	 * @author 管理员
	 * @date 2016-03-15 09:45:11
	 * @throws
	 */
	public function showPanel(){
		$submodel=M("mis_system_panel_desing_sub");
		$sublist = $submodel->where("masid=74")->find();
		$this->assign("sublist",$sublist);
		$this->display("MisSystemPanelDesingMas:report");
	}
	public function index(){
		$this->showPanel();
	}
}
			