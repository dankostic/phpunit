<?php
namespace App\Api;

/**
 * Class ApiClient
 * @package App\Api
 */
class ApiClient
{
    /**
     * @var
     */
    protected $httpClient;

    /**
     * ApiClient constructor.
     * @param $httpClient
     */
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $postcode
     * @return mixed
     */
    public function getPostcodeData(string $postcode)
    {
        return $this->httpClient->get('postcodes/' . $postcode);
    }

    /**
     * @param array $postcodes
     * @return mixed
     */
    public function getPostcodesData(array $postcodes)
    {
        $postcodes = [
            'json' => [
                'postcodes' => $postcodes
            ]
        ];
        return $this->httpClient->post('postcodes', $postcodes);
    }

    /**
     * @param int $post_id
     * @return mixed
     */
    public function getPost(int $post_id)
    {
        return $this->httpClient->get('posts/' . $post_id);
    }

    /**
     * @param $post
     * @return mixed
     */
    public function addPost($post)
    {
        $post = [
            'json' => $post
        ];
        return $this->httpClient->post('posts', $post);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deletePost(int $id)
    {
        return $this->httpClient->delete('posts/' . $id);
    }
}
