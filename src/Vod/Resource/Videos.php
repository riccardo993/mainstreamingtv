<?php
namespace riccardo993\mainstreamingtv\Vod\Resource;

use riccardo993\mainstreamingtv\Vod\Video;

class Videos{
    protected $videos = [];

    public function __construct(array $videos = []) {
        foreach ($videos as $video) {
            array_push($this->videos, new Video($video));
        }
    }

    public function all()
    {
        return $this->videos;
    }

    public function first()
    {
        if(! empty($this->videos))
            return $this->videos[0];

        return null;
    }
}
