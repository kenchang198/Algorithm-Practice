<?php

declare(strict_types=1);

/**
 * LeetCode 238: Product of Array Except Self
 * 自分以外の要素の積を求める問題
 *
 * 除算を使用せずに O(n) 時間で解く
 *
 * @see https://leetcode.com/problems/product-of-array-except-self/
 */

/**
 * Brute Force（総当たり）アプローチ
 *
 * すべての要素について、自分以外の要素の積を計算する方法。
 * シンプルだが、大規模な入力では非効率。
 *
 * 時間計算量: O(n²) - 2重ループで全要素を処理
 * 空間計算量: O(1) - 出力配列を除く追加メモリは定数
 *
 * @param int[] $nums 整数配列
 * @return int[] 自分以外の要素の積の配列
 */
function productExceptSelfBruteForce(array $nums): array
{
    $n = count($nums);
    $answer = [];

    for ($i = 0; $i < $n; $i++) {
        $product = 1;
        for ($j = 0; $j < $n; $j++) {
            if ($i !== $j) {
                $product *= $nums[$j];
            }
        }
        $answer[$i] = $product;
    }

    return $answer;
}

/**
 * Prefix & Suffix Arrays アプローチ
 *
 * 各位置 i について:
 * - answer[i] = (左側のすべての要素の積) × (右側のすべての要素の積)
 * - answer[i] = prefix[i] × suffix[i]
 *
 * 時間計算量: O(n) - 配列を3回走査
 * 空間計算量: O(n) - prefix と suffix 配列
 *
 * @param int[] $nums 整数配列
 * @return int[] 自分以外の要素の積の配列
 */
function productExceptSelfWithArrays(array $nums): array
{
    $n = count($nums);

    // prefix[i] = nums[0] * nums[1] * ... * nums[i-1]
    // 位置 i より左側にあるすべての要素の積
    $prefix = array_fill(0, $n, 1);
    for ($i = 1; $i < $n; $i++) {
        $prefix[$i] = $prefix[$i - 1] * $nums[$i - 1];
    }

    // suffix[i] = nums[i+1] * nums[i+2] * ... * nums[n-1]
    // 位置 i より右側にあるすべての要素の積
    $suffix = array_fill(0, $n, 1);
    for ($i = $n - 2; $i >= 0; $i--) {
        $suffix[$i] = $suffix[$i + 1] * $nums[$i + 1];
    }

    // answer[i] = prefix[i] * suffix[i]
    $answer = [];
    for ($i = 0; $i < $n; $i++) {
        $answer[$i] = $prefix[$i] * $suffix[$i];
    }

    return $answer;
}

/**
 * Space Optimized (Two Pass) アプローチ【推奨】
 *
 * 出力配列を再利用して、追加空間を O(1) に削減。
 * 第1パスで左側の積を計算し、第2パスで右側の積を掛ける。
 *
 * 時間計算量: O(n) - 配列を2回走査
 * 空間計算量: O(1) - 出力配列を除く追加メモリは定数
 *
 * @param int[] $nums 整数配列
 * @return int[] 自分以外の要素の積の配列
 */
function productExceptSelf(array $nums): array
{
    $n = count($nums);
    $answer = [];

    // 第1パス: 左側の積（prefix）を計算
    // answer[i] には nums[0] * nums[1] * ... * nums[i-1] が格納される
    $answer[0] = 1;
    for ($i = 1; $i < $n; $i++) {
        $answer[$i] = $answer[$i - 1] * $nums[$i - 1];
    }

    // 第2パス: 右側の積（suffix）を掛ける
    // rightProduct は現在位置より右側のすべての要素の積を保持
    $rightProduct = 1;
    for ($i = $n - 1; $i >= 0; $i--) {
        $answer[$i] *= $rightProduct;
        $rightProduct *= $nums[$i];
    }

    return $answer;
}

// ==================== テストケース ====================

/**
 * テストを実行する関数
 */
function runTests(): void
{
    $testCases = [
        [
            'input' => [1, 2, 3, 4],
            'expected' => [24, 12, 8, 6],
            'description' => '基本的なケース',
        ],
        [
            'input' => [-1, 1, 0, -3, 3],
            'expected' => [0, 0, 9, 0, 0],
            'description' => 'ゼロを含む',
        ],
        [
            'input' => [1, 2],
            'expected' => [2, 1],
            'description' => '最小要素数（2要素）',
        ],
        [
            'input' => [-1, -2, -3, -4],
            'expected' => [-24, -12, -8, -6],
            'description' => '負の数のみ',
        ],
        [
            'input' => [0, 1, 2, 0, 3],
            'expected' => [0, 0, 0, 0, 0],
            'description' => 'ゼロが2つ',
        ],
        [
            'input' => [1, 1, 1, 1],
            'expected' => [1, 1, 1, 1],
            'description' => 'すべて1',
        ],
        [
            'input' => [2, 3, 5],
            'expected' => [15, 10, 6],
            'description' => '3要素',
        ],
    ];

    echo "=== Product of Array Except Self テスト ===\n\n";
    $passed = 0;
    $failed = 0;

    foreach ($testCases as $index => $testCase) {
        $result = productExceptSelf($testCase['input']);
        $status = $result === $testCase['expected'] ? '✓ PASS' : '✗ FAIL';

        if ($result === $testCase['expected']) {
            $passed++;
        } else {
            $failed++;
        }

        echo 'テスト ' . ($index + 1) . ": {$status}\n";
        echo "  説明: {$testCase['description']}\n";
        echo '  入力: [' . implode(', ', $testCase['input']) . "]\n";
        echo '  期待値: [' . implode(', ', $testCase['expected']) . "]\n";
        echo '  結果: [' . implode(', ', $result) . "]\n";

        if ($result !== $testCase['expected']) {
            echo "  ⚠ 不一致！\n";
        }
        echo "\n";
    }

    echo "=== 結果サマリー ===\n";
    echo "通過: {$passed}\n";
    echo "失敗: {$failed}\n";
    echo '合計: ' . ($passed + $failed) . "\n\n";
}

/**
 * ステップバイステップの実行例を表示
 */
function demonstrateStepByStep(): void
{
    echo "=== Space Optimized アプローチ ステップバイステップ実行例 ===\n\n";

    $nums = [1, 2, 3, 4];
    echo '入力配列: [' . implode(', ', $nums) . "]\n\n";

    $n = count($nums);
    $answer = [];

    // 第1パス
    echo "--- 第1パス: 左側の積（prefix）を計算 ---\n\n";
    $answer[0] = 1;
    echo "初期状態: answer[0] = 1（左側に要素なし）\n\n";

    for ($i = 1; $i < $n; $i++) {
        $answer[$i] = $answer[$i - 1] * $nums[$i - 1];
        echo "i={$i}: answer[{$i}] = answer[" . ($i - 1) . '] * nums[' . ($i - 1) . '] = '
            . $answer[$i - 1] . ' * ' . $nums[$i - 1] . ' = ' . $answer[$i] . "\n";
    }

    echo "\n第1パス後: answer = [" . implode(', ', $answer) . "]\n";
    echo "（各位置に、その左側のすべての要素の積が格納されている）\n\n";

    // 第2パス
    echo "--- 第2パス: 右側の積（suffix）を掛ける ---\n\n";
    $rightProduct = 1;
    echo "初期状態: rightProduct = 1（右端より右に要素なし）\n\n";

    for ($i = $n - 1; $i >= 0; $i--) {
        $oldAnswer = $answer[$i];
        $answer[$i] *= $rightProduct;
        echo "i={$i}: answer[{$i}] = {$oldAnswer} * {$rightProduct} = " . $answer[$i] . "\n";
        $oldRightProduct = $rightProduct;
        $rightProduct *= $nums[$i];
        echo "       rightProduct = {$oldRightProduct} * {$nums[$i]} = {$rightProduct}\n\n";
    }

    echo '最終結果: answer = [' . implode(', ', $answer) . "]\n\n";

    echo "検証:\n";
    for ($i = 0; $i < $n; $i++) {
        $product = 1;
        $elements = [];
        for ($j = 0; $j < $n; $j++) {
            if ($i !== $j) {
                $product *= $nums[$j];
                $elements[] = $nums[$j];
            }
        }
        echo '- answer[' . $i . '] = ' . implode(' × ', $elements) . " = {$product} ";
        echo ($product === $answer[$i] ? '✓' : '✗') . "\n";
    }
}

/**
 * 解法の比較デモ
 */
function compareApproaches(): void
{
    echo "\n=== 解法の比較 ===\n\n";

    $nums = [1, 2, 3, 4];
    echo '入力: [' . implode(', ', $nums) . "]\n\n";

    // Brute Force
    $start = microtime(true);
    $result1 = productExceptSelfBruteForce($nums);
    $time1 = microtime(true) - $start;

    // Prefix & Suffix Arrays
    $start = microtime(true);
    $result2 = productExceptSelfWithArrays($nums);
    $time2 = microtime(true) - $start;

    // Space Optimized
    $start = microtime(true);
    $result3 = productExceptSelf($nums);
    $time3 = microtime(true) - $start;

    echo "Brute Force:         [" . implode(', ', $result1) . "]\n";
    echo "Prefix/Suffix Arrays: [" . implode(', ', $result2) . "]\n";
    echo "Space Optimized:      [" . implode(', ', $result3) . "]\n\n";

    echo "┌─────────────────────────┬────────────┬────────────┬─────────────┐\n";
    echo "│ 解法                    │ 時間計算量 │ 空間計算量 │ 推奨度      │\n";
    echo "├─────────────────────────┼────────────┼────────────┼─────────────┤\n";
    echo "│ Brute Force             │ O(n²)      │ O(1)       │ 学習用      │\n";
    echo "│ Prefix/Suffix Arrays    │ O(n)       │ O(n)       │ 理解用      │\n";
    echo "│ Space Optimized         │ O(n)       │ O(1)       │ ★本番用★   │\n";
    echo "└─────────────────────────┴────────────┴────────────┴─────────────┘\n";
}

// ==================== メイン実行 ====================

if (php_sapi_name() === 'cli') {
    echo "Product of Array Except Self - LeetCode 238\n";
    echo "=============================================\n\n";

    runTests();
    echo "\n";
    demonstrateStepByStep();
    compareApproaches();
} else {
    echo '<pre>';
    echo "Product of Array Except Self - LeetCode 238\n";
    echo "=============================================\n\n";

    runTests();
    echo "\n";
    demonstrateStepByStep();
    compareApproaches();
    echo '</pre>';
}
