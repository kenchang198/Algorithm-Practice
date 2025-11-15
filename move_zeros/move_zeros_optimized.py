"""
Move Zeros - 最適化版実装

配列内のすべての0を末尾に移動する（1パスアプローチ + 最適化）
時間計算量: O(n)
空間計算量: O(1)
"""


def move_zeros(nums):
    """
    配列内のすべての0を末尾に移動する
    
    Args:
        nums: 整数のリスト（in-placeで変更される）
    
    Returns:
        None（配列はin-placeで変更される）
    """
    left = 0
    
    for right in range(len(nums)):
        if nums[right] != 0:
            # 最適化: 同じ位置の場合はスワップ不要
            if left != right:
                nums[left], nums[right] = nums[right], nums[left]
            left += 1


def move_zeros_with_trace(nums):
    """
    デバッグ用: 実行過程を表示するバージョン
    """
    print(f"初期配列: {nums}")
    left = 0
    
    for right in range(len(nums)):
        print(f"right={right}, nums[{right}]={nums[right]}, left={left}")
        if nums[right] != 0:
            if left != right:
                print(f"  スワップ: nums[{left}]={nums[left]} ↔ nums[{right}]={nums[right]}")
                nums[left], nums[right] = nums[right], nums[left]
            else:
                print(f"  スキップ（同じ位置）")
            left += 1
            print(f"  結果: {nums}, left={left}")
        else:
            print(f"  ゼロをスキップ")
    
    print(f"最終結果: {nums}\n")


# テスト実行
if __name__ == "__main__":
    # テストケース1: 基本的なケース
    test1 = [0, 1, 0, 3, 12]
    print("=== テストケース1 ===")
    move_zeros_with_trace(test1.copy())
    
    # テストケース2: すべてゼロ
    test2 = [0, 0, 0]
    print("=== テストケース2 ===")
    move_zeros_with_trace(test2.copy())
    
    # テストケース3: ゼロなし
    test3 = [1, 2, 3]
    print("=== テストケース3 ===")
    move_zeros_with_trace(test3.copy())
    
    # テストケース4: 先頭がゼロ
    test4 = [0, 0, 1]
    print("=== テストケース4 ===")
    move_zeros_with_trace(test4.copy())
    
    # テストケース5: 単一要素
    test5 = [0]
    print("=== テストケース5 ===")
    move_zeros_with_trace(test5.copy())

