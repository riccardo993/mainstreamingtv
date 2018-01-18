<?php
namespace riccardo993\mainstreamingtv\Vod;

class Category{
    protected $id;
    protected $description;
    protected $videoCount;

    public function __construct(array $category) {
        $this->id = $category['IdCategory'];
        $this->description = $category['Description'];
        $this->videoCount = $category['VideoCount'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getVideoCount()
    {
        return $this->videoCount;
    }
}
