<?php
class LGD_Font{
    public $point=14;
    public $pixel=14;
    public $height;
    public $width;
    public $file;
    public $color;
    
    public function __construct($size=14,$color="#000",$file="FugazOne-Regular.ttf",$sizeType="px") {
        if($file=="FugazOne-Regular.ttf"){
            $file=AP."library/lgd/fonts/".$file;
        }
        
        $this->color=new LGD_Color($color);
        $this->file=$file;
        
        $this->pixel=$size;
        $this->point=ceil($size*0.75);
        
        
        $this->width=$this->point;
        $this->width=($this->width>$this->point-2)?$this->width:$this->point-2;
        
        $this->height=$size;
        
    }
    
}