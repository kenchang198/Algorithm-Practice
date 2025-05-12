<?php

function twoSum($target, $nums) {
    $pair = [];
    
    foreach ($nums as $k => $v) {
        
        $diff = $target - $v;
        
        $foundIndex = array_search($diff, $pair);
        
        if ($foundIndex !== false) {
            return [$foundIndex, $k];
        }
        $pair[$k] = $v;
    }
}

$target = 3;
$nums = [2, 1, 5, 8];

var_dump(twoSum($target, $nums));