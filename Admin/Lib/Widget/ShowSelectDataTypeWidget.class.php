<?php
class ShowSelectDataTypeWidget extends Widget {
	public function render($data){
        $html = "";
        $html.= '<select name="fieldtype['.($data["j"]-1)."][".($data["k"]-1).']" class="select2 opcategory ';
        if($data["ischoise"] == 1){
            $html.= 'readonly';
        }
        $html.= ' ">';
        foreach ($data["fieldtypeList"] as $k =>$v){
            $html.= "<option ";
            if(($data["category"]=="date" && $data["type"]==$v["key"]) || ($data["type"]==$v["key"])){
                $html.= "selected";
            }
            $html.= " value='".$v["key"]."' len='{$v["len"]}' cate='{$v["cate"]}'>{$v["val"]}</option>";
        }
        $html.= '</select>';
        if($data["id"]) {
            $name = "oldfieldtype[".($data["j"]-1)."][".($data["k"]-1)."]";
            $html .= '<input  name="'.$name.'" value="'.$data["type"].'" type="hidden" />';
        }
	    return $html;
	}
}