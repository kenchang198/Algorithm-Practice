from typing import Optional


class ListNode:
    def __init__(self, val=0, next=None):
        self.val = val
        self.next = next


def hasCycle(head: Optional[ListNode]) -> bool:
    slow = head
    fast = head

    while fast and fast.next:
        slow = slow.next
        fast = fast.next.next
        if slow == fast:
            return True
    return False


def create_test_list(has_cycle=False):
    # 1->2->3->4のLinked List作成
    node1 = ListNode(1)
    node2 = ListNode(2)
    node3 = ListNode(3)
    node4 = ListNode(4)

    node1.next = node2
    node2.next = node3
    node3.next = node4

    if has_cycle:
        # 4->2 のリンクを作成して、サイクルを作る
        node4.next = node2

    return node1


# テスト実行
test1 = create_test_list(has_cycle=False)
test2 = create_test_list(has_cycle=True)
print("Test 1 (no cycle):", hasCycle(test1))  # False
print("Test 2 (has cycle):", hasCycle(test2))  # True
