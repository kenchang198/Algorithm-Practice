<?php

class ListNode 
{
    public function __construct(public $val = 0, public $next = null){}
}

$obj = new ListNode();

function hasCycle($head)
{
    // 空リストまたは1つのノードしかない場合はサイクルなし
    if ($head == null || $head->next === null) {
        return false;
    }

    // 遅いポインタと早いポインタを初期化
    $slow = $head;
    $fast = $head;

    // while
}