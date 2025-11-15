<?php
/**
 * Move Zeros - 1パスアプローチ（Two Pointers）
 * 
 * 配列内のすべての0を末尾に移動する
 * 時間計算量: O(n) - 1回の走査
 * 空間計算量: O(1)
 */

/**
 * 配列内のすべての0を末尾に移動する（1パスアプローチ）
 * 
 * @param array $nums 整数の配列（参照渡しで変更される）
 * @return array 変更後の配列
 */
function move_zeros(array &$nums): array
{
    $left = 0;
    
    for ($right = 0; $right < count($nums); $right++) {
        if ($nums[$right] !== 0) {
            // スワップ操作
            if ($left !== $right) {
                [$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];
                echo "right: $right (値が0以外) leftは $left 交換後" . json_encode($nums) . "\n";
            } else {
                echo "right: $right (値が0以外) leftとrightが同じ位置のため交換をスキップ" . "\n";
            }
            $left++;
            echo " left {$left} に移動\n\n";
        } else {
            echo "right: {$right} (値が0) 交換をスキップ. leftは {$left} をキープ\n\n";
        }
    }
    
    return $nums;
}

// テスト実行
// $nums = [0, 1, 0, 3, 12];
$nums = [1, 2, 0, 0, 12];
// $nums = [0, 1, 2, 0, 12];
// $nums = [1, 0, 3, 4, 5];

echo "初期配列: " . json_encode($nums) . "\n\n";
move_zeros($nums);
// echo "結果: " . json_encode(move_zeros($nums)) . "\n";
echo "\n結果: " . json_encode($nums). "\n";

