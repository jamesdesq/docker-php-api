<?php 

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
class CmsRequest
{

    private $space;

    private $accessToken;

    private $domain;
    
    function __construct() { 
        $this->space = $_ENV["CONTENTFUL_SPACE_ID"];

        $this->accessToken = $_ENV["CONTENTFUL_ACCESS_TOKEN"];

        $this->domain = $_ENV["CONTENTFUL_DOMAIN"];
    }

    function getItemsAsync() { 

        $contentType = "story";
        $search = "";

        $path = "/spaces/$this->space/environments/master/entries?access_token=$this->accessToken&content_type=$contentType&fields.url=$search";
        $url =  $this->domain . $path;

        $client = new GuzzleHttp\Client();

        $request = new Request('GET', $url);
        $promise = $client->getAsync($url);

        $promise->then(
            function (ResponseInterface $res) {
                $content = $res->getBody()->getContents();
                $this->orderResponse($content);
            },
            function ($e) {
                d($e);
            }
        )->wait();
    }

    function getItems() { 

        $contentType = "story";
        $search = "";
        $client = new GuzzleHttp\Client();
        $path = "/spaces/$this->space/environments/master/entries?access_token=$this->accessToken&content_type=$contentType&fields.url=$search";

        $url =  $this->domain . $path;

        // httpbin returns quite slowly
        $url = "http://httpbin.org/anything";

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url, ["timeout => 1"]);
        
        $response = json_decode($res->getBody()->getContents(), TRUE);

        d($response);
        
        $processed = [];

        if (isset($response["items"])) { 
            foreach($response["items"] as $v) { 
                $processed[] = [
                    "title" => $v["fields"]["title"],
                    "summary" => $v["fields"]["summary"],
                    "url" => $v["fields"]["url"],
                ];
                
            }
        }
        echo json_encode($processed);
    }

    function submitPost() { 
        $account_data['device'] = "Test";
        $account_data['mac'] = "a1-a1-a1-b2-b2-b2";
        $account_data['accountId'] = "123abc";

        $logged_in = 1;

        $url = $_ENV["TEST_POST_ENDPOINT"];

        $body = json_encode([
            'account_data' => $account_data,
            'logged_in' => $logged_in
        ]);

        $client = new GuzzleHttp\Client();

        $request = new Request('POST', $url, [
            "timeout" => 5,
            "connect_timeout" => 5,
            "body" => $body
        ]);
        $promise = $client->sendAsync($request);

        $promise->then(
            function (ResponseInterface $res) {
                d($res);
            },
            function ($e) {
                d("Problems");
            }
        )->wait();

    }

    function orderResponse($body) { 
        $response = json_decode($body, TRUE);

        $processed = [];

        if (isset($response["items"])) { 
            foreach($response["items"] as $v) { 
                $processed[] = [
                    "title" => $v["fields"]["title"],
                    "summary" => $v["fields"]["summary"],
                    "url" => $v["fields"]["url"],
                ];
            }
        }
        echo json_encode($processed);
    }
}