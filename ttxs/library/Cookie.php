<?php
/**
 * @declare cookie操作
 */
class Cookie {

    const codeStr = "ttxs1q2w3e4r";
    const codeLen = 32;

    // 加密
    public static function encode ($data) {

        if (strlen($data) < 32) {
            $preLen = 32 - strlen($data);

            for ($i = 0; $i < $preLen; $i++) {
                $data = '0'.$data;
            }
        }

        $key = md5(self::codeStr);
        $str = '';
        for ($i = 0; $i < self::codeLen; $i++)
        {
            $str .= chr(ord($data{$i}) + ord($key{$i}));
        }

        return base64_encode($str);
    }

    // 解密
    public static function decode ($data) {
        $data = base64_decode($data);
        $key = md5(self::codeStr);

        $arrAscii = array();

        for ($i = 0; $i < strlen($data); $i++) {
            array_push($arrAscii, ord($data[$i]));
        }

        foreach ($arrAscii as $k => $row) {
            $arrAscii[$k] = $row - ord($key[$k]);
        }

        for ($i = 0; $i < count($arrAscii); $i++) {
            if (chr($arrAscii[$i]) != 0) {
                $pos = $i;
                break;
            }
        }
        $str = '';
        if(!isset($pos)){
            return false;    
        }
        for($i = $pos; $i < count($arrAscii); $i++) {
            $str .= chr($arrAscii[$i]);
        }

        return $str;
    }

}
