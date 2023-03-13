<?php 

// Autoload files using composer
require_once __DIR__ . './../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once __DIR__ . '/api/create.php';
require_once __DIR__ . '/api/test.php';

// Use this namespace
use Steampixel\Route;


// Add your first route
Route::add(
    '/', function () {
  
        print("<pre>");
        print_r($_ENV);
        print("</pre>");
  
        return 'WELCOME!';
    }
);

Route::add(
    '/bar', function () { 
        include_once __DIR__ . "/app/index.php";
    }
);


Route::add(
    '/foo', function () { 
    
        echo "Hello world";
    
        // include_once(__DIR__ . "/src/app/index.php");
    }
);

Route::add(
    '/api/create-paypal-order', function () { 
        $paypalPayments = new PayPalPayments();
        $paypalPayments->createOrder();
    }, 'post'
);

Route::add(
    '/api/capture-paypal-order', function () { 
    
        $data = json_decode(file_get_contents('php://input'), true);
        // print_r($data);
    
        $paypalPayments = new PayPalPayments();
        $paypalPayments->captureOrder($data["orderID"]);
    }, 'post'
);

Route::add(
    '/api/test-function', function () {
        test();
    }
);

Route::add(
    '/xdebug-info', function () { 
        xdebug_info();
        // phpinfo();
    }
);


// Route::add('/api/test-create-paypal-order', function() { 
//     error_log("Am I executing?");
//     return "HELLO!";
// });

Route::run('/');

