<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use App\Api\ApiClient;
use PHPUnit\Framework\TestCase;

class
ApiClientTest extends TestCase
{
   protected $httpClient;
   protected $apiClient;

   public function setUp(): void
   {
       $this->httpClient = new Client(['base_uri' => 'https://api.postcodes.io/']);
       $this->apiClient = new ApiClient($this->httpClient);
   }

   public function tearDown(): void
   {
       $this->httpClient = null;
       $this->apiClient = null;
   }

   public function test_show_postcode_data()
   {
       $response = $this->apiClient->getPostcodeData('NE30 1DP');
       $this->assertEquals(200, $response->getStatusCode());
       $data = (object) json_decode($response->getBody(), true);
       $this->assertArrayHasKey('country', $data->result);
   }

    public function test_show_postcodes_data()
    {
        $response = $this->apiClient->getPostcodesData(["OX49 5NU", "M32 0JG", "NE30 1DP"]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = (object) json_decode($response->getBody(), true);
        $this->assertCount(3, $data->result);
    }
}
