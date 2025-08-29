<?php

namespace App\Notifications;

use App\Http\Resources\DepartureResource;
use App\Http\Resources\IntraClaimResource;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IntraClaimNotification extends Notification
{
    use Queueable;

    protected $intraClaim;
    protected $comment;
    protected $departure;
    protected $type;

    public function __construct($intraClaim, $comment, $departure, $type = null)
    {
        $this->intraClaim = $intraClaim;
        $this->comment = $comment;
        $this->departure = $departure;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        $this->departure->load('user.userProfile', 'intraUser.userProfile');
        return [
            'intraClaim' => new IntraClaimResource($this->intraClaim),
            'comment' => $this->comment,
            'departure' => new DepartureResource($this->departure),
            'type' => $this->type
        ];
    }

    public function toMail($notifiable)
    {
        $this->departure->load('user.userProfile', 'intraUser.userProfile');
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
                'userName' => $this->departure->user->userProfile->name,
                'startTime' => $this->departure->start->format('m月d日 H:i'),
                'endTime' => $this->departure->end->format('H:i'),
                'url' => '' // 必要に応じて追加
            ]);
        }
}
