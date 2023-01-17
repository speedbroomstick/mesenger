<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    public function accept_or_reject_friend(){
        if(isset($_GET['do_friend']))
        {
            $postData_for_person = [
                'messages' => "",
                'state' =>  "confirm"
            ];
            $firebase = (new Factory)
                ->withServiceAccount('file.json')
                ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');
            $database = $firebase->createDatabase();
            if($_GET['do_friend'] == "agree"){
                $account_activ_user = $database
                    ->getReference('users')->getChild($_COOKIE['user_name'])
                    ->getChild('friends')->getChild($_GET['name_user'])->set($postData_for_person);
                $account_another_user = $database
                    ->getReference('users')->getChild($_GET['name_user'])
                    ->getChild('friends')->getChild($_COOKIE['user_name'])->set($postData_for_person);
            }
            else{
                $account_activ_user = $database
                    ->getReference('users')->getChild($_COOKIE['user_name'])
                    ->getChild('friends')->getChild($_GET['name_user'])->set(null);
                $account_another_user = $database
                    ->getReference('users')->getChild($_GET['name_user'])
                    ->getChild('friends')->getChild($_COOKIE['user_name'])->set(null);
            }
        }
    }
    public function Check_state_friend(){
        $firebase = (new Factory)
            ->withServiceAccount('file.json')
            ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');
        $database = $firebase->createDatabase();
        $check_state = $database
            ->getReference('users')->getChild($_COOKIE['user_name'])
            ->getChild('friends');
        $friend = $check_state->getvalue();
        return $friend;
    }
    public function FindNewFriend(){
        if(isset($_GET['login']) && isset($_COOKIE['user_name']))
        {
            if($_GET['login'] != $_COOKIE['user_name']){
                $firebase = (new Factory)
                    ->withServiceAccount('file.json')
                    ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');
                $database = $firebase->createDatabase();

                $users_ison = $database
                    ->getReference('users')->getChild($_GET['login']);
                $check_repeat = $database
                    ->getReference('users')->getChild($_COOKIE['user_name'])
                    ->getChild('friends')->getChild($_GET['login']);
                $users_ison = $users_ison->getvalue();
                $check_repeat = $check_repeat->getvalue();
                if($users_ison != null && $check_repeat == null) {

                    $postData_for_person = [
                        'messages' => "",
                        'state' =>  "not_confirmed"
                    ];
                    $postData_for_me = [
                        'messages' => "",
                        'state' =>  "wait_confirmation"
                    ];
                    $postRef_me = $database->getReference('users')->getChild($_COOKIE['user_name'])
                        ->getChild('friends')->getChild($_GET['login'])->set($postData_for_me);
                    $postRef_person = $database->getReference('users')->getChild($_GET['login'])
                        ->getChild('friends')->getChild($_COOKIE['user_name'])->set($postData_for_person);
                }
            }
        }
    }
    public function LoadMessages(Request $req){
        $username = $_COOKIE['user_name'];
        $friend = $req->input('friend');
        $firebase = (new Factory)
            ->withServiceAccount('file.json')
            ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');
        $database = $firebase->createDatabase();

        $users_ison = $database
            ->getReference('users')->getChild($username)->getChild('friends')->getChild($friend)->getChild('messages');
        $messages = $users_ison->getvalue();
        $users_ison2 = $database
            ->getReference('users')->getChild($username)->getChild('friends');
        $friends = $users_ison2->getvalue();
        $check_friends = $this->Check_state_friend();
        $count_friend = $this->count_new_friend();
        return view('messages',compact('messages','friends','count_friend','check_friends'));
    }
    public function count_new_friend(){
        $check_friends = $this->Check_state_friend();
        $count_friend = 0;
        if($check_friends != null){
            foreach ($check_friends as $key => $value) {
                if($value['state'] == "not_confirmed") {
                    $count_friend++;
                }
            }
        }
        return $count_friend;
    }
    public function LoadFriends(){
        if(isset($_COOKIE['user_name'])) {
            $username = $_COOKIE['user_name'];
            $firebase = (new Factory)
                ->withServiceAccount('file.json')
                ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');
            $database = $firebase->createDatabase();

            $users_ison = $database
                ->getReference('users')->getChild($username)->getChild('friends');
            $friends = $users_ison->getvalue();
            $this->FindNewFriend();
            $check_friends = $this->Check_state_friend();
            $count_friend = $this->count_new_friend();
            $this->accept_or_reject_friend();
            return view('messages', compact('friends','check_friends', 'count_friend'));
        }
        else{
            echo 'Нет прав доступа!!!!';
        }
    }
    public function RegistrationNewUser(Request $req)
    {

        $login = $req->input('login');
        $email = $req->input('email');
        $password = $req->input('password');

        $firebase = (new Factory)
            ->withServiceAccount('file.json')
            ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');


        $database = $firebase->createDatabase();

        $postData = [
            'login' => $login,
            'email' =>  $email,
            'password'=>$password,
            'friends'=>""
        ];
        $postRef = $database->getReference('users')->getChild($login)->set($postData);
        $postKey = $postRef->getKey();
        $flag_regisration = true;
        return view('registration',compact('flag_regisration'));
    }

    public function Autorization(Request $req, Response $response){
        $login = $req->input('login');
        $password = $req->input('password');

        $firebase = (new Factory)
            ->withServiceAccount('file.json')
            ->withDatabaseUri('https://kursbd-b3292-default-rtdb.firebaseio.com');


        $database = $firebase->createDatabase();

        $users_ison = $database
            ->getReference('users');
        $users = $users_ison->getvalue();
        if(count($users)){
            foreach($users as $key => $value){
                if($value['login']==$login && $value['password']==$password){
                    setcookie('state_r',true);
                    setcookie('user_name',$value['login']);//setcookie('state_r',true, time()+120);
                        return view('auth');
                }
            }
        }
    }
}
