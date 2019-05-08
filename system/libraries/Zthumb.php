<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
author: uzzal
email: uzzal.me@gamil.com
website: http://uzzal.wordpress.com
use: creates thumbnail of a image
currently supports 4formats: jpg, gif, png, wbmp
-----------doc---------------------------------------------------------
createThumb($filename,$sourcepath,$thumbpath,$percent,$height)	//filename is the just name of the file with ext.
												    if both percent and height are given then percent treated as width
--------------------FOR AUTO RATIO-------------------------------------------
createThumb($filename,$sourcepath,$thumbpath,$size,$fitwidth,$autoratio)
												here $size is the size of height or width dependes of $fitwidth if $fitwidth is true then size is width and otherwise height
												to activate the autoratio $autoratio must be true

------coution---------------------------------------------------------
if percent is greater than 100% then it is treated as default size of 25%
-----------example---------------------------------------------------
$gd=new Zthumb();
$gd->createThumb("test.gif","images","thumb",100,80);

----autoratio example-------------
$gd->createThumb("test.gif","images","thumb",330,true,true);

----auto adjust example-------------
$gd->createThumb("test.gif","images","thumb",330,200,true);

*/

class Zthumb{
//variables
var $_filename;
var $_outputfilename;
var $_percent;
var $_width;
var $_height;
var $_owidth;
var $_oheight;
var $_otype;
var $_source;
var $_thumb;
var $_thumbpath;
var $_sourcepath;
var $_debug;
var $_fitwidth;
var $_size;

//1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 6 = BMP,

//constructor
function Zthumb(){
}

//private functions
function setPath($path,$opt=""){	
	$len=strlen($path);
	$lastchar=substr($path,$len-1,$len);
	
	if($opt!=""){		
		if($lastchar=="/"){
			$this->_sourcepath=$path;
		}else{
			$this->_sourcepath=$path."/";
		}		
	}else{		
		if($lastchar=="/"){
			$this->_thumbpath=$path;
		}else{
			$this->_thumbpath=$path."/";
		}		
	}
}

function setFileSizePercent($percent){
if($percent>1 and $percent<100){
$percent=$percent/100;
}elseif($percent>100){
$percent=0.25;
}

$this->_width = $this->_owidth * $percent;
$this->_height = $this->_oheight * $percent;
}

function setFileSizeFixed($width,$height){
$this->_width = $width;
$this->_height = $height;
}

function _setFileSizeAuto($fitwidth,$fitheight){		
	if($this->_owidth<$this->_oheight){	//width priority		
		$this->_setFileSizeAutoAdjust($fitheight,false);
	}else{	//height priority		
		$this->_setFileSizeAutoAdjust($fitwidth,true);
	}	
}

function fitWidth($size){
	$this->_fitwidth=true;
	$this->_size=$size;
}

function fitHeight($size){
	$this->_fitwidth=false;
	$this->_size=$size;
}

function _setFileSizeAutoAdjust($size,$fitwidth){
	if($this->_fitwidth){
		$size=$this->_size;
	}
	
	if($fitwidth==true or $this->_fitwidth==true){
		if($this->_owidth>$size){		
			$this->_width=$size;
			$this->_height=(($this->_oheight/$this->_owidth)*$size);		
		}else{
			$this->_width=$this->_owidth;
			$this->_height=$this->_oheight;
		}
	}else{
		if($this->_oheight>$size){
			$this->_height=$size;
			$this->_width=(($this->_owidth/$this->_oheight)*$size);
		}else{
			$this->_width=$this->_owidth;
			$this->_height=$this->_oheight;
		}
	}
}

function getImageInfo(){
list($this->_owidth,$this->_oheight,$this->_otype)=getimagesize ($this->_sourcepath.$this->_filename);
}

function getImageResource(){
	$this->getImageInfo();
	switch($this->_otype){
	case '1':/* GIF */$this->_source = imagecreatefromgif($this->_sourcepath.$this->_filename); break;
	case '3':/* PNG */$this->_source = imagecreatefrompng($this->_sourcepath.$this->_filename); break;
	case '6':/*WBMP */$this->_source = imagecreatefromwbmp($this->_sourcepath.$this->_filename); break;
	default: $this->_source = imagecreatefromjpeg($this->_sourcepath.$this->_filename);	//type 2
	}
}

function writeFile(){
if($this->_outputfilename==""){
	$this->_outputfilename=$this->_filename;
}
switch($this->_otype){
	case '1':/* GIF */imagegif($this->_thumb,$this->_thumbpath.$this->_outputfilename); break;
	case '3':/* PNG */imagepng($this->_thumb,$this->_thumbpath.$this->_outputfilename); break;
	case '6':/* BMP */imagewbmp($this->_thumb,$this->_thumbpath.$this->_outputfilename); break;
	default: imagejpeg($this->_thumb,$this->_thumbpath.$this->_outputfilename);	//type 2
	}
}


//public functions

function setDebug($debug=true){
	$this->_debug=$debug;
}

function setFileName($filename=""){
	$this->_outputfilename=$filename;
}

function createThumb($filename,$outputfilename,$sourcepath,$thumbpath,$percent="",$height="",$autoratio=false){
	if($filename!=""){
		$this->setPath($sourcepath,"src");
		$this->setPath($thumbpath);

		if(!file_exists($this->_thumbpath)){
		mkdir($this->_thumbpath,0777,true);
		}
		
		$this->_filename=$filename;
		$this->_outputfilename=$outputfilename;

		$this->getImageResource();

		if($height!="" and $percent!="" and $autoratio==false){
		if($this->_debug){echo "Debug!!!: Fixed Size";}
		$this->setFileSizeFixed($percent,$height);
		}elseif($percent!="" and $height=="" and $autoratio==false){
		if($this->_debug){echo "Debug!!!: Percent";}
		$this->setFileSizePercent($percent);
		}elseif($autoratio){
		if($this->_debug){echo "Debug!!!: Auto Ratio";}
		$this->_setFileSizeAuto($percent,$height);
		}

		$this->_thumb = imagecreatetruecolor($this->_width, $this->_height);
		imagecopyresampled($this->_thumb, $this->_source, 0, 0, 0, 0, $this->_width, $this->_height, $this->_owidth, $this->_oheight);
		$this->writeFile();
	}
}

}//class end
?>