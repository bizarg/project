<?php
namespace App\Verifications;


use App\Facades\MessagesManager;
use App\Types\MessageType;
use App\User;

abstract class Verification

{

    protected $site;
    protected $verifiable;
    protected $user;

    /**
     * Verification constructor.
     */
    public function __construct(Verifiable $v)
    {
        $this->verifiable = $v;
        $this->site = $v->site;
        $this->user = $this->getUser();

    }

    protected function getUser()
    {
        $user = User::select('users.*', 'user_sites.notify_level')
            ->join('user_sites', 'users.id', '=', 'user_sites.user_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where('user_sites.site_id', $this->site->id)
            ->first();
        return $user;
    }

    public function check()
    {

        if ($this->checkParams()) {
            $send = MessagesManager::addMessage($this->site, $this->verifiable->getType());
            if (isset($this->user) && $send && $this->user->notify_level <= MessageType::getLevel($this->verifiable->getType())) {
                $this->user->notify($this->getProblemNotify()->onQueue($this->getQueue()));
                //$user->notify((new SSLExpire($site, $params))->onQueue('emails'));
            }
        } else {
            $send = MessagesManager::closeMessage($this->site, $this->verifiable->getType());
            if (isset($this->user) && $send && $this->user->notify_level <= MessageType::getLevel($this->verifiable->getType())) {
                $this->user->notify($this->getOkNotify()->onQueue($this->getQueue()));
            }
        }

    }

    public abstract function checkParams();

    public abstract function getQueue();

    public abstract function getProblemNotify();

    public abstract function getOkNotify();

}