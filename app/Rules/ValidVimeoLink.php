<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ValidVimeoLink implements Rule
{
    public function passes($attribute, $value)
    {
        // Validate URL format
        if (!preg_match('/^https?:\/\/(?:www\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|)(\d+)(?:$|\/|\?)/', $value)) {
            return false;
        }

        // Check if the link actually resolves to a valid Vimeo video
        $videoId = $this->getVideoId($value);
        if (!$videoId) {
            return false;
        }

        try {
            return $this->validateVimeoVideo($videoId);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                return false; // Handle 404 Not Found response
            }
            throw $e; // Rethrow other exceptions
        }
    }

    private function getVideoId($url)
    {
        preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/[^\/]*\/videos\/|video\/|)(\d+)/', $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    private function validateVimeoVideo($videoId)
    {
        $client = new Client();
        $response = $client->get("https://vimeo.com/api/v2/video/{$videoId}.json");
        $data = json_decode($response->getBody(), true);

        // Check if the video exists and is accessible
        return !empty($data);
    }

    public function message()
    {
        return 'The :attribute must be a valid Vimeo link.';
    }
}
