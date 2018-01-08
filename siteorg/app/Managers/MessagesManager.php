<?php


namespace App\Managers;


use App\EmailTemplate;
use App\EmailType;
use App\Message;
use App\Site;
use App\Types\MessageType;
use App\User;
use Illuminate\Support\Facades\Mail;

class MessagesManager
{
    public function addMessage(Site $site, $type)
    {
        $notification = Message::where('site_id', $site->id)->where('status', 'show')->where('type', $type)->first();
        if (!isset($notification)) {
            $notification = new Message();
            $notification->site_id = $site->id;
            $notification->status = 'show';
            $notification->level = MessageType::getLevel($type);
            $notification->type = $type;
            $notification->save();
            return true;
        }
        return false;
    }

    public function closeMessage(Site $site, $type)
    {
        $notification = Message::where('site_id', $site->id)->where('status', 'show')->where('type', $type)->first();
        if (isset($notification)) {
            $notification->status = 'hide';
            $notification->sended = 0;
            $notification->save();
            return true;
        }
        return false;
    }

    /**
     * @param EmailType $emailType
     * @param User $user
     * @param string $type
     * @return null
     */
    public function getTemplate(EmailType $emailType, User $user, $type = 'problem')
    {
        $template = null;
        if (isset($user->parent_id)) {
            $template_tmp = EmailTemplate::where('type_id', $emailType->id)
                ->where('user_id', $user->parent_id)
                ->where('type', $type)
                ->first();
            if (isset($template_tmp)) {
                $template = $template_tmp;
            }
        } else {
            $template = EmailTemplate::where('type_id', $emailType->id)
                ->whereNull('user_id')
                ->where('type', $type)
                ->first();
        }
        return $template;
    }
    
    public function adminEmail($subject, $text){
        Mail::raw($text, function ($message) use ($subject) {
            $emails = explode(',', env('NOTIFI_EMAILS'));
            $message->to($emails);
            $message->subject($subject);
            $message->from(env('MAIL_EMAIL'));

        });
    }
}