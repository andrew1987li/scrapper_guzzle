<?php
  require 'vendor/autoload.php';
  use GuzzleHttp\Client;
  use Symfony\Component\DomCrawler\Crawler;
  use RuntimeException;

  function placeholder($someParam)
  {
    echo("start");
 
    getResult('http://archive-grbj-2.s3-website-us-west-1.amazonaws.com/');
    //echo $body;
  }

  $site='http://archive-grbj-2.s3-website-us-west-1.amazonaws.com/';

  function getBody($url){
     $client = new Client([
        'base_uri' => $url,
        'timeout'  => 5.0,
      ]);

      # Request / or root
      $response = $client->request('GET', '/');
      $body = $response->getBody()->getContents();   
      return $body;
  }


  $checked_url=array();
  $result = array();

  function getResult($url){
    //echo $body;
     $body = getBody($url);
     $crawler = new Crawler($body);
     

     if(preg_match("/articles/", $url)==1){
        //This is article
        $art_date=$crawler->filter('div.date')->text();
        $art_title=$crawler->filter('h1')->text();
        $art_url=$url
        $art_name=$crawler->filter('div.author-info h2 a')->text();
        $art_twit=$crawler->filter('div.author_bio a')->attr('href');
        $art_bio=$crawler->filter('div.author_bio')->text();
        $art_url=$site.$crawler->filter('div.author a')->attr('href');

        array_push($result, array('authorName'=>$art_name, 'article'=>array($art_url,$art_date),'AuthBio'=>$art_bio, 'Title'=>$art_title));
     }
     


    //CSS filtering
    //Get all links
    $filter = $crawler->filter('a');

   // print_r($filter);
   if(iterator_count($filter)>1){
        foreach ($filter as $key => $value) {
          //echo $key."=>".$value->text();
          $con = new Crawler($value);
          getResult($con->attr('href'));
        }


    }else {
      throw new RuntimeException('Got empty result processing dataset');
    }
    
  }




?>
