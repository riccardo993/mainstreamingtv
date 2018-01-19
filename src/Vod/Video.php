<?php
namespace riccardo993\mainstreamingtv\Vod;

class Video{
    protected $contentId;
    protected $customAttribute1;
    protected $customAttribute2;
    protected $customAttribute3;
    protected $customAttribute4;
    protected $customAttribute5;
    protected $customAttribute6;
    protected $customAttribute7;
    protected $customAttribute8;
    protected $customAttribute9;
    protected $customAttribute10;
    protected $duration;
    protected $encodingStatusPercent;
    protected $filename;
    protected $idCategory;
    protected $longDescription;
    protected $referenceID;
    protected $relatedLinkText;
    protected $relatedLinkURL;
    protected $shortDescription;
    protected $status;
    protected $tags;
    protected $title;
    protected $uploadDate;
    protected $visualizations;
    protected $thumbnail;

    const STATUS_MAP = [
        0 => 'queued',
        16 => 'encoding',
        32 => 'ready',
        24 => 'error'
    ];

    const THUMBNAIL_URI = 'https://video.mainstreaming.tv/image/{{contentId}}/poster';

    public function __construct(array $video) {
        $this->contentId = $video['contentId'];
        $this->customAttribute1 = $video['customAttribute1'];
        $this->customAttribute2 = $video['customAttribute2'];
        $this->customAttribute3 = $video['customAttribute3'];
        $this->customAttribute4 = $video['customAttribute4'];
        $this->customAttribute5 = $video['customAttribute5'];
        $this->customAttribute6 = $video['customAttribute6'];
        $this->customAttribute7 = $video['customAttribute7'];
        $this->customAttribute8 = $video['customAttribute8'];
        $this->customAttribute9 = $video['customAttribute9'];
        $this->customAttribute10 = $video['customAttribute10'];
        $this->duration = new \DateInterval($video['duration']);
        $this->encodingStatusPercent = $video['encodingStatusPercent'];
        $this->filename = $video['filename'];
        $this->idCategory = $video['idCategory'];
        $this->longDescription = $video['longDescription'];
        $this->referenceID = $video['referenceID'];
        $this->relatedLinkText = $video['relatedLinkText'];
        $this->relatedLinkURL = $video['relatedLinkURL'];
        $this->shortDescription = $video['shortDescription'];
        $this->status = $video['status'];
        $this->tags = $video['tags'];
        $this->title = $video['title'];
        $this->uploadDate = $video['uploadDate'];
        $this->visualizations = $video['visualizations'];
        $this->thumbnail = str_replace("{{contentId}}", $this->contentId, self::THUMBNAIL_URI);
    }

    public function getContentId()
    {
        return $this->contentId;
    }

    public function getStatus()
    {
        if(array_key_exists( $this->status, self::STATUS_MAP))
            return self::STATUS_MAP[ $this->status ];

        return 'error';
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getVisualizations()
    {
        return $this->visualizations;
    }
}

?>
