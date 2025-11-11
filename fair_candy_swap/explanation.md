# Fair Candy Swap（公平なキャンディー交換）解説

## 問題概要

LeetCode 888: Fair Candy Swap

2 人の友人が 1 つずつキャンディーボックスを交換して、交換後に両者が同じ総量のキャンディーを持つようにする問題です。

## 問題例

**入力:**

- Alice: [1, 2, 5]（合計 8）
- Bob: [2, 4]（合計 6）

**解答:**

- Alice のキャンディーボックスのうち 5 を、Bob のキャンディーボックスのうち 4 を交換
- 交換後: Alice = 8 - 5 + 4 = 7, Bob = 6 - 4 + 5 = 7
- 両者とも合計 7 になり、公平になる

## 解法のポイント

### 1. 数学的なアプローチ

交換前の状態:

- Alice の合計: `aliceSum`
- Bob の合計: `bobSum`
- 差分: `diff = aliceSum - bobSum`

Alice が`x`を Bob に渡し、Bob が`y`を Alice に渡すとすると:

```
aliceSum - x + y = bobSum - y + x
aliceSum - bobSum = 2x - 2y
diff = 2(x - y)
x - y = diff / 2
```

つまり、`x - y = diff / 2` となるような`x`と`y`のペアを見つければよい。

**重要: `halfDiff`の符号と合計の大小について**

- `diff = aliceSum - bobSum` なので:
  - **Alice の合計 > Bob の合計の場合**: `diff > 0`, `halfDiff > 0`
    - `y = x - halfDiff` → `y < x`（Alice が大きい値を渡し、Bob が小さい値を渡す）
  - **Alice の合計 < Bob の合計の場合**: `diff < 0`, `halfDiff < 0`
    - `y = x - halfDiff` → `y = x - (負の値) = x + 正の値` → `y > x`（Bob が大きい値を渡す）
    - 数学的には: `- (負の値) = + 正の値` なので、引き算が実質的に足し算になる
  - **Alice の合計 = Bob の合計の場合**: `diff = 0`, `halfDiff = 0`（既に公平）

**合計の大小を事前に知る必要はありません。** `diff`を計算すれば自動的に正負が決まり、正しく動作します。

### 2. アルゴリズムの実装

1. **合計の計算**: 両方の配列の合計を計算（O(N + M)）
2. **差分の計算**: `diff = aliceSum - bobSum`
3. **調整値の計算**: `halfDiff = diff / 2`
4. **HashSet の作成**: Bob のキャンディーボックスを連想配列に格納（O(M)）
5. **検索**: Alice の各キャンディーボックスについて、交換可能な値を探す（O(N)）

**アルゴリズムの実装方法**

- Alice の各要素`x`について、`y = x - halfDiff`が Bob のセットに存在するか確認
- 式: `x - y = halfDiff` より `y = x - halfDiff`

### 3. 時間計算量と空間計算量

- **時間計算量**: O(N + M)
  - 合計の計算: O(N + M)
  - HashSet の作成: O(M)
  - 検索: O(N)
- **空間計算量**: O(M)
  - Bob のキャンディーボックスを格納する HashSet
  - **補足**: HashSet の値は何でも良い（`true`, `1`, `null`など）。`isset()`で存在チェックするため、値の内容は使用しない

### 4. コードの流れ

```php
function fairCandySwap($aliceSizes, $bobSizes) {
    // 1. 合計を計算
    $aliceSum = array_sum($aliceSizes);
    $bobSum = array_sum($bobSizes);

    // 2. 差分と調整値を計算
    $diff = $aliceSum - $bobSum;
    $halfDiff = $diff / 2;

    // 3. BobのボックスをHashSetに格納
    $bobSet = [];
    foreach ($bobSizes as $size) {
        $bobSet[$size] = true;
    }

    // 4. Aliceの各ボックスについて、交換可能なBobのボックスを探す
    foreach ($aliceSizes as $aliceSize) {
        $bobSize = $aliceSize - $halfDiff;  // y = x - halfDiff
        if (isset($bobSet[$bobSize])) {
            return [$aliceSize, $bobSize];
        }
    }

    return [];
}
```

## なぜこの解法が効率的か

1. **HashSet の使用**: Bob のボックスを連想配列に格納することで、検索が O(1)で可能になる
2. **一度の走査**: Alice の配列を一度だけ走査すれば解を見つけられる
3. **数学的性質の活用**: `x - y = diff / 2`という関係式を使うことで、全探索ではなく効率的な検索が可能

## 実行例

```bash
php fair_candy_swap.php
```

出力:

```
=== Fair Candy Swap テスト ===

テストケース1:
Alice: [1, 2, 5] (合計: 8)
Bob: [2, 4] (合計: 6)
解答: Aliceの5とBobの4を交換
交換後 - Alice: 7, Bob: 7
```

## 参考リンク

- [LeetCode 888: Fair Candy Swap](https://leetcode.com/problems/fair-candy-swap/description/)
