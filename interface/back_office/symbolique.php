<?php

$texte=fopen("../police.svg","r");
			$contents = fread($texte, filesize ("../police.svg"));
			$data1=explode("<",$contents);
			$tab_symbol=array();
				for ($i=1;$i<count($data1);$i++)
				{
					$pos1=0;$pos2=0;
					if(ereg('unicode="',$data1[$i]) && ereg('d="',$data1[$i]))
					{ 
					$symbol.="<".$data1[$i]."\n";
					$pos1 = strpos($data1[$i], 'unicode="');
					$pos2 = strpos($data1[$i],'"',$pos1+9);
					$lettre=substr($data1[$i], $pos1+9, (($pos1+9)-($pos2-2)));
					//genere_symbole($font_file,$lettre,$font_size,$font_color,$background_color,$transparent_background,$cache_images,$cache_folder );
					//$textsymbol.="<text id=\"".$lettre."\" font-family=\"fontsvg\" fill=\"rgb(0,0,0)\" font-size=\"10\" >".$lettre."</text>"; 
					array_push($tab_symbol,$lettre);
					
					}
				}
			fclose($texte);
$nb_symbol=count($tab_symbol);
$nbligne_symbol=ceil($nb_symbol/11);
//$ysymbole=87;
//$xsymbole=152;
$cont_symbol=1;
$des_symbol="<center><table>";
for ($i=0;$i<($nbligne_symbol*11);$i++)
				{
				//$hash = md5(basename($font_file) .$tab_symbol[$i]) ;
				if($i<$nb_symbol)
				{
				if($cont_symbol==1)
				{
				$des_symbol.="<tr>";
				}
				//$des_symbol.="<td style=\"border:solid\" width=\"20px\" height=\"20px\" onclick=\"select_symb('".$tab_symbol[$i]."')\"><img width=\"20px\" height=\"20px\" src=\"./interface/back_office/image/".$hash.".png\"></td>";
				$des_symbol.="<td style=\"border-color:#000080;border:solid;border-width:1px\" width=\"20px\" height=\"20px\" onmouseover=\"this.style.background='#f00'\" onmouseout=\"this.style.background='none'\" onclick=\"select_symb('".$tab_symbol[$i]."')\"><font face=\"svg\" size=\"6px\">".$tab_symbol[$i]."</font></td>";
				//$des_symbol.="<td style=\"border:solid\" width=\"20px\" height=\"20px\" onclick=\"select_symb('".$tab_symbol[$i]."')\">".include('./genere_symbole.php?font=Font1&text='.$tab_symbol[$i].'&size=96&couleur=000080&fond=ffffff&fond_transparent=true')."</td>";
				//$des_symbol.="<a><rect id=\"cont_symb".$i."\" width=\"20\" height=\"20\" x=\"".$xsymbole."\" y=\"".$ysymbole."\" class=\"defaut\" onmouseover=\"switchColor(evt,'fill','red','','cont_symb".$i."')\" onmouseout=\"switchColor(evt,'fill','none','','cont_symb".$i."')\" onclick=\"select_symb('".$tab_symbol[$i]."')\"/></a>";
				//$des_symbol.="<text id=\"sym".$tab_symbol[$i]."\" font-family=\"fontsvg\" fill=\"rgb(0,0,0)\" font-size=\"15\" pointer-events=\"none\" x=\"".($xsymbole+9)."\" y=\"".($ysymbole+15)."\" text-anchor=\"middle\" >".$tab_symbol[$i]."</text>";
				}
				else
				{
				$des_symbol.="<td style=\"border-color:#000080;border:solid;border-width:1px\" width=\"20px\" height=\"20px\" >&nbsp;</td>";
				//$des_symbol.="<rect id=\"cont_symb".$i."\" width=\"20\" height=\"20\" x=\"".$xsymbole."\" y=\"".$ysymbole."\" class=\"defaut\"/>";
				}
				if($cont_symbol==11)
				{
				$des_symbol.="</tr>";
				//$ysymbole=$ysymbole+22;
				//$xsymbole=152;
				$cont_symbol=1;
				}
				else
				{
				$cont_symbol=$cont_symbol+1;
				//$xsymbole=22+$xsymbole;
				}
				
				}
			$des_symbol.="</table></center>";
			
echo $des_symbol;
?>
