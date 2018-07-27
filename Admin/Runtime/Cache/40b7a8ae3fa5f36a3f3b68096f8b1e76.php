<?php if (!defined('THINK_PATH')) exit();?><script>
function delOften($this){
	$obj = $($this);
	$id = $obj.attr('id');
	$.ajax({
		url : "__APP__/UserOftenMenu/delOften",// 通过Ajax取数据的目标页面
		type : 'post',// 方法，还可以是"post"
		data:{id:$id},
		success : function(res){
			// 成功后执行的语句，这里是一个函数，“locals”是返回的数据
			if(res){
				//$obj.parent().remove();
				$("#userConstantly_div").loadUrl("__APP__/UserOftenMenu/oftenindex");
			}
		}
	});
}
</script>

 <?php $usertype=getFieldBy($_SESSION[C('USER_AUTH_KEY')],'id','usertype','user'); ?>  
<?php if($usertype != '3'): ?><div class="entry-box  entry-box-small">
            <div class="entry-box-body">
                <div class="xystartmenu_con clearfix">
                    <div class="xypreferences clearfix tml-pos-rel" id="userConstantly_div">
						<!-- 
						<div class="tml-text-r tml-pos-abs" style="right: 10px;top: 10px;z-index: 2;">
                            <a class="tml-btn tml-btn-default tml_add_btn"   href="__URL__/lookupuserindex/type/2" target="dialog" rel="__MODULE__add" width="770" height="530"><span class="icon icon-plus">常用</span>  </a>
                        </div>
                         -->
                        <!-- <h3>常用</h3> -->
                        <ul class="clearfix xyuseapp tml-mt5">
                            <?php if(is_array($workoftenList)): $i = 0; $__LIST__ = $workoftenList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$workvo): $mod = ($i % 2 );++$i; if($workvo['rel'] && $workvo['title'] && $workvo['url'] && $workvo['icon']): ?><li>
                                        <a href="__APP__/<?php echo ($workvo['url']); ?>" target="navTab" rel="<?php echo ($workvo['rel']); ?>" >
                                            <img alt="<?php echo ($workvo['title']); ?>" width="50" height="50px" src="__PUBLIC__/Images/xyicon/<?php echo ($workvo['icon']); ?>" />
                                            <span><?php echo ($workvo['title']); ?></span>
                                        </a>
                                        <?php if(!$workvo["isdefault"] ): ?><a id="<?php echo ($workvo['id']); ?>" class="delapp" href="#" onclick="delOften(this);"></a><?php endif; ?>
                                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            <li>
                                <a href="__APP__/UserOftenMenu/oftenadd" target="dialog" rel="__MODULE__add" width="770" height="530">
                                    <img width="50" height="50px" src="__PUBLIC__/Images/xyicon/set_icon.png" alt=""/>
                                    <span>常用设置</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                
        </div><?php endif; ?>