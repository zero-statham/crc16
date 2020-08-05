# crc16
PHP CRC-16/IBM,CRC-16/MAXIM,CRC-16/USB,CRC-16/MODBUS,CRC-16/CCITT,CRC-16/CCITT-FALSE,CRC-16/X25,CRC-16/XMODEM,CRC-16/DNP

|模式|多项式|初始值|结果异或值|输入数据翻转|输出数据翻转|
|----|----|----|----|----|----|
|CRC-16/IBM|0x8005|0|0|true|true|
CRC-16/MAXIM|0x8005|0|0xffff|true|true|
CRC-16/USB|0x8005|0xffff|0xffff|true|true|
CRC-16/MODBUS|0x8005|0xffff|0|true|true|
CRC-16/CCITT|0x1021|0|0|true|true|
CRC-16/CCITT-FALSE|0x1021|0xffff|0|false|false|
CRC-16/X25|0x1021|0xffff|0xffff|true|true|
CRC-16/XMODEM|0x1021|0|0|false|false|
CRC-16/DNP|0x3d65|0|0xffff|true|true|
```$xslt
$crc = new Sjzzhanglu\Crc16();

$hexString = '';        // 十六进制字符串
$poly = 0x8005;         // 多项式
$initValue = 0xffff;    // 初始值
$xOrValue = 0x0000;     // 结果异或值
$inputReverse = true;   // 输入数据翻转
$outputReverse = true;  // 输出数据翻转

$checkValue = $crc->crc16($hexString, 'hex', $poly, $initValue, $xOrValue, $inputReverse, $outputReverse);
```
