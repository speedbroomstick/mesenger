<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Factory;

class Registr
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $email;
    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username,$email,$password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
    public function RegistrationNewUser(){
        $firebase = (new Factory)
            ->withServiceAccount('file.json')
            ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');

        $database = $firebase->createDatabase();
        $postData = [
            'username' => $this->username,
            'email' => $this->email,
            'password'=> $this->password
        ];
        $postRef = $database->getReference('Users')->set($postData);
        $postKey = $postRef->getKey();

        /*  echo '<pre>';

          print_r($users_ison->getvalue());
          echo  $postKey.'</pre>';*/
        //  $users = $users_ison->getvalue();


//return view('shablon', /*compact('users')*/);
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('registration');
    }
    public function broadcastAs()
    {
        return 'datainfo';
    }
}
