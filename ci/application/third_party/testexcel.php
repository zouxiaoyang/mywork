<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=test_data.xls");

$tx='表头';  
echo   $tx."\n\n";  
//输出内容如下：  
echo   "姓名"."\t";  
echo   "年龄"."\t";  
echo   "学历"."\t";  
echo   "\n";  
echo   "张三"."\t";  
echo   "25"."\t";  
echo   "本科"."\t";  
?>