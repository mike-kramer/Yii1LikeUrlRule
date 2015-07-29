<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;

class Yii1LikeUrlRule extends Object implements UrlRuleInterface {
    public function createUrl($manager, $route, $params) {
        $url = $route;
        foreach ($params as $name => $value) {
            $url .= "/$name/$value";
        }
        return $url;
    }

    public function parseRequest($manager, $request) {
        $params = [];
        $pathInfo = $request->getPathInfo();
        
        $segments = explode("/", $pathInfo);
        if (count($segments) < 3)
            return false;
        $controller = array_shift($segments);
        $action = array_shift($segments);
        
        while (count($segments)) {
            $paramName  = array_shift($segments);
            $paramValue = array_shift($segments);
            
            $params[$paramName] = $paramValue;
        }
        
        return ["$controller/$action", $params];
    }

}