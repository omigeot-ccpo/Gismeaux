<?
//	svg2pdf fpdf class
//	sylvain briand
//	http://www.godisaduck.com/svg2pdf_fpdf_class
//	syb@godisaduck.com

//	cette class etendue est open source, toute modification devra cependant etre repertoriée~

//	v1.0
//	la class retraces les svg dans les pdf via fpdf (http://www.fpdf.org)
//	analyse du path sauf pour les commandes arc elliptique
//	analayse des formes rect, ellipse, circle, polyline, polygone.
//	les degradé sont pris en compte ainsi que la gestion des styles groupé.
//	la transparence n'est pas prise en compte


require('fpdf.php');

class PDF_SVG extends FPDF
{

	var $svg_gradient;		//	array - contient les infos sur les gradient fill du svg classé par id du svg
	var $svg_shadinglist;	//	array - contient les ids des objet shading
	var $gradients;			//	array - contient les infos sur les gradient fill du svg classé par ordre d'aparission
	var $color_chart;		//	array - chartre des couleur nommé pris en compte par le  svg
	var $svg_offset;		//	array - position et scaling general du svg
	var $svg_info;			//	array contenant les infos du svg voulue par l'utilisateur
	var $svg_style;			//	array contenant les style de groupes du svg
	var $svg_string;		//	String contenant le tracage du svg en lui même.

	function PDF_SVG($orientation='P',$unit='mm',$format='A4'){
		parent::FPDF($orientation,$unit,$format);
		$this->gradients = array();
		$this->svg_gradient = array();
		$this->svg_shadinglist = array();
		$this->svg_string = '';
		$this->svg_info = array(
		
		
		);
		
		$this->svg_style = array(
			array(
			'fill'				=> 'none',			//	pas de remplissage par defaut
			'fill-opacity'		=> 1,				//	remplissage opaque par defaut
			'fill-rule'			=> 'nonzero',		//	mode de remplissage par defaut
			'stroke'			=> 'none',			//	pas de trait par defaut
			'stroke-linecap'	=> 'butt',			//	style de langle par defaut
			'stroke-linejoin'	=> 'miter',			//	
			'stroke-miterlimit'	=> 4,				//	limite de langle par defaut
			'stroke-opacity'	=> 1,				//	trait opaque par defaut
			'stroke-width'		=> 0				//	epaisseur du trait par defaut
			)
		);
	
		$this->svg_offset = array(
			'xo' => 0, //	offset x position en pt
			'yo' => 0, //	offset y position en pt
			'xs' => 1, //	scale sur l'axe des x
			'ys' => 1, //	scale sur l'axe des y
		);
		
		$this->color_chart = array(
			'aliceblue' => "#F0F8FF",
			'antiquewhite' => "#FAEBD7",
			'aqua' => "#00FFFF",
			'aquamarine' => "#7FFFD4",
			'azure' => "#F0FFFF",
			'beige' => "#F5F5DC",
			'bisque' => "#FFE4C4",
			'black' => "#000000",
			'blanchedalmond' => "#FFEBCD",
			'blue' => "#0000FF",
			'blueviolet' => "#8A2BE2",
			'brown' => "#A52A2A",
			'burlywood' => "#DEB887",
			'cadetblue' => "#5F9EA0",
			'chartreuse' => "#7FFF00",
			'chocolate' => "#D2691E",
			'coral' => "#FF7F50",
			'cornflowerblue' => "#6495ED",
			'cornsilk' => "#FFF8DC",
			'crimson' => "#DC143C",
			'cyan' => "#00FFFF",
			'darkblue' => "#00008B",
			'darkcyan' => "#008B8B",
			'darkgoldenrod' => "#B8860B",
			'darkgray' => "#A9A9A9",
			'darkgreen' => "#006400",
			'darkgrey' => "#A9A9A9",
			'darkkhaki' => "#BDB76B",
			'darkmagenta' => "#8B008B",
			'darkolivegreen' => "#556B2F",
			'darkorange' => "#FF8C00",
			'darkorchid' => "#9932CC",
			'darkred' => "#8B0000",
			'darksalmon' => "#E9967A",
			'darkseagreen' => "#8FBC8F",
			'darkslateblue' => "#483D8B",
			'darkslategray' => "#2F4F4F",
			'darkslategrey' => "#2F4F4F",
			'darkturquoise' => "#00CED1",
			'darkviolet' => "#9400D3",
			'deeppink' => "#FF1493",
			'deepskyblue' => "#00BFFF",
			'dimgray' => "#696969",
			'dimgrey' => "#696969",
			'dodgerblue' => "#1E90FF",
			'firebrick' => "#B22222",
			'floralwhite' => "#FFFAF0",
			'forestgreen' => "#228B22",
			'fuchsia' => "#FF00FF",
			'gainsboro' => "#DCDCDC",
			'ghostwhite' => "#F8F8FF",
			'gold' => "#FFD700",
			'goldenrod' => "#DAA520",
			'gray' => "#808080",
			'grey' => "#808080",
			'green' => "#008000",
			'greenyellow' => "#ADFF2F",
			'honeydew' => "#F0FFF0",
			'hotpink' => "#FF69B4",
			'indianred' => "#CD5C5C",
			'indigo' => "#4B0082",
			'ivory' => "#FFFFF0",
			'khaki' => "#F0E68C",
			'lavender' => "#E6E6FA",
			'lavenderblush' => "#FFF0F5",
			'lawngreen' => "#7CFC00",
			'lemonchiffon' => "#FFFACD",
			'lightblue' => "#ADD8E6",
			'lightcoral' => "#F08080",
			'lightcyan' => "#E0FFFF",
			'lightgoldenrodyellow' => "#FAFAD2",
			'lightgray' => "#FAFAD2",
			'lightgreen' => "#90EE90",
			'lightgrey' => "#FAFAD2",
			'lightpink' => "#FFB6C1",
			'lightsalmon' => "#FFA07A",
			'lightseagreen' => "#20B2AA",
			'lightskyblue' => "#87CEFA",
			'lightslategray' => "#778899",
			'lightslategrey' => "#778899",
			'lightsteelblue' => "#B0C4DE",
			'lightyellow' => "#FFFFE0",
			'lime' => "#00FF00",
			'limegreen' => "#32CD32",
			'linen' => "#FAF0E6",
			'magenta' => "#FF00FF",
			'maroon' => "#800000",
			'mediumaquamarine' => "#66CDAA",
			'mediumblue' => "#0000CD",
			'mediumorchid' => "#BA55D3",
			'mediumpurple' => "#9370DB",
			'mediumseagreen' => "#3CB371",
			'mediumslateblue' => "#7B68EE",
			'mediumspringgreen' => "#00FA9A",
			'mediumturquoise' => "#48D1CC",
			'mediumvioletred' => "#C71585",
			'midnightblue' => "#191970",
			'mintcream' => "#F5FFFA",
			'mistyrose' => "#FFE4E1",
			'moccasin' => "#FFE4B5",
			'navajowhite' => "#FFDEAD",
			'navy' => "#000080",
			'oldlace' => "#FDF5E6",
			'olive' => "#808000",
			'olivedrab' => "#6B8E23",
			'orange' => "#FFA500",
			'orangered' => "#FF4500",
			'orchid' => "#DA70D6",
			'palegoldenrod' => "#EEE8AA",
			'palegreen' => "#98FB98",
			'paleturquoise' => "#AFEEEE",
			'palevioletred' => "#DB7093",
			'papayawhip' => "#FFEFD5",
			'peachpuff' => "#FFDAB9",
			'peru' => "#CD853F",
			'pink' => "#FFC0CB",
			'plum' => "#DDA0DD",
			'powderblue' => "#B0E0E6",
			'purple' => "#800080",
			'red' => "#FF0000",
			'rosybrown' => "#BC8F8F",
			'royalblue' => "#4169E1",
			'saddlebrown' => "#8B4513",
			'salmon' => "#FA8072",
			'sandybrown' => "#F4A460",
			'seagreen' => "#2E8B57",
			'seashell' => "#FFF5EE",
			'sienna' => "#A0522D",
			'silver' => "#C0C0C0",
			'skyblue' => "#87CEEB",
			'slateblue' => "#6A5ACD",
			'slategray' => "#708090",
			'slategrey' => "#708090",
			'snow' => "#FFFAFA",
			'springgreen' => "#00FF7F",
			'steelblue' => "#4682B4",
			'tan' => "#D2B48C",
			'teal' => "#008080",
			'thistle' => "#D8BFD8",
			'tomato' => "#FF6347",
			'turquoise' => "#40E0D0",
			'violet' => "#EE82EE",
			'wheat' => "#F5DEB3",
			'white' => "#FFFFFF",
			'whitesmoke' => "#F5F5F5",
			'yellow' => "#FFFF00",
			'yellowgreen' => "#9ACD32"
		);
		
	}
	
	function svgGradient($gradient_info){

		$n = count($this->gradients)+1;

		$return = "";
		
		if ($gradient_info['type'] == 'linear'){
			$this->gradients[$n]['type'] = 2;
			$x1 = ($gradient_info['info']['x1']*$this->svg_offset['xs']);
			$y1 = ($gradient_info['info']['y1']*$this->svg_offset['ys']);
			$x2 = ($gradient_info['info']['x2']*$this->svg_offset['xs']);
			$y2 = ($gradient_info['info']['y2']*$this->svg_offset['ys']);
			
			$matrix = preg_replace('/matrix\(([0-9\.\- ]*)\)/i','$1',$gradient_info['transform']);
			if ($matrix != ''){
				$tmp = split(' ',$matrix);

				$s = 1;
				if ($x1>$x2){
				
					$s = -1;
				}
			
				$a = $tmp[0];
				$b = $s*$tmp[1];
				$c = $tmp[2];
				$d = $tmp[3];
				$e = ($tmp[4]*$this->svg_offset['xs']);
				$f = ($tmp[5]*$this->svg_offset['ys']);
				

				
				$_x1 = ($a*$x1) + ($c*$y1) + $e;
				$_y1 = ($b*$x1) + ($d*$y1) + $f;
				
				$_x2 = ($a*$x2) + ($c*$y2) + $e;
				$_y2 = ($b*$x2) + ($d*$y2) + $f;
				
				

				
				$x1 = $_x1;
				$y1 = $_y1;
				
				$x2 = $_x2;
				$y2 = $_y2;

			}
			
			$y2 = $y1*2-$y2;
				
			$w = $x2-$x1;
			$h = $y2-$y1;
			
			$a = 1;
			$b = 0;
			$c = 0;
			$d = 1;
			$e = $this->svg_offset['xo']+$x1;
			$f = $this->svg_offset['yo']-$y1;
			$return .= sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm ', $a, $b, $c, $d, $e, $f);
			
			
			$this->gradients[$n]['coords']=array(
				'w'=> $w,
				'h'=> $h
			);
		
		}
		else if ($gradient_info['type'] == 'radial'){
		
			$this->gradients[$n]['type'] = 3;

			$this->gradients[$n]['coords']=array(
			
				'r'=> $gradient_info['info']['r']
				
			);
			
			
			
			$a = $this->svg_offset['xs'];
			$b = 0;
			$c = 0;
			$d = $this->svg_offset['ys'];
			$e = $this->svg_offset['xo']+($gradient_info['info']['x0']*$this->svg_offset['xs']);
			$f = $this->svg_offset['yo']-($gradient_info['info']['y0']);
			
			$return .= sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm ', $a, $b, $c, $d, $e, $f);
			
		}
	
		$this->gradients[$n]['color'] = array();
		
		$n_color = count($gradient_info['color']);
		for ($i = 0;$i<$n_color;$i++){
		
			$color = array (
				'color' => $gradient_info['color'][$i]['color'],
				'offset' => $gradient_info['color'][$i]['offset'],
				'opacity' => $gradient_info['color'][$i]['opacity']
			);
			
			array_push($this->gradients[$n]['color'],$color);
		
		}
		
		$return .= '/Sh'.count($this->gradients).' sh Q ';
		return $return;
		
	}

	function svgOffset ($attribs){
		
		$convert_mm = 2.835;
		
		$svg_w = preg_replace("/([0-9\.]*)(.*)/i","$1",$attribs['width']);
		$svg_h = preg_replace("/([0-9\.]*)(.*)/i","$1",$attribs['height']);
		$svg_u = preg_replace("/([0-9\.]*)(.*)/i","$2",$attribs['width']);
		
		switch($svg_u){
			case 'mm':
			$convert_svg = $convert_mm;
			break;
			default:
			$convert_svg = 1;
			break;
		}
		
		//
		switch ($this->svg_info['scale_u']){
			case 'mm':
			switch($this->svg_info['scale_r']){
				case 'width':
				$xscale = ($this->svg_info['scale_x']*$convert_mm)/($svg_w*$convert_svg);
				$yscale = ($this->svg_info['scale_x']*$convert_mm)/($svg_w*$convert_svg);
				break;
				case 'height':
				$xscale = ($this->svg_info['scale_y']*$convert_mm)/($svg_h*$convert_svg);
				$yscale = ($this->svg_info['scale_y']*$convert_mm)/($svg_h*$convert_svg);
				break;
				default:
				$xscale = ($this->svg_info['scale_x']*$convert_mm)/($svg_w*$convert_svg);
				$yscale = ($this->svg_info['scale_y']*$convert_mm)/($svg_h*$convert_svg);
				break;
			}
			break;
			
			default:
			switch ($this->svg_info['scale_r']){
				case 'width':
				$xscale = $this->svg_info['scale_x']/$svg_w;
				$yscale = $this->svg_info['scale_x']/$svg_w;
				break;
				case 'height':
				$xscale = $this->svg_info['scale_y']/$svg_h;
				$yscale = $this->svg_info['scale_y']/$svg_h;
				break;
				default:
				$xscale = $this->svg_info['scale_x']/$svg_w;
				$yscale = $this->svg_info['scale_y']/$svg_h;
				break;
			}
			break;
		}
		
		//
		// calcul de la positon du svg
		switch ($this->svg_info['pos_u']){
			case 'mm':
			$xoffset = $this->svg_info['pos_x']*$convert_mm;
			$yoffset = $this->fhPt-($this->svg_info['pos_y']*$convert_mm);
			break;
			default:
			$xoffset = $this->svg_info['pos_x'];
			$yoffset = $this->fhPt-$this->svg_info['pos_y'];
			break;
		}
		
		$this->svg_offset = array(
			'xo' => $xoffset,	//	offset x position en pt
			'yo' => $yoffset,	//	offset y position en pt
			'xs' => $xscale,	//	scale sur l'axe des x
			'ys' => $yscale		//	scale sur l'axe des y
		);
	
	}
	
	//
	//	Cette fonction attribue le style par defaut du groupe contenant la forme ou le groupe de forme
	//	puis analise les attributions de la forme ou du group de forme pour le redistribuer
	//	dans un array rapidement analisable par la fonction svgStyle. 
	function svgDefineStyle($critere_style){
		
		//
		//	copiage du style par defaut a savoir, celui du group precedent:
		$tmp = count($this->svg_style)-1;
		$current_style = $this->svg_style[$tmp];
		
		//
		//	si l'attribs style existe, on analise la chaine:
		
		if (isset($critere_style['style'])){

			$tmp = preg_replace("/(.*)fill:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['fill'] = $tmp;}
		
			$tmp = preg_replace("/(.*)fill-opacity:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['fill-opacity'] = $tmp;}
		
			$tmp = preg_replace("/(.*)fill-rule:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['fill-rule'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke-linecap:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke-linejoin:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke-linejoin'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke-miterlimit:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke-miterlimit'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke-opacity:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke-opacity'] = $tmp;}
		
			$tmp = preg_replace("/(.*)stroke-width:([0-9#]*|none)(.*)/i","$2",$critere_style['style']);
			if ($tmp != ''){ $current_style['stroke-width'] = $tmp;}
		
		}
		
		
		if(isset($critere_style['fill'])){
			$current_style['fill'] = $critere_style['fill'];
		}
		
		if(isset($critere_style['fill-opacity'])){
			$current_style['fill-opacity'] = $critere_style['fill-opacity'];
		}
		
		if(isset($critere_style['fill-rule'])){
			$current_style['fill-rule'] = $critere_style['fill-rule'];
		}
		
		if(isset($critere_style['stroke'])){
			$current_style['stroke'] = $critere_style['stroke'];
		}

		if(isset($critere_style['stroke-linecap'])){
			$current_style['stroke-linecap'] = $critere_style['stroke-linecap'];
		}

		if(isset($critere_style['stroke-linejoin'])){
			$current_style['stroke-linejoin'] = $critere_style['stroke-linejoin'];
		}

		if(isset($critere_style['stroke-miterlimit'])){
			$current_style['stroke-miterlimit'] = $critere_style['stroke-miterlimit'];
		}

		if(isset($critere_style['stroke-opacity'])){
			$current_style['stroke-opacity'] = $critere_style['stroke-opacity'];
		}

		if(isset($critere_style['stroke-width'])){
			$current_style['stroke-width'] = $critere_style['stroke-width'];
		}
		
		return $current_style;
		
	}

	//
	//	Cette fonction ecrit le style dans le stream svg.
	function svgStyle ($critere_style){
	
		$path_style = '';
		
		if (substr_count($critere_style['fill'],'url')>0){
			//
			// couleur degradé
			$id_gradient = preg_replace("/url\(#([\w_]*)\)/i","$1",$critere_style['fill']);
			
			$fill_gradient = $this->svgGradient($this->svg_gradient[$id_gradient]);
			
			$path_style = "q ";
			$w = "W";
			$style .= 'N';
		
		}
		else if ($critere_style['fill'] != 'none'){

			//
			//	fill couleur pleine
			if (isset($this->color_chart[$critere_style['fill']])){
				
				$fill = $this->color_chart[$critere_style['fill']];
			
			} else {
				
				$fill = $critere_style['fill'];
			
			}
			
			$fill_r = base_convert(substr($fill,1,2),16,10);
			$fill_g = base_convert(substr($fill,3,2),16,10);
			$fill_b = base_convert(substr($fill,5,2),16,10);
			$path_style .= sprintf('%.3f %.3f %.3f rg ',$fill_r/255,$fill_g/255,$fill_b/255);
			$style .= 'F';
		}

		if ($critere_style['stroke'] != 'none'){
			
			if (isset($this->color_chart[$critere_style['stroke']])){
			
				$stroke = $this->color_chart[$critere_style['stroke']];
			
			} else {
			
				$stroke = $critere_style['stroke'];
			
			}
			
			
			$stroke_r = base_convert(substr($stroke,1,2),16,10);
			$stroke_g = base_convert(substr($stroke,3,2),16,10);
			$stroke_b = base_convert(substr($stroke,5,2),16,10);								
			$path_style .= sprintf('%.3f %.3f %.3f RG ',$stroke_r/255,$stroke_g/255,$stroke_b/255);
			$style .= 'D';
			
			$path_style .= sprintf('%.2f w ',$critere_style['stroke-width']);

		}
		
		switch ($style){
			case 'F':
				$op = 'f';
			break;
			case 'FD':
				$op = 'B';
			break;
			case 'ND':
				$op = 'S';
			break;
			case 'D':
				$op = 'S';
			break;
			default:
				$op = 'n';		
		}
		
		$final_style = "$path_style $w $op $fill_gradient";
		
		return $final_style;
		
	}

	//
	//	fonction retracant les <path />
	function svgPath($command, $arguments){
	
		global $xbase, $ybase;
		
		$path_cmd = '';
		preg_match_all('/[\-^]?[\d.]+/', $arguments, $a, PREG_SET_ORDER);
		
		//	if the command is a capital letter, the coords go absolute, otherwise relative
		if(strtolower($command) == $command) $relative = true;
		else $relative = false;
		
		//echo $arguments;
		// argument count
		$ile_argumentow = count($a);
		
		//	each command may have different needs for arguments [1 to 8]
		
		switch(strtolower($command)){
			case 'm': // move
				for($i = 0; $i<$ile_argumentow; $i+=2){
					$x = $a[$i][0];
					$y = $a[$i+1][0];
					if($relative){
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y  * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					if($i == 0) $path_cmd .= sprintf('%.2f %.2f m ', $pdfx, $pdfy);
					else $path_cmd .= sprintf('%.2f %.2f l ', $pdfx, $pdfy);							
				}
			break;
			case 'l': // a simple line
				for($i = 0; $i<$ile_argumentow; $i+=2){
					$x = $a[$i][0];
					$y = $a[$i+1][0];
					if($relative){
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f l ', $pdfx, $pdfy);							
				}
			break;
			case 'h': // a very simple horizontal line
				for($i = 0; $i<$ile_argumentow; $i++){
					$x = $a[$i][0];
					if($relative){
						$y = 0;
						$pdfx = ($xbase + $x)  * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y)  * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$y = -$ybase;
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f l ', $pdfx, $pdfy);							
				}
			break;
			case 'v': // the simplest line, vertical
				for($i = 0; $i<$ile_argumentow; $i++){
					$y = $a[$i][0];
					if($relative){
						$x = 0;
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$x = $xbase;
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f l ', $pdfx, $pdfy);							
				}
			break;
			case 's': // bezier with first vertex equal first control
				for($i = 0; $i<$ile_argumentow; $i += 4){
					$x1 = $a[$i][0];
					$y1 = $a[$i+1][0];
					$x = $a[$i+2][0];
					$y = $a[$i+3][0];
					if($relative){
						$pdfx1 = ($xbase + $x1) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = ($ybase - $y1) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$pdfx1 = $x1 * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = -$y1 * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f %.2f %.2f v ', $pdfx1, $pdfy1, $pdfx, $pdfy);							
				}
			break; 
			case 'c': // bezier with second vertex equal second control
			for($i = 0; $i<$ile_argumentow; $i += 6){
					$x1 = $a[$i][0];
					$y1 = $a[$i+1][0];
					$x2 = $a[$i+2][0];
					$y2 = $a[$i+3][0];
					$x = $a[$i+4][0];
					$y = $a[$i+5][0];
					if($relative){
						$pdfx1 = ($xbase + $x1) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = ($ybase - $y1) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx2 = ($xbase + $x2) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy2 = ($ybase - $y2) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$pdfx1 = $x1 * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = -$y1 * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx2 = $x2 * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy2 = -$y2 * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $pdfx1, $pdfy1, $pdfx2, $pdfy2, $pdfx, $pdfy);							
				}
			break; 
			case 'q': // bezier quadratic avec point de control
			for($i = 0; $i<$ile_argumentow; $i += 4){
					$x1 = $a[$i][0];
					$y1 = $a[$i+1][0];
					$x = $a[$i+2][0];
					$y = $a[$i+3][0];
					if($relative){
						$pdfx1 = ($xbase + ($x1*2/3)) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = ($ybase - ($y1*2/3)) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx2 = ($xbase + (($x-$x1)*1/3)) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy2 = ($ybase - (($y-$y1)*1/3)) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = ($xbase + $x) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy = ($ybase - $y) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase += $x;
						$ybase += -$y;
					}
					else{
						$pdfx1 = ($xbase+(($x1-$xbase)*2/3)) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy1 = ($ybase-(($y1+$ybase)*2/3)) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx2 = ($x1+($x*1/3)) * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy2 = (-$y1-($y*1/3)) * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$pdfx = $x * $this->svg_offset['xs'] + $this->svg_offset['xo'];
						$pdfy =  -$y * $this->svg_offset['ys'] + $this->svg_offset['yo']; 
						$xbase = $x;
						$ybase = -$y;
					}
					$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $pdfx1, $pdfy1, $pdfx2, $pdfy2, $pdfx, $pdfy);							
				}
			break;
			case 't': // bezier quadratic avec point de control simetrique a lancien point de control
			break;
			case'z':
				$path_cmd .= 'h ';
			break;
			default:
			break;
			}
			
		return $path_cmd;
		
	}
	
	//
	//	fonction retracant les <rect />
	function svgRect($arguments){

		$x = $arguments['x'];
		$y = $arguments['y'];
		$h = $arguments['h'];
		$w = $arguments['w'];
		$rx = $arguments['rx']/2;
		$ry = $arguments['ry']/2;
		
		if ($rx>0 and $ry == 0){$ry = $rx;}
		if ($ry>0 and $rx == 0){$rx = $ry;}
		
		if ($rx == 0 and $ry == 0){
			//	trace un rectangle sans angle arrondit
			$path_cmd = sprintf('%.2f %.2f m ', $this->svg_offset['xo']+($x*$this->svg_offset['xs']), $this->svg_offset['yo']-($y*$this->svg_offset['ys']));
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+(($x+$w)*$this->svg_offset['xs']), $this->svg_offset['yo']-($y*$this->svg_offset['ys']));
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+(($x+$w)*$this->svg_offset['xs']), $this->svg_offset['yo']-(($y+$h)*$this->svg_offset['ys']));
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+($x*$this->svg_offset['xs']), $this->svg_offset['yo']-(($y+$h)*$this->svg_offset['ys']));
			$path_cmd .= sprintf('%.2f %.2f l h ', $this->svg_offset['xo']+($x*$this->svg_offset['xs']), $this->svg_offset['yo']-($y*$this->svg_offset['ys']));
		
		}
		else {
			//	trace un rectangle avec les arrondit
			//	les points de controle du bezier sont deduis grace a la constante kappa
			$kappa = 4*(sqrt(2)-1)/3;
			
			$kx = $kappa*$rx;
			$ky = $kappa*$ry;
			
			$path_cmd = sprintf('%.2f %.2f m ', $this->svg_offset['xo']+$x+($rx*$this->svg_offset['xs']), $this->svg_offset['yo']-$y);
			
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+$x+(($w-$rx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y);
			
			$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', 	$this->svg_offset['xo']+$x+(($w-$rx+$kx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y, 
																		$this->svg_offset['xo']+$x+($w*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+((-$ry+$ky)*$this->svg_offset['ys']),
																		$this->svg_offset['xo']+$x+($w*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+(-$ry*$this->svg_offset['ys'])
																		);
			
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+$x+($w*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+((-$h+$ry)*$this->svg_offset['ys']));
			
		 	$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', 	$this->svg_offset['xo']+$x+($w*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+((-$h-$ky+$ry)*$this->svg_offset['ys']), 
																		$this->svg_offset['xo']+$x+(($w-$rx+$kx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+(-$h*$this->svg_offset['ys']),
																		$this->svg_offset['xo']+$x+(($w-$rx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+(-$h*$this->svg_offset['ys'])
																		);
			
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+$x+($rx*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+(-$h*$this->svg_offset['ys']));
			
			$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', 	$this->svg_offset['xo']+$x+(($rx-$kx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y+(-$h*$this->svg_offset['ys']), 
																		$this->svg_offset['xo']+$x, $this->svg_offset['yo']-$y+((-$h-$ky+$ry)*$this->svg_offset['ys']),
																		$this->svg_offset['xo']+$x, $this->svg_offset['yo']-$y+((-$h+$ry)*$this->svg_offset['ys'])
																		);
			
			$path_cmd .= sprintf('%.2f %.2f l ', $this->svg_offset['xo']+$x, $this->svg_offset['yo']-$y+(-$ry*$this->svg_offset['ys']));
			
			$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c h ', 	$this->svg_offset['xo']+$x, $this->svg_offset['yo']-$y+((-$ry+$ky)*$this->svg_offset['ys']), 
																		$this->svg_offset['xo']+$x+(($rx-$kx)*$this->svg_offset['xs']), $this->svg_offset['yo']-$y,
																		$this->svg_offset['xo']+$x+($rx*$this->svg_offset['xs']), $this->svg_offset['yo']-$y
																		);
			
		
		}
		
		return $path_cmd;
		
	
	}
	
	//
	//	fonction retracant les <ellipse /> et <circle />
	//	 le cercle est tracé grave a 4 bezier cubic, les poitn de controles
	//	sont deduis grace a la constante kappa * rayon
	function svgEllipse($arguments){
		
		
		$kappa = 4*(sqrt(2)-1)/3;
		
		$cx = $arguments['cx']*$this->svg_offset['xs'];
		$cy = $arguments['cy']*$this->svg_offset['ys'];
		$rx = $arguments['rx']*$this->svg_offset['xs'];
		$ry = $arguments['ry']*$this->svg_offset['ys'];
		
		$x1 = $this->svg_offset['xo']+$cx;
		$y1 = $this->svg_offset['yo']-$cy+$ry;
		
		$x2 = $this->svg_offset['xo']+$cx+$rx;
		$y2 = $this->svg_offset['yo']-$cy;
		
		$x3 = $this->svg_offset['xo']+$cx;
		$y3 = $this->svg_offset['yo']-$cy-$ry;
		
		$x4 = $this->svg_offset['xo']+$cx-$rx;
		$y4 = $this->svg_offset['yo']-$cy;
		
		$path_cmd = sprintf('%.2f %.2f m ', $x1, $y1);
		
		$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1+($rx*$kappa), $y1, $x2, $y2+($ry*$kappa), $x2, $y2);
		
		$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x2, $y2-($ry*$kappa), $x3+($rx*$kappa), $y3, $x3, $y3);
		
		$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x3-($rx*$kappa), $y3, $x4, $y4-($ry*$kappa), $x4, $y4);
		
		$path_cmd .= sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x4, $y4+($ry*$kappa), $x1-($rx*$kappa), $y1, $x1, $y1);
		
		$path_cmd .= 'h ';
		
		return $path_cmd;
	
	}
	
	//
	//	fonction retracant les <polyline /> et les <line />
	function svgPolyline($arguments){
			
		$xbase = $this->svg_offset['xo'] + $arguments[0]*$this->svg_offset['xs'];
		$ybase = $this->svg_offset['yo'] - $arguments[1]*$this->svg_offset['ys'];		
		
		$path_cmd = sprintf('%.2f %.2f m ', $xbase, $ybase);
		for ($i = 2; $i<count($arguments);$i += 2) {
		
			$tmp_x = $this->svg_offset['xo'] + $arguments[$i]*$this->svg_offset['xs'];
			$tmp_y = $this->svg_offset['yo'] - $arguments[($i+1)]*$this->svg_offset['ys'];
			
			$path_cmd .= sprintf('%.2f %.2f l ', $tmp_x, $tmp_y);
		
		}
		
		$path_cmd .= 'h ';
		return $path_cmd;

	}
	
	//
	//	fonction retracant les <polygone />
	function svgPolygon($arguments){
		
		$xbase = $this->svg_offset['xo'] + $arguments[0]*$this->svg_offset['xs'];
		$ybase = $this->svg_offset['yo'] - $arguments[1]*$this->svg_offset['ys'];		
		
		$path_cmd = sprintf('%.2f %.2f m ', $xbase, $ybase);
		for ($i = 2; $i<count($arguments);$i += 2) {
			
			$tmp_x = $this->svg_offset['xo'] + $arguments[$i]*$this->svg_offset['xs'];
			$tmp_y = $this->svg_offset['yo'] - $arguments[($i+1)]*$this->svg_offset['ys'];
			
			$path_cmd .= sprintf('%.2f %.2f l ', $tmp_x, $tmp_y);
		
		}
		
		$path_cmd .= sprintf('%.2f %.2f l ', $xbase, $ybase);
		$path_cmd .= 'h ';
		return $path_cmd;
	
	}
	
	//
	//	fonction analisant le style du group
	function svgGroup($attribs){
	
		$array_style = $this->svgDefineStyle($attribs);
		array_push($this->svg_style,$array_style);

	}
	
	//
	//	fonction fermant le group
	function svgUngroup(){
	
		array_pop($this->svg_style);
	
	}
	
	//
	//	fonction ajoutant un gradient
	function svgAddGradient($id,$array_gradient){
	
		$this->svg_gradient[$id] = $array_gradient;
	
	}
	//
	//	Ajoute une couleur dans le gradient correspondant
	function svgStop ($id,$array_color){
	
		array_push($this->svg_gradient[$id]['color'],$array_color);
	
	}
	
	//
	//	function ecrivant dans le svgstring
	function svgWriteString($content){
	
		$this->svg_string .= $content;
	
	}

	function _putshaders(){
		global $fpdf_class;

    	foreach($fpdf_class->gradients as $id=>$grad){

			$this->_newobj();
				array_push($this->svg_shadinglist,$this->n);
				$fpdf_class->gradients[$id]['id'] = ($this->n);
			$this->_out('<<');
			$this->_out('/ShadingType '.$grad['type']);
			$this->_out('/ColorSpace /DeviceRGB');
			
			if($grad['type']=='2'){
			
				$w = $grad['coords']['w'];
				$h = $grad['coords']['h'];
				$this->_out(sprintf('/Coords [%.3f %.3f %.3f %.3f]',0,0,$w,$h));
				
			}
			else if($grad['type']==3){
			

				$r = $grad['coords']['r'];

				$this->_out(sprintf('/Coords [%.3f %.3f %.3f %.3f %.3f %.3f]',0,0,0,0,0,$r));
			}
			$this->_out('/Extend [true true]');
			$this->_out('/Function');
			$this->_out('<<');
			$this->_out('/FunctionType 3');
			$this->_out('/Domain [0 1]');
			
			$color_function = "";
			$color_bounds = "";
			$color_encode = "";
			$n_color = count($grad['color'])-1;
			
			for ($i = 0; $i<$n_color; $i++){
			
				$color_function .= ($this->n+1+$i)." 0 R ";
				
				if ($i<$n_color-1){
					$color_bounds .= sprintf('%3f ',$grad['color'][$i+1]['offset']);
				}
				
				$color_encode .= "0 1 ";
			}
			
			$this->_out('/Functions ['.trim($color_function).']');
			$this->_out('/Bounds ['.trim($color_bounds).']');
			$this->_out('/Encode ['.trim($color_encode).']');
			$this->_out('>>');
			$this->_out('>>');
			$this->_out('endobj');
			
			for ($i = 0; $i<$n_color; $i++){
				
				$this->_newobj();
				$this->_out('<<');
				$this->_out('/FunctionType 2');
				$this->_out('/Domain [0 1]');
				$this->_out('/C0 ['.$grad['color'][$i]['color'].']');
				$this->_out('/C1 ['.$grad['color'][$i+1]['color'].']');
				$this->_out('/N 1');
				$this->_out('>>');
	            $this->_out('endobj');
	    	}
			
		}
	}

	function _putresourcedict(){
		parent::_putresourcedict();
		$this->_out('/Shading <<');
		for ($i=0; $i<count($this->svg_shadinglist); $i++){
		
			$this->_out('/Sh'.($i+1).' '.$this->svg_shadinglist[$i].' 0 R');
		
		}
		$this->_out('>>');
	}

	function _putresources(){
		$this->_putshaders();
		parent::_putresources();
	}

	//
	//	analise le svg et renvoie aux fonctions precedente our le traitement
	function ImageSVG($critere){
	
		$this->svg_info = $critere;
		
		//
		//	chargement unique des fonctions
		if(!function_exists(xml_svg2pdf_start)){
		
			function xml_svg2pdf_start($parser, $name, $attribs){
				//
				//	definition 
				global	$fpdf_class,$last_gradid;
				
				switch (strtolower($name)){
					
					
					//
					//	analise de la balise <svg /> ou est contenu essentielement les information sur la taille d'origine
					//	le traitement prend en compte la taille d'origine du document, et la taille voulu par l'utilisateur au final
					//	afin de produire $xoffset/$yoffset, coordoné du point d'origine du svg dans le doncument
					//	et $xscale/$yscale multiplicateur qui met le svg a la bonne taille.
					//	selon le format de la page  le multiplicateur change en consequence, et sont origine egalement si
					//	le format est en mode paysage, $yoffset prend automatiquement -height.
					
					case 'svg':
						$fpdf_class->svgOffset($attribs);
					break;
					
					//
					//	grstion des forme path, rect circle, ellipse, polygon, polyline
					//	à chaque fois on lui attribu un style par defaut correspond au style du group courant,
					//	le style par defaut est ensuite remplacer par le style de la forme si il y a lieu d'etre.
					//
					//	trace la forme <path /> en suivant les commandes m,z,l,h,v,c,s,q,t
					//	seul la commande a (elleptique arc) n'est pas encore gerée.
					case 'path':
					$path = $attribs['d'];
					// redistribution du contenu du path dans des array:
					preg_match_all('/([a-z]|[A-Z])([ ,\-.\d]+)*/', $path, $commands, PREG_SET_ORDER);
					$path_cmd = '';
					//	traitement par action du path
					foreach($commands as $c){
						if(count($c)==3){
							list($tmp, $command, $arguments) = $c;
						}
						else{
							list($tmp, $command) = $c;
							$arguments = '';
						}
						$path_cmd .= $fpdf_class->svgPath($command, $arguments);
					}
					//
					//	definition du style
					$critere_style = $attribs;
					unset($critere_style['d']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					case 'rect':
					if (!isset($attribs['x'])) {$attribs['x'] = 0;}
					if (!isset($attribs['y'])) {$attribs['y'] = 0;}
					if (!isset($attribs['rx'])) {$attribs['rx'] = 0;}
					if (!isset($attribs['ry'])) {$attribs['ry'] = 0;}
					$arguments = array(
						'x' => $attribs['x'],
						'y' => $attribs['y'],
						'w' => $attribs['width'],
						'h' => $attribs['height'],
						'rx' => $attribs['rx'],
						'ry' => $attribs['ry']
					);
					$path_cmd =  $fpdf_class->svgRect($arguments);
					$critere_style = $attribs;
					unset($critere_style['x'],$critere_style['y'],$critere_style['rx'],$critere_style['ry'],$critere_style['height'],$critere_style['width']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
								
					case 'circle':
					if (!isset($attribs['cx'])) {$attribs['cx'] = 0;}
					if (!isset($attribs['cy'])) {$attribs['cy'] = 0;}
					$arguments = array(
						'cx' => $attribs['cx'],
						'cy' => $attribs['cy'],
						'rx' => $attribs['r'],
						'ry' => $attribs['r']
					);
					$path_cmd =  $fpdf_class->svgEllipse($arguments);
					$critere_style = $attribs;
					unset($critere_style['cx'],$critere_style['cy'],$critere_style['r']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					case 'ellipse':
					if (!isset($attribs['cx'])) {$attribs['cx'] = 0;}
					if (!isset($attribs['cy'])) {$attribs['cy'] = 0;}
					$arguments = array(
						'cx' => $attribs['cx'],
						'cy' => $attribs['cy'],
						'rx' => $attribs['rx'],
						'ry' => $attribs['ry']
					);
					$path_cmd =  $fpdf_class->svgEllipse($arguments);
					$critere_style = $attribs;
					unset($critere_style['cx'],$critere_style['cy'],$critere_style['rx'],$critere_style['ry']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					case 'line':
					$arguments = array($attribs['x1'],$attribs['y1'],$attribs['x2'],$attribs['y2']);
					$path_cmd =  $fpdf_class->svgPolyline($arguments);
					$critere_style = $attribs;
					unset($critere_style['x1'],$critere_style['y1'],$critere_style['x2'],$critere_style['y2']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					case 'polyline':
					$path = $attribs['points'];
					//	redirstribution du contenu de la forme dans un array.
					preg_match_all('/[0-9\-\.]*/',$path, $tmp, PREG_SET_ORDER);
					$arguments = array();
					for ($i;$i<count($tmp);$i++){
						if ($tmp[$i][0] !=''){
							array_push($arguments, $tmp[$i][0]);
						}
					}
					$path_cmd =  $fpdf_class->svgPolyline($arguments);
					$critere_style = $attribs;
					unset($critere_style['points']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					case 'polygon':
					
					$path = $attribs['points'];
					
					//	redirstribution du contenu de la forme dans un array.
					preg_match_all('/[0-9\-\.]*/',$path, $tmp, PREG_SET_ORDER);
					$arguments = array();
					for ($i;$i<count($tmp);$i++){
						if ($tmp[$i][0] !=''){
							array_push($arguments, $tmp[$i][0]);
						}
					}
					$path_cmd =  $fpdf_class->svgPolygon($arguments);
					//	definition du style de la forme:
					$critere_style = $attribs;
					unset($critere_style['points']);
					$path_style = $fpdf_class->svgDefineStyle($critere_style);
					break;
					
					//
					//	Le linearGradient comme les radials sont declaré avant d'etre utilisé dans leur
					//	les balises <lineargradient /> et <radialgradient /> definisse le placement du gradient
					//	leur couleur sont definit par les balise stop.
					case 'lineargradient':

						$tmp_gradient = array(
							'type' => 'linear',
							'info' => array(
								'x1' => $attribs['x1'],
								'y1' => $attribs['y1'],
								'x2' => $attribs['x2'],
								'y2' => $attribs['y2']
							),
							'transform' => $attribs['gradientTransform'],
							'color' => array()
						);
						
						$last_gradid = $attribs['id'];
						
						$fpdf_class->svgAddGradient($attribs['id'],$tmp_gradient);
						
					break;
					
					case 'radialgradient':
						
						$tmp_gradient = array(
							'type' => 'radial',
							'info' => array(
								'x0' => $attribs['cx'],
								'y0' => $attribs['cy'],
								'x1' => $attribs['fx'],
								'y1' => $attribs['fy'],
								'r' => $attribs['r']
							),
							'transform' => $attribs['gradientTransform'],
							'color' => array() 
						);
						
						$last_gradid = $attribs['id'];
						
						$fpdf_class->svgAddGradient($attribs['id'],$tmp_gradient);
					
					break;
					
					//
					//	couleur du dégradé
					case 'stop':
						
						if (isset($attribs['style']) AND !isset($attribs['stop-color'])){
						
							$color = preg_replace('/stop-color:([0-9#]*)/i','$1',$attribs['style']);
						
						} else {
						
							$color = $attribs['stop-color'];
						
						}
						$color_r = base_convert(substr($color,1,2),16,10);
						$color_g = base_convert(substr($color,3,2),16,10);
						$color_b = base_convert(substr($color,5,2),16,10);
					
						$color_final = $path_style .= sprintf('%.3f %.3f %.3f',$color_r/255,$color_g/255,$color_b/255);

						
						$tmp_color = array(
							'color' => $color_final,
							'offset' => $attribs['offset'],
							'opacity' => $attribs['stop-opacity']
						);
						
						$fpdf_class->svgStop($last_gradid,$tmp_color);
					
					break;
					//
					//	les groupes peuvent egalement definir des styles pour plusieurs formes
					//	ont retient donc les styles du groupes à part pour etre reutiliser plus tard par les forme concerné
					//	en ajoutant un nouveau style dans l'array global $svg2pdf_groupstyle.
					case 'g':
						$fpdf_class->svgGroup($attribs);
					break;
				}
				
				//
				//insertion des path et du style dans le flux de donné general.
				if (isset($path_cmd)){
					
					//echo 'path >> '.$path_cmd."<br><br>";
					//productionde  la chaine de character du style grace a l'array $path_style definit auparavant
					$get_style = $fpdf_class->svgStyle($path_style);
					//echo "style >> ".$get_style[1]."<br><br>";
					//sauvetage de la forme (q) si le style contient un fill gradient
					//	insertion de la forme et de son style dans la chaine svg general

					$fpdf_class->svgWriteString("$path_cmd $get_style");
					
				}
			}
			
			function xml_svg2pdf_end($parser, $name){
			
				global $fpdf_class;

				switch($name){
					//
					//	quand un groupe se fini on supprime le dernier 
					case "g":
						$fpdf_class->svgUngroup();
					break;
					default:
				}

			}
		
		}

		global $fpdf_class;
		
		$svg2pdf_xml='';
		//
		//
		$fpdf_class = $this;
		//
		//	parsage du xml:
		
		if($fp = fopen($this->svg_info['filename'], "r")){
			while (!feof($fp)) $svg2pdf_xml .= fgets ( $fp, 4096);
			fclose($fp);
	 		$svg2pdf_xml_parser = xml_parser_create("iso-8859-1");
			xml_parser_set_option($svg2pdf_xml_parser, XML_OPTION_CASE_FOLDING, false);
			xml_set_element_handler($svg2pdf_xml_parser, "xml_svg2pdf_start", "xml_svg2pdf_end");
			xml_parse($svg2pdf_xml_parser, $svg2pdf_xml);
		}
		
		$this->_out($fpdf_class->svg_string);

	}



}


?>
