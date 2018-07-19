<?php
/**
 * @Title: MisSalesMyProjectAction 
 * @Package package_name
 * @Description: todo(项目管理 里的我的项目) 
 * @author xiafengqin 
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2013-6-1 上午9:31:36 
 * @version V1.0
 */
class MisSalesMyProjectForWmAction extends Action {
	public function index() {
		$MisWorkExecutingModel = D("MisWorkExecuting");
		$MisWorkExecutingModel->_filter("MisSalesMyProject",$map);
		print_r($map);
	}
}
?>
