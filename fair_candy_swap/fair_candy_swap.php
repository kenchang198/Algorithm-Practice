<?php
/**
 * LeetCode 888: Fair Candy Swap（公平なキャンディー交換）
 * 
 * 2人の友人が1つずつキャンディーボックスを交換して、
 * 交換後に両者が同じ総量のキャンディーを持つようにする問題
 */

/**
 * Fair Candy Swap の解法
 * 
 * @param int[] $aliceSizes Aliceのキャンディーボックスのサイズ配列
 * @param int[] $bobSizes Bobのキャンディーボックスのサイズ配列
 * @return int[] 交換すべきキャンディーボックスのサイズ [Aliceの交換する値, Bobの交換する値]
 */
function fairCandySwap(array $aliceSizes, array $bobSizes): array
{
    // 各配列の合計を計算
    $aliceSum = array_sum($aliceSizes);
    $bobSum = array_sum($bobSizes);
    
    // 合計の差分を計算
    // 注意: 合計の大小を事前に知る必要はない。diffを計算すれば自動的に正負が決まる
    $diff = $aliceSum - $bobSum;
    
    // 差分の半分が調整値（詳細はexplanation.mdを参照）
    // halfDiffは正でも負でも、関係式 x - y = halfDiff が成り立つため正しく動作する
    $halfDiff = $diff / 2;
    
    // BobのキャンディーボックスをHashSetに格納（O(1)で検索可能にする）
    $bobSet = [];
    foreach ($bobSizes as $size) {
        $bobSet[$size] = true;
    }
    
    // Aliceの各キャンディーボックスについて、交換可能なBobのボックスを探す
    // 関係式: x - y = halfDiff より y = x - halfDiff
    // halfDiffが負でも正しく動作（例: y = 1 - (-1) = 2）
    foreach ($aliceSizes as $aliceSize) {
        $bobSize = $aliceSize - $halfDiff;
        
        if (isset($bobSet[$bobSize])) {
            return [$aliceSize, $bobSize];
        }
    }
    
    // 解が見つからない場合（通常は問題の制約上発生しない）
    return [];
}

/**
 * テストケースの作成と実行
 */
function runTests(): void
{
    echo "=== Fair Candy Swap テスト ===\n\n";
    
    // テストケース1: intro.txtの例
    $alice1 = [1, 2, 5];
    $bob1 = [2, 4];
    $result1 = fairCandySwap($alice1, $bob1);
    echo "テストケース1:\n";
    echo "Alice: [" . implode(", ", $alice1) . "] (合計: " . array_sum($alice1) . ")\n";
    echo "Bob: [" . implode(", ", $bob1) . "] (合計: " . array_sum($bob1) . ")\n";
    echo "解答: Aliceの" . $result1[0] . "とBobの" . $result1[1] . "を交換\n";
    echo "交換後 - Alice: " . (array_sum($alice1) - $result1[0] + $result1[1]) . ", Bob: " . (array_sum($bob1) - $result1[1] + $result1[0]) . "\n\n";
    
    // テストケース2: 別の例
    $alice2 = [1, 1];
    $bob2 = [2, 2];
    $result2 = fairCandySwap($alice2, $bob2);
    echo "テストケース2:\n";
    echo "Alice: [" . implode(", ", $alice2) . "] (合計: " . array_sum($alice2) . ")\n";
    echo "Bob: [" . implode(", ", $bob2) . "] (合計: " . array_sum($bob2) . ")\n";
    echo "解答: Aliceの" . $result2[0] . "とBobの" . $result2[1] . "を交換\n";
    echo "交換後 - Alice: " . (array_sum($alice2) - $result2[0] + $result2[1]) . ", Bob: " . (array_sum($bob2) - $result2[1] + $result2[0]) . "\n\n";
    
    // テストケース3: より大きな配列
    $alice3 = [2];
    $bob3 = [1, 3];
    $result3 = fairCandySwap($alice3, $bob3);
    echo "テストケース3:\n";
    echo "Alice: [" . implode(", ", $alice3) . "] (合計: " . array_sum($alice3) . ")\n";
    echo "Bob: [" . implode(", ", $bob3) . "] (合計: " . array_sum($bob3) . ")\n";
    echo "解答: Aliceの" . $result3[0] . "とBobの" . $result3[1] . "を交換\n";
    echo "交換後 - Alice: " . (array_sum($alice3) - $result3[0] + $result3[1]) . ", Bob: " . (array_sum($bob3) - $result3[1] + $result3[0]) . "\n\n";
    
    // テストケース4: Bobの合計がAliceより大きい場合（halfDiffが負の値になる）
    $alice4 = [1, 2];
    $bob4 = [2, 3];
    $result4 = fairCandySwap($alice4, $bob4);
    echo "テストケース4（Bobの合計 > Aliceの合計）:\n";
    echo "Alice: [" . implode(", ", $alice4) . "] (合計: " . array_sum($alice4) . ")\n";
    echo "Bob: [" . implode(", ", $bob4) . "] (合計: " . array_sum($bob4) . ")\n";
    echo "diff = " . (array_sum($alice4) - array_sum($bob4)) . ", halfDiff = " . ((array_sum($alice4) - array_sum($bob4)) / 2) . "\n";
    echo "解答: Aliceの" . $result4[0] . "とBobの" . $result4[1] . "を交換\n";
    echo "交換後 - Alice: " . (array_sum($alice4) - $result4[0] + $result4[1]) . ", Bob: " . (array_sum($bob4) - $result4[1] + $result4[0]) . "\n";
}

// テスト実行
runTests();

