<?php

namespace App\Auth;

use Config\Services;
use App\Models\User;
use App\Models\AuthLog;

class Auth
{
  	protected $isLogin;
  
  	public function __construct()
    {
      if(! isset($_SESSION)){
      	session()->start();
      }
      $this->isLogin = false;
    }
  
  	public function attempt($name, $password): bool
    {
      //cek if email or username is registered
      $user = User::where('email',$name)
        		->orWhere('username',$name)
        		->first();
      
      if(!$user)
      {
        return false;
      }
      
      if(password_verify($password,$user->password))
      {
        $setSession = [
        	'user' => $user->id,
          	'level' => $user->role,
          	'logged_in' => true
        ];
        
        // set the session
        session()->set($setSession);
        
        $this->loginHistoryWrite();
       	$this->isLogin = session()->logged_in;
        
        return true;
      }
      
      return false;
    }
  
  	public function isLogin(): bool
    {
      $is = session('logged_in');
      
      // not login
      if(!$is)
      {
        return false;
      }
      
      return true;
    }
  
  	public function getUser(): int
    {
      return session('user') ?? 0;
    }
  
  	public function logout()
    {
      session()->destroy();
      
      
      return true;
    }
  
  	/**
    * every time user just logged in
    * lets write history :)
    *
    */
  	private function loginHistoryWrite()
    {
      $request = Services::request();
      $write = [
      	'user_id' => session()->user,
        'ip_address' => $request->getIPAddress(),
        'browser' => $request->getServer('HTTP_USER_AGENT')
      ];
      
      AuthLog::create($write);
      
    }
  	
}