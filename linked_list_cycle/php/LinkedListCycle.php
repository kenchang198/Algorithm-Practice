<?php

class ListNode 
{
    public function __construct(public $val = 0, public $next = null){}
}

function hasCycle($head)
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

// サイクルのないリンクドリスト: 1->2->3->NULL
$node1 = new ListNode(1);
$node2 = new ListNode(2);
$node3 = new ListNode(3);
$node1->next = $node2;
$node2->next = $node3;

echo "サイクルなし: " . (hasCycle($node1) ? "true" : "false") . "\n";

// サイクルのあるリンクドリスト: 1->2->3->1
$node3->next = $node1; // 3が1を指すようにしてサイクルを作る

echo "サイクルあり: " . (hasCycle($node1) ? "true" : "false") . "\n";