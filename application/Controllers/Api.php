<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;
use App\Auth\Auth;


class Api extends Controller
{
 	protected $auth;
  
  	public function __construct(...$params)
    {
      parent::__construct(...$params);
      if(! isset($_SESSION))
      {
      	session()->start();
      }
      
      $this->auth = new Auth;
      
    }
  	function index(){
      session()->start();
    	print_r(session('user'));
  	}
  	public function login()
    {
      
      $validate = $this->validate([
      	'email' => [
        	'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        'password' => [
        	'label' => 'password',
            'rules' => 'required|min_length[6]'
        ]
      ]);
      
      $err = $this->validator->getErrors();
      
      $response = [
      	'validation' => $validate,
        'errors' => $err,
        'status' => false
      ];
      
      if($validate)
      {
        if(
          $this->auth->attempt(
          			$this->request->getPost('email'),
          			$this->request->getPost('password')
        )) 
        {
          $response['status'] = true;
        }
      }
      
      $this->response
        	->setStatusCode(200)
        	->setContentType('application/json')
        	->setBody(json_encode($response))
        	->send();
      exit;
    }
  
  
  	public function register()
    {
      
      $validate = $this->validate([
      	'name'  => [
          'label' => 'Name',
          'rules' => 'required|trim'
        ],
        'username' => [
          'label' => 'Username',
          'rules' => 'required|alpha_numeric|min_length[3]|max_length[7]'
        ],
        'email' => [
          'label' => 'Email',
          'rules' => 'required|valid_email'
        ],
        'password' => [
          'label' => 'Password',
          'rules' => 'required|min_length[6]'
        ],
        'confpassword' => [
          'label' => 'Confirm Password',
          'rules' => 'matches[password]'
        ]
      ]);
      
      $err = $this->validator->getErrors();
      
      
      $response = [
      	'status' => $validate,
        'errors' => $err
      ];
      
      if($validate)
      {
        User::create([
        	'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
          	'email' => $this->request->getPost('email'),
          	'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
        ]);
      }
      
      $this->response
        	->setStatusCode(201)
        	->setContentType('application/json')
        	->setBody(json_encode($response))
        	->send();
      exit;
    }
  
  	public function ask()
    {
      
      if(!$this->auth->isLogin())
      {
        exit('forbidden');
      }
      
      $validate = $this->validate([
      	'topic' => [
        	'label' => 'Topic',
            'rules' => 'required|min_length[5]|trim'
        ],
        'body' => [
        	'label' => 'Body',
            'rules' => 'required'
        ]
      ]);
      
      $err = $this->validator->getErrors();
      
      $response = [
      	'validation' => $validate,
        'errors' => $err,
        'status' => false
      ];
      
      $topic = $this->request->getPost('topic');
      $body = esc($this->request->getPost('body'));
      $tags = esc($this->request->getPost('tags'));
      
      if($validate)
      {
      	$discuss = new \App\Models\Discuss;
      	$discuss->user_id = session('user');
      	$discuss->topic = $topic;
      	$discuss->body = \Michelf\MarkdownExtra::defaultTransform($body);
        $discuss->slug = url_title($topic.'-'.rand(00000,99999));
        $discuss->tags = $tags;
        
      	$discuss->save();
        
      	$response = [
        	'validation' => true,
          	'status'	=> true
        ];
      }
      
      $this->response
        	->setStatusCode(201)
        	->setContentType('application/json')
        	->setBody(json_encode($response))
        	->send();
      exit;
    }
  
  
  	public function comment()
    {
      
      $validate = $this->validate([
      	'body' => [
        	'label' => 'Comment',
            'rules' => 'required|min_length[3]|trim'
        ]
      ]);
      
      $err = $this->validator->getErrors();
      
      $response = [
      	'validation' => $validate,
        'errors' => $err,
        'status' => false
      ];
      
      if($validate)
      {
        $comment = new \App\Models\Comment;
        $comment->user_id = session('user');
        $comment->parent_id = $this->request->getPost('parent');
        $comment->body = esc($this->request->getPost('body'));
        $comment->save();
        
        $response = [
        	'validation' => true,
          	'status'	 => true
        ];
      }
      
      $this->response
        	->setStatusCode(201)
        	->setContentType('application/json')
        	->setBody(json_encode($response))
        	->send();
      exit;
    }
  
}