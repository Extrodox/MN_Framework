<?php
class LGD_Color{
    public $red=255;
    public $green=255;
    public $blue=255;
    public $alpha=127;
    
    public function __construct($color=null){
        if(!is_null($color)){
            $this->setColor($color);
        }            
    }
    public function setAlpha($alpha){
        $this->alpha=$alpha;
    }
    public function hex2Array($hex){
         $hex = str_replace("#", "", $hex);
 
         if(strlen($hex) == 3) {
             $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           } else {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
         }
         return array(
             "red"=>$r,
             "green"=>$g,
             "blue"=>$b,
             "alpha"=>0
         );

    }
    public function setColor($color){
        if(is_array($color)){
            foreach($color as $name=>$value){
                $this->$name=$value;
            }
        }
        else{
            return $this->setColor($this->hex2Array($color));
        }
    }
    
    public function getColor($image){
        return imagecolorallocatealpha($image, $this->red, $this->green, $this->blue,  $this->alpha);
    }
}