<?php
class LGD_Htmljson{
	
	private $json;
	private $token="layers";

	public function __construct($json){
		$this->json=json_decode($json,true);
	}

	public function setjson($json){
		$this->json=json_decode($json,true);
	}

	public function getjson(){
		return $this->json;
	}

	private function getElements($jelements){
		$elements=array();
		$i=0;
		foreach ($jelements as $e) {
			if($i++>=1){
				//break;
			}



			if($e['type']=='text'){
				if(intval($e['height'])!=0 || intval($e['width'])!=0 ){
					$background=new LGD_Border(0,$e['background']['color']);
					if(isset($e['background']['colorAlpha'])){
						$background->color->alpha=$e['background']['colorAlpha'];
					}
							
					$ttfPath=AP."library/lgd/fonts/".$e['font']['family'].".ttf";
					
					$font=new LGD_Font($e['font']['size'],$e['font']['color'],$ttfPath,$e['font']['sizeType']);
					//var_dump($e);
					echo "--element: $i <br>";
					var_dump($e);
					$elements[]=new LGD_LayerTextElement($e['content'],intval($e['left']),intval($e['top']),$font,intval($e['width']),intval($e['height']),$background,-1*$e['rotation'],$e['opacity']*100);
					
				}
			}else{
				$border=new LGD_Border(intval($e['border']['width']),$e['border']['color']);
				if(isset($e['border']['colorAlpha'])){
					$border->color->alpha=$e['border']['colorAlpha'];
				}
					
				var_dump($e);
				$elements[]=new LGD_LayerImageElement($e['content'],intval($e['left']),intval($e['top']),$border,-1*$e['rotation'],$e['opacity']*100);
			}
			
			
			
		}
		return $elements;
	}

	private function getLayers(){
		$layers=array();
		$i=0;
		echo "<pre>";
		foreach ($this->json[$this->token] as $jlayerElements) {
			$elements=$this->getElements($jlayerElements);
			$l=new LGD_Layer();

			foreach($elements as $e){
				
				$l->addElement($e);
				
			}
			$layers[]=$l;
			echo "layer: $i <br>";
			if($i++>=4){
				//break;
			}
			
		}
		return $layers;
	}

	public function getImage(){
		$layers=$this->getLayers();
		//var_dump($layers);
		$flag['height']=1000;
		$flag['width']=1300;
		$img=new LGD_LayeredImage($flag);
		//$img->addLayrs($layers);
		return $img;

	}
}


