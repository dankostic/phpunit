<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use App\Api\ApiClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class
ApiClientTest extends TestCase
{
   protected $httpClient;
   protected $apiClient;
   protected $mockHandler;
   protected $jsonClient;
   protected $jsonApiClient;

   public function setUp(): void
   {
//       $this->httpClient = new Client(['base_uri' => 'https://api.postcodes.io/']);
       $this->mockHandler = new MockHandler();
       $this->httpClient = new Client([
           'handler' => $this->mockHandler,
       ]);
       $this->apiClient = new ApiClient($this->httpClient);
       $this->jsonClient = new Client(['base_uri' => 'http://localhost:3000/']);
       $this->jsonApiClient = new ApiClient($this->jsonClient);


   }

   public function tearDown(): void
   {
       $this->httpClient = null;
       $this->apiClient = null;
       $this->jsonClient = null;
       $this->jsonApiClient = null;
   }

   public function test_show_postcode_data()
   {
       $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/Data/postcode.json')));

       $response = $this->apiClient->getPostcodeData('NE30 1DP');
       $this->assertEquals(200, $response->getStatusCode());
       $data = (object) json_decode($response->getBody(), true);
       $this->assertArrayHasKey('country', $data->result);
   }

    public function test_show_postcodes_data()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/Data/postcodes.json')));
        $response = $this->apiClient->getPostcodesData(["OX49 5NU", "M32 0JG", "NE30 1DP"]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody());
        $this->assertCount(3, $data->result);
    }

    public function test_show_post()
    {
        $response = $this->jsonApiClient->getPost(1);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('title', $data);
    }

    public function test_add_post()
    {
        $this->jsonApiClient->addPost(['id' => 2, 'title' => 'api-client', 'author' => 'dankostic']);
        $response = $this->jsonApiClient->getPost(2);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        $this->assertSame('dankostic', $data->author);
    }

    /**
     * @depends test_add_post
     */
    public function test_delete_post()
    {
        $response = $this->jsonApiClient->deletePost(2);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_update_post()
    {
        $this->jsonApiClient->updatePost(1, ['title' => 'json-api-server']);
        $response = $this->jsonApiClient->getPost(1);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        $this->assertSame('json-api-server', $data->title);
    }

    public function test_replace_post()
    {
        $this->jsonApiClient->replacePost(1, ['title' => 'json-replace-server', 'author' => 'dankostic']);
        $response = $this->jsonApiClient->getPost(1);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        $this->assertEquals('dankostic', $data->author);
        $this->assertSame('json-replace-server', $data->title);
    }
}
