<?php
//生成表单容器的    表单、列表  等样式
class ShowFormControllWidget extends Widget {
	public function render($data){
        $vo = $data['vojson'];
        $tp = $data['tp'];
        $propery = D('mis_dynamic_form_propery');
        $manage = D('mis_dynamic_form_manage');
        $modelname = $data['model'];                //當前actionname
        $dbname=D($modelname)->getTableName();
        $map['dbname']=$dbname;
        $map['fieldname']=$data['field'];
        $form =$propery->where($map)->getField('id,formtitle,invokeroam,formheight,showformtoolbar,formstatu,formshowtype,bindform,issydel,bindval,inbindval,formcondition,incondition');
        $sql = $propery->getLastSql();
//        return  json_encode($sql);
        foreach ($form as $formcontroll){
            $bindformid = $formcontroll['bindform'];//绑定的表单id
            $formshowtype = $formcontroll['formshowtype'];//  |请选择#1|表单#2|列表#3|列表-列表录入#4|列表-弹框录入',
            $formstatu = $formcontroll['formstatu'];//   |请选择#1|跟随状态#2|查看状态',
//            $isshowformtoolbar = $formcontroll['showformtoolbar'];//是否显示表单工具栏',
//            $formheight = $formcontroll['formheight'];//自定义容器高度
//            $invokeroam = $formcontroll['invokeroam'];//绑定的漫游
//            $issydel = $formcontroll['issydel'];//是否同步删除
//            $bindval = $formcontroll['bindval'];//主表绑定字段
            $inbindval  = $formcontroll['inbindval'];//绑定表的绑定字段
            if($formstatu==1){
                $caozuo = $data['caozuo'];
            }else{
                $caozuo = 'view';
            }
            if($caozuo=='add'){
                $bindrdid=0;
            }else{
                $bindrdid=$data['id'];
            }
            //找到绑定的表
            $managemap['id']=$bindformid;
            $inbindaction = $manage->where($managemap)->getField('actionname');      //绑定表单的actionname
            //获取当前主表的信息
            $bindmap['id'] = $bindrdid;
            $zhus = D($modelname)->where($bindmap)->select();
            //设置表中表的条件
            $zhu = $zhus[0];
            $formcontroll['bindval'];         //主表的字段匹配
            $zhu[$formcontroll['bindval']];   //主表字段的值
            $formcontroll['inbindval'];         //从表的字段匹配
            $mmap[$formcontroll['inbindval']] = $zhu[$formcontroll['bindval']];    //基础条件
            //附加条件
            if ($formcontroll['formcondition']) {
                $mmap['_string'] = $formcontroll['formcondition'];
            }
            //子单条件
            if ($formcontroll['incondition']) {
                $ret = $formcontroll['incondition'];
                $listarr = unserialize(base64_decode(base64_decode($ret)));
                if ($listarr === false) {//有老数据是base64_encode(serialize())加密的 --xyz 15-09-16
                    $listarr = unserialize(base64_decode($ret));
                }
                foreach ($listarr as $item) {

                    foreach ($item as $kk => $vv) {
                        if ($vv['name'] == 'sql') {//手写sql
                            $mmap['_string'] = $vv['sql'];
                        } else if ($vv['name'] == 'avgsql') {//高级sql
                            $mmap['_string'] = $vv['avgsql'];
                        } else {
                            $symob = $vv['symbol'];
                            if ($symob == 1) {//等于
                                $symobol = 'eq';
                            } else if ($symob == 2) {//不等于
                                $symobol = 'neq';
                            } else if ($symob == 3) {// 包含
                                $symobol = 'in';
                            } else if ($symob == 4) {//不包含
                                $symobol = 'not in';
                            } else if ($symob == 5) {//大于
                                $symobol = 'gt';
                            } else if ($symob == 6) {//大于等于
                                $symobol = 'egt';
                            } else if ($symob == 7) {// 小于
                                $symobol = 'lt';
                            } else if ($symob == 8) {//  小于等于
                                $symobol = 'elt';
                            }
                            $mmap[$vv['name']] = array($symobol, $vv['val']);        //*********高级设置centertip   rightipt   leftipt   未知用途
                        }
                    }
                }
            }
        }
        $vos = D($inbindaction)->where($mmap)->select();
        if(count($vo)>0){
            $vo = $vos[0];                          //  查出很多条  也只显示第一条   表单形式
        }


        //  $caozuo = 'add';       //當前為新增   edit  view   ！！！！
        //当为查看状态时候    操作为view

        $MisSystemDataRoamSubDao = M("mis_system_data_roam_sub");
        $MisSystemDataRoamingModel = D("MisSystemDataRoaming");
        $MisDynamicFormProperyModel = D("MisDynamicFormPropery");
        $MisProjectFlowFormModel = D("MisProjectFlowForm");
        $randUniqueTag = getMillisecond();



        //设置dataromain
        $updateBackup = setOldDataToCache($modelname, $vo);
        $updateBackupList = str_replace('=', '', base64_encode(serialize($updateBackup)));
        $dataroamingCondition = '/dataromaing/' . $updateBackupList;

        $html= <<<EOF
        <div class="$inbindaction">
<div class="tabs proTabNav nbm_relation_form_tabs_navi" id="tabsContent_{$randUniqueTag}" eventtype="click" currentindex="0">
        <div class="tabsHeader proNavHeader"style="display: none">
            <div class="tabsHeaderContent proTabNavHeaderContent ">
                <ul>
                    <li class="selected">
EOF;
        if($vo!='null'){
            $inbindvalv = $vo[$inbindval] ? $vo[$inbindval] : "null";
        }else{
            $inbindvalv = '-';
        }

//        return json_encode($inbindvalv);
        if($_REQUEST['isformcon']==1){      //表单容器的条件    套表
            $bindname = $_REQUEST['bindaname'];             //zhu表单model
            $propery = D('mis_dynamic_form_propery');
            $pmap['isshow']=1;
            $pmap['dbname']=D($bindname)->getTableName();
            $pmap['fieldname'] = $_REQUEST['field'];
            $formcontrolls = $propery->where($pmap)->getField('id,formtitle,invokeroam,formheight,showformtoolbar,formstatu,formshowtype,bindform,issydel,bindval,inbindval,formcondition,incondition');
            foreach($formcontrolls as $item) {       //表中表
                $formcontroll = $item;
                if ($_REQUEST['fieldtype']) {
                    $mmap[$item['inbindval']] = $_REQUEST[$_REQUEST['fieldtype']];
                } else {

                }
            }

            $vos = D($inbindaction)->where($mmap)->select();
            $vo = $vos[0];                          //  查出很多条  也只显示第一条   表单形式
        }
    if(!$bindrdid){
        $bindrdid=0;
    }
        if($formshowtype==0){
            if($caozuo=='add'){                 //子页面为新增的时候   默认去执行一次
                $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/add/main/fieldtype/testf/testf/aa/{$modelname}/{$modelname}/bindrdid/{$bindrdid}{$dataroamingCondition}#{$inbindaction}_{$randUniqueTag}"
                        rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
            }else if($caozuo=='edit'){     //当没有值的时候  是新增   直接传入id
                if(count($vos)>0){
                    $html .=<<<EOF
  <a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/edit/main/{$modelname}/bindaname/{$modelname}/bindrdid/{$bindrdid}/isformcon/1/field/{$data['field']}/id/{$vo['id']}#{$inbindaction}_{$randUniqueTag}"
                       rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
                }else{
                    $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/add/main/{$modelname}/{$modelname}/bindrdid/{$bindrdid}{$dataroamingCondition}#{$inbindaction}_{$randUniqueTag}"
                        rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
                }

            }else if($caozuo=='view'){
                $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/view/bindaname/{$modelname}/bindrdid/{$bindrdid}/isformcon/1/field/{$data['field']}#{$inbindaction}_{$randUniqueTag}"
                       rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
            }

        }else{    //列表
            if($caozuo=='add' || $caozuo=='edit'){      //miniindex  add/edit列表
                $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/miniindex/func/{$caozuo}/bindtype/{$formshowtype}/main/{$modelname}/bindaname/{$modelname}/bindrdid/{$bindrdid}/isformcon/1{$dataroamingCondition}/field/{$data['field']}{$dataroamingCondition}#{$inbindaction}_{$randUniqueTag}"
                        rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
}else if($caozuo=='view' ){                             //miniindex view列表fieldtype/{$inbindval}/{$inbindval}/{$inbindvalv}/
                if($data['caozuo']=='add'){
                    $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/miniindex/func/add/bindtype/{$formshowtype}/main/{$modelname}/bindaname/{$modelname}/bindrdid/0/isformcon/1{$dataroamingCondition}/field/{$data['field']}{$dataroamingCondition}#{$inbindaction}_{$randUniqueTag}"
                        rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
                }else{
                    $html .=<<<EOF
<a id="{$inbindaction}_{$randUniqueTag}"  href="{$tp}/{$inbindaction}/miniindex/func/{$caozuo}/bindtype/{$formshowtype}/main/{$modelname}/bindaname/{$modelname}/bindrdid/{$bindrdid}/isformcon/1/field/{$data['field']}{$dataroamingCondition}#{$inbindaction}_{$randUniqueTag}"
                        rel='{$modelname}{$inbindaction}_edit' class="j-ajax" >
EOF;
                }

            }
           

        }

         $html .=<<<EOF
                       <span style="display: none"> $inbindaction </span>      </a>           
                    </li>
                </ul>
            </div>
        </div>
            <div  class="tabsContent tml-p0">
            <div id="{$modelname}{$inbindaction}_edit"></div>
            </div>
</div>
EOF;


    return $html;

	}
}