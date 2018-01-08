<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\EmailType;
use App\Facades\MessagesManager;
use App\Site;
use App\Types\MessageType;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

/**
 * Class GoogleIndexNotFound
 * @package App\Notifications
 */
class GoogleIndexNotFound extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Site
     */
    private $site;
    /**
     * @var
     */
    private $emailType;
    /**
     * @var string
     */
    private  $type;


    /**
     * GoogleIndexNotFound constructor.
     * @param Site $site
     * @param string $type
     */
    public function __construct(Site $site, $type = 'problem')
    {
        $this->type = $type;
        $this->site = $site;
        $this->emailType = EmailType::where('name', MessageType::google_index)->first();
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
        Log::debug('GoogleIndexNotFound');

        $mm = new MailMessage();
        $from_adress = env('MAIL_EMAIL');

        $template = MessagesManager::getTemplate($this->emailType, $notifiable, $this->type);
//        $template = EmailTemplate::where('type_id', $this->emailType->id)->whereNull('user_id')->first();
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
        $data['domain'] = $this->site->domain;
        $mm->from($from_adress);
        $mm->subject($template->subject);
        $mm->view('mail.blank', ['content' => $template->parseHtml($data)]);
        //  Log::info($mm);
        return $mm;
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'domain' => $this->site->domain
        ];
    }

}
