	
						<!-- 地图组件 -->

                        <div class="#class#" original="#original#" category="#category#" style="#style#">
                            <label class="label_new">{$fields["#fields#"]}</label>
                            {:W('ShowArea',
                            array("0"=>$areainfo["#fields#"],
                            "1"=>#fields#,
                            "2"=>$fields[#fields#],
                            "3"=>"",
                            "5"=>"")
                            )}

                            <div class="display_none {$classNodeSettingArr['#fields#']}">
                                <input type="hidden" name="areainfo[#fields#][province]" value="{$areainfo['#fields#']['province']}">
                                <input type="hidden" name="areainfo[#fields#][city]" value="{$areainfo['#fields#']['city']}">
                                <input type="hidden" name="areainfo[#fields#][area]" value="{$areainfo['#fields#']['area']}">
                                <input type="hidden" name="areainfo[#fields#][town]" value="{$areainfo['#fields#']['town']}">
                                <input type="hidden" name="areainfo[#fields#][street]" value="{$areainfo['#fields#']['street']}">
                                <input type="hidden" name="areainfo[#fields#][address]" value="{$areainfo['#fields#']['address']}">
                                <input type="hidden" name="areainfo[#fields#][longitude]" value="{$areainfo['#fields#']['longitude']}"/>
                                <input type="hidden" name="areainfo[#fields#][latitude]" value="{$areainfo['#fields#']['latitude']}"/>
                                <input type="hidden" name="areainfo[#fields#][formattedAddress]" value="{$areainfo['#fields#']['detail']}"/>
                            </div>
                        </div>


