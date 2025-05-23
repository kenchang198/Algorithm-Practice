<?php

class ListNode 
{
    public function __construct(public $val = 0, public $next = null){}
}

function hasCycle(ListNode $head)
{
    // 空リストまたは1つのノードしかない場合はサイクルなし
    if ($head == null || $head->next === null) {
        return false;
    }

    // 遅いポインタと早いポインタを初期化
    $slow = $head;
    $fast = $head;

    while ($fast !== null && $fast->next !== null) {
        // 遅いポインタは1ステップ進む
        $slow = $slow->next;
        // 速いポインタは2ステップ進む
        $fast = $fast->next->next;
        
        // 両ポインタが同じノードを指していればサイクルが存在する
        if ($slow === $fast) {
            return true;
        }
    }

    // リストの終端に達したのでサイクルはない
    return false;
}

// サイクルを作成する(true) or 作成しない(false)
$createLink = true;

$node1 = new ListNode(1);
$node2 = new ListNode(2);
$node3 = new ListNode(3);
$node4 = new ListNode(4);

$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;

// 作成しない場合: サイクルのないリンクドリスト: 1->2->3->4->NULL
if ($createLink) {
    // 1->2->3->4->1
    $node4->next = $node1;
}

$hasCycle = hasCycle($node1);
if ($hasCycle) {
    echo "cycle exists";
} else {
    echo "cycle not exists";
}