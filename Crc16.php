<?php
namespace Sjzzhanglu;

class Crc16{

    /**
     * @param string $str 待校验字符串
     * @param string $strType hex:16进制；ascii：ascii码
     * @param int $polynomial 二项式
     * @param int $initValue 初始值
     * @param int $xOrValue 输出结果前异或的值
     * @param bool $inputReverse 输入字符串是否每个字节按比特位反转
     * @param bool $outputReverse 输出是否整体按比特位反转
     * @return int
     */
    public function crc16($str,$strType="hex", $polynomial, $initValue, $xOrValue, $inputReverse = false, $outputReverse = false) {
        $crc = $initValue;
        if($strType == "hex"){
            $str = pack('H*', $str);
        }
        for ($i = 0; $i < strlen($str); $i++) {
            if ($inputReverse) {
                // 输入数据每个字节按比特位逆转
                $c = ord($this->reverseChar($str{$i}));
            } else {
                $c = ord($str{$i});
            }
            $crc ^= ($c << 8);
            for ($j = 0; $j < 8; ++$j) {
                if ($crc & 0x8000) {
                    $crc = (($crc << 1) & 0xffff) ^ $polynomial;
                } else {
                    $crc = ($crc << 1) & 0xffff;
                }
            }
        }
        if ($outputReverse) {
            // 把低地址存低位，即采用小端法将整数转换为字符串
            $ret = pack('cc', $crc & 0xff, ($crc >> 8) & 0xff);
            // 输出结果按比特位逆转整个字符串
            $ret = $this->reverseString($ret);
            // 再把结果按小端法重新转换成整数
            $arr = unpack('vshort', $ret);
            $crc = $arr['short'];
        }
        return base_convert($crc ^ $xOrValue, 10, 16);
    }

    /**
     * 将一个字节流按比特位反转 eg: 'AB'(01000001 01000010)  --> '\x42\x82'(01000010 10000010)
     * @param $str
     */
    public function reverseString($str) {
        $m = 0;
        $n = strlen($str) - 1;
        while ($m <= $n) {
            if ($m == $n) {
                $str{$m} = $this->reverseChar($str{$m});
                break;
            }
            $ord1 = $this->reverseChar($str{$m});
            $ord2 = $this->reverseChar($str{$n});
            $str{$m} = $ord2;
            $str{$n} = $ord1;
            $m++;
            $n--;
        }
        return $str;
    }

    /**
     * 将一个字符按比特位进行反转 eg: 65 (01000001) --> 130(10000010)
     * @param $char
     * @return $char
     */
    public function reverseChar($char) {
        $byte = ord($char);
        $tmp = 0;
        for ($i = 0; $i < 8; ++$i) {
            if ($byte & (1 << $i)) {
                $tmp |= (1 << (7 - $i));
            }
        }
        return chr($tmp);
    }
}
