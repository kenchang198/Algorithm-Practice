target = 3
nums = [2, 1, 5, 8]
pair = {}

# WIP


def two_sum():
    for i, num in enumerate(nums):
        vv = target - num
        if vv in pair:
            return [pair[vv], i]

        pair[i] = num
