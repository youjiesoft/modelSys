<?php if (!defined('THINK_PATH')) exit();?><div class="entry-box-body nbm_work_container">
                    <div class="entry-box-data" >
                        <?php if(!$userOaitemlist['count'] && !$userAuditlist['count'] && !$userWorkExecutList['count'] && !$userZhuilist['count']): ?><a target="navTab" href="__APP__/MisWorkExecuting/index/jump/7" rel="MisWorkExecutingbox" title="工作中心">
                                <!--<div class="index_work_lay">-->
                                    <!--<div><img src="__PUBLIC__/Css/tmlstyle/images/icon_start_work.png" alt=""/></div>-->
                                    <!--<div>-->
                                        <!--<p style="color: #34495e; font-size: 14px;line-height: 30px;">点击进入工作中心</p>-->
                                        <!--<button class="start_work_btn">发起工作</button>-->
                                    <!--</div>-->
                                <!--</div>-->
                            </a><?php endif; ?>
                        <div class="tml_box_content">
                            <ul class="tml_box_content_ul">
                                <li class="tml_box_content_li">
                                    <!--<a rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/5/md/MisOaItems/type/3/wjump/1/rel/MisWorkExecutingbox" title="工作中心" target="navTab">-->
                                    <a rel="MisWorkExecuting" href="__APP__/MisAutoIbf/index" title="业务受理" target="navTab">
                                        <span class="tml_box_content_title">业务受理</span></br>
                                        <span class="tml_box_content_count tml_box_content_number"><?php echo ($userOaitemlist['count']); ?></span>
                                    </a>
                                </li>
                                <li class="tml_box_content_li">
                                <!--<a rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/3/md/MisWorkMonitoring/worktype/1/rel/MisWorkExecutingbox" title="工作中心" target="navTab">-->
                                    <a rel="MisWorkExecuting" href="__APP__/MisSalesMyProject/index" title="项目管理" target="navTab">
                                        <span class="tml_box_content_title">项目管理</span></br>
                                        <span class="tml_box_content_count tml_box_content_number"><?php echo ($userOaitemlist1['count']); ?></span>
                                    </a>
                                </li>
                                <li class="tml_box_content_li">
                                 <!--<a rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/4/md/MisWorkExecuting" title="评审会管理" target="navTab">-->
                                    <a rel="MisWorkExecuting" href="__APP__/MisAutoZpg/index" title="评审会管理" target="navTab">
                                        <span class="tml_box_content_title" style="margin-left: -40px">评审会管理</span></br>
                                        <!--<?php echo ($userWorkExecutList['count']); ?>-->
                                        <span class="tml_box_content_count tml_box_content_number"><?php if($totalCount != null): echo ($totalCount); else: ?>0<?php endif; ?></span>
                                    </a>
                                </li>
                                <li class="tml_box_content_li">
                                   <!--<a rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/6/md/MisWorkExecuting/istepperson/1" title="审批管理" target="navTab">-->
                                    <!--MisWorkExecuting/index/jump/jump/jumptemp/1/md/MisWorkMonitoring/worktype/1/rel/MisWorkExecutingbox/5-->
                                    <a rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/6/md/MisWorkExecuting/istepperson/1" title="流程管理" target="navTab">
                                        <span class="tml_box_content_title">流程管理</span></br>
                                        <span class="tml_box_content_count tml_box_content_number"><?php echo ($userAuditlist['count']); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>