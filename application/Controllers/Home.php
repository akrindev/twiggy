<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Auth\Auth;
use App\Models\Discuss;

class Home extends Controller
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
      $discusses = Discuss::all();
    //  print_r($discusses);
      
      return $this->twig->render('discuss.twig',[
      	'discusses' => $discusses
      ]);
      
    }
  
  	public function topic($slug)
    {
      $discuss = Discuss::where('slug',$slug)->get();
      
      if($discuss->count() === 0)
      {
        return redirect('/notfound');
      }
     // print_r($discuss);
      return $this->twig->render('discuss_topic.twig',[
      	'discuss' => $discuss
      ]);
    }
  
  
  	public function tanya()
    {
      
      if(!$this->auth->isLogin())
        return redirect('/login');
      return $this->twig->render('discuss_ask.twig');
    }
  
  	

}