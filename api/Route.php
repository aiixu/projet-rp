<?php
  // class to manage application routes
  class Route
  {
    private static $routes = Array();
    private static $pathNotFound = null;
    private static $methodNotAllowed = null;

    // function to add route to the router
    public static function add($expression, $function, $method = "get")
    {
      array_push(self::$routes, Array(
        "expression" => $expression,
        "function" => $function,
        "method" => $method
      ));
    }

    // 404 handler
    public static function pathNotFound($function)
    {
      self::$pathNotFound = $function;
    }

    // 405 handler
    public static function methodNotAllowed($function)
    {
      self::$methodNotAllowed = $function;
    }

    // run router on current url
    public static function run($basepath = "/")
    {
      // parse current url
      $parsed_url = parse_url($_SERVER["REQUEST_URI"]);

      // set default path to basepath if uri wasn't parsed
      if(isset($parsed_url["path"]))
      {
        $path = $parsed_url["path"];
      }
      else
      {
        $path = $basepath;
      }

      // get current request method
      $method = $_SERVER["REQUEST_METHOD"];

      $path_match_found = false;
      $route_match_found = false;

      foreach(self::$routes as $route)
      {
        // if the method matches, check the path

        // add basepath to matching string
        if($basepath != "" && $basepath != "/")
        {
          $route["expression"] = "($basepath)" . $route["expression"];
        }

        // add 'find string start' automatically
        $route["expression"] = "^" . $route["expression"];

        // add 'find string end' automatically
        $route["expression"] = $route["expression"] . "$";

        // check path match	
        if(preg_match("#" . $route["expression"] . "#", $path, $matches))
        {
          $path_match_found = true;

          // check method match
          if(strtolower($method) == strtolower($route["method"]))
          {
            // always remove first element
            // this contains the whole string
            array_shift($matches);

            if($basepath != "" && $basepath != "/")
            {
              // Remove basepath
              array_shift($matches);
            }

            // invoke callback
            call_user_func_array($route["function"], $matches);

            $route_match_found = true;

            // do not check other routes
            break;
          }
        }
      }

      // no matching route was found
      if(!$route_match_found)
      {
        // but a matching path exists
        if($path_match_found)
        {
          // throw 405 and invoke callback if defined
          header("HTTP/1.0 405 Method Not Allowed");
          if(self::$methodNotAllowed)
          {
            call_user_func_array(self::$methodNotAllowed, Array($path,$method));
          }
        }
        else
        {
          // throw 404 and invoke callback if defined
          header("HTTP/1.0 404 Not Found");
          if(self::$pathNotFound)
          {
            call_user_func_array(self::$pathNotFound, Array($path));
          }
        }
      }
    }
  }
?>