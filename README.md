# URL-User-Friendly-Router-PHP
This Class for handle user firendly url into controller
#How to?
In this case, you have a routes configuration for your configuration. For example:

```php
<?php
// routes.php
// ruotes configuration
// Ex: $routes[uri/param] = controller/menthod/params

$routes['/']                        = 'HomeController/index';
$routes['/view/:num']               = 'ViewController/detail/#1';

// for custom regex in your paramaters
// and dont forget to make group in  your regex "()" 
$routes['/view/([a-z]+)/page:num']  = 'ViewController/customDetail/#1/#2';

?>
```

# Implementation

Based on the routes.php files.

```php
<?php

$uri = '/'; // example of your uri

require "routes.php"; // load routes configuration
require "Routes.php"; // loud routes class

$routes = new Routes();
$route = $routes->match($uri);

$cName = $route['controller'];  // get the controller
$mName = $route['method'];      // get the method
$pName = $route['params];       // get the params

```


