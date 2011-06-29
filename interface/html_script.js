var x=0;
var y=0; 
var svgDocument = null;
var svgWin = null;
var fond_select=2;

 function derou(x,z)
 {

 if(document.getElementById('im'+x).d=="2")
 {

 for(i=1;i<=z;i++)
	{
	
 document.getElementById('li'+x+svgWin.codalph(i)).style.visibility ="hidden";
 document.getElementById('li'+x+svgWin.codalph(i)).style.position ="absolute";
 	}
 document.getElementById('im'+x).src="./interface/expandbtn2.gif";
 document.getElementById('im'+x).d="1"
 }
 else
 {
  
 for(i=1;i<=z;i++)
	{
 document.getElementById('li'+x+svgWin.codalph(i)).style.visibility ="visible";
 document.getElementById('li'+x+svgWin.codalph(i)).style.position ="relative";
 	}
 document.getElementById('im'+x).src="./interface/collapsebtn2.gif";
 document.getElementById('im'+x).d="2"
 
 }
 }
 
function verifVersion(vers)
{
if(vers<3.5 && nav==2)
{alert("Gismeaux fonctionne en natif avec Firefox, mais pour profiter pleinement de l'application ,nous vous conseillons une version de Firefox >=3.5 .");}
}
function init_svg()
{
var embed = document.embeds["embed"];
  try {
    svgDocument = embed.getSVGDocument();
  }
  catch(exception) {
    alert('The GetSVGDocument interface is not supported');
  }

if (svgDocument && svgDocument.defaultView)  // try the W3C standard way first
    svgWin = svgDocument.defaultView;
  else if (embed.window)
    svgWin = embed.window;
  else try {
    svgWin = embed.getWindow();
  }
  catch(exception) {
	  if(nav==2)
	  {
		  alert("Firefox n'est pas correctement configur�\n -Dans la barre adresse taper about:config  valider \n -Cliquer sur 'Je ferais attention,promis !' \n -Dans filtre mettre svg \n -Double click sur False dans la colonne Valeur \n -R�actualiser l'application");
	  }
	  else
	  {
    alert('The DocumentView interface is not supported\r\n' +
          'Non-W3C methods of obtaining "window" also failed');
	  }
  }

}

function change_color_fond(e)
{
document.getElementById('fond'+fond_select).style.background="none";
fond_select=e;
document.getElementById('fond'+e).style.background="#ccc";
}
function mod_color_fond(e,z,type)
{
if(fond_select!=e)
z.style.background=type;
}
function determinehauteur()
{
if(window.innerHeight)
{
hauteur=window.innerHeight-80;

}
else
{
hauteur=document.documentElement.clientHeight-80;
}

document.getElementById("carto").style.height = hauteur+"px";
}
function quelle_touche(evenement)
   {
       var touche = window.event ? evenement.keyCode : evenement.which;
       
   }
 function direction(evenement){
      var touche = window.event ? evenement.keyCode : evenement.which;
	  switch(touche) 
	   {
		 case 40: svgWin.goSouth() ; break;
		 case 39: svgWin.goEast() ; break;
 		case 38: svgWin.goNorth() ; break;
		 case 37: svgWin.goWest() ; break ; 
	   }
	   
}

function position_souris(e)
{
if(e.pageX) 
		{
		x = e.pageX;
		y = e.pageY;
 		}
		else if(e.clientX) 
		{
		x = e.clientX;
		y = e.clientY;
		}
 		else 
		{
		x = e.x;
		y = e.y;
		 }
}
function toolTip(a,e)
{
	if(toolTip.arguments.length < 1) 
  {
	 document.getElementById("toolTipLayer").style.visibility='hidden'; 
    
  }
  else 
  {
		position_souris(e)
	
	 if(a.length>0)
	{
	msg=a;	
		
	}
	else
	{
		msg=a.getAttribute("lab");
	}  
   var content =
    '<table border="1" cellspacing="0" cellpadding="0" style="border-color:#008; background:#dff0ff"><td align="center">&nbsp\;' + msg + '&nbsp\;</td></table>';
    
	
      document.getElementById("toolTipLayer").innerHTML=content;
	
	document.getElementById("toolTipLayer").style.visibility='visible';
  }


document.getElementById("toolTipLayer").style.top=y+"px";
  document.getElementById("toolTipLayer").style.left=x+"px";
}


var down = 0;
var init_x;
var init_y;

function setD(a,b,e)
 {
down = a;
position_souris(e);
init_x=x;
init_y=y;
div_x = document.getElementById(b).offsetLeft;
div_y = document.getElementById(b).offsetTop;
 }


function drag(b,e)
{
 if(down==1)
 {
position_souris(e)
pos_x=x;
pos_y=y;
dx = pos_x - init_x; 
dy = pos_y - init_y;
document.getElementById(b).style.left = div_x + dx +"px";
document.getElementById(b).style.top = div_y + dy +"px";
}
} 

function retourfocus()
{
window.focus();
}

