<?php 
class MisSaleProIndicatorViewModel extends ViewModel{
    /**
     * 人事离职模型
     * @var unknown_type
     */
	public $viewFields = array(
						'mis_sale_chain_indicator'=>array('id','remark','status','_as'=>'mis_sale_chain_indicator'),
						'mis_sale_profession'=>array('name'=>'pname','_on'=>'mis_sale_chain_indicator.professionid=mis_sale_profession.id','_type'=>'LEFT'),	 
						'mis_sale_industry'=>array('name'=>'iuname','_on'=>'mis_sale_chain_indicator.industryid=mis_sale_industry.id','_type'=>'LEFT'),
						'mis_sale_basic_indicator'=>array('name'=>'name','orderno','_on'=>'mis_sale_chain_indicator.indicatorid=mis_sale_basic_indicator.id','_type'=>'LEFT'),
			
		);
}
?>



