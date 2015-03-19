<?php
/***
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class LGD_Layer{
    /***
     * defines the index number of
     * the layer
     * 
     * @var int
     */
    public $d=0;
    public static $index=0;
    /**
     * A static array
     * which stores record of all 
     * layer instances
     * 
     * @var Array<Layer>
     */
    public static $allLayers=array();
    /**
     * color that is to be filled
     * in layer
     * 
     * @var Color|null
     */
    public $color=null;
    
    /**
     * transperancy 
     * or opaciy of
     * layer values [0-100]
     * 
     * @var int
     */
    public $trasnperancy=100;
    /**
     * height of layer
     * @var int
     */
    protected $height=0;
    /**
     *width of layer
     * @var int
     */
    protected $width=0;
    
    /**
     * the main image
     */
    public $image;
    /**
     * elements
     * @var LayerElements
     */
    protected $elements=array();
    
    
    public function __construct() {
        
        /**$this->image=$image;
        $this->height=imagesy($image);
        $this->width=imagesx($image); */
    ///    $this->layer=imagecreatetruecolor($this->width, $this->height);
    
//        imagefill($this->layer, 0 , 0, $this->color);
        self::$index++;
        self::$allLayers[self::$index]=$this;
    }
    /**
     * set background color
     * hex string | array rbga
     * @param $color string
     */
    public function setBackgroundColor($color){
        
        $this->color=new Color($color);
    }
    /**
     * set background color alpha
     * needed if u set color by opacity
     * from 0-127
     * @param $alpha int|127
     * @return void
     */
    public function setBackgroundAlpha($alpha=127){
        if(is_null($this->color)){
                $this->color=new Color();
        }
        $this->color->alpha=$alpha;
    }
    /**
     * get Layer of perticular index
     * @param int $index
     * @return Layer
     */
    public static function getLayerByIndex($index){
        return isset(self::$allLayers[$index])?(self::$allLayers[$index]):null;
    }
    /**
     * add images to layes
     *as images opacity 0-100
     * 
     *@param image resource $image
     *@param X-coordinate $x 
     *@param Y-coordinate $y 
     *@param opacity|0 $opacity
     *@return boolean
     */
    
    public function addElement(LGD_LayerElement $le){
        $this->elements[]=$le;
    }
    /**
     * mergers all elements
     * to layer
     * @return void
     */
    protected function mergeAll($image){                
        if(!is_null($this->color)){
            $bg=imagecreatetruecolor(imagesx($image), imagesy($image));          
            imagefill($bg, 0, 0, $this->color->getColor($bg));
            imagecopy($image, $bg, 0, 0, 0, 0, imagesx($bg), imagesy($bg));
        }
        foreach ($this->elements as $e){
            imagecopy($image, $e->image, $e->x, $e->y, 0, 0, $e->width, $e->height);
        }
    }
    /**
     * get current layer
     * @param $image resource
     * @return void
     */
    public function allElemetsTo($image){
        $this->mergeAll($image);
    }
    public static function toImage($image){
       foreach(self::$allLayers as $layer){
           $layer->allElemetsTo($image);
       }
    }
    
}


