<?php

function twoSum($target, $nums) {
    $pair = [];
    
    foreach ($nums as $k => $v) {
        
        $vv = $target - $v;
        
        $kk = array_search($vv, $pair);
        
        if ($kk) {
            return [$kk, $k];
        }
        $pair[$k] = $v;
    }
}

$target = 6;
$nums = [2, 1, 5, 8];

var_dump(twoSum($target, $nums));