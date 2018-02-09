<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Auth\Auth;
use App\Models\Discuss;
//use Illuminate\Pagination\Paginator;
  
class Home extends Controller
{

  	protected $twig;
  	protected $auth;
  
  	public function __construct(...$params)
    {
      parent::__construct(...$params);
      if(! isset($_SESSION))
      	session()->start();
      
      $this->twig = Service('twig');
      $this->auth = new Auth;
    }
  
  	public function index()
    {
      $page = $this->request->getGet('page') === '' 
        	? 1
        	: $this->request->getGet('page') > 0 
              ? $this->request->getGet('page') 
              : 1 ;
      
      $limit     = 2; // Number of posts on one page
      $skip      = ($page - 1) * $limit;
      $count     = Discuss::all()->count(); 
      $pagination = [
            'needed'        => $count > $limit,
          //'count'         => $count,
            'page'          => $page,
            'lastpage'      => (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit)),
          //'limit'         => $limit,
        ];
      
      return $this->twig->render('discuss.twig',[
          'pagination'    => $pagination,
      	  'discusses' => Discuss::take($limit)->skip($skip)->get()
          
      ]);
      
    }
  
  	public function topic($slug)
    {
      $discuss = Discuss::where('slug','=',$slug)->first();
      $comments = $discuss->comments;
      
      if($discuss->count() === 0)
      {
        return redirect('/notfound');
      }
     	//print_r($discuss);
      
        
      
     return $this->twig->render('discuss_topic.twig',[
      	'discus' => $discuss,
        'comments' => $comments
          
      ]);
    }
  
  
  	public function tanya()
    {
      
      if(!$this->auth->isLogin())
        return redirect('/login');
      return $this->twig->render('discuss_ask.twig');
    }
  
  	

}