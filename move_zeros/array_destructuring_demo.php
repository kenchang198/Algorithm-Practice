<?php
/**
 * 配列分割代入（Array Destructuring）のデモンストレーション
 * 
 * PHP 7.1で導入された配列分割代入機能の詳細な解説と使用例
 * 
 * 参考文献:
 * - https://www.php.net/manual/ja/language.types.array.php
 * - https://www.php.net/manual/ja/function.list.php
 * - https://www.php.net/manual/ja/migration71.new-features.php
 */

echo "========================================\n";
echo "配列分割代入（Array Destructuring）デモ\n";
echo "========================================\n\n";

// ============================================
// 1. 基本的な配列分割代入
// ============================================
echo "【1】基本的な配列分割代入\n";
echo "----------------------------------------\n";

$data = [10, 20, 30];
[$a, $b, $c] = $data;

echo "配列: " . json_encode($data) . "\n";
echo "[$a, $b, $c] = \$data;\n";
echo "結果: \$a = $a, \$b = $b, \$c = $c\n\n";

// ============================================
// 2. スワップ操作の詳細解説
// ============================================
echo "【2】スワップ操作の詳細解説\n";
echo "----------------------------------------\n";

echo "■ 2つの変数のスワップ\n";
$x = 5;
$y = 10;
echo "スワップ前: \$x = $x, \$y = $y\n";

// 配列分割代入によるスワップ
[$x, $y] = [$y, $x];
echo "スワップ後: \$x = $x, \$y = $y\n\n";

echo "■ 配列要素のスワップ\n";
$nums = [0, 1, 0, 3, 12];
$left = 0;
$right = 1;

echo "配列: " . json_encode($nums) . "\n";
echo "スワップ前: nums[$left] = {$nums[$left]}, nums[$right] = {$nums[$right]}\n";

// スワップ操作
[$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];

echo "スワップ後: nums[$left] = {$nums[$left]}, nums[$right] = {$nums[$right]}\n";
echo "配列: " . json_encode($nums) . "\n\n";

// ============================================
// 3. スワップ操作の実行の流れ（詳細解説）
// ============================================
echo "【3】スワップ操作の実行の流れ（詳細解説）\n";
echo "----------------------------------------\n";

$arr = [100, 200];
$i = 0;
$j = 1;

echo "初期状態:\n";
echo "  配列: " . json_encode($arr) . "\n";
echo "  \$i = $i, \$j = $j\n";
echo "  arr[\$i] = {$arr[$i]}, arr[\$j] = {$arr[$j]}\n\n";

echo "実行するコード:\n";
echo "  [\$arr[\$i], \$arr[\$j]] = [\$arr[\$j], \$arr[\$i]];\n\n";

echo "ステップ1: 右辺の評価\n";
echo "  [\$arr[\$j], \$arr[\$i]] を評価\n";
echo "  \$arr[\$j] = {$arr[$j]}, \$arr[\$i] = {$arr[$i]}\n";
$temp_array = [$arr[$j], $arr[$i]];
echo "  → 一時配列が作成される: " . json_encode($temp_array) . "\n\n";

echo "ステップ2: 左辺への代入\n";
echo "  \$arr[\$i] = {$temp_array[0]} (一時配列の最初の要素)\n";
echo "  \$arr[\$j] = {$temp_array[1]} (一時配列の2番目の要素)\n\n";

// 実際にスワップを実行
[$arr[$i], $arr[$j]] = [$arr[$j], $arr[$i]];

echo "ステップ3: 結果\n";
echo "  配列: " . json_encode($arr) . "\n";
echo "  arr[\$i] = {$arr[$i]}, arr[\$j] = {$arr[$j]}\n";
echo "  → 値が交換されました！\n\n";

// ============================================
// 4. 従来の方法との比較
// ============================================
echo "【4】従来の方法との比較\n";
echo "----------------------------------------\n";

$arr1 = [1, 2];
$arr2 = [1, 2];
$left = 0;
$right = 1;

echo "■ 従来の方法（一時変数を使用）\n";
echo "コード:\n";
echo "  \$temp = \$arr[\$left];\n";
echo "  \$arr[\$left] = \$arr[\$right];\n";
echo "  \$arr[\$right] = \$temp;\n";

$temp = $arr1[$left];
$arr1[$left] = $arr1[$right];
$arr1[$right] = $temp;

echo "結果: " . json_encode($arr1) . "\n";
echo "デメリット:\n";
echo "  - 一時変数が必要（メモリ使用量が増える）\n";
echo "  - コードが3行必要\n";
echo "  - 一時変数の名前を考える必要がある\n\n";

echo "■ 配列分割代入を使用\n";
echo "コード:\n";
echo "  [\$arr[\$left], \$arr[\$right]] = [\$arr[\$right], \$arr[\$left]];\n";

[$arr2[$left], $arr2[$right]] = [$arr2[$right], $arr2[$left]];

echo "結果: " . json_encode($arr2) . "\n";
echo "メリット:\n";
echo "  - 一時変数が不要（メモリ効率が良い）\n";
echo "  - 1行で完結（コードが簡潔）\n";
echo "  - 可読性が向上\n";
echo "  - 意図が明確（「値を交換する」という操作が明確）\n\n";

// ============================================
// 5. その他の使用例
// ============================================
echo "【5】その他の使用例\n";
echo "----------------------------------------\n";

echo "■ 例1: 複数の変数への代入\n";
$userData = ['山田', '太郎', 30];
[$firstName, $lastName, $age] = $userData;
echo "配列: " . json_encode($userData) . "\n";
echo "[$firstName, $lastName, $age] = \$userData;\n";
echo "結果: 姓=$firstName, 名=$lastName, 年齢=$age\n\n";

echo "■ 例2: 関数の戻り値の分割代入\n";
function getUserInfo() {
    return ['John', 'john@example.com', 30];
}

[$name, $email, $age] = getUserInfo();
echo "関数: getUserInfo()\n";
echo "[$name, $email, $age] = getUserInfo();\n";
echo "結果: 名前=$name, メール=$email, 年齢=$age\n\n";

echo "■ 例3: 連想配列の分割代入（PHP 7.1+）\n";
$user = ['name' => 'John', 'email' => 'john@example.com', 'age' => 30];
['name' => $name, 'email' => $email, 'age' => $age] = $user;
echo "配列: " . json_encode($user) . "\n";
echo "['name' => \$name, 'email' => \$email, 'age' => \$age] = \$user;\n";
echo "結果: 名前=$name, メール=$email, 年齢=$age\n\n";

echo "■ 例4: 配列の一部だけを取得（要素のスキップ）\n";
$data = [1, 2, 3, 4, 5];
[$first, , $third, , $fifth] = $data;
echo "配列: " . json_encode($data) . "\n";
echo "[$first, , $third, , $fifth] = \$data;  // 2番目と4番目の要素をスキップ\n";
echo "結果: \$first = $first, \$third = $third, \$fifth = $fifth\n\n";

echo "■ 例5: ネストした配列の分割代入\n";
$nested = [[1, 2], [3, 4]];
[[$a1, $a2], [$b1, $b2]] = $nested;
echo "配列: " . json_encode($nested) . "\n";
echo "[[$a1, $a2], [$b1, $b2]] = \$nested;\n";
echo "結果: [$a1, $a2], [$b1, $b2]\n\n";

// ============================================
// 6. move_zerosでの実際の使用例
// ============================================
echo "【6】move_zerosでの実際の使用例\n";
echo "----------------------------------------\n";

function move_zeros_demo(array &$nums): array {
    $left = 0;
    
    echo "初期配列: " . json_encode($nums) . "\n\n";
    
    for ($right = 0; $right < count($nums); $right++) {
        if ($nums[$right] !== 0) {
            if ($left !== $right) {
                echo "right=$right: 非ゼロ要素 {$nums[$right]} を発見\n";
                echo "  スワップ前: nums[$left] = {$nums[$left]}, nums[$right] = {$nums[$right]}\n";
                
                // 配列分割代入によるスワップ
                [$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];
                
                echo "  スワップ後: nums[$left] = {$nums[$left]}, nums[$right] = {$nums[$right]}\n";
                echo "  配列: " . json_encode($nums) . "\n";
            } else {
                echo "right=$right: 非ゼロ要素 {$nums[$right]} を発見（既に正しい位置）\n";
            }
            $left++;
        } else {
            echo "right=$right: ゼロをスキップ\n";
        }
    }
    
    echo "\n最終結果: " . json_encode($nums) . "\n";
    return $nums;
}

$testArray = [0, 1, 0, 3, 12];
move_zeros_demo($testArray);

echo "\n";

// ============================================
// 7. PHP 7.1以前との比較
// ============================================
echo "【7】PHP 7.1以前との比較\n";
echo "----------------------------------------\n";

echo "■ PHP 7.0以前（list()関数を使用）\n";
echo "コード:\n";
echo "  list(\$a, \$b) = [1, 2];\n";
echo "  list(\$arr[\$i], \$arr[\$j]) = [\$arr[\$j], \$arr[\$i]];  // スワップ\n";
echo "注意: list()関数は配列要素への直接代入ができないため、\n";
echo "      スワップ操作には使用できません。\n\n";

echo "■ PHP 7.1以降（短縮構文[]を使用）推奨\n";
echo "コード:\n";
echo "  [\$a, \$b] = [1, 2];\n";
echo "  [\$arr[\$i], \$arr[\$j]] = [\$arr[\$j], \$arr[\$i]];  // スワップ可能！\n";
echo "メリット:\n";
echo "  - より簡潔な構文\n";
echo "  - 配列要素への直接代入が可能\n";
echo "  - スワップ操作が1行で可能\n\n";

echo "========================================\n";
echo "デモ終了\n";
echo "========================================\n";

