<?php
// $nums = [-1, 0, 3, 9, 11, 12];
// $target = 9;
$nums = [-1,0, 3 ,5,9,12];
$target = 2;

var_dump(main($nums, $target));

function main($nums, $target) 
{
    $left = 0;
    $right = count($nums) -1;
    while ($left <= $right) {
        $mid = intval(($left + $right) / 2);
        if ($nums[$mid] == $target) {
            return $mid;
        } else if ($target < $nums[$mid]) {
            $right = $mid -= 1;
        } else {
            $left = $mid += 1;
        }
    }
    return -1;
}