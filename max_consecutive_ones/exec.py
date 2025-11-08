def findMaxConsecutiveOnes(nums) -> int:
    res = 0
    left = 0
    for right in range(len(nums)):
        if nums[right] == 0:
            left = right + 1
        else:
            res = max(res, right - left + 1)
    return res

nums = [1,1,0,1,1,1]
print(findMaxConsecutiveOnes(nums))