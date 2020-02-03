<?php

class Uploader

{
    public $source;
    public $sourceName;
    public $sourceSize;
    public $extension;
    public $destinationPath;
    public $destinationName;
    public $baseDir;
    public $result;
    public $insertedId;
    public $allowCDN = true;
    /**
     * Allow image type
     */
    private $imageTypes = array('png', 'jpg', 'gif', 'jpeg', 'webp');
    private $imageSizes = array(75, 200, 600, 920);
    /**
     * Allowed File types
     */
    private $fileTypes = array(
        'doc',
        'xml',
        'exe',
        'txt',
        'zip',
        'rar',
        'doc',
        'mp3',
        'jpg',
        'png',
        'css',
        'psd',
        'pdf',
        '3gp',
        'ppt',
        'pptx',
        'xls',
        'xlsx',
        'html',
        'docx',
        'fla',
        'avi',
        'mp4',
        'swf',
        'ico',
        'gif',
        'webm',
        'jpeg'
    );
    /**
     * Allowed video types
     */
    private $videoTypes = array('mp4');
    private $audioTypes = array('mp3');
    private $sourceFile;
    private $linkContent = '';

    private $uploadedFiles = array();
    private $dbType;
    private $dbTypeId;
    private $type;
    //max sizes
    private $maxFileSize = 10000000;

    //allow Animated gif
    private $maxImageSize = 10000000;
    private $maxVideoSize = 10000000;
    private $maxAudioSize = 10000000;
    private $animatedGif = true;
    private $error = false;
    private $errorMessage;

    /**
     * @param $source
     * @param string $type
     * @param mixed $validate
     * @param bool $fromFile
     * @param bool $isLink
     */
    public function __construct($source, $type = "image", $validate = false, $fromFile = false, $isLink = false)
    {
        //$source = is_string($source) ? fire_hook('path.local', $source) : $source;
        $this->source = $source;
        $this->type = $type;
        $this->maxFileSize = config("max-file-upload", $this->maxFileSize);
        $this->maxVideoSize = config("max-video-upload", $this->maxVideoSize);
        $this->maxAudioSize = config("max-audio-upload", $this->maxAudioSize);
        $this->maxImageSize = config("max-image-size", $this->maxImageSize);
        $this->animatedGif = config("support-animated-image", $this->animatedGif);
        //$this->imageTypes = fire_hook('uploader.types.image', explode(',', config('image-file-types', 'jpg,png,gif,jpeg,webp')));
        $this->imageTypes =  config('image-file-types', 'jpg,png,gif,jpeg,webp');
        $allow_image_types = array();
        foreach ($allow_image_types as $type) {
            if (!in_array($type, $this->imageTypes)) {
                $this->imageTypes[] = $type;
            }
        }
        $this->videoTypes = config('video-file-types', 'mp4,mov,wmv,3gp,avi,flv,f4v,webm');
        $this->audioTypes = config('audio-file-types', 'mp3,aac,wma,webm');
        $this->fileTypes = config('files-file-types', 'doc,xml,exe,txt,zip,rar,mp3,jpg,png,css,psd,pdf,3gp,ppt,pptx,xls,xlsx,docx,fla,avi,mp4,swf,ico,gif,jpeg,webm,webp');

        if (!$fromFile) {
            if ($source and $this->source['size'] != 0) {
                $this->source = $source;
                $this->sourceFile = $this->source['tmp_name'];
                $this->sourceSize = $this->source['size'];
                $this->sourceName = $this->source['name'];
                $name = pathinfo($this->sourceName);
                if (isset($name['extension'])) $this->extension = strtolower($name['extension']);

                $this->confirmFile();

            } else {
                if (!$validate) {
                    $this->error = true;
                    $this->errorMessage = lang("failed-to-upload-file");
                } else {
                    $this->validate($validate);
                }
            }
        } else {
            $this->source = $this->sourceFile = $this->sourceName = $source;
            $this->extension = pathinfo($this->source, PATHINFO_EXTENSION);
            $curl = curl_init();
            if (file_exists($this->source)) {
                $this->linkContent = file_get_contents($this->source);
            } else {
                curl_setopt_array($curl, array(CURLOPT_URL => str_replace(' ', '%20', $this->source), CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_POSTFIELDS => ""));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                $this->linkContent = $err ? '' : $response;
            }
            if ($this->linkContent) {
                if ($isLink) {
                    $headers = get_headers($this->source, 1);
                    $size = 0;
                    try {
                        if (is_array($headers['Content-Length'])) {
                            foreach ($headers['Content-Length'] as $size) {
                                if ($size) {
                                    break;
                                }
                            }
                        } else {
                            $size = $headers['Content-Length'];
                        }
                    } catch (Exception $e) {
                        print(debug_backtrace()[2]['file']);
                        print(debug_backtrace()[2]['line']);
                        exit;
                    }
                    $this->sourceSize = $size;
                    if ($url = parse_url($this->source)) {
                        $this->extension = pathinfo($url['path'], PATHINFO_EXTENSION);
                    }
                } else {
                    $this->sourceSize = filesize($this->source);
                }
                $this->confirmFile();
            } else {
                $this->error = true;
                $this->errorMessage = lang("failed-to-upload-file");
            }
        }

        //load our libraries
        require_once path("includes/libraries/PHPImageWorkshop/autoload.php");
        if ($this->animatedGif) require_once path("includes/libraries/gif_exg.php");

        //confirm the creation of uploads directory
        if (!is_dir(path('storage/uploads/'))) {
            @mkdir(path('storage/uploads/'), 0777, true);
            $file = @fopen(path('storage/uploads/index.html'), 'x+');
            fclose($file);
        }

    }

    public function confirmFile()
    {
        switch ($this->type) {
            case 'image':
                if (!in_array($this->extension, $this->imageTypes)) {
                    $this->errorMessage = lang("upload-file-not-valid-image");
                    $this->error = true;
                }
                if ($this->sourceSize > $this->maxImageSize) {
                    $this->errorMessage = lang("upload-image-size-error", array('size' => format_bytes($this->maxImageSize)));
                    $this->error = true;
                }
                break;
            case 'video':
                if (!in_array($this->extension, $this->videoTypes)) {
                    $this->errorMessage = lang("upload-file-not-valid-video");
                    $this->error = true;
                }
                if ($this->sourceSize > $this->maxVideoSize) {
                    $this->errorMessage = lang("upload-video-size-error", array('size' => format_bytes($this->maxVideoSize)));
                    $this->error = true;
                }
                break;
            case 'audio':
                if (!in_array($this->extension, $this->audioTypes)) {
                    $this->errorMessage = lang("upload-file-not-valid-audio");
                    $this->error = true;
                }
                if ($this->sourceSize > $this->maxAudioSize) {
                    $this->errorMessage = lang("upload-audio-size-error", array('size' => format_bytes($this->maxAudioSize)));
                    $this->error = true;
                }
                break;
            case 'file':
                if (!in_array($this->extension, $this->fileTypes)) {
                    $this->errorMessage = lang("upload-file-not-valid-file");
                    $this->error = true;
                }

                if ($this->sourceSize > $this->maxFileSize) {
                    $this->errorMessage = lang("upload-file-size-error", array('size' => format_bytes($this->maxFileSize)));
                    $this->error = true;
                }
                break;
        }

        if (!$this->error) {
            $confirm_file = array('status' => !$this->error, 'message' => $this->errorMessage);
            $this->error = !$confirm_file['status'];
            $this->errorMessage = $confirm_file['message'];
        }
    }

    /**
     * Validate upload files for multiple uploads
     * @param array $files
     * @return void
     */
    public function validate($files)
    {
        $isError = false;
        foreach ($files as $file) {
            $pathInfo = pathinfo($file['name']);
            $this->extension = strtolower($pathInfo['extension']);
            $this->sourceSize = $file['size'];
            switch ($this->type) {
                case 'image':
                    if (!in_array($this->extension, $this->imageTypes)) {
                        $this->errorMessage = lang("upload-file-not-valid-image");
                        $this->error = true;
                    }
                    if ($this->sourceSize > $this->maxImageSize) {
                        $this->errorMessage = lang("upload-file-size-error", array('size' => format_bytes($this->maxImageSize)));
                        $this->error = true;
                    }
                    break;
                case 'video':
                    if (!in_array($this->extension, $this->videoTypes)) {
                        $this->errorMessage = lang("upload-file-not-valid-video");
                        $this->error = true;
                    }
                    if ($this->sourceSize > $this->maxVideoSize) {
                        $this->errorMessage = lang("upload-file-size-error", array('size' => format_bytes($this->maxVideoSize)));
                        $this->error = true;
                    }
                    break;
                case 'audio':
                    if (!in_array($this->extension, $this->audioTypes)) {
                        $this->errorMessage = lang("upload-file-not-valid-audio");
                        $this->error = true;
                    }
                    if ($this->sourceSize > $this->maxAudioSize) {
                        $this->errorMessage = lang("upload-file-size-error", array('size' => format_bytes($this->maxAudioSize)));
                        $this->error = true;
                    }
                    break;
                case 'file':
                    if (!in_array($this->extension, $this->fileTypes)) {
                        $this->errorMessage = lang("upload-file-not-valid-file");
                        $this->error = true;
                    }

                    if ($this->sourceSize > $this->maxFileSize) {
                        $this->errorMessage = lang("upload-file-size-error", array('size' => format_bytes($this->maxFileSize)));
                        $this->error = true;
                    }
                    break;
            }
        }
    }

    public function setFileTypes($types)
    {
        $this->fileTypes = $types;
        return $this;
    }

    public function noThumbnails()
    {
        $this->imageSizes = array(600, 920);
        return $this;
    }

    public function disableCDN()
    {
        $this->allowCDN = false;
    }

    public function enableCDN()
    {
        $this->allowCDN = true;
    }

    /**
     * Method to get the file type
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Method to get the file type
     * @return string|null
     */
    public function getDBType()
    {
        return $this->dbType;
    }

    /**
     * Method to get the image width
     * @return null
     */
    function getWidth()
    {
        list($width, $height) = getimagesize($this->sourceFile);
        return ($width) ? $width : null;
    }

    /**
     * Method to get the image height
     * @return int
     */
    function getHeight()
    {
        list($width, $height) = getimagesize($this->sourceFile);
        return ($height) ? $height : null;
    }

    /**
     * Function to confirm file passes
     */
    public function passed()
    {
        return !$this->error;
    }

    /**
     * Function to set destination
     * @param $path
     * @return Uploader
     */
    public function setPath($path)
    {
        $this->baseDir = "storage/uploads/" . $path;
        $path = path("storage/uploads/") . $path;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            //create the index.html file
            if (!file_exists($path . 'index.html')) {
                $file = fopen($path . 'index.html', 'x+');
                fclose($file);
            }
        }
        $this->destinationPath = $path;
        return $this;
    }

    /**
     *Function to resize image
     * @param int $width
     * @param int $height
     * @param string $fit
     * @param string $any
     * @return $this
     */
    public function resize($width = null, $height = null, $fit = "inside", $any = "down")
    {
        if ($this->error) return false;
        $fileName = md5($this->sourceName . time()) . '.' . $this->extension;
        $fileName = (!$width) ? '_%w_' . $fileName : '_' . $width . '_' . $fileName;

        $this->result = $this->baseDir . $fileName;

        if ($width) {
            $this->finalizeResize($fileName, $width, $height, $fit, $any);
        } else {
            foreach ($this->imageSizes as $size) {
                $this->finalizeResize(str_replace('%w', $size, $fileName), $size, $size, $fit, $any);
            }
        }

        return $this;
    }

    /**
     * @param $filename
     * @param $width
     * @param $height
     * @param $fit
     * @param $any
     */
    private function finalizeResize($filename, $width, $height, $fit, $any)
    {
        try {
            if ($this->animatedGif and $this->extension == "gif") {
                if ($this->linkContent) {
                    $Gif = new GIF_eXG($this->source, 1);
                } else {
                    $Gif = new GIF_eXG($this->sourceFile, 1);
                }
                $Gif->resize($this->destinationPath . $filename, $width, $height, 1, 0);
            } else {
                /**$wm = WideImage::load($this->sourceFile);
                 * $wm = $wm->resize($width, $height, $fit, $any);
                 * $wm->saveToFile($this->destinationPath.$filename);**/
                if ($this->linkContent) {
                    $image_details = getimagesizefromstring($this->linkContent);
                    if ($image_details['mime'] === 'image/webp') {
                        if (extension_loaded('exif')) {
                            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath($this->sourceFile, true);
                        } else {
                            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath($this->sourceFile);
                        }
                    } else {
                        $layer = PHPImageWorkshop\ImageWorkshop::initFromString($this->linkContent);
                    }
                } else {
                    if (extension_loaded('exif')) {
                        $layer = PHPImageWorkshop\ImageWorkshop::initFromPath($this->sourceFile, true);
                    } else {
                        $layer = PHPImageWorkshop\ImageWorkshop::initFromPath($this->sourceFile);
                    }
                }
                if ($width == 550) {
                    $layer->resizeInPixel($width, $height, true);
                } elseif ($width < 600) {
                    $layer->cropMaximumInPixel(0, 0, "MM");
                    $layer->resizeInPixel($width, $height);
                } else {
                    $layer->resizeToFit($width, $height, true);
                }

                $layer->save($this->destinationPath, $filename);
                $this->uploadedFiles[] = $filename;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
            $this->result = '';
        }
    }

    /**
     * Function to crop image
     * @param int $left
     * @param int $top
     * @param string $width
     * @param string $height
     * @return $this
     */
    public function crop($left = 0, $top = 0, $width = '100%', $height = '100%')
    {
        if ($this->error) return false;
        $fileName = md5($this->sourceName . time()) . '.' . $this->extension;
        $fileName = '_' . str_replace('%', '', $width) . '_' . $fileName;
        $this->result = $this->baseDir . $fileName;

        try {
            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath($this->sourceFile, true);
            $layer->cropInPixel($width, $height, $left, $top);
            $layer->save($this->destinationPath, $fileName);
            /**$wm = $wm->crop($left, $top, $width, $height);
             * $wm->saveToFile($this->destinationPath.$fileName);**/
            $this->uploadedFiles[] = $fileName;
        } catch (Exception $e) {
            $this->result = '';
        }

        return $this;
    }

    /**
     * Function to get result
     * @return string
     */
    public function result()
    {
        /*foreach ($this->uploadedFiles as $file_name) {
            fire_hook("upload.before", null, array($this, $file_name));
            fire_hook("upload", null, array($this, $file_name));
        }*/
        return $this->result;
    }

    /**
     * Function to save media to database
     * @param string $type
     * @param string $typeId
     * @param int $privacy
     * @param string $album
     * @param null $uid
     * @param string $entity_type
     * @param string $entity_id
     * @param null $ref_name
     * @param null $ref_id
     * @return $this
     */
    public function toDB($type = "", $typeId = "", $privacy = 1, $album = '', $uid = null, $entity_type = null, $entity_id = null, $ref_name = null, $ref_id = null)
    {
        $this->dbType = $type;
        $this->dbTypeId = $typeId;
        if ($this->error) return false;
        $userid = ($uid) ? $uid : get_userid();
        $entity_type = isset($entity_type) ? $entity_type : 'user';
        $entity_id = isset($entity_id) ? $entity_id : get_userid();
        $query = db()->query("INSERT INTO `medias` (`user_id`,`path`, `file_type`, `type`, `type_id`, `entity_type`, `entity_id`,`privacy`,`album_id`)
         VALUES('" . $userid . "','" . $this->result . "', '" . $this->type . "','" . $type . "', '" . $typeId . "','" . $entity_type . "', '" . $entity_id . "','" . $privacy . "','" . $album . "');
        ");
        if ($query) {
            $insertId = db()->insert_id;
            $this->insertedId = $insertId;
            //fire_hook('media-added', null, array($insertId, $this->result, $this->type, $type, $typeId, $privacy, $album));
        }
        return $this;
    }

    /**
     * Function to upload video
     */
    public function uploadVideo()
    {
        return $this->directUpload();
    }

    protected function directUpload()
    {
        if ($this->error) return false;
        $fileName = md5($this->sourceName . time()) . "." . $this->extension;
        $this->result = $this->baseDir . $fileName;
        if (move_uploaded_file($this->sourceFile, $this->destinationPath . $fileName)) {
            $this->uploadedFiles[] = $fileName;
        } elseif ($this->linkContent) {
            file_put_contents($this->destinationPath . $fileName, $this->linkContent);
            $this->uploadedFiles[] = $fileName;
        }
        return $this;
    }

    /**
     * function to upload file
     */
    public function uploadFile()
    {
        return $this->directUpload();
    }

    public function getError()
    {
        return $this->errorMessage;
    }
}