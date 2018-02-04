<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Auth\Auth;



class User extends Controller
{

  	protected $twig;
  	protected $auth;
  
  	public function __construct()
    {
      if(! isset($_SESSION))
      	session()->start();
      
      $this->twig = Service('twig');
      $this->auth = new Auth;
    }
  
  	public function index()
    {
      
      if(!$this->auth->isLogin())
        return redirect('login');
      
      return $this->twig->render('dashboard.twig');
    }
  
  
  	public function tanya()
    {
      
      if(!$this->auth->isLogin())
        return redirect('/login');
      return $this->twig->render('discuss_ask.twig');
    }
  
  
  
	public function login()
	{
      
      if($this->auth->isLogin())
        return redirect('profile');
      
      return $this->twig->render('login.twig');
	}
  
  
	public function register()
	{
      if($this->auth->isLogin())
        return redirect('profile');
      
    	return $this->twig->render('register.twig',[]);
	}
  
  	public function logout()
    {
      if(!$this->auth->isLogin())
        return redirect('login');
      
      $this->auth->logout();
      
      return redirect('login');
    }
  
}