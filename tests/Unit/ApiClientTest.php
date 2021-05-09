<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class
ApiClientTest extends TestCase
{
   protected $httpClient;

   public function setUp(): void
   {
       $this->httpClient = new Client(['base_uri' => 'https://api.postcodes.io/']);
   }

   public function tearDown(): void
   {
       $this->httpClient = null;
   }

   public function test_show_postcode_data()
   {
       $response = $this->httpClient->get('postcodes/NE30 1DP');
       $this->assertEquals(200, $response->getStatusCode());
       $data = (object) json_decode($response->getBody(), true);
       $this->assertArrayHasKey('country', $data->result);
   }

    public function test_show_postcodes_data()
    {
        $postcodes = [
            'json' => [
                'postcodes' => ["OX49 5NU", "M32 0JG", "NE30 1DP"]
            ]
        ];
        $response = $this->httpClient->post('postcodes', $postcodes);
        $this->assertEquals(200, $response->getStatusCode());
        $data = (object) json_decode($response->getBody(), true);
        $this->assertCount(3, $data->result);
    }
}
