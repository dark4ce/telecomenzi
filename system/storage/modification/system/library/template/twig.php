<?php
namespace Template;
final class Twig {
	private $twig;
	private $data = array();
	
	public function __construct() {
		// include and register Twig auto-loader
		include_once DIR_SYSTEM . 'library/template/Twig/Autoloader.php';
		
		\Twig_Autoloader::register();	
		
		// specify where to look for templates
		$loader = new \Twig_Loader_Filesystem(DIR_TEMPLATE);	
		
		// initialize Twig environment
		$this->twig = new \Twig_Environment($loader, array('autoescape' => false));			
	}	
	
	public function set($key, $value) {

                $this->twig->addFunction('staticCall', new \Twig_Function_Function(function ($class, $function, $args = array()) {
                    if (class_exists($class) && method_exists($class, $function)) {
                        return call_user_func_array(array($class, $function), $args);
                    }

                    return null;
                }));
            
		$this->data[$key] = $value;
	}
	
	public function render($template) {
		try {
			// load template
			$template = $this->twig->loadTemplate($template . '.twig');
			
			return $template->render($this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $template . '!');
			exit();	
		}	
	}	
}