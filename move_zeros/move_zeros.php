<?php
/**
 * Move Zeros - 2パスアプローチ
 * 
 * 配列内のすべての0を末尾に移動する
 * 時間計算量: O(n) - 2回の走査
 * 空間計算量: O(1)
 */

/**
 * 配列内のすべての0を末尾に移動する（2パスアプローチ）
 * 
 * @param array $nums 整数の配列（参照渡しで変更される）
 * @return array 変更後の配列
 */
function move_zeros(array &$nums): array {
    $left = 0;
    
    // 第1パス: 非ゼロ要素を左に詰める
    foreach ($nums as $num) {
        if ($num !== 0) {
            $nums[$left] = $num;
            $left++;
        }
    }
    
    // 第2パス: 残りを0で埋める
    for ($i = $left; $i < count($nums); $i++) {
        $nums[$i] = 0;
    }
    
    return $nums;
}

// テスト実行
$nums = [0, 1, 0, 3, 12];
echo "初期配列: " . json_encode($nums) . "\n";
move_zeros($nums);
echo "結果: " . json_encode($nums) . "\n";