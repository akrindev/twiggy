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
      $page = (int) $this->request->getGet('page') === '' 
        	? 1
        	: $this->request->getGet('page') > 0 
              ? $this->request->getGet('page') 
              : 1 ;
      
      $limit     = 2; // Number of posts on one page
      $skip      = (int) ($page - 1) * $limit;
      $count     = (int) Discuss::all()->count();
      $lastpage  = (int) (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));
      
      //if ?page= is greater than lastpage
      if($page > $lastpage)
      {
        //asign page to the lastpage
       	$page = $lastpage;
      }
      
      $pagination = [
            'needed'        => $count > $limit,
          //'count'         => $count,
            'page'          => $page,
            'lastpage'      => $lastpage,
          //'limit'         => $limit,
        ];
      
      return $this->twig->render('discuss.twig',[
          'pagination'    => $pagination,
      	  'discusses' => Discuss::take($limit)->skip($skip)->get()
          
      ]);
      
    }
  
  	public function topic($slug)
    {
      //get slug
      $discuss = Discuss::where('slug','=',$slug)->first();
      //get comment topic
      $comments = $discuss->comments;
      
      //if topic not found
      if($discuss->count() === 0)
      {
        return redirect('/notfound');
      } 
      
     return $this->twig->render('discuss_topic.twig',[
      	'discus' => $discuss,
        'comments' => $comments
          
      ]);
    }
  
  
  	public function tanya()
    {
      //must login
      if(!$this->auth->isLogin())
        return redirect('/login');
      
      return $this->twig->render('discuss_ask.twig');
    }
  
  	

}