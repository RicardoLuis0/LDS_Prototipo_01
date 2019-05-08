<?php

function randomString(int $length,string $chars="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789_./$"):string{
    $len=strlen($chars);
    $output='';
    for($i=0;$i<$length;$i++){
        $output.=$chars[random_int(0,$len-1)];
    }
    return $output;
}