
nums = [0, 1, 0, 3, 12]
print(nums)

left = 0

for num in nums:
    if num != 0:
        nums[left] = num
        left += 1

print(nums)

for l in range(left, len(nums)):
    nums[l] = 0

print(nums)
