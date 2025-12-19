<?php

/**
 * NG 重大なバグ: アルゴリズムが不正解を返すケースがある
 */
function bestTimeToBuyAndSellStock(array $prices): int
{
    $buyPrice = max($prices);
    $buyDay = 0;

    // Buy
    for ($i = 0; $i < count($prices); $i++) {
        if ($prices[$i] < $buyPrice) {
            if ($i === count($prices) - 1) {
                // echo "売る日がないため利益 ゼロ" . "\n";
                return 0;
            }
            // 最安値を更新
            $buyPrice = $prices[$i];
            $buyDay = $i;
        }
    }

    // Sell
    $sellPrice = 0;
    for ($j = $buyDay + 1; $j < count($prices); $j++) {
        if ($buyPrice < $prices[$j]) {
            // 最高値を更新
            $sellPrice = max($sellPrice, $prices[$j]);
        }
    }
    
    // 仕入れ値が売値以上のとき利益なし
    if ($sellPrice <= $buyPrice) {
        // echo "仕入れ値が売値以上のとき利益なし" . "\n";
        return 0;
    }

    return $sellPrice - $buyPrice;
}

// $prices = [7,1,5,3,6,4];
// $prices = [7,2,5,3,1,4];

/**
 * bestTimeToBuyAndSellStock
 * 「全体の最安値で買うことが最適とは限らない」 という点を見落としている。
 *
 * [失敗するテストケース]
 * テストケース 1: [3, 2, 6, 5, 0, 3]
 * 
 * 現在:
 * - 第1ループ: 最安値 = 0 (index 4)
 * - 第2ループ: index 4 以降の最高値 = 3 (index 5)
 * - 結果: 3 - 0 = 3
 *
 * 正しい答え:
 * - 2 (index 1) で買い、6 (index 2) で売る
 * - 結果: 6 - 2 = 4
 * 
 * 
 * テストケース 2: [2, 4, 1]
 * 
 * 現在:
 * - 第1ループ: 最安値 = 1 (index 2)
 * - 最終日が最安値なので return 0
 * 
 * 正しい答え:
 * - 2 (index 0) で買い、4 (index 1) で売る
 * - 結果: 4 - 2 = 2
 */

// $prices = [3,2,6,5,0,3];
// $prices = [2,4,1];

// echo bestTimeToBuyAndSellStock($prices);

// Brute Force（総当たり）アプローチ
function maxProfitBruteForce(array $prices): int
{
    $n = count($prices);
    $maxProfit = 0;

    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $maxProfit = max($maxProfit, $prices[$j] - $prices[$i]);
        }
    }
    return $maxProfit;
}

// $prices = [3,2,6,5,0,3];
// $prices = [2,4,1];
// echo maxProfitBruteForce($prices) . "\n";

// One Pass（1 パス）アプローチ
function maxProfitWithOnePass(array $prices): int
{
    $minPrice = PHP_INT_MAX;
    $maxProfit = 0;
    foreach ($prices as $price) {
        $minPrice = min($minPrice , $price);
        $maxProfit = max($maxProfit, $price - $minPrice);
    }
    return $maxProfit;
}

$prices = [3,2,6,5,0,3];
// $prices = [2,4,1];
echo maxProfitWithOnePass($prices) . "\n";