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

// デバッグ出力付きのサイクル検出関数
function hasCycleWithDebug(ListNode $head)
{
    echo "=== サイクル検出アルゴリズムの実行開始 ===\n";
    
    // 空リストまたは1つのノードしかない場合はサイクルなし
    if ($head == null || $head->next === null) {
        echo "リストが空または1つのノードのみ: サイクルなし\n";
        return false;
    }

    // 遅いポインタと早いポインタを初期化
    $slow = $head;
    $fast = $head;
    $loopCount = 0;

    echo "初期状態: slow={$slow->val}, fast={$fast->val}\n";
    echo "----------------------------------------\n";

    while ($fast !== null && $fast->next !== null) {
        $loopCount++;
        
        // 現在の位置を記録（移動前）
        $slowBefore = $slow->val;
        $fastBefore = $fast->val;
        
        // 遅いポインタは1ステップ進む
        $slow = $slow->next;
        // 速いポインタは2ステップ進む
        $fast = $fast->next->next;
        
        echo "ループ {$loopCount}回目:\n";
        echo "  slow: {$slowBefore} → {$slow->val} (1ステップ進んだ)\n";
        $fastVal = ($fast !== null) ? $fast->val : "NULL";
        echo "  fast: {$fastBefore} → {$fastVal} (2ステップ進んだ)\n";
        
        // 両ポインタが同じノードを指していればサイクルが存在する
        if ($slow === $fast) {
            echo "  ★ slowとfastが同じノードを指しました！\n";
            echo "  → サイクルが検出されました\n";
            echo "========================================\n";
            return true;
        }
        
        echo "  slowとfastは異なるノードを指しています\n";
        echo "----------------------------------------\n";
    }

    // リストの終端に達したのでサイクルはない
    echo "fastがNULLに到達: サイクルなし\n";
    echo "========================================\n";
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

echo "テストケース1: サイクルなしのリンクリスト (1->2->3->4->NULL)\n";
echo "================================================================\n";
$hasCycleNoLoop = hasCycleWithDebug($node1);
echo "結果: " . ($hasCycleNoLoop ? "サイクルあり" : "サイクルなし") . "\n\n";

// サイクルを作成
$node4->next = $node2; // 4->2 のリンクを作成

echo "テストケース2: サイクルありのリンクリスト (1->2->3->4->2)\n";
echo "================================================================\n";
$hasCycleWithLoop = hasCycleWithDebug($node1);
echo "結果: " . ($hasCycleWithLoop ? "サイクルあり" : "サイクルなし") . "\n";