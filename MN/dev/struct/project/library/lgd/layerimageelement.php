<?php
class LGD_LayerImageElement extends LGD_LayerElement{
    /**
     * path/to/a/valid/image
     * (jpeg,png,gif)
     * @var string
     */
    public $path;
    /**
     *
     * @param string $filename path/to/a/valid/image (jpeg,png,gif)
     * @return sting extension of file
     */
    private function returnType($filename)
    {
        
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);
        if(!isset($fileSuffix[1])){
            return "jpeg";
        }
        switch(strtolower($fileSuffix[1]))
        {
            case "jpg" :
            case "jpeg" :
            case "jpe" :
                return "jpeg";
            case "png" :
            case "gif" :
                return strtolower($fileSuffix[1]);
            default :
                return "jpeg";
        }
    }
    /**
     * layer image element
     * to be attached in layers
     * 
     * @param string $path path/to/a/valid/image (jpeg,png,gif)
     * @param int $x left-margin
     * @param int $y top-margin
     * @param Border $border Border object 
     * @param int $opacity opacity of element
     * @param int $rotation roation in degrees
     */
    public function __construct($path, $x, $y,LGD_Border $border=null,$rotation=0,$opacity=100) {
        $this->path=$path;
        
        $createimage=$this->returnType($path);
        $createimage="imagecreatefrom".$createimage;
        $image=$createimage($path);
        
        parent::__construct($image, $x, $y,$border, $opacity ,$rotation);
    }
    
}
?>