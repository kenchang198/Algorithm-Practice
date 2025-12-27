<?php

function productOfArrayExceptSelf(array $nums): array
{
    $answer = [];
    $n = count($nums);
    for ($i = 0; $i < $n; $i++) {
        $p = 1;
        for ($j = 0; $j < $n; $j++) {
            // echo "i: {$i} j: {$j}\n";
            if ($i === $j) {
                // echo "skip\n";
                continue;
            }
            $p = $p * $nums[$j];
        }
        // $answer[$i] = $p;
        $answer[] = $p;
        // echo "\n";
    }
    return $answer;
}

$nums = [1,2,3,4]; // output 24,12,8,6]
$nums = [-1,1,0,-3,3]; // [0,0,9,0,0]
$nums = [2,2,3,4]; // [24, 24, 16, 12]

$r = productOfArrayExceptSelf($nums);
echo json_encode($r) . "\n";