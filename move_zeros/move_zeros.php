<?php
// 0以外の数字を左にもっていく方法
function move_zeros($nums)
{
    $left = 0;
    foreach ($nums as $k => $num) {
        if ($num !== 0) {
            $nums[$left] = $num;
            $left += 1;
        }
    }

    for ($i = $left; $i < count($nums); $i++) {
        $nums[$i] = 0;
    }
    return $nums;
}

$nums = [0, 1, 0, 3, 12];
var_dump(move_zeros($nums));