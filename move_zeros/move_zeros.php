<?php

$nums = [0, 1, 0, 3, 12];

// 0以外の数字を左にもっていく方法
$left = 0;
foreach ($nums as $k => $num) {
    if ($num !== 0) {
        $nums[$left] = $num;
        $left += 1;
    }
    // var_dump($left);
}

for ($i = $left; $i < count($nums); $i++) {
    $nums[$i] = 0;
}
var_dump($nums);