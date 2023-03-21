<?php 

class CmsRequest
{
    function getItems() { 

        $space = $_ENV["CONTENTFUL_SPACE_ID"];

        $accessToken = $_ENV["CONTENTFUL_ACCESS_TOKEN"];

        $domain = $_ENV["CONTENTFUL_DOMAIN"];

        $contentType = "story";
        $search = "";

        $path = "/spaces/$space/environments/master/entries?access_token=$accessToken&content_type=$contentType&fields.url=$search";
        $url =  $domain . $path;

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $response = json_decode($res->getBody()->getContents(), TRUE);
        
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