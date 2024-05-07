<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ValidYouTubeLink implements Rule
{
    public function passes($attribute, $value)
    {
        // Validate URL format
        if (!preg_match('/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/m', $value)) {
            return false;
        }

        // Check if the link actually resolves to a valid YouTube video
        try {
            $client = new Client();
            $response = $client->get($value);
            $htmlContent = (string)$response->getBody();
            $crawler = new Crawler($htmlContent);

            // Check if the title element exists
            $titleElement = $crawler->filter('meta[itemprop="name"][content]');
            if ($titleElement->count() > 0) {
                // Video is available
                return true;
            } else {
                // Video is unavailable
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid YouTube link.';
    }
}
