<?php

namespace App\Notifications;

use App\Facades\MessagesManager;
use App\Site;
use App\Types\MessageType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class VirusFound
 * @package App\Notifications
 */
class VirusFound extends Notification implements ShouldQueue
{
    use Queueable;


    private $site;
    private $emailType;
    private $type;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Site $site, $type = 'problem')
    {
        $this->type = $type;
        $this->site = $site;
        $this->emailType = EmailType::where('name', MessageType::virus_found)->first();

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        Log::debug('VirusFound');

        $mm = new MailMessage();
        $from_adress = env('MAIL_EMAIL');
//
//        $template = EmailTemplate::where('type_id', $this->emailType->id)
//            ->whereNull('user_id')
//            ->first();
//        $subject = $template->subject;
//
//        if (isset($notifiable->parent_id)) {
//            $parent_user = User::find($notifiable->parent_id);
//
//            $from_adress = $parent_user->email;
//            $template_tmp = EmailTemplate::where('type_id', $this->emailType->id)->where('user_id', $parent_user->user_id)->first();
//            if (isset($template_tmp)) {
//                $template = $template_tmp;
//                $subject = $template->subject;
//            }
//        }
        $template = MessagesManager::getTemplate($this->emailType, $notifiable, $this->type);
        $data['domain'] = $this->site->domain;
        $mm->from($from_adress);
        $mm->subject($template->subject);
        $mm->view('mail.blank', ['content' => $template->parseHtml($data)]);
        return $mm;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
