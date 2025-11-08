<?php
function findMaxConsecutiveOnes($nums)
{
    $result = 0;
    $count = 0;

    foreach ($nums as $num) {
        if ($num === 1) {
            $count += 1;
        } else {
            $count = 0;
        }
        if ($result < $count) {
            $result = $count;
        }
    }
    return $result;
}

function findMaxConsecutiveOnesBySlidingWindow($nums)
{
    $result = 0;
    $left = 0;
    foreach($nums as $right => $num) {
        if ($num === 0) {
            $left = $right + 1;
        } else {
            $result = max($result, $right - $left + 1);
        }
    }
    return $result;
}

// $nums = [1, 1, 0, 1, 1, 1, 0, 1, 1];
$nums = [1,1,0,1,1,1];
// echo findMaxConsecutiveOnes($nums);
echo findMaxConsecutiveOnesBySlidingWindow($nums);