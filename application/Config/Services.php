<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

require_once BASEPATH.'Config/Services.php';


class Services extends CoreServices
{

   public static function twig($getShared = true)
   {
       if ($getShared)
       {
           return self::getSharedInstance('twig');
       }
     

     
       $loader = new \Twig_Loader_Filesystem(APPPATH.'Views');
       $twig = new \Twig_Environment($loader);
	   
	   $engine = new \Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine();

	   $twig->addExtension(new \Aptoma\Twig\Extension\MarkdownExtension($engine));
       
       $auth = new \Twig_Function('auth', function($u=null) {
       $isauth = new \App\Auth\Auth;
       
       if(!is_null($u))
       {
         return $isauth->getUser();
       }
         
         
       if($isauth->isLogin())
       {
         return true;
       } else {
         return false;
       }
         
       });
     
       $tags = new \Twig_Function('tags', function ($v) {
       		$ex = explode(',',$v);
         	$data = '';
         
         	for($i=0;$i < count($ex);$i++)
            {
              $data .= "<span class='label label-info'>";
              $data .= $ex[$i];
              $data .= "</span> &nbsp;";
           	  if($i == 3) break;
            }
         
         return $data;
       });
     
       $twig->addFunction($tags);
       $twig->addFunction($auth);
       return $twig;
   }


}