<?php
namespace riccardo993\mainstreamingtv\Vod;

class DownloadSession{
    protected $downloadPath;

    public function __construct($array) {

        $this->downloadPath = $array['downloadPath'] ?? null;
    }

    public function getDownloadPath()
    {
        return $this->downloadPath;
    }

    public function getSecureDownloadPath()
    {
        $array = parse_url($this->downloadPath);
        $array['scheme'] = "https";
        return http_build_url($array);
    }
}
?>
