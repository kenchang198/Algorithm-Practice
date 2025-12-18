<?php

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

$prices = [7,1,5,3,6,4];
// $prices = [7,6,4,3,1];

echo bestTimeToBuyAndSellStock($prices);