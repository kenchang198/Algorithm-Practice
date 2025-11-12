<?php

/**
 * array_search()は内部で線形探索（O(n)）を行います
 * ループと組み合わせると、全体の計算量は最悪の場合O(n²)になります
 * 大きな配列では著しくパフォーマンスが低下します
 * @deprecated
 */
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

/**
 * Better
 * map 値をキー、インデックスを値にする
 */
function twoSumBetter($target, $nums) {
    $map = [];
    foreach ($nums as $i => $num) {
        $need = $target - $num;
        if (isset($map[$need])) {
            return [$map[$need], $i];
        }
        $map[$num] = $i;
    }
}

$target = 3;
$nums = [2, 1, 5, 8];

// var_dump(twoSum($target, $nums));
var_dump(twoSumBetter($target, $nums));