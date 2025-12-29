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

function spaceOptimized(array $nums): array
{
    $n = count($nums);
    $answer = [];

    // 第1パス: 左側の積 (prefix)
    $answer[0] = 1;
    for ($i = 1; $i < $n; $i++) {
        $answer[$i] = $answer[$i - 1] * $nums[$i - 1];
    }
    
    // 第2パス: 右側の積（suffix）を掛ける
    $rightProduct = 1;
    for ($i = $n - 1; $i >= 0; $i--) {
        $answer[$i] = $answer[$i] * $rightProduct;
        $rightProduct = $rightProduct * $nums[$i];
    }
    return $answer;
}

$nums = [1,2,3,4]; // output [24,12,8,6]
$nums = [-1,1,0,-3,3]; // [0,0,9,0,0]
$nums = [2,2,3,4]; // [24, 24, 16, 12]

// $r = productOfArrayExceptSelf($nums);
$r = spaceOptimized($nums);
echo json_encode($r) . "\n";

function spaceOptimizedWithTrace(array $nums): array
{
    $n = count($nums);
    $answer = [];

    // 第1パス: 左側の積 (prefix)
    echo "左側の積 (prefix)\n";
    $answer[0] = 1;
    echo "nums: " . json_encode($nums) . "\n";
    echo "\$answer[0] = 1\n";
    for ($i = 1; $i < $n; $i++) {
        $idx = $i - 1;
        echo "\$answer[{$i}] = \$answer[{$idx}] * \$nums[{$idx}]\n";
        $answer[$i] = $answer[$i - 1] * $nums[$i - 1];
        echo "answer: " . json_encode($answer) . "\n\n";
    }
    
    echo "\n===========================\n\n";
    echo "右側の積 (suffix)";
    $rightProduct = 1;
    for ($i = $n -1; $i >= 0; $i--) {
        $answer[$i] = $answer[$i] * $rightProduct;
        echo "\$answer[{$i}] = \$answer[{$i}] * {$rightProduct}(rightProduct)\n";
        echo "answer: " . json_encode($answer) . "\n\n";
        
        echo "rightProduct = rightProduct (before:{$rightProduct}) × {$nums[$i]}(\$nums[$i])\n";
        $rightProduct = $rightProduct * $nums[$i];
        echo "rightProduct updated {$rightProduct}\n\n";
    }

    return $answer;
}