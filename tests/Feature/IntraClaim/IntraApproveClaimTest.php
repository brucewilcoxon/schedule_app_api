<?php

namespace Tests\Feature\IntraClaim;

use App\Models\IntraClaim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntraApproveClaimTest extends TestCase
{
    use RefreshDatabase;

    public function test_200(): void
    {
        // テスト用のユーザーを作成
        $intraUser = User::factory()->create();

        $otherUser = User::factory()->create();

        // テスト用の IntraClaim を作成
        $intraClaim = IntraClaim::factory()->create([
            'user_id' => $intraUser->id,
            'intra_user_id' => $otherUser->id,
        ]);

        // 作成した IntraClaim の ID を使用してリクエストを実行
        $response = $this->actingAs($intraUser)->postJson("/api/approveClaim/{$intraClaim->id}");

        // レスポンスをダンプ
        $response->dump();

        // ステータスコード200を確認
        $response->assertStatus(200);
    }
}
