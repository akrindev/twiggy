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
     
       return $twig;
   }


}