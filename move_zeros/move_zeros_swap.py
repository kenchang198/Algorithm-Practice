"""
Move Zeros - 1パスアプローチ（Two Pointers）

配列内のすべての0を末尾に移動する
時間計算量: O(n) - 1回の走査
空間計算量: O(1)
"""


def move_zeros(nums):
    """
    配列内のすべての0を末尾に移動する（1パスアプローチ）
    
    Args:
        nums: 整数のリスト（in-placeで変更される）
    """
    left = 0
    
    for right in range(len(nums)):
        if nums[right] != 0:
            nums[left], nums[right] = nums[right], nums[left]
            left += 1


# テスト実行
if __name__ == "__main__":
    nums = [0, 1, 0, 3, 12]
    print(f"初期配列: {nums}")
    move_zeros(nums)
    print(f"結果: {nums}")
