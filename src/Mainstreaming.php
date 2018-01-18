<?php
namespace riccardo993\mainstreamingtv;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use riccardo993\mainstreamingtv\Vod\DownloadSession;
use riccardo993\mainstreamingtv\Vod\Resource\Categories;
use riccardo993\mainstreamingtv\Vod\Resource\Videos;
use riccardo993\mainstreamingtv\Vod\UploadSession;
use riccardo993\mainstreamingtv\Vod\Video;

class Mainstreaming{
    const BASE_URI = 'https://video.mainstreaming.tv/Sdk/13/WCFMSApi.svc/json/';

    public $token;
    public $client;

    public function __construct($token) {

        $this->token = $token;

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            $body = json_decode($request->getBody(), 1);

            if(! is_array($body))
                $body = [];

            if(! array_key_exists('token', $body))
                $body = ['token' => $this->token] + $body;

            return new Request(
                $request->getMethod(),
                $request->getUri(),
                $request->getHeaders(),
                json_encode($body)
            );
        }));

        $this->client = new Client([
            'base_uri' => self::BASE_URI,
            'debug' => false,
            'handler' => $stack,
            'headers' => [
                'Content-type' => 'application/json'
            ]
        ]);
    }

    public function upload()
    {
        $response = $this->client->post('CreateUploaderSession');

        return new UploadSession(json_decode($response->getBody()->getContents(), 1)['d']);
    }

    public function categories()
    {
        $response = $this->client->post('ListVodCategory');

        return new Categories(json_decode($response->getBody()->getContents(), 1)['d']);
    }

    public function videos(array $opt = [])
    {
        $response = $this->client->post('ListVodContentByCategory', [
            'json' => [
                'idVodCategory' => $opt['idVodCategory'] ?? 0,
                'sort' => $opt['sort'] ?? 'SORT_TITLE',
                'sortmode' => $opt['sortmode'] ?? 'ASC',
                'start' => $opt['start'] ?? 0,
                'limit' => $opt['limit'] ?? 25
            ]
        ]);

        return new Videos(json_decode($response->getBody()->getContents(), 1)['d']);
    }

    public function video(string $contentId)
    {
        $response = $this->client->post('GetVodContentByContentID', [
            'json' => [
                'contentId' => $contentId,
            ]
        ]);
        $json = json_decode($response->getBody()->getContents(), 1);

        return isset($json['d']) ? new Video($json['d']) : null;
    }

    public function delete(string $contentId) : bool
    {
        $response = $this->client->post('DeleteVodContent', [
            'json' => [
                'contentId' => $contentId,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), 1)['d'];
    }

    public function download(string $contentId)
    {
        $response = $this->client->post('CreateDownloaderSession', [
            'json' => [
                'contentId' => $contentId,
            ]
        ]);

        return new DownloadSession(json_decode($response->getBody()->getContents(), 1)['d']);
    }
}
