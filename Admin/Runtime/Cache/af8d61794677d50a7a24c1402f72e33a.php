<?php if (!defined('THINK_PATH')) exit();?><script>
function changeapp($page){
	 changehref="__APP__/MisSystemRemind/lookupmyRemindDis/maxlimit/<?php echo ($maxcount); ?>/minlimit/<?php echo ($mincount); ?>/page/"+$page;
	 $("#remind_div").loadUrl(changehref,{},function(){
         $("#remind_div").find("[layoutH]").layoutH();},false);
}
</script>
<div id="remind_div">
	<div class="entry-box  entry-box-large"> 
			<span class="tml_remind_btn">
			<span class="remind_btn tml_remind_left icon-angle-left <?php if($prevlist): ?>remind_btn_active<?php endif; ?>" <?php if($prevlist): ?>onclick="changeapp('prevpage')" class="remind_btn_active"<?php endif; ?> > </span>
					<a class="  remind_btn tml_remind_center" target="dialog" width="508"
						height="344" mask="true"
						rel="missystempanelmethod_lookupchangeremind" title="更改提醒模块"
						href="__APP__/MisSystemRemind/lookupchangeremind">
						设置
						<span class="tml-badge tml-bg-orange"><?php echo ($remindnum); ?></span>
					</a>
					<span class="remind_btn tml_remind_right icon-angle-right <?php if($nextlist): ?>remind_btn_active<?php endif; ?>" <?php if($nextlist): ?>onclick="changeapp('nextpage')"<?php endif; ?>></span>
					</span> 
		<?php if($remindAllList): ?><div class="entry-box-body">
			<div class="entry-box-data">
				<ul class="tml_wake">
					<?php if(is_array($remindAllList)): $h = 0; $__LIST__ = $remindAllList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$remindAll): $mod = ($h % 2 );++$h; if($h <= 6 ): ?><li class="tml-mb5">
						<span class="tml-label tml-bg-info tml-mr3">
							<span class='icon  <?php echo ($remindAll["span"]); ?> tml-mr3"'></span>
							&nbsp;<?php echo ($remindAll["title"]); ?>：
						</span>
					   <?php if(is_array($remindAll['list'])): $i = 0; $__LIST__ = $remindAll['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rtvo): $mod = ($i % 2 );++$i; $usertype=getFieldBy($_SESSION[C('USER_AUTH_KEY')],'id','usertype','user'); ?>
                        <?php if($rtvo['relhref'] == 'MisSystemSysremind/index' && $usertype == '3'): echo ($rtvo["rtitle"]); ?>(0)<?php else: ?><a href="__APP__/<?php echo ($rtvo["relhref"]); ?>"
                            title="<?php echo ($rtvo["reltitle"]); ?>" target="navTab" rel="<?php echo ($rtvo["relhref"]); ?>">
							<?php echo ($rtvo["rtitle"]); ?>(<span class="<?php echo ($remindAll["countcolor"]); ?>  "><?php echo ($rtvo['count']); ?></span>)
                        </a><?php endif; ?>；&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
					</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
		<?php else: ?>
		<div class="entry-box-body">
			<div class="noData">没有提醒事项</div>
		</div><?php endif; ?>
	</div>
</div>