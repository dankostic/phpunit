<?php
namespace App\Api;

class ApiClient {
    protected $httpClient;

    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPostcodeData(string $postcode)
    {
        return $this->httpClient->get('postcodes/' . $postcode);
    }

    public function getPostcodesData(array $postcodes)
    {
        $postcodes = [
            'json' => [
                'postcodes' => $postcodes
            ]
        ];
        return $this->httpClient->post('postcodes', $postcodes);
    }

    public function getPost(int $post_id)
    {
        return $this->httpClient->get('posts/' . $post_id);
    }
}
