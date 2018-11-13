
				<!-- 按钮组件 -->
				<div class="#class#" original="#original#" category="#category#" style="#style#">
					<input type="button"  name="#fields#" #callback# class="   #content_class#" <if condition="$vo['#fields#'] neq ''">value="{$vo['#fields#']}"<else/>value="#defaultvaltext#"</if>  >
				<div class="display_none {$classNodeSettingArr['#fields#']}">{$vo['#fields#']}</div>
				</div>