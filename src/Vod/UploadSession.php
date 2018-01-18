<?php
namespace riccardo993\mainstreamingtv\Vod;

class UploadSession{
    protected $uploadPath;

    public function __construct($array) {

        $this->uploadPath = $array['uploadPath'] ?? null;
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function getSecureUploadPath()
    {
        $array = parse_url($this->uploadPath);
        $array['scheme'] = "https";
        return http_build_url($array);
    }
}
?>
