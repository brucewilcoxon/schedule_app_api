<?php

namespace App\Notifications;

use App\Http\Resources\IntraClaimResource;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IntraClaimNotification extends Notification
{
    use Queueable;

    protected $intraClaim;

    protected $comment;

    protected $type;

    public function __construct($intraClaim, $comment, $type = null)
    {
        $this->intraClaim = $intraClaim;
        $this->comment = $comment;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'intraClaim' => new IntraClaimResource($this->intraClaim),
            'comment' => $this->comment,
            'type' => $this->type,
        ];
    }

    public function toMail($notifiable)
    {
        $subject = match ($this->type) {
            'approved' => '申請が承認されました',
            'rejected' => '申請が却下されました',
            'commented' => '新しいコメントがあります',
            default => 'イントラ申請通知'
        };

        return (new MailMessage)
            ->subject($subject)
            ->markdown('mail.notification', [
                'comment' => $this->comment,
                'url' => '', // 必要に応じて追加
            ]);
    }
}
