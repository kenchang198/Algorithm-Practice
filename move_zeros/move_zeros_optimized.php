<?php
/**
 * Move Zeros - 最適化版実装
 * 
 * 配列内のすべての0を末尾に移動する（1パスアプローチ + 最適化）
 * 時間計算量: O(n)
 * 空間計算量: O(1)
 */

/**
 * 配列内のすべての0を末尾に移動する
 * 
 * @param array $nums 整数の配列（参照渡しで変更される）
 * @return array 変更後の配列
 */
function move_zeros(array &$nums): array {
    $left = 0;
    
    for ($right = 0; $right < count($nums); $right++) {
        if ($nums[$right] !== 0) {
            // 最適化: 同じ位置の場合はスワップ不要
            if ($left !== $right) {
                [$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];
            }
            $left++;
        }
    }
    
    return $nums;
}

/**
 * デバッグ用: 実行過程を表示するバージョン
 */
function move_zeros_with_trace(array $nums): array {
    echo "初期配列: " . json_encode($nums) . "\n";
    $left = 0;
    
    for ($right = 0; $right < count($nums); $right++) {
        echo "right=$right, nums[$right]={$nums[$right]}, left=$left\n";
        if ($nums[$right] !== 0) {
            if ($left !== $right) {
                echo "  スワップ: nums[$left]={$nums[$left]} ↔ nums[$right]={$nums[$right]}\n";
                [$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];
            } else {
                echo "  スキップ（同じ位置）\n";
            }
            $left++;
            echo "  結果: " . json_encode($nums) . ", left=$left\n";
        } else {
            echo "  ゼロをスキップ\n";
        }
    }
    
    echo "最終結果: " . json_encode($nums) . "\n\n";
    return $nums;
}

// テスト実行
echo "=== テストケース1 ===\n";
move_zeros_with_trace([0, 1, 0, 3, 12]);

echo "=== テストケース2 ===\n";
move_zeros_with_trace([0, 0, 0]);

echo "=== テストケース3 ===\n";
move_zeros_with_trace([1, 2, 3]);

echo "=== テストケース4 ===\n";
move_zeros_with_trace([0, 0, 1]);

echo "=== テストケース5 ===\n";
move_zeros_with_trace([0]);

