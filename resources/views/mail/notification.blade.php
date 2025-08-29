<x-mail::message>
# イントラ申請通知

申請について以下の通り通知いたします。

@if($comment)
**コメント**:  
{{ $comment }}
@endif

**申請者**: {{ $userName }}  
**出艇時間**: {{ $startTime }}～{{ $endTime }}

@if($url)
<x-mail::button :url="$url">
詳細を確認
</x-mail::button>
@endif

このメールはシステムより自動送信されています。

{{ config('app.name') }}
</x-mail::message>