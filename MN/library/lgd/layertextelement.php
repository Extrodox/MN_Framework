<?php
class LGD_LayerTextElement extends LGD_LayerElement{
    public $text;
    public $width;
    public $height;
    public $font;
    public $color;
    public $lines;
    public $lineSize;
    /**
     * layer image element
     * to be attached in layers
     * 
     * @param $path string
     * @param $x int
     * @param $y int
     * @param $background Border
     * @param $opacity int
     * @param $rotation int
     */
    public function __construct($text, $x, $y,LGD_Font $font,$width,$height=null,LGD_Border $background=null,$rotation=0,$opacity=100) {
        $this->width=$width;
        $this->height=$height;
        $this->text=$text;
        $this->font=$font;
        
        $this->lineSize= ceil($this->width/($this->font->width+2));
        $image=$this->textToImage($text);
        
        parent::__construct($image, $x, $y,$background, $opacity ,$rotation);
    }
    public function is_overflow($line){
        if((strlen($line)*$this->font->width)>$this->width*2){
         //   return true;
            $box = imagettfbbox($this->font->point, 0, $this->font->file,$line);
            //echo $line."<br><pre>";
            //var_dump($box);
            if(($box[2]-$box[0])>$this->width){
                return true;
            }
            return false;
        }
        return false;
    }
    public function lineFromWords($words){
        $tmpwords=array();
        foreach($words as $word){
                    if($this->is_overflow($word)){
                        for($i=0;$i<strlen($word);$i=($i+$this->lineSize>strlen($word))?strlen($word):$i+$this->lineSize){
                            $tmpwords[]=substr($word, $i,$this->lineSize);
                        }
                    }else{
                        $tmpwords[]=$word;
                    }
                }
                return $tmpwords;
    }
    public function getTextBoxHeight($text){
        $b=imagettfbbox($this->font->point, 0, $this->font->file, $text);
        return $b[0]-$b[5];
    }
    public function getLines($text){
        $final=array();
        $lines=explode("\n", $text);
        
        foreach($lines as $line){
            if($this->is_overflow($line)){
                
                $words=explode(" ", $line);
                $tmpwords=$this->lineFromWords($words);
                
                for($i=0,$tmpline="";$i<count($tmpwords);$i++){
                    if($tmpline==""){
                        $tmpline=$tmpwords[$i];
                    }else if(!$this->is_overflow($tmpline." ".$tmpwords[$i])){
                        $tmpline=$tmpline." ".$tmpwords[$i];
                    }else{

                        $i--;
                            $final[]=array(
                                "text"=>$tmpline,
                                "height"=>$this->getTextBoxHeight($tmpline)
                                    );
                            $tmpline="";
                    }
                    
                }
                
                $final[]=array(
                        "text"=>$tmpline,
                        "height"=>$this->getTextBoxHeight($tmpline)
                            );
            }else{
                $final[]=array(
                        "text"=>$line,
                        "height"=>$this->getTextBoxHeight($line)
                            );
            }
        }

        return $final;
    }
    public function textToImage($text){
        $this->lines=$this->getLines($text);
        
        if(is_null($this->height)){
            //$this->height=count($this->lines)*($this->font->height+2);
            $this->height=0;
            foreach ($this->lines as $line){
                $this->height+=$line['height']+ceil($line['height']*0.60);
            }
            
        }
        $image=imagecreatetruecolor($this->width, $this->height+10);
        imagefill($image, 0, 0, imagecolorallocatealpha($image,255, 255, 255, 127));
        $i=0;
        foreach($this->lines as $line){
            //$box = imagettfbbox($this->font->point, 0, $this->font->file, $line);
            //$i=$i+($box[1]-$box[5])+5;
            //$i*($this->font->height+1)
            
            $i+=$line['height']+ceil($line['height']*0.60);
            imagettftext($image, $this->font->point , 0, 0,$i, $this->font->color->getColor($image), $this->font->file, $line['text']);
        }
        
        return $image;
    }
    
}
?>