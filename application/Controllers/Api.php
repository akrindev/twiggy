<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;
use App\Auth\Auth;


class Api extends Controller
{
 
  
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
        $check = new Auth;
        $check->attempt(
          		$this->request->getPost('email'),
          		$this->request->getPost('password')
        );
        
        if($check)
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
        	->setStatusCode(200)
        	->setContentType('application/json')
        	->setBody(json_encode($response))
        	->send();
      exit;
    }
  
}