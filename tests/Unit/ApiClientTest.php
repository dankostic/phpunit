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

   public function setUp(): void
   {
//       $this->httpClient = new Client(['base_uri' => 'https://api.postcodes.io/']);
       $this->mockHandler = new MockHandler();
       $this->httpClient = new Client([
           'handler' => $this->mockHandler,
       ]);
       $this->apiClient = new ApiClient($this->httpClient);

   }

   public function tearDown(): void
   {
       $this->httpClient = null;
       $this->apiClient = null;
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
        $data = (object) json_decode($response->getBody(), true);
        $this->assertCount(3, $data->result);
    }
}
