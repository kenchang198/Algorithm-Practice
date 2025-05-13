<?php

function move_zeros_trace($nums) {
    echo "初期配列: " . json_encode($nums) . "\n";
    $left = 0;
    foreach ($nums as $k => $num) {
        echo "処理中: k=$k, num=$num, left=$left\n";
        if ($num !== 0) {
            $nums[$left] = $num;
            $left += 1;
            echo "非ゼロ値を移動: " . json_encode($nums) . ", left=$left\n";
        } else {
            echo "ゼロをスキップ\n";
        }
    }
    echo "ゼロ埋め前: " . json_encode($nums) . ", left=$left\n";
    for ($i = $left; $i < count($nums); $i++) {
        $nums[$i] = 0;
        echo "ゼロ埋め: i=$i, " . json_encode($nums) . "\n";
    }
    echo "最終配列: " . json_encode($nums) . "\n";
    return $nums;
}

// $nums = [0, 1, 0, 3, 12];
$nums = [0, 0, 0, 0, 0, 0, 9, 0, 9];

move_zeros_trace($nums);