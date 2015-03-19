<?php
/**
 * create layered image
 * with LGD library
 * 
 * @license meSaphire
 */
class LGD_LayeredImage{
    /**
     * name of image
     *( without extension)
     * @var string
     */
    protected $name;
    /**
     * path / to / directory / of / image /
     * trailling "/" is required
     * @var string
     */
    protected $path;
    /**
     * 
     * full path of image
     * @var string
     */
    protected $fullpath;
    /**
     * type of image
     * defalurt "jpg"
     * @var string
     */
    protected $type="jpeg";
    
    protected function makeDir($path){
        $dirs=explode("/", $path);
        if(count($dirs)){
            $dirs=explode("\\", $path);
        }
        $path="";
        foreach($dirs as $dir){
            if($dir!=''){
                $path.=$dir."/";
                mkdir($path);
            }
            
        }
    }

    /**
     * sets path to the image
     * with trailling "/" sign
     * 
     * @param string $path path/to/image/
     */
    public function setPath($path){
        
        $path=str_replace(array('>','<','\'','\"','*','.'), "-", $path);
        if($path[strlen($path)-1]!='/' && $path[strlen($path)-1]!='\\')
            $path.="/";
        //var_dump(is_dir($path));
        if(!is_dir($path))
            $this->makeDir ($path);
        $this->path=$path;
        
    }
    public function setType($type){
        $this->type=$type;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setAutoName($prefix=""){
        return $this->name=uniqid($prefix);
    }
    
    // dimention details
    public $height;
    public $width;
    public $image;
    public $frame;
    
    private function returnType($filename)
    {
        
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);

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
                return null;
        }
    }
    public function setBaseImage($path){
        $creatimage="imagecreatefrom".$this->returnType($path);
        $this->image=$creatimage($path);
        $this->height=imagesy($this->image);
        $this->width=imagesx($this->image);
        $this->type=$this->returnType($path);
    }
    public function addFrame(LGD_Border $border){
        $this->frame=$border;
    }
    

    //constructers
    public $debug=false;
    public function __construct($flag,$backgroundColor=null){
        //var_dump($flag);
        
        if(is_array($flag)){
            $this->height=$flag['height'];
            $this->width=$flag['width'];
            $this->image=imagecreatetruecolor($this->width, $this->height);
            $color=new LGD_Color($backgroundColor);
            $color=$color->getColor($this->image);
            imagefill($this->image, 0, 0, $color);
        }else{
            $this->setBaseImage($flag);
        }
    }
    // layer parts
    protected $created=false;
    protected function attachFrame(){
        if(!is_null($this->frame)){
            $this->image=$this->frame->renderBorder($this->image);
        }
    }
    public function makeImage(){
        if(!$this->created){
            LGD_Layer::toImage($this->image);
            $this->attachFrame();
            $this->created=true;
        }
        
    }
    public function saveTo($path,$prefixname=''){
        $this->makeImage();
        $this->setPath($path);
        $this->name=$this->setAutoName($prefixname);
        $this->fullpath=$this->path.$this->name.'.'.$this->type;
        $imagetypefunction="image".$this->type;
        $imagetypefunction($this->image,  $this->fullpath);
        imagedestroy($this->image);
        return $this->fullpath;
        
    }
    public function show(){
        $this->makeImage();
        if(!$this->debug){
           header("content-type: image/".$this->type);
           $imagetypefunction="image".$this->type;
           $imagetypefunction($this->image,null);     
         }
         imagedestroy($this->image);
    }
}
