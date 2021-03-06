<?php

namespace OCFram;

class Router
{
	protected $routes = [];
	const NO_ROUTE = 1;

	public function addRoute (Route $route) 
	{
		if(!in_array($route, $this->routes)) 
		{	
			$this->routes [] = $route;
		}
	}

	public function getRoute ($url){	
		foreach ($this->routes as $route){
			$varsValues = $route->match($url);
			if ($varsValues !== false){				
				if ($route -> hasVars()){
					$varsName = $route-> varsNames(); 
					$listVars = []; 

						foreach($varValues as $key=>$match){
							if ($key !==0)
							{
								$listVars[$varsName[$key-1]] = $match; 
							}
						}

						$route->setVars($listVars);	 
				}  
				return $route; 
			}
		}

		 throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
	}
}
