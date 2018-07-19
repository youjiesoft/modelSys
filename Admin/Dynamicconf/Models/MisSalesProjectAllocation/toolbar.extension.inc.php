<?php 
return array(
	'js-allot' => array(
			'ifcheck' => '0',
			'rules' => '#type#==1',
			'permisname' => 'missalesprojectallocation_allot',
			'html' => '<a class="js-allot icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesProjectAllocation/projectallot/id/{sid_node}" rel="MisSalesProjectAllocationprojectallot" target="navTab"  title="任务分派"><span><span class="icon icon-stackexchange icon_lrp"></span>任务分派</span></a>',
			'shows' => '1',
			'sortnum' => '1',
	),
	'js-map' => array(
			'ifcheck' => '0',
			'permisname' => 'missalesprojectallocation_view',
			'html' => '<a class="js-map icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesProjectAllocation/lookupmap/project/{sid_node}" target="navTab" rel="MisSalesMyProjectlookupmap" title="项目进度_查看"><span><span class="icon icon-eye-open icon_lrp"></span>进度查看</span></a>',
			'shows' => '1',
			'sortnum' => '2',
	),
	'js-lookupGaiKuang' => array(
			'ifcheck' => '0',
			'permisname' => 'missalesprojectallocation_view',
			'html' => '<a class="js-map icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesProjectAllocation/lookupGaiKuang/projectid/{sid_node}" target="navTab" rel="MisSalesMyProjectlookupmap" title="项目结构_查看"><span><span class="icon icon-eye-open icon_lrp"></span>项目结构</span></a>',
			'shows' => '1',
			'sortnum' => '2',
	),
);