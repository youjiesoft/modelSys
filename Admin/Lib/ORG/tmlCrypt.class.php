<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of tmlCrypt
 *
 * @author mashihe
 */
class tmlCrypt extends Think{
    var $key;
    function tmlCrypt($key)   
    {         
        $this->key = $key;
    }
    //解密字符
    public function decrypt($encrypted)  
    {         

    }
    //反派生
    private function pkcs5_unpad($text)   
    {         
       $pad = ord($text{strlen($text)-1});  
       if ($pad > strlen($text))  
       {
           return false;  
       }  
       if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)  
       {  
          return false;  
       }
       return substr($text, 0, -1 * $pad);  
    }
}
?>
