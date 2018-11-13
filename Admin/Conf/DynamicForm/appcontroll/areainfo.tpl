                <div id="topMenu">

                <comptopmenu title="地址组件演示" right_show="hidden" right_name="" right_method="">

                </comptopmenu>
                <div id="content" class="content">
                <compaddress
                        v-bind:address="{filed:'adressId',label:'地址',value:'点击选择地址',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:lng="{label:'经度',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:lat="{label:'纬度',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:province="{label:'省/直辖市',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'250px',height:'20px',fontsize:'15px'}"
                        v-bind:city="{label:'市',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:district="{label:'县',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:township="{label:'镇',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:street="{label:'街',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        v-bind:streetnumber="{label:'街号',showFlag:true,readonlyFlag:true,disabledFlag:false,width:'300px',height:'20px',fontsize:'15px'}"
                        ref="compaddress1"
                        refname="compaddress1"
                />
                </div>
                </div>
