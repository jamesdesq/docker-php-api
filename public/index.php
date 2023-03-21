<?php 

/**
 * Autoload files using composer
 */
require_once __DIR__ . './../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/api/create.php';
require_once __DIR__ . '/api/cmsrequest.php';

use Steampixel\Route;

Route::add(
    '/', function () {
        return 'Hello world!';
    }
);

Route::add(
    '/api/content/list-content', function() { 
        $cmsRequest = new CmsRequest();
        $response = $cmsRequest->getItems();
        echo $response;
    }
);

Route::add(
    '/bar', function () { 
        include_once __DIR__ . "/app/index.php";
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
        $paypalPayments = new PayPalPayments();
        $paypalPayments->captureOrder($data["orderID"]);
    }, 'post'
);

Route::add(
    '/xdebug-info', function () { 
        xdebug_info();
    }
);

Route::run('/');

