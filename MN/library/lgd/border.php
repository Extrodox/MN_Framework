<?php
/**
 * border object for 
 * LayerImageElements.
 * 
 */
class LGD_Border{
    public $width;
    public $color;    
    /**
     * border object for 
     * LayerImageElements.
     * (for LayerImageElement $width behaves 
     * as border thinkness)
     * and background for
     * LayerTextElement.
     * (for LayerTextElement $width behaves as padding)
     * 
     * 
     * @param float $width
     * @param hex string or Color $color 
     */
    public function __construct($width,$color) {
        $this->width=$width;
        $this->color=new LGD_Color($color);
    }
    /**
     * return an image
     * with border on it
     * to the supplied image
     * 
     * @param gd image resouce $image
     * @return gd image resouce
     */
    public function renderBorder($image){
        $x=imagesx($image);
        $y=imagesy($image);
        $xBack=$x+(2*  $this->width);
        $yBack=$y+(2*  $this->width);
        $bg=imagecreatetruecolor($xBack, $yBack);
        imagefill($bg, 0, 0, $this->color->getColor($bg));
        imagecopy($bg, $image, $this->width, $this->width, 0, 0, $x, $y);
        imagedestroy($image);
        return $bg;
    }
}
?>
