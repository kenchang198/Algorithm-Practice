nums = [0, 1, 0, 3, 12]
# nums = [0, 0, 0, 3, 9]
print(nums)

left = 0

for right in (range(len(nums))):
    if nums[right] != 0:
        # nums[right], nums[left] = nums[left], nums[right]
        nums[left], nums[right] = nums[right], nums[left]
        left += 1

print(nums)
