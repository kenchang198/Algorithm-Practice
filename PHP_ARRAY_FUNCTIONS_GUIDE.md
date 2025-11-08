# PHP 配列関数活用ガイド - アルゴリズム問題対策

アルゴリズム問題・コーディング試験でよく使う PHP 配列関数を、パターン別・目的別に整理したリファレンスガイドです。

## 目次

### 基本パターン

1. [配列の基本情報取得](#1-配列の基本情報取得)
2. [配列の探索・検索](#2-配列の探索検索)
3. [配列の変換・抽出](#3-配列の変換抽出)
4. [配列の集計・計算](#4-配列の集計計算)
5. [配列のソート](#5-配列のソート)
6. [配列のフィルタリング](#6-配列のフィルタリング)
7. [配列の結合・分割](#7-配列の結合分割)
8. [配列の操作・追加・削除](#8-配列の操作追加削除)

### アルゴリズムパターン別活用

9. [Two Pointers（2 ポインタ法）](#9-two-pointers2ポインタ法)
10. [Sliding Window（スライディングウィンドウ）](#10-sliding-windowスライディングウィンドウ)
11. [ハッシュマップ/連想配列](#11-ハッシュマップ連想配列)
12. [配列の前処理](#12-配列の前処理)
13. [スタック/キュー操作](#13-スタックキュー操作)

---

## 基本パターン

### 1. 配列の基本情報取得

#### `count(array $array): int`

配列の要素数を取得（計算量: O(1)）

```php
// 配列サイズの取得
$nums = [1, 2, 3, 4, 5];
$n = count($nums);  // 5

// Two Pointersパターンで右端の初期化
$left = 0;
$right = count($nums) - 1;
```

#### `empty(mixed $var): bool`

配列が空かどうかをチェック

```php
// エッジケースの処理
function solve(array $nums): int {
    if (empty($nums)) {
        return 0;
    }
    // メインロジック
}
```

#### `isset(mixed $var): bool`

配列要素や連想配列のキーが存在するかチェック（計算量: O(1)）

```php
// ハッシュマップでの要素存在チェック
$map = ['a' => 1, 'b' => 2];
if (isset($map['a'])) {
    echo $map['a'];
}

// 配列インデックスの存在確認
if (isset($nums[5])) {
    $value = $nums[5];
}
```

#### `in_array(mixed $needle, array $haystack): bool`

配列内に特定の値が存在するかチェック（計算量: O(n)）

```php
// 特定値の存在チェック
$nums = [1, 2, 3, 4, 5];
if (in_array(3, $nums)) {
    echo "Found!";
}

// 注意: 連想配列でのO(1)検索にはisset()を推奨
$map = array_flip($nums);  // 値をキーに変換
if (isset($map[3])) {  // O(1)で検索可能
    echo "Found!";
}
```

---

### 2. 配列の探索・検索

#### `array_search(mixed $needle, array $haystack): int|string|false`

配列から値を検索し、最初に見つかったキーを返す（計算量: O(n)）

```php
// Two Sum問題での差分検索
function twoSum(array $nums, int $target): array {
    $map = [];
    foreach ($nums as $i => $num) {
        $diff = $target - $num;
        $foundIndex = array_search($diff, $map);
        if ($foundIndex !== false) {
            return [$foundIndex, $i];
        }
        $map[$i] = $num;
    }
    return [];
}
```

#### `array_key_exists(string|int $key, array $array): bool`

配列に指定したキーが存在するかチェック（計算量: O(1)）

```php
// isset()との違い: nullの値も検出できる
$arr = ['a' => null, 'b' => 2];
array_key_exists('a', $arr);  // true
isset($arr['a']);              // false (値がnullのため)
```

#### `array_keys(array $array): array`

配列の全キーを取得（計算量: O(n)）

```php
// 連想配列のキー一覧取得
$scores = ['Alice' => 95, 'Bob' => 87, 'Carol' => 92];
$names = array_keys($scores);  // ['Alice', 'Bob', 'Carol']

// 特定値を持つキーの検索
$positions = array_keys([1, 0, 1, 0, 1], 1);  // [0, 2, 4]
```

#### `array_values(array $array): array`

配列の全値を取得し、インデックスを 0 から振り直す（計算量: O(n)）

```php
// 連想配列から値のみを抽出
$scores = ['Alice' => 95, 'Bob' => 87, 'Carol' => 92];
$values = array_values($scores);  // [95, 87, 92]

// 配列のインデックスをリセット
$filtered = [2 => 'a', 5 => 'b', 8 => 'c'];
$reindexed = array_values($filtered);  // [0 => 'a', 1 => 'b', 2 => 'c']
```

---

### 3. 配列の変換・抽出

#### `array_slice(array $array, int $offset, ?int $length = null): array`

配列の一部を抽出（計算量: O(k)、k は抽出する要素数）

```php
// 固定サイズスライディングウィンドウの初期化
function maxSumSubarray(array $arr, int $k): int {
    $windowSum = array_sum(array_slice($arr, 0, $k));
    $maxSum = $windowSum;

    for ($i = $k; $i < count($arr); $i++) {
        $windowSum = $windowSum - $arr[$i - $k] + $arr[$i];
        $maxSum = max($maxSum, $windowSum);
    }
    return $maxSum;
}

// 部分配列の抽出
$nums = [1, 2, 3, 4, 5];
$sub = array_slice($nums, 1, 3);  // [2, 3, 4]
```

#### `array_map(callable $callback, array ...$arrays): array`

配列の各要素に関数を適用（計算量: O(n)）

```php
// 各要素を2倍にする
$nums = [1, 2, 3, 4, 5];
$doubled = array_map(fn($x) => $x * 2, $nums);  // [2, 4, 6, 8, 10]

// 複数配列の要素を組み合わせる
$a = [1, 2, 3];
$b = [4, 5, 6];
$sums = array_map(fn($x, $y) => $x + $y, $a, $b);  // [5, 7, 9]
```

#### `array_chunk(array $array, int $length): array`

配列を指定サイズのチャンクに分割（計算量: O(n)）

```php
// 配列をグループ化
$nums = [1, 2, 3, 4, 5, 6, 7];
$chunks = array_chunk($nums, 3);
// [[1, 2, 3], [4, 5, 6], [7]]

// ペア処理
$pairs = array_chunk($nums, 2);
foreach ($pairs as [$first, $second]) {
    // ペアごとの処理
}
```

#### `array_column(array $array, mixed $column_key): array`

多次元配列から特定のカラムを抽出（計算量: O(n)）

```php
// オブジェクトの配列から特定フィールドを抽出
$users = [
    ['id' => 1, 'name' => 'Alice', 'age' => 25],
    ['id' => 2, 'name' => 'Bob', 'age' => 30],
    ['id' => 3, 'name' => 'Carol', 'age' => 28]
];
$names = array_column($users, 'name');  // ['Alice', 'Bob', 'Carol']
$ages = array_column($users, 'age');    // [25, 30, 28]
```

#### `array_flip(array $array): array`

配列のキーと値を入れ替える（計算量: O(n)）

```php
// 値からインデックスへの高速検索用マップ作成
$nums = [10, 20, 30, 40];
$map = array_flip($nums);
// [10 => 0, 20 => 1, 30 => 2, 40 => 3]

// O(1)で値の存在チェック
if (isset($map[30])) {
    $index = $map[30];  // 2
}
```

---

### 4. 配列の集計・計算

#### `array_sum(array $array): int|float`

配列の合計値を計算（計算量: O(n)）

```php
// 部分配列の合計
$nums = [1, 2, 3, 4, 5];
$sum = array_sum($nums);  // 15

// スライディングウィンドウの初期合計
$k = 3;
$windowSum = array_sum(array_slice($nums, 0, $k));
```

#### `max(mixed ...$values): mixed`

最大値を取得（配列またはバラバラの引数）（計算量: O(n)）

```php
// 配列から最大値を取得
$nums = [3, 7, 2, 9, 1];
$maxValue = max($nums);  // 9

// 2つの値の最大値（Two Pointersなどで頻出）
$result = 0;
$result = max($result, $currentValue);

// 固定ウィンドウ内の最大値
$windowMax = max(array_slice($arr, $i, $k));
```

#### `min(mixed ...$values): mixed`

最小値を取得（配列またはバラバラの引数）（計算量: O(n)）

```php
// Container With Most Water問題
function maxArea(array $height): int {
    $maxArea = 0;
    $left = 0;
    $right = count($height) - 1;

    while ($left < $right) {
        $h = min($height[$left], $height[$right]);
        $w = $right - $left;
        $maxArea = max($maxArea, $h * $w);

        if ($height[$left] < $height[$right]) {
            $left++;
        } else {
            $right--;
        }
    }
    return $maxArea;
}
```

#### `array_product(array $array): int|float`

配列の積を計算（計算量: O(n)）

```php
// 配列の全要素の積
$nums = [2, 3, 4];
$product = array_product($nums);  // 24

// Product of Array Except Self問題の補助として
function productExceptSelf(array $nums): array {
    $n = count($nums);
    $result = array_fill(0, $n, 1);

    // 左からの積
    $leftProduct = 1;
    for ($i = 0; $i < $n; $i++) {
        $result[$i] = $leftProduct;
        $leftProduct *= $nums[$i];
    }

    // 右からの積
    $rightProduct = 1;
    for ($i = $n - 1; $i >= 0; $i--) {
        $result[$i] *= $rightProduct;
        $rightProduct *= $nums[$i];
    }

    return $result;
}
```

#### `array_reduce(array $array, callable $callback, mixed $initial = null): mixed`

配列を単一の値に畳み込む（計算量: O(n)）

```php
// 合計を計算（array_sumの代替）
$nums = [1, 2, 3, 4, 5];
$sum = array_reduce($nums, fn($carry, $item) => $carry + $item, 0);  // 15

// 最大値を計算（maxの代替）
$max = array_reduce($nums, fn($carry, $item) => max($carry, $item), PHP_INT_MIN);

// 複雑な集計処理
$words = ['apple', 'banana', 'cherry'];
$lengths = array_reduce($words, function($carry, $word) {
    $carry[$word] = strlen($word);
    return $carry;
}, []);
```

---

### 5. 配列のソート

#### `sort(array &$array): bool`

配列を昇順にソート（破壊的、計算量: O(n log n)）

```php
// 基本的なソート
$nums = [3, 1, 4, 1, 5, 9];
sort($nums);  // [1, 1, 3, 4, 5, 9]

// ソート後の二分探索や Two Pointers
function threeSum(array $nums): array {
    sort($nums);
    $result = [];
    $n = count($nums);

    for ($i = 0; $i < $n - 2; $i++) {
        if ($i > 0 && $nums[$i] === $nums[$i - 1]) continue;

        $left = $i + 1;
        $right = $n - 1;

        while ($left < $right) {
            $sum = $nums[$i] + $nums[$left] + $nums[$right];
            if ($sum === 0) {
                $result[] = [$nums[$i], $nums[$left], $nums[$right]];
                $left++;
                $right--;
            } elseif ($sum < 0) {
                $left++;
            } else {
                $right--;
            }
        }
    }
    return $result;
}
```

#### `rsort(array &$array): bool`

配列を降順にソート（破壊的、計算量: O(n log n)）

```php
// 降順ソート
$nums = [3, 1, 4, 1, 5, 9];
rsort($nums);  // [9, 5, 4, 3, 1, 1]

// Top K問題で使用
function topKFrequent(array $nums, int $k): array {
    $freqMap = array_count_values($nums);
    arsort($freqMap);  // 頻度で降順ソート
    return array_slice(array_keys($freqMap), 0, $k);
}
```

#### `asort(array &$array): bool` / `arsort(array &$array): bool`

連想配列を値でソート、キーを保持（計算量: O(n log n)）

```php
// 連想配列を値で昇順ソート
$scores = ['Alice' => 85, 'Bob' => 92, 'Carol' => 88];
asort($scores);
// ['Alice' => 85, 'Carol' => 88, 'Bob' => 92]

// 連想配列を値で降順ソート
arsort($scores);
// ['Bob' => 92, 'Carol' => 88, 'Alice' => 85]
```

#### `ksort(array &$array): bool` / `krsort(array &$array): bool`

連想配列をキーでソート（計算量: O(n log n)）

```php
// キーで昇順ソート
$data = [3 => 'c', 1 => 'a', 2 => 'b'];
ksort($data);  // [1 => 'a', 2 => 'b', 3 => 'c']

// キーで降順ソート
krsort($data);  // [3 => 'c', 2 => 'b', 1 => 'a']
```

#### `usort(array &$array, callable $callback): bool`

カスタム比較関数でソート（計算量: O(n log n)）

```php
// カスタムソート: 絶対値で昇順
$nums = [-3, -1, 2, 4, -5];
usort($nums, fn($a, $b) => abs($a) <=> abs($b));
// [-1, 2, -3, 4, -5]

// 複数条件でのソート
$intervals = [[1, 3], [2, 6], [8, 10], [15, 18]];
usort($intervals, function($a, $b) {
    if ($a[0] === $b[0]) {
        return $a[1] <=> $b[1];  // 開始が同じなら終了で比較
    }
    return $a[0] <=> $b[0];  // 開始位置で比較
});
```

#### `array_multisort(array &$array1, mixed ...$rest): bool`

複数配列を同時にソート（計算量: O(n log n)）

```php
// 2つの配列を連動してソート
$names = ['Alice', 'Bob', 'Carol'];
$ages = [25, 30, 22];
array_multisort($ages, SORT_ASC, $names, SORT_ASC);
// $ages: [22, 25, 30]
// $names: ['Carol', 'Alice', 'Bob']

// インデックスと値のペアを保ちながらソート
$values = [30, 10, 20];
$indices = [0, 1, 2];
array_multisort($values, SORT_ASC, $indices, SORT_ASC);
```

---

### 6. 配列のフィルタリング

#### `array_filter(array $array, ?callable $callback = null): array`

条件に合う要素のみを抽出（計算量: O(n)）

```php
// 偶数のみを抽出
$nums = [1, 2, 3, 4, 5, 6];
$evens = array_filter($nums, fn($x) => $x % 2 === 0);
// [1 => 2, 3 => 4, 5 => 6] (キーは保持される)

// 0でない要素のみを抽出
$nums = [1, 0, 2, 0, 3];
$nonZero = array_filter($nums);  // [0 => 1, 2 => 2, 4 => 3]

// インデックスも使用
$nums = [10, 20, 30, 40, 50];
$filtered = array_filter($nums, fn($v, $k) => $k % 2 === 0, ARRAY_FILTER_USE_BOTH);
// [0 => 10, 2 => 30, 4 => 50]
```

#### `array_unique(array $array): array`

重複を除去（計算量: O(n)）

```php
// 重複削除
$nums = [1, 2, 2, 3, 4, 3, 5];
$unique = array_unique($nums);
// [0 => 1, 1 => 2, 3 => 3, 4 => 4, 6 => 5]

// インデックスをリセット
$unique = array_values(array_unique($nums));
// [1, 2, 3, 4, 5]
```

#### `array_diff(array $array, array ...$arrays): array`

差集合を取得（計算量: O(n \* m)）

```php
// 差分の抽出
$arr1 = [1, 2, 3, 4, 5];
$arr2 = [2, 4];
$diff = array_diff($arr1, $arr2);  // [0 => 1, 2 => 3, 4 => 5]

// 複数配列との差分
$arr1 = [1, 2, 3, 4, 5];
$arr2 = [2, 3];
$arr3 = [4];
$diff = array_diff($arr1, $arr2, $arr3);  // [0 => 1, 4 => 5]
```

#### `array_intersect(array $array, array ...$arrays): array`

積集合を取得（計算量: O(n \* m)）

```php
// 共通要素の抽出
$arr1 = [1, 2, 3, 4, 5];
$arr2 = [2, 3, 4];
$arr3 = [3, 4, 5];
$common = array_intersect($arr1, $arr2, $arr3);  // [2 => 3, 3 => 4]

// インデックスをリセット
$common = array_values($common);  // [3, 4]
```

#### `array_count_values(array $array): array`

各値の出現回数をカウント（計算量: O(n)）

```php
// 頻度カウント
$nums = [1, 2, 2, 3, 3, 3, 4];
$freq = array_count_values($nums);
// [1 => 1, 2 => 2, 3 => 3, 4 => 1]

// Top K Frequent Elements問題
function topKFrequent(array $nums, int $k): array {
    $freq = array_count_values($nums);
    arsort($freq);
    return array_slice(array_keys($freq), 0, $k);
}
```

---

### 7. 配列の結合・分割

#### `array_merge(array ...$arrays): array`

複数の配列を結合（計算量: O(n + m)）

```php
// 配列の結合
$arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];
$merged = array_merge($arr1, $arr2);  // [1, 2, 3, 4, 5, 6]

// 連想配列の結合（後の配列が優先）
$defaults = ['color' => 'red', 'size' => 'M'];
$custom = ['color' => 'blue'];
$config = array_merge($defaults, $custom);
// ['color' => 'blue', 'size' => 'M']

// 多次元配列の平坦化
$nested = [[1, 2], [3, 4], [5, 6]];
$flat = array_merge(...$nested);  // [1, 2, 3, 4, 5, 6]
```

#### `implode(string $separator, array $array): string`

配列を文字列に結合（計算量: O(n)）

```php
// 配列を文字列に変換
$words = ['Hello', 'World'];
$sentence = implode(' ', $words);  // "Hello World"

// カンマ区切り
$nums = [1, 2, 3, 4, 5];
$csv = implode(',', $nums);  // "1,2,3,4,5"

// デバッグ出力
echo "配列: [" . implode(", ", $nums) . "]\n";
```

#### `explode(string $separator, string $string, int $limit = PHP_INT_MAX): array`

文字列を配列に分割（計算量: O(n)）

```php
// 文字列を分割
$csv = "apple,banana,cherry";
$fruits = explode(',', $csv);  // ['apple', 'banana', 'cherry']

// スペース区切りのパース
$input = "1 2 3 4 5";
$nums = array_map('intval', explode(' ', $input));

// 制限付き分割
$str = "a:b:c:d:e";
$parts = explode(':', $str, 3);  // ['a', 'b', 'c:d:e']
```

#### `array_combine(array $keys, array $values): array`

2 つの配列からキーと値のペアを作成（計算量: O(n)）

```php
// キーと値の配列から連想配列を作成
$keys = ['name', 'age', 'city'];
$values = ['Alice', 25, 'Tokyo'];
$person = array_combine($keys, $values);
// ['name' => 'Alice', 'age' => 25, 'city' => 'Tokyo']

// インデックスと値のマッピング
$nums = [10, 20, 30];
$indices = [0, 1, 2];
$map = array_combine($nums, $indices);
// [10 => 0, 20 => 1, 30 => 2]
```

#### `str_split(string $string, int $length = 1): array`

文字列を配列に分割（計算量: O(n)）

```php
// 文字列を1文字ずつ分割
$s = "hello";
$chars = str_split($s);  // ['h', 'e', 'l', 'l', 'o']

// 指定サイズで分割
$s = "123456";
$chunks = str_split($s, 2);  // ['12', '34', '56']

// 文字列操作問題で頻出
function isPalindrome(string $s): bool {
    $chars = str_split(strtolower($s));
    $left = 0;
    $right = count($chars) - 1;

    while ($left < $right) {
        if ($chars[$left] !== $chars[$right]) {
            return false;
        }
        $left++;
        $right--;
    }
    return true;
}
```

---

### 8. 配列の操作・追加・削除

#### `array_push(array &$array, mixed ...$values): int`

配列の末尾に要素を追加（計算量: O(1)）

```php
// 末尾に追加
$stack = [];
array_push($stack, 1);
array_push($stack, 2);
// $stack = [1, 2]

// 複数要素を一度に追加
$arr = [1, 2];
array_push($arr, 3, 4, 5);  // [1, 2, 3, 4, 5]

// 短縮構文（推奨）
$arr[] = 6;  // [1, 2, 3, 4, 5, 6]
```

#### `array_pop(array &$array): mixed`

配列の末尾から要素を取り出す（計算量: O(1)）

```php
// スタック操作（LIFO）
$stack = [1, 2, 3];
$last = array_pop($stack);  // 3
// $stack = [1, 2]

// 空配列の場合
$empty = [];
$result = array_pop($empty);  // null
```

#### `array_shift(array &$array): mixed`

配列の先頭から要素を取り出す（計算量: O(n)）

```php
// キュー操作（FIFO）
$queue = [1, 2, 3];
$first = array_shift($queue);  // 1
// $queue = [2, 3]

// 注意: O(n)の操作なので、頻繁に使うと遅い
```

#### `array_unshift(array &$array, mixed ...$values): int`

配列の先頭に要素を追加（計算量: O(n)）

```php
// 先頭に追加
$arr = [2, 3];
array_unshift($arr, 1);  // [1, 2, 3]

// 複数要素を追加
array_unshift($arr, -1, 0);  // [-1, 0, 1, 2, 3]

// 注意: O(n)の操作なので、頻繁に使うと遅い
```

#### `unset(mixed $var): void`

配列要素を削除（計算量: O(1)）

```php
// 特定インデックスの削除
$nums = [1, 2, 3, 4, 5];
unset($nums[2]);  // [0 => 1, 1 => 2, 3 => 4, 4 => 5]

// 連想配列のキー削除
$map = ['a' => 1, 'b' => 2, 'c' => 3];
unset($map['b']);  // ['a' => 1, 'c' => 3]

// スライディングウィンドウで文字削除
$charCount = ['a' => 2, 'b' => 1];
$charCount['a']--;
if ($charCount['a'] === 0) {
    unset($charCount['a']);
}
```

#### `array_fill(int $start_index, int $count, mixed $value): array`

指定値で配列を初期化（計算量: O(n)）

```php
// 0で初期化
$zeros = array_fill(0, 5, 0);  // [0, 0, 0, 0, 0]

// 動的計画法のDP配列初期化
$n = 10;
$dp = array_fill(0, $n, -1);

// 二次元配列の初期化
$rows = 3;
$cols = 4;
$matrix = array_fill(0, $rows, array_fill(0, $cols, 0));
```

#### `array_pad(array $array, int $length, mixed $value): array`

配列を指定サイズまで埋める（計算量: O(n)）

```php
// 配列を右側に拡張
$arr = [1, 2, 3];
$padded = array_pad($arr, 5, 0);  // [1, 2, 3, 0, 0]

// 配列を左側に拡張（負の長さ）
$padded = array_pad($arr, -5, 0);  // [0, 0, 1, 2, 3]

// すでに指定サイズ以上の場合は変更なし
$padded = array_pad($arr, 2, 0);  // [1, 2, 3]
```

#### `array_reverse(array $array): array`

配列を反転（計算量: O(n)）

```php
// 配列の反転
$nums = [1, 2, 3, 4, 5];
$reversed = array_reverse($nums);  // [5, 4, 3, 2, 1]

// 文字列の反転
$s = "hello";
$reversed = implode('', array_reverse(str_split($s)));  // "olleh"
```

---

## アルゴリズムパターン別活用

### 9. Two Pointers（2 ポインタ法）

Two Pointers は、配列の両端や異なる位置から 2 つのポインタを動かして問題を解くテクニックです。

#### パターン 1: 両端からのアプローチ

```php
// Container With Most Water
function maxArea(array $height): int {
    $maxArea = 0;
    $left = 0;
    $right = count($height) - 1;

    while ($left < $right) {
        $h = min($height[$left], $height[$right]);
        $w = $right - $left;
        $maxArea = max($maxArea, $h * $w);

        if ($height[$left] < $height[$right]) {
            $left++;
        } else {
            $right--;
        }
    }
    return $maxArea;
}

// 使用する関数: count(), min(), max()
```

#### パターン 2: ソート済み配列での Two Sum

```php
// Two Sum II - Input Array Is Sorted
function twoSumSorted(array $numbers, int $target): array {
    $left = 0;
    $right = count($numbers) - 1;

    while ($left < $right) {
        $sum = $numbers[$left] + $numbers[$right];

        if ($sum === $target) {
            return [$left + 1, $right + 1];  // 1-indexed
        } elseif ($sum < $target) {
            $left++;
        } else {
            $right--;
        }
    }
    return [];
}

// 使用する関数: count()
```

#### パターン 3: 配列の再配置（Move Zeros）

```php
// Move Zeros - 0を末尾に移動
function moveZeroes(array &$nums): void {
    $left = 0;  // 非ゼロ要素の書き込み位置

    // 非ゼロ要素を前に詰める
    foreach ($nums as $num) {
        if ($num !== 0) {
            $nums[$left] = $num;
            $left++;
        }
    }

    // 残りを0で埋める
    for ($i = $left; $i < count($nums); $i++) {
        $nums[$i] = 0;
    }
}

// 使用する関数: count()
```

#### パターン 4: 3Sum 問題

```php
// 3つの数の合計が0になる組み合わせを全て見つける
function threeSum(array $nums): array {
    $result = [];
    $n = count($nums);
    sort($nums);  // まずソート

    for ($i = 0; $i < $n - 2; $i++) {
        // 重複をスキップ
        if ($i > 0 && $nums[$i] === $nums[$i - 1]) {
            continue;
        }

        $left = $i + 1;
        $right = $n - 1;

        while ($left < $right) {
            $sum = $nums[$i] + $nums[$left] + $nums[$right];

            if ($sum === 0) {
                $result[] = [$nums[$i], $nums[$left], $nums[$right]];
                $left++;
                $right--;

                // 重複をスキップ
                while ($left < $right && $nums[$left] === $nums[$left - 1]) {
                    $left++;
                }
                while ($left < $right && $nums[$right] === $nums[$right + 1]) {
                    $right--;
                }
            } elseif ($sum < 0) {
                $left++;
            } else {
                $right--;
            }
        }
    }

    return $result;
}

// 使用する関数: count(), sort()
```

---

### 10. Sliding Window（スライディングウィンドウ）

連続した部分配列を効率的に処理するテクニックです。

#### パターン 1: 固定サイズウィンドウ

```php
// サイズkの部分配列の最大合計
function maxSumSubarray(array $arr, int $k): int {
    $n = count($arr);
    if ($n < $k) return 0;

    // 最初のウィンドウの合計
    $windowSum = array_sum(array_slice($arr, 0, $k));
    $maxSum = $windowSum;

    // ウィンドウをスライド
    for ($i = $k; $i < $n; $i++) {
        $windowSum = $windowSum - $arr[$i - $k] + $arr[$i];
        $maxSum = max($maxSum, $windowSum);
    }

    return $maxSum;
}

// 使用する関数: count(), array_sum(), array_slice(), max()
```

#### パターン 2: 可変サイズウィンドウ（合計条件）

```php
// 合計がtarget以上となる最小の部分配列長
function minSubArrayLen(int $target, array $nums): int {
    $n = count($nums);
    $minLen = PHP_INT_MAX;
    $windowSum = 0;
    $left = 0;

    for ($right = 0; $right < $n; $right++) {
        $windowSum += $nums[$right];

        // 条件を満たしたらウィンドウを縮小
        while ($windowSum >= $target) {
            $minLen = min($minLen, $right - $left + 1);
            $windowSum -= $nums[$left];
            $left++;
        }
    }

    return $minLen === PHP_INT_MAX ? 0 : $minLen;
}

// 使用する関数: count(), min()
```

#### パターン 3: 文字列ウィンドウ（連想配列でカウント）

```php
// 重複なし最長部分文字列
function lengthOfLongestSubstring(string $s): int {
    $n = strlen($s);
    $charSet = [];
    $maxLen = 0;
    $left = 0;

    for ($right = 0; $right < $n; $right++) {
        $char = $s[$right];

        // 重複がある間は左を進める
        while (isset($charSet[$char])) {
            unset($charSet[$s[$left]]);
            $left++;
        }

        $charSet[$char] = true;
        $maxLen = max($maxLen, $right - $left + 1);
    }

    return $maxLen;
}

// 使用する関数: strlen(), isset(), unset(), max()
```

#### パターン 4: K 個の異なる要素を持つウィンドウ

```php
// 最大k個の異なる文字を含む最長部分文字列
function longestSubstringKDistinct(string $s, int $k): int {
    $n = strlen($s);
    if ($k === 0) return 0;

    $charCount = [];
    $maxLen = 0;
    $left = 0;

    for ($right = 0; $right < $n; $right++) {
        $char = $s[$right];
        $charCount[$char] = ($charCount[$char] ?? 0) + 1;

        // 異なる文字数がkを超えたら縮小
        while (count($charCount) > $k) {
            $leftChar = $s[$left];
            $charCount[$leftChar]--;
            if ($charCount[$leftChar] === 0) {
                unset($charCount[$leftChar]);
            }
            $left++;
        }

        $maxLen = max($maxLen, $right - $left + 1);
    }

    return $maxLen;
}

// 使用する関数: strlen(), count(), unset(), max()
```

---

### 11. ハッシュマップ/連想配列

O(1)の検索を活用した効率的な解法パターンです。

#### パターン 1: Two Sum（ハッシュマップ）

```php
// Two Sum - O(n)解法
function twoSum(array $nums, int $target): array {
    $map = [];  // 値 => インデックス

    foreach ($nums as $i => $num) {
        $need = $target - $num;

        if (isset($map[$need])) {
            return [$map[$need], $i];
        }

        $map[$num] = $i;
    }

    return [];
}

// 使用する関数: isset()
```

#### パターン 2: 頻度カウント

```php
// 最も頻繁に出現するK個の要素
function topKFrequent(array $nums, int $k): array {
    // 頻度をカウント
    $freq = array_count_values($nums);

    // 頻度で降順ソート
    arsort($freq);

    // 上位k個を取得
    return array_slice(array_keys($freq), 0, $k);
}

// 使用する関数: array_count_values(), arsort(), array_keys(), array_slice()
```

#### パターン 3: アナグラム判定

```php
// 2つの文字列がアナグラムか判定
function isAnagram(string $s, string $t): bool {
    if (strlen($s) !== strlen($t)) {
        return false;
    }

    $countS = count_chars($s, 1);
    $countT = count_chars($t, 1);

    return $countS === $countT;
}

// 別解: ソートを使う方法
function isAnagramSort(string $s, string $t): bool {
    $charsS = str_split($s);
    $charsT = str_split($t);
    sort($charsS);
    sort($charsT);
    return $charsS === $charsT;
}

// 使用する関数: strlen(), count_chars(), str_split(), sort()
```

#### パターン 4: アナグラムのグループ化

```php
// 文字列配列をアナグラムごとにグループ化
function groupAnagrams(array $strs): array {
    $groups = [];

    foreach ($strs as $str) {
        // 文字列をソートしてキーにする
        $chars = str_split($str);
        sort($chars);
        $key = implode('', $chars);

        if (!isset($groups[$key])) {
            $groups[$key] = [];
        }
        $groups[$key][] = $str;
    }

    return array_values($groups);
}

// 使用する関数: str_split(), sort(), implode(), isset(), array_values()
```

#### パターン 5: インデックスマッピング

```php
// 配列内の値を高速検索するためのマップ作成
function createValueToIndexMap(array $nums): array {
    $map = [];
    foreach ($nums as $i => $num) {
        // 重複がある場合は配列で保持
        if (!isset($map[$num])) {
            $map[$num] = [];
        }
        $map[$num][] = $i;
    }
    return $map;
}

// 別解: array_flip()で1対1マッピング
function createSimpleMap(array $nums): array {
    return array_flip($nums);  // 値 => 最後のインデックス
}

// 使用する関数: isset(), array_flip()
```

---

### 12. 配列の前処理

配列を事前に加工することで、クエリを高速化するテクニックです。

#### パターン 1: ソートの活用

```php
// ソート済み配列での二分探索
function binarySearch(array $nums, int $target): int {
    $left = 0;
    $right = count($nums) - 1;

    while ($left <= $right) {
        $mid = $left + (int)(($right - $left) / 2);

        if ($nums[$mid] === $target) {
            return $mid;
        } elseif ($nums[$mid] < $target) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }

    return -1;
}

// 使用する関数: count()
```

#### パターン 2: 累積和（Prefix Sum）

```php
// 累積和を使った範囲合計のO(1)クエリ
class RangeSumQuery {
    private array $prefixSum;

    public function __construct(array $nums) {
        $n = count($nums);
        $this->prefixSum = array_fill(0, $n + 1, 0);

        for ($i = 0; $i < $n; $i++) {
            $this->prefixSum[$i + 1] = $this->prefixSum[$i] + $nums[$i];
        }
    }

    // O(1)で範囲[left, right]の合計を取得
    public function sumRange(int $left, int $right): int {
        return $this->prefixSum[$right + 1] - $this->prefixSum[$left];
    }
}

// 使用する関数: count(), array_fill()
```

#### パターン 3: インデックスソート

```php
// 値はそのままでインデックスをソート順に取得
function getIndicesSortedByValues(array $nums): array {
    $indices = array_keys($nums);
    usort($indices, fn($a, $b) => $nums[$a] <=> $nums[$b]);
    return $indices;
}

// 例: [30, 10, 20] -> [1, 2, 0] (値の昇順のインデックス)
$nums = [30, 10, 20];
$sortedIndices = getIndicesSortedByValues($nums);
// [1, 2, 0] (nums[1]=10, nums[2]=20, nums[0]=30)

// 使用する関数: array_keys(), usort()
```

#### パターン 4: 範囲マッピング

```php
// 座標圧縮（値を順位に変換）
function coordinateCompression(array $nums): array {
    $sorted = array_unique($nums);
    sort($sorted);
    $rank = array_flip(array_values($sorted));

    $result = [];
    foreach ($nums as $num) {
        $result[] = $rank[$num];
    }

    return $result;
}

// 例: [100, 5, 100, 50] -> [2, 0, 2, 1]
// 使用する関数: array_unique(), sort(), array_flip(), array_values()
```

---

### 13. スタック/キュー操作

LIFO（後入れ先出し）/FIFO（先入れ先出し）のデータ構造を配列で実装します。

#### パターン 1: スタック（LIFO）

```php
// スタックの基本操作
$stack = [];

// Push: 末尾に追加 O(1)
$stack[] = 1;
array_push($stack, 2, 3);

// Pop: 末尾から取り出し O(1)
$top = array_pop($stack);

// Peek: 末尾を確認（取り出さない）
$top = end($stack);

// 空チェック
$isEmpty = empty($stack);

// サイズ
$size = count($stack);

// 使用する関数: array_push(), array_pop(), end(), empty(), count()
```

#### パターン 2: 有効な括弧の判定

```php
// Valid Parentheses
function isValid(string $s): bool {
    $stack = [];
    $pairs = [')' => '(', '}' => '{', ']' => '['];

    for ($i = 0; $i < strlen($s); $i++) {
        $char = $s[$i];

        if (in_array($char, ['(', '{', '['])) {
            $stack[] = $char;
        } else {
            if (empty($stack) || end($stack) !== $pairs[$char]) {
                return false;
            }
            array_pop($stack);
        }
    }

    return empty($stack);
}

// 使用する関数: strlen(), in_array(), empty(), end(), array_pop()
```

#### パターン 3: キュー（FIFO）

```php
// キューの基本操作
$queue = [];

// Enqueue: 末尾に追加 O(1)
$queue[] = 1;
array_push($queue, 2, 3);

// Dequeue: 先頭から取り出し O(n) ※注意: 遅い
$first = array_shift($queue);

// Peek: 先頭を確認
$first = $queue[0] ?? null;

// 空チェック
$isEmpty = empty($queue);

// より効率的なキュー実装（SplQueue使用）
$queue = new SplQueue();
$queue->enqueue(1);
$queue->enqueue(2);
$first = $queue->dequeue();  // O(1)

// 使用する関数: array_push(), array_shift(), empty()
```

#### パターン 4: モノトニックスタック

```php
// Next Greater Element - 各要素の右側で最初に大きい要素を見つける
function nextGreaterElement(array $nums): array {
    $n = count($nums);
    $result = array_fill(0, $n, -1);
    $stack = [];  // インデックスを保存

    for ($i = 0; $i < $n; $i++) {
        // スタックのトップより大きい要素が見つかったら
        while (!empty($stack) && $nums[$i] > $nums[end($stack)]) {
            $idx = array_pop($stack);
            $result[$idx] = $nums[$i];
        }
        $stack[] = $i;
    }

    return $result;
}

// 例: [2, 1, 2, 4, 3] -> [4, 2, 4, -1, -1]
// 使用する関数: count(), array_fill(), empty(), end(), array_pop()
```

#### パターン 5: スライディングウィンドウ最大値（Deque）

```php
// 各ウィンドウの最大値を取得（モノトニックデック）
function maxSlidingWindow(array $nums, int $k): array {
    $result = [];
    $deque = [];  // インデックスを保存（降順を維持）

    for ($i = 0; $i < count($nums); $i++) {
        // 範囲外のインデックスを削除
        if (!empty($deque) && $deque[0] <= $i - $k) {
            array_shift($deque);
        }

        // 現在の値より小さい要素を削除
        while (!empty($deque) && $nums[end($deque)] < $nums[$i]) {
            array_pop($deque);
        }

        $deque[] = $i;

        // ウィンドウが完成したら最大値を記録
        if ($i >= $k - 1) {
            $result[] = $nums[$deque[0]];
        }
    }

    return $result;
}

// 使用する関数: count(), empty(), array_shift(), end(), array_pop()
```

---

## クイックリファレンス

### 計算量別関数一覧

#### O(1) - 定数時間

- `count()` - 配列サイズ取得
- `empty()` - 空チェック
- `isset()` - 要素存在チェック
- `array_push()` / `$arr[]` - 末尾追加
- `array_pop()` - 末尾削除
- `unset()` - 要素削除
- `end()` - 末尾要素取得

#### O(n) - 線形時間

- `array_sum()` - 合計
- `max()`, `min()` - 最大/最小
- `array_map()` - 要素変換
- `array_filter()` - フィルタリング
- `array_unique()` - 重複削除
- `array_count_values()` - 頻度カウント
- `array_flip()` - キー・値の反転
- `array_reverse()` - 反転
- `array_fill()` - 初期化
- `implode()`, `explode()` - 結合/分割

#### O(n log n) - ソート

- `sort()`, `rsort()` - 基本ソート
- `asort()`, `arsort()` - 連想配列を値でソート
- `ksort()`, `krsort()` - 連想配列をキーでソート
- `usort()` - カスタムソート

#### O(n\*m) - 複数配列操作

- `array_diff()` - 差集合
- `array_intersect()` - 積集合

### パターン別推奨関数

#### Two Pointers

- `count()`, `min()`, `max()`, `sort()`

#### Sliding Window

- `array_sum()`, `array_slice()`, `strlen()`, `isset()`, `unset()`

#### ハッシュマップ

- `isset()`, `array_count_values()`, `array_flip()`, `array_keys()`

#### スタック/キュー

- `array_push()`, `array_pop()`, `array_shift()`, `end()`, `empty()`

---

## 参考リンク

### プロジェクト内の関連ファイル

- `sliding_window/fixed_window.php` - 固定ウィンドウの実装例
- `sliding_window/variable_window.php` - 可変ウィンドウの実装例
- `two-sum/two-sum.php` - Two Sum 問題
- `move_zeros/move_zeros.php` - Two Pointers の例
- `container_with_most_water/container_with_most_water.php` - Two Pointers の応用

### PHP 公式ドキュメント

- [配列関数](https://www.php.net/manual/ja/ref.array.php)
- [文字列関数](https://www.php.net/manual/ja/ref.strings.php)

---

**最終更新:** 2025 年 11 月 8 日
