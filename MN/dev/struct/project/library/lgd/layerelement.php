<?php
class LGD_LayerElement{
    /**
     * x coodinate of element
     * @var int|0
     */
    public $x;
    /**
     * y coodinate of element
     * @var int | 0
     */
    public $y;
    /**
     * opacity of element
     * @var int | 0
     */
    public $opacity;
    /**
     * actaul GD image element
     * 
     * @var resource
     */
    public $image;
    /**
     * height image element
     * 
     * @var int
     */
    public $height;
    /**
     * width image element
     * 
     * @var int
     */
    public $width;
    /**
     * set roatation in degrees
     * 
     * 
     * 
     * @var int|0
     */
    public $rotation=0;
    
    /**
     * layer elements 
     * to be attached in layers
     * like images
     * 
     * @param  resource $image
     * @param  int $x
     * @param int $y
     * @param Border $border 
     * @param int $opacity
     * @param int $rotation int
     */
    public function __construct($image,$x,$y,$border,$opacity,$rotation=0 ){
        
        if(!is_null($border)){
            $this->image=$border->renderBorder($image);
            
        }else{
            $this->image=$image;
        }
        if($rotation!=0 && is_numeric($rotation)){
            $this->rotation=$rotation;
            $this->image=imagerotate($this->image, $rotation,imagecolorallocatealpha($this->image, 255, 255, 255, 127));
        }
        if(!is_null($this->image)){
            
        $this->width=imagesx($this->image);
        $this->height=imagesy($this->image);
        }
        $this->x=$x;
        $this->y=$y;
        $this->opacity=$opacity;
    }
    /**
     *
     * ration in 
     * 0.5 resize to 50%
     * 2 doubles the size
     * @param int $ratio 
     */
    public function resizeByRatio($ratio){
        
        $dst_w= ceil($ratio*$this->width);
        $dst_h= ceil($ratio*$this->height);
        
        $new=imagecreatetruecolor($dst_w, $dst_h);
        imagesavealpha($this->image, true);
        imagesavealpha($new, true);
        imagecopyresized($new, $this->image, 0, 0, 0, 0, $dst_w, $dst_h, $this->width, $this->height);
        imagedestroy($this->image);
        $this->height=$dst_h;
        $this->width=$dst_w;
        $this->image=$new;        
        
    }
    
}

?>
