"""
Move Zeros - 2パスアプローチ

配列内のすべての0を末尾に移動する
時間計算量: O(n) - 2回の走査
空間計算量: O(1)
"""


def move_zeros(nums):
    """
    配列内のすべての0を末尾に移動する（2パスアプローチ）
    
    Args:
        nums: 整数のリスト（in-placeで変更される）
    """
    left = 0
    
    # 第1パス: 非ゼロ要素を左に詰める
    for num in nums:
        if num != 0:
            nums[left] = num
            left += 1
    
    # 第2パス: 残りを0で埋める
    for i in range(left, len(nums)):
        nums[i] = 0


# テスト実行
if __name__ == "__main__":
    nums = [0, 1, 0, 3, 12]
    print(f"初期配列: {nums}")
    move_zeros(nums)
    print(f"結果: {nums}")
