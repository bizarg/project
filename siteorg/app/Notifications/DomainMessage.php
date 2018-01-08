<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\EmailType;
use App\Types\Error;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DomainMessage extends Notification
{
    use Queueable;

    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //TODO как будет рассылка другими методами дописать

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
        $mm = new MailMessage();
        $from_adress = env('MAIL_EMAIL');
        $site = $this->message->site()->first();
        $template_type = EmailType::where('name', constant('App\Types\Error::' . $this->message->type))->first();
        //dd(constant('App\Types\Error::' . $this->message->type));
      //  dd($template_type );
        $template = EmailTemplate::where('type_id', $template_type->id)->whereNull('user_id')->first();
        $subject = $template->subject;

        if (isset($notifiable->parent_id)) {
            $parent_user = User::find($notifiable->parent_id);

            $from_adress = $parent_user->email;
            $template_tmp = EmailTemplate::where('type_id', $template_type->id)->where('user_id', $parent_user->user_id)->first();
            if (isset($template_tmp)) {
                $template = $template_tmp;
                $subject = $template->subject;
            }
        }
        $data['domain'] = $site->domain;
        $data['message'] = $this->message->type;


        $mm->from($from_adress);
        $mm->subject($subject);
        $mm->view('mail.blank', ['content' => $template->parseHtml($data)]);
        return $mm;
    }
}
