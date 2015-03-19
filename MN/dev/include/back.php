<style type="text/css">
	.back{
		position: absolute;
		top: 0;
		left: 0;
		z-index: -1;
		height: 100%;
		width: 100%;
		overflow: hidden;
	}
	html,body{
		overflow-y: visible;
	}
	.roundies{
		border-radius: 100%;
		position: absolute;
		text-align: center;
		display: table-cell;
		transition: 2s opacity;
		color: hsl(0, 100%, 100%);
		opacity: 0;
		/* border: 1px solid hsl(0, 0%, 0%); */
		display: list-item;
		list-style: none;
		/*border: 1px solid black;*/

	}
	.roundies span{
		display: inline-block;
		vertical-align: middle;
  		line-height: normal;     
	}
	.homeslides{
		background: hsla(0, 0%, 100%,0.7)!important;
	}
	.home{
		background: hsla(240, 8%, 97%,0.8)
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	var $b=$(".back");
	var $r=$('<div valign="middle" class="roundies"><span></span></div>');
	var minSize=10;
	var ratio=1.15;
	var mouseL=0;
	var mouseT=0;
	var mouseR=0;
	var layer=0;
	var count=20;
	var timeouts=[];
	var pt=minSize*Math.pow(ratio,count)*100/$(window).width(); //positionTolerance
	var reviewOn=false;
	var slideCount=3;
	var reviews=["It is a great way to learn -India",
	"New defination of learning -Spain",
	"It is cool to talk with Alex",
	"Just amazing",
	"I will Actually learn from this",
	"Helps us to solve our problems",
	"Super fun",
	"Need more courses here",
	"Coding is never fun like this",
	"Loved it",
	"Best for beginners",
	"It is a great way to learn -India",
	"New defination of learning -Spain",
	"It is cool to talk with Alex",
	"Just amazing",
	"I will Actually learn from this",
	"Helps us to solve our problems",
	"Super fun",
	"Need more courses here",
	"Coding is never fun like this",
	"Loved it",
	"Best for beginners"]
	
	var x=0;
	function makeBubbles(){

		for(var i=count-1,j=count-1;i>=0;i--,j+=i){
			var $r=getRoundies();
			$b.append($r);		
			$r.css(getCSS());
			

			timeouts.push(setTimeout(function(obj){
				obj.css("opacity",1)
				
			},(100),$r))
			
		}
		var change=0;
		$(window).scroll(function(e){
			//console.log(e);
			var maxScroll=$(document).height() - $(window).height()
			
			
			var scroll=$(window).scrollTop()/maxScroll;
			var lock=false;
		//	if(!lock){
				lock=true;
				$(".roundies").each(function(i,o){
					var $o=$(o);

					$o.css({
						//top:(parseFloat($o.css("top"))+((mouseT+scroll)*(Math.pow(1.45,$o.attr("layer")))))+"px"
						//top:(parseFloat($o.css("top"))+((mouseT-scroll)*(Math.pow(1.3,$o.attr("layer")))))+"px"
					//	top:parseFloat($o.css('top'))+((scroll-change)*Math.pow(1.8,$o.attr("layer")))+"px"
					});
				});
//				mouseL=e.pageX;
				change=scroll;
				///console.log(change)
				lock=false;
			//}
		})
		mouseL=0;
		mouseR=0;
		$(window).mousemove(function(e){
			lock=false;

			if(!lock){
				lock=true;
				$(".roundies").each(function(i,o){
					var $o=$(o);
					$o.css({
						left:(parseFloat($o.css("left"))+((mouseL-e.pageX)*(Math.pow(1.35,$o.attr("layer"))))/1000)+"px",
						top:(parseFloat($o.css("top"))+((mouseR-e.pageY)*(Math.pow(1.35,$o.attr("layer"))))/1000)+"px"
					});
				});
				mouseL=e.pageX;
				mouseR=e.pageY;
				lock=false;
			}
			
		})
	}
	makeBubbles();

	function getRoundies(){
		var t;
		if(reviewOn){
			t=$r.clone().html("<span>"+reviews[layer]+"</span>");
		}else{
			t=$r.clone();
		}
		
		layer+=1;
		return t.attr("layer",layer);
	}
	function getCSS(){
		var size=getSize();
		var t=getTop();
		return {
			
			background:getColor(),
			top:t,
			left:getLeft(t),
			padding:size/2+"px",
			fontSize: size/5+"px",
			height:size+"px",
			width:size+"px",
			lineHeight:size+"px"
		};
		
	}
	function getSize(){
		minSize*=ratio
		return minSize;
	}
	function getColor(){
		var opacity =(layer*0.025);
		return "hsla("+getRand(0,359)+",62%,63%,"+(opacity)+")";
	}

	function getTop(){
		return getRand(0,100)+"%";
	}
	function getSlideId(top){
		/*returns 0 , 1 , 2, 3*/
		return Math.floor(top/getSlideHeight());
	}
	function getK(top){
		return (getSlideId(top)*getSlideHeight())+(getSlideHeight()/2);
	}
	function getReginPoint(top,hr,vr){
		
		return 50-(hr*Math.sqrt(1-Math.pow((top-getK(top))/vr,2)));
	}
	//top=y hr=a vr=b

	function getReginPointPlus(top,hr,vr){
		
		return 50+(hr*Math.sqrt(1-Math.pow((top-getK(top))/vr,2)));
	} 

	function getLeft(top){

		top=parseFloat(top);
		
		var bhr=50,bvr=getSlideHeight()/2,shr=30,svr=16;
		
		p=getReginPoint(top,bhr,bvr);
		//s=(2*bhr)-p;
		s=getReginPointPlus(top,bhr,bvr);;
		//console.log(layer,(getSlideHeight()/2-svr),(getSlideHeight()/2+svr),top%getSlideHeight(),top)
		if((getSlideHeight()/2-svr)<top%getSlideHeight() && top%getSlideHeight()<(getSlideHeight()/2+svr)){
			//q=bhr-shr+getReginPoint(top,shr,svr);
			q=getReginPoint(top,shr,svr);
			
			//r=(2*bhr)-q
			r=getReginPointPlus(top,shr,svr);
			//console.log(p,q,r,s);
			if(getRand(1,2)>1){
				return getRand(p,q)+"%";
				
			}else{
				return getRand(r,s)+"%";
			}
		}else{
		//	console.log(p,s);
			return getRand(p,s)+"%";
		}
		
		
		//return Math.sqrt(Math.pow(radius,2)-Math.pow(getRand(0,radius)-bR,2)) +50+"%";
	}
	function getRand(from,to){

		return Math.floor((Math.random()*Math.floor(to))+Math.floor(from));
	}
	function getSlideHeight(){
		return 100/slideCount;
	}
});
	
</script>
<section class="back">
</section>