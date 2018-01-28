<?php

namespace App\Controllers;

use CodeIgniter\Controller;
//use App\Models\User;
//use CodeIgniter\HTTP\RequestInterface;
use Twig_Loader_Filesystem as tw;
use Twig_Environment as te;
use App\Auth\Auth;

use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;


class Home extends Controller
{
  	protected $twig;
  
  	public function __construct()
    {
      $loader = new tw(APPPATH.'Views');
      $this->twig = new te($loader);
      
	  $engine = new 	MarkdownEngine\MichelfMarkdownEngine();

	  $this->twig->addExtension(new MarkdownExtension($engine));
    }
  
	public function login()
	{
    	return $this->twig->render('login.twig',[]);
	}
  
  
	public function register()
	{
    	return $this->twig->render('register.twig',[]);
	}
  
}