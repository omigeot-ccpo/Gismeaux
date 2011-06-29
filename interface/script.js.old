/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est régi par la licence CeCILL-C soumise au droit français et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusée par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilité au code source et des droits de copie,
de modification et de redistribution accordés par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitée.  Pour les mêmes raisons,
seule une responsabilité restreinte pèse sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concédants successifs.

A cet égard  l'attention de l'utilisateur est attirée sur les risques
associés au chargement,  à l'utilisation,  à la modification et/ou au
développement et à la reproduction du logiciel par l'utilisateur étant 
donné sa spécificité de logiciel libre, qui peut le rendre complexe à 
manipuler et qui le réserve donc à des développeurs et des professionnels
avertis possédant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invités à charger  et  tester  l'adéquation  du
logiciel à leurs besoins dans des conditions permettant d'assurer la
sécurité de leurs systèmes et ou de leurs données et, plus généralement, 
à l'utiliser et l'exploiter dans les mêmes conditions de sécurité. 

Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accepté les 
termes.
test mise a jour
*/
var largeurbox=800,hauteurbox=566,larmap=780,haumap=546,ratiovue=larmap/haumap,imp='',coucherasterold='',coucherasterposi='',Rpressed=0;
var zoomtool='',RevtX=0,RevtY=0,couraster=0,mapPosX=0,mapPosY=0,nbsplit=0,liste_scroll_decale=0,offsetXmap=0,offsetYmap=0,scroll_y=0;
var liste_scroll_appui=false,ratio=0,svgdoc='',overini=0,press=0,rectOveXcorner='',rectOveYcorner='',rectXcorner=0,rectYcorner=0;
var rect1Ovewidth=0,rect1Oveheight=0,rect1UlXCorner=0,rect1UlYCorner=0,vtX=0,vtY=0,coucherastervisible='',couchesvgvisible='';
var coucherasteraenvoye='',xnulcorner=0,ynulcorner=0,nWidth=0,nHeight=0,newViewport='',ini=0,coulfill='',opacityfill='',multi=0;
var selectio='',id1='',placid='',n_url='',tee='',tape_autorise=0,tapenum_autorise=0,zoomrecherche=100,svgRect='',Rect1='',lin1='';
var lin2='',svgMainViewport='',xlinkns='http://www.w3.org/1999/xlink',svgns='http://www.w3.org/2000/svg',ligne='',ligne1='',traitpret=0,lx=0,ly=0,lxdist=0,lydist=0;
var xm='',ym='',cotation=0,longtrait=0,angle=0,posix=0,posiy=0,countrait=0,countcotation=0,countsurface=0,selectid='boutonselect';
var selectstroke='0',parce="''",bouton_distance=0,cumul=0,distance=0,surface=0,polygon=0,polyg='',indice='',count=0,image='';
var nom='',noactive=0,retparam1='',Periode='',retparam2='',idparam1='',idparam2='',phrase='',phrase1='',valn=0,valconteur=new Array;
var varcotations=new Array,ini_use=0,couche_init=0,coulmofif='',scroll_x_zoom=0,scroll_appui_zoom='false',valz='',ns = "http://www.w3.org/TR/SVG11/feature#CoreAttribute",sansplug='false',parcelle_appia=new Array;
function init(evt) 
	{
HTTP();
	svgdoc=evt.target.ownerDocument;
	svgRect = svgdoc.getElementById('locationRect');
	Rect1 = svgdoc.getElementById('Rect1');
	lin1 = svgdoc.getElementById('lin1');
	lin2 = svgdoc.getElementById('lin2');
	svgMainViewport = svgdoc.getElementById('mapid');
if(nav!=0 && (document &&
        document.implementation &&
        document.implementation.hasFeature &&
        document.implementation.hasFeature(ns, "1.1")))
{
sansplug='true';
}
Zoomto(evt,zoomVal);
zoomrecherche=2400;
if(zoomrecherche>zoommax)
{zoomrecherche=zoommax;}
}

function codalph(ch)
{
         if(ch>26 && 260>ch)
		 {
			ve=Math.floor(ch/26);
			txt=String.fromCharCode(96+ve);
            txt=txt+String.fromCharCode(65+(ch-(26*ve)));
         }
		 else
		 {
            txt=String.fromCharCode(64+ch);
         }
         if(ch==0)
		 {
			txt="";
		 }
         return txt;
}

function derouler(evt,x,y)
{
	var nlay=nblayer-1;	
	var objet=svgdoc.getElementById("d" + x);
	if (objet.getAttributeNS(null,"visibility") == "hidden")
	{
	objet.setAttributeNS(null,'visibility','visible');
	svgdoc.getElementById("soustheme" + x).setAttributeNS(null,'visibility','hidden');
	
	for(z=1;z<=y;z++)
	{
	svgdoc.getElementById("tra"+x+codalph(z)).setAttributeNS(null,'visibility','hidden');
	}
	for (i=1;i<=nblayer-1;i++)
		{
			if(svgdoc.getElementById("theme" + i).getAttributeNS(null,"so")>0 && svgdoc.getElementById("d" + i).getAttributeNS(null,"visibility") == "hidden")
			{
			
			nlay=nlay+Math.round(svgdoc.getElementById("theme" + i).getAttributeNS(null,"so"));
			}
			if(i==x+1)
			{
			svgdoc.getElementById("theme" + i).setAttributeNS(null,'transform','translate(0,0)');
			}
		}
	} 
	else
	{
	objet.setAttributeNS(null,'visibility','hidden')

	for(z=1;z<=y;z++)
	{
		if (svgdoc.getElementById("control"+x+codalph(z)).getAttributeNS(null,"visibility") == "visible")
		{
		svgdoc.getElementById("tra"+x+codalph(z)).setAttributeNS(null,'visibility','visible');
		}
	}

	
for (i=1;i<=nblayer-1;i++)
		{
			if(svgdoc.getElementById("theme" + i).getAttributeNS(null,"so")>0 && svgdoc.getElementById("d" + i).getAttributeNS(null,"visibility") == "hidden")
			{
			
			nlay=nlay+Math.round(svgdoc.getElementById("theme" + i).getAttributeNS(null,"so"))
			}
			if(i==x+1)
			{
			svgdoc.getElementById("theme" + i).setAttributeNS(null,'transform','translate(0,'+Math.round(12*y)+')');
			}
	}
svgdoc.getElementById("soustheme" + x).setAttributeNS(null,'visibility','visible')
}
if(17+(nlay*12)>291)
{
svgdoc.getElementById("scroll_cursor").setAttributeNS(null,"height",291-((nlay-23)*12));
}
else
{
svgdoc.getElementById("layer").setAttributeNS(null,'transform','translate(0,0)');
svgdoc.getElementById("curseur").setAttributeNS(null,'transform','translate(0,0)');
svgdoc.getElementById("scroll_cursor").setAttributeNS(null,"height",291);
}
}


function switchColor (evt,property,newcolor,idpath,idoption)
{

if(idoption!='')
{
	svgdoc.getElementById(idoption).setAttribute(property, newcolor);
}
else if (idpath.substring(0,17) == 'composedLineStyle')
   {
	 objpath = svgdoc.getElementById(idpath.substring(17,idpath.length));objpath.setAttributeNS(null,'style','');
	 tempobj = svgdoc.getElementById(idpath);tempobj.style.setProperty(property,newcolor);
	 }
else
	{
	var target;
target = get_target(evt);	
	target.setAttribute(property, newcolor);
	}
}
function get_target (evt){
var target = evt.target; 
while (target && !target.getAttributeNS(null,'id'))target = target.parentNode;
return target;
}
function determ_ratio()
{
if ((window.innerWidth/largeurbox) < (window.innerHeight/hauteurbox))
{
scaleFactor=largeurbox / window.innerWidth;
ratio=window.innerWidth / largeurbox;
}
else
{
scaleFactor=hauteurbox/window.innerHeight;
ratio=window.innerHeight/hauteurbox;		
}
offsetXmap = (window.innerWidth-(largeurbox/scaleFactor))/2+(mapPosX / scaleFactor);
offsetYmap = (window.innerHeight-(hauteurbox/scaleFactor))/2+(mapPosY / scaleFactor);	
}
function showinfotip (evt,info1){
splitString="";
var reg111=new RegExp("[$\n]+", "g");
splitString = info1.split(reg111);
nbsplit = splitString.length;
var scale = svgMainViewport.CurrentScale;
var translateX = svgMainViewport.currentTranslate.x;
var translateY = svgMainViewport.currentTranslate.y;
var pixel = 1 / scale;
var infotip = 'infotip';
var infotiprect = 'infotipRect';
var svgobj = svgdoc.getElementById (infotip);
svgobj.setAttributeNS(null,'x', (evt.clientX-offsetXmap)/ratio+9);
svgobj.setAttributeNS(null,'y', (evt.clientY-offsetYmap)/ratio+6);
//var svgstyle = svgobj.style;
svgobj.setAttributeNS(null,'visibility', 'visible');
svgobj.setAttributeNS(null,'font-size', 8);
svgobj1 = svgobj.firstChild;
nbcar=0;
var txtlen=0;
if (nbsplit == 1)
	{
	svgobj1.data=info1;
	nbcar=svgobj.getNumberOfChars()-1;
	txtlen=9+svgobj.getEndPositionOfChar(nbcar).x-svgobj.getStartPositionOfChar(0).x;
	}
else
	{
		
		
	var reg3=new RegExp("\\[rgb","g");
	var reg4=new RegExp("\\[rgb\\]|\\[/rgb\\]", "ig");
	var reg5=new RegExp("[$]", "ig");
	//var reg4=new RegExp("\[/rgb\]","g");
			
			if (splitString[0].match(reg3)) 
				{
				var c1=splitString[0].substring(splitString[0].indexOf("\]")+1,splitString[0].lastIndexOf("\["));
				var c2=splitString[0].substring(splitString[0].indexOf("\[")+1,splitString[0].indexOf("\]"));
				
				if(splitString[0].indexOf("\[")>0)
				{
				svgobj1.data=splitString[0].substring(0,splitString[0].indexOf("\["));
				myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.setAttributeNS(null,'fill',c2);
				myspan.appendChild(svgdoc.createTextNode(c1));
				svgobj.appendChild(myspan);
				}
				else
				{
				svgobj1.data='';
				myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.setAttributeNS(null,'fill',c2);
				myspan.appendChild(svgdoc.createTextNode(c1));
				svgobj.appendChild(myspan);
				myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.appendChild(svgdoc.createTextNode(splitString[0].substring(splitString[0].lastIndexOf("\]")+1)));
				svgobj.appendChild(myspan);
				}
				
				}
				else
				{
					svgobj1.data=splitString[0];
				}
				
	
	var lg=0;
	for (k=1; k<nbsplit ; k++)
		{
		myspan = svgdoc.createElementNS(svgns,'tspan');
		myspan.setAttributeNS(null,'dy',7.2);
		myspan.setAttributeNS(null,'id', k);
		myspan.setAttributeNS(null,'x', (evt.clientX-offsetXmap)/ratio+9);
		var reg1=new RegExp("<i>","g");
			if (splitString[k].match(reg1)) 
				{
					
					myspan.setAttributeNS(null,'font-style','italic');
					splitString[k]=splitString[k].replace(reg1,"");
				}
			var reg2=new RegExp("<rgb>","g");
			if (splitString[k].match(reg2)) 
				{
				
				var c=splitString[k].substring(6,splitString[k].indexOf("<",5));
				var re=splitString[k].substring(0,splitString[k].indexOf("</rgb>",1)+6);
				var reg3=new RegExp(re,"g");
				myspan.setAttributeNS(null,'fill',c);
				splitString[k]=splitString[k].replace(re,"");
				}
			//var reg3=new RegExp("[rgb]","g");
			if (splitString[k].match(reg3)) 
				{
				var c1=splitString[k].substring(splitString[k].indexOf("\]")+1,splitString[k].lastIndexOf("\["));
				var c2=splitString[k].substring(splitString[k].indexOf("\[")+1,splitString[k].indexOf("\]"));
				
				if(splitString[k].indexOf("\[")>0)
				{
				//svgobj1.data=splitString[0].substring(0,splitString[0].indexOf("\["));
				//myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.appendChild(svgdoc.createTextNode(splitString[k].substring(0,splitString[k].indexOf("\["))));
				svgobj.appendChild(myspan);	
				myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.setAttributeNS(null,'fill',c2);
				myspan.appendChild(svgdoc.createTextNode(c1));
				//svgobj.appendChild(myspan);
				}
				else
				{
				//svgobj1.data='';
				//myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.setAttributeNS(null,'fill',c2);
				myspan.appendChild(svgdoc.createTextNode(c1));
				svgobj.appendChild(myspan);
				myspan = svgdoc.createElementNS(svgns,'tspan');
				myspan.appendChild(svgdoc.createTextNode(splitString[k].substring(splitString[k].lastIndexOf("\]")+1)));
				//svgobj.appendChild(myspan);
				}
				}
				else
				{
					myspan.appendChild(svgdoc.createTextNode(splitString[k]));
				}
			lg_text=splitString[k];
			
			
			svgobj.appendChild(myspan);
			nbcar=svgobj.getNumberOfChars()-1;
			if(txtlen<9+svgobj.getEndPositionOfChar(nbcar).x-svgobj.getStartPositionOfChar(0).x)
			{
			txtlen=9+svgobj.getEndPositionOfChar(nbcar).x-svgobj.getStartPositionOfChar(0).x;
			}
		}
	}

//nbcar=svgobj.getNumberOfChars()-1;
//var txtlen=9+svgobj.getEndPositionOfChar(nbcar).x-svgobj.getStartPositionOfChar(0).x;
var svgobj = svgdoc.getElementById (infotiprect);
svgobj.setAttributeNS(null,'x', (evt.clientX-offsetXmap)/ratio+5.5);
svgobj.setAttributeNS(null,'y', (evt.clientY-offsetYmap)/ratio-3);
svgobj.setAttributeNS(null,'width', txtlen);
if (nbsplit >1) svgobj.setAttributeNS(null,'height',10*nbsplit);else svgobj.setAttributeNS(null,'height',1+'em');
svgobj.setAttributeNS(null,'visibility', 'visible');
}

function hideinfotip(evt)
	{
	var infotip = 'infotip';
	var infotiprect = 'infotipRect';
	var svgobj = svgdoc.getElementById (infotip);
	if (nbsplit == 1)
		{
		svgobj.setAttributeNS(null,'visibility', 'hidden');
		}
	else
		{
		nodelist = svgobj.childNodes;
						
		for (k=nodelist.length-1; k>0; k--)
			{
			if(nodelist.item(k)!="")
			{
			svgobj.removeChild(nodelist.item(k))
			}
			}
		svgobj.setAttributeNS(null,'visibility', 'hidden');
	}
	svgdoc.getElementById(infotiprect).setAttributeNS(null,'visibility', 'hidden');
	nbsplit="0";
}

function gest_zoom(evt,tovalue)
{
	//alert(tovalue)
	rectOveXcorner = parseFloat(svgRect.getAttributeNS(null,'x'));
	rectOveYcorner = parseFloat(svgRect.getAttributeNS(null,'y'));
	rectOvewidth = parseFloat(svgRect.getAttributeNS(null,'width'));
	rectOveheight = parseFloat(svgRect.getAttributeNS(null,'height'));
	if(cx!=0)
	{
	xcenter=cx;
	ycenter=cy;
	cx=0;cy=0;
	}
	else
	{
	xcenter = rectOveXcorner + rectOvewidth / 2;
	ycenter = rectOveYcorner + rectOveheight / 2;
	
	}
	if(hauteurini*ratiovue>largeurini)
	{
		lar=hauteurini*ratiovue;
		hau=hauteurini;
		nWidth = hauteurini*ratiovue * (100/tovalue);
		nHeight = hauteurini*(100/tovalue);
		
	}
	else
	{
		hau=largeurini/ratiovue;
		lar=largeurini;
		nWidth = largeurini*(100/tovalue);
		nHeight = (largeurini/ratiovue)*(100/tovalue);
	}
	if(zoomVal==100)
	{
	xnulcorner = xcenterini - nWidth/ 2;
	ynulcorner = ycenterini - nHeight/2;
	}
	else
	{
	xnulcorner = xcenter - nWidth/ 2;
	ynulcorner = ycenter - nHeight/2;
	}
	if ((zoomtool == 'zoomin') && (Rpressed != 0))
		{
		svgRectee = svgdoc.getElementById('rectevt');
		xnulcorner = parseFloat(svgRectee.getAttributeNS(null,'x'));
	    ynulcorner  = parseFloat(svgRectee.getAttributeNS(null,'y'));
		xcenter = xnulcorner + nWidth/2;
		ycenter = ynulcorner + nHeight/2;
		}
	Rect1lar = parseFloat(Rect1.getAttributeNS(null,'width'));
	Rect1hau =Rect1lar/ratiovue;
	if(xnulcorner<(xcenterini - lar/ 2) && zoomVal!=100)
	{
	xnulcorner=xcenterini - lar/ 2;	
	}
	
	if(ynulcorner<ycenterini - hau/2 && zoomVal!=100)
	{
	ynulcorner=ycenterini - hau/2;	
	}
	
	if(ynulcorner+nHeight>(ycenterini + hau/ 2) && zoomVal!=100)
	{
	ynulcorner=(ycenterini + hau/ 2)-nHeight;	
	if(ynulcorner<ycenterini - hau/2)
	{
	ynulcorner=ycenterini - hau/2;	
	}
	}
	if(xnulcorner+nWidth>(xcenterini + lar/ 2) && zoomVal!=100)
	{
		
	xnulcorner=(xcenterini + lar/ 2)-nWidth;
	if(xnulcorner<(xcenterini - lar/ 2))
	{
		
	xnulcorner=(xcenterini - lar/ 2);	
	}
	}
	
	svgRect.setAttributeNS(null,'x',xnulcorner);
	var xnu=xnulcorner;
	svgRect.setAttributeNS(null,'y',ynulcorner);
	var ynu=ynulcorner;
	svgRect.setAttributeNS(null,'width',nWidth);
	svgRect.setAttributeNS(null,'height',nHeight);
	svgRect.setAttributeNS(null,'visibility','visible');
	
	if (tovalue>600)
	{
	svgdoc.getElementById('locationRect').setAttributeNS(null,'pointer-events','none');
	svgdoc.getElementById('Rect1').setAttributeNS(null,'visibility','visible');
	svgdoc.getElementById('lin1').setAttributeNS(null,'visibility','visible');
	svgdoc.getElementById('lin2').setAttributeNS(null,'visibility','visible');
	if(overini==0)
	{
	overini=1;
	Rect1.setAttributeNS(null,'x',xcenter-((Rect1lar/6)/2));
	Rect1.setAttributeNS(null,'y',ycenter-((Rect1hau/6)/2));
	Rect1.setAttributeNS(null,'width',Rect1lar/6);
	Rect1.setAttributeNS(null,'height',Rect1hau/6);
	lin1.setAttributeNS(null,'x',xcenter-((Rect1lar/6)/2));
	lin1.setAttributeNS(null,'y',ycenter);
	lin1.setAttributeNS(null,'width',Rect1lar/6);
	
	lin2.setAttributeNS(null,'x',xcenter);
	lin2.setAttributeNS(null,'y',ycenter-((Rect1hau/6)/2));
	lin2.setAttributeNS(null,'height',Rect1hau/6);
	}
	else
	{
		Rect1.setAttributeNS(null,'x',xcenter-(parseFloat(Rect1.getAttributeNS(null,'width'))/2));
		Rect1.setAttributeNS(null,'y',ycenter-(parseFloat(Rect1.getAttributeNS(null,'height'))/2));	
		lin1.setAttributeNS(null,'x',xcenter-(parseFloat(Rect1.getAttributeNS(null,'width'))/2));
		lin1.setAttributeNS(null,'y',ycenter);
		lin2.setAttributeNS(null,'x',xcenter);
		lin2.setAttributeNS(null,'y',ycenter-(parseFloat(Rect1.getAttributeNS(null,'height'))/2));											   }
	}
	else
	{
	svgdoc.getElementById('locationRect').setAttributeNS(null,'pointer-events','visible');	
	svgdoc.getElementById('Rect1').setAttributeNS(null,'visibility','hidden');
	svgdoc.getElementById('lin1').setAttributeNS(null,'visibility','hidden');
	svgdoc.getElementById('lin2').setAttributeNS(null,'visibility','hidden');
	}
}
function Zoomto(evt,tovalue,x)
{
	
	//svgdoc.getElementById("rectzoom").setAttributeNS(null,'y',109-((tovalue-zoommin)/(zoommax-zoommin))*79);
	svgdoc.getElementById("rectzoom").setAttributeNS(null,'y',109-Math.pow(((tovalue-zoommin)/(zoommax-zoommin)),1/3)*79);
	zoomVal = parseInt(tovalue);
	theZoom  = zoomVal;
	gest_zoom(evt,theZoom);
	
	
	newViewport = xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
	svgMainViewport.setAttributeNS(null,'viewBox',newViewport);

	
	if (zoomVal>zoommin)
		{
		var zoomin=svgdoc.getElementById('moins');
		zoomin.setAttributeNS(null,'pointer-events','visible');
		zoomin.setAttributeNS(null,'opacity','1');
		}
	else
		{
		zoomin=svgdoc.getElementById('moins');
		zoomin.setAttributeNS(null,'pointer-events','none');
		zoomin.setAttributeNS(null,'opacity','0.2');
		}
	if (zoomVal==zoommax)
		{
		zoomin=svgdoc.getElementById('plus');
		zoomin.setAttributeNS(null,'pointer-events','none');
		zoomin.setAttributeNS(null,'opacity','0.2');
		}
	else
		{
		zoomin=svgdoc.getElementById('plus');
		zoomin.setAttributeNS(null,'pointer-events','visible');
		zoomin.setAttributeNS(null,'opacity','1');
		}
		initScaleBar(evt);
		lecture_control();
		
}
/*function getDataFile(myUrlString , useData) {
	//call getURL() if available
	if (window.getURL) {
		getURL(myUrlString , useData);
	}
	else
	//call XMLHttpRequest() if available
	if (window.XMLHttpRequest) {
		function XMLHttpRequestCallback() {
			if (xmlRequest.readyState == 4) {
				useData({success:xmlRequest.status,content:xmlRequest.responseText,contentType:xmlRequest.getResponseHeader("Content-Type")})
			}
		}
		var xmlRequest = null;
		xmlRequest = new XMLHttpRequest();
		xmlRequest.open("GET",myUrlString,true);
		xmlRequest.onreadystatechange = XMLHttpRequestCallback;
		xmlRequest.send(null);
	}
	//write an error message if either method is not available
	else {
		alert("your browser/svg viewer neither supports window.getURL nor window.XMLHttpRequest!");
	}		
}*/

function getSVGObject(myUrlString , addSVGObject) {
	//call getURL() if available
	if (window.getURL) {
		MyaddObject = addSVGObject;
		getURL(myUrlString,addObjectGetURL);
	}
	else
	//call XMLHttpRequest() if available
	if (window.XMLHttpRequest) {
		//this nested function is used to make XMLHttpRequest threadsafe
		//(subsequent calls would not override the state of the request and can use the variable/object context of the parent function)
		//this idea is borrowed from http://www.xml.com/cs/user/view/cs_msg/2815 (brockweaver)
		function XMLHttpRequestCallback() {
			if (xmlRequest.readyState == 4) {
				if(nav==0)
				{
				addSVGObject({success:xmlRequest.status,content:xmlRequest.responseText,contentType:xmlRequest.getResponseHeader("Content-Type")})
				}
				
				else
				{
				
				if (xmlRequest.status == 200) {
						//parse and import the SVG fragment
						var importedNode = document.importNode(xmlRequest.responseXML.documentElement,true);
						//call function addGeom
						addSVGObject(importedNode)
				}
				}
			}
		}
		var xmlRequest = null;
		xmlRequest = new XMLHttpRequest();
		xmlRequest.open("GET",myUrlString,true);
		xmlRequest.onreadystatechange = XMLHttpRequestCallback;
		xmlRequest.send(null);
	}
	//write an error message if either method is not available
	else {
		alert("your browser/svg viewer neither supports window.getURL nor window.XMLHttpRequest!");
	}		
}

//this function is only necessary for getURL()
function addObjectGetURL(data) {
	//check if data has a success property
	if (data.success) {
		//parse content of the XML format to the variable "node"
		var node = parseXML(data.content, document);
		var importedNode = node.firstChild
		MyaddObject(importedNode);
	}
	else {
		alert("something went wrong with dynamic loading of geometry!");
	}
}


function HTTP() {
 var xmlhttp
  try {
   xmlhttp = new XMLHttpRequest();
  } catch (e) {
   //xmlhttp=false
   try  
  {  
  // Internet Explorer 
  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
 catch (e)
 {xmlhttp=false}
  }
  
  
 return xmlhttp
}
if (typeof postURL=='undefined') {
 postURL=function(url,txt,fn,type,enc) {
  var xmlhttp=new HTTP();
  if (xmlhttp) {
   xmlhttp.open("POST",url,true);
   if (enc) xmlhttp.setRequestHeader("Content-Encoding",enc)
   if (type) xmlhttp.setRequestHeader("Content-Type",type)
   xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4) {
					try {		
      fn({success:xmlhttp.status,content:xmlhttp.responseText,
      	contentType:xmlhttp.getResponseHeader("Content-Type")})
					} catch (e) {
						fn.operationComplete({success:xmlhttp.status,content:xmlhttp.responseText,contentType:xmlhttp.getResponseHeader("Content-Type")})
     }
    }
   }
   xmlhttp.send(txt)
  } else {
  alert("trugudu")
   //Some Appropriate Fallback...
  }
 }
}

if (typeof printNode=='undefined') {
printNode= function (el) {
   return (new XMLSerializer()).serializeToString(el);
};
}

function initScaleBar(evt)
{
	rectOvewidth = parseFloat(svgRect.getAttributeNS(null,'width'));
	svgdoc.getElementById('droite').firstChild.data=parseFloat(parseInt((rectOvewidth/larmap)*50*100))/100;
}

function clear(id1)
{
while (document.getElementById(id1).hasChildNodes())
{
document.getElementById(id1).removeChild(document.getElementById(id1).firstChild);
}
}

function masque()
{
if(window.top.document.getElementById('coche_masque').checked==false)
						{	
						svgdoc.getElementById('dessin').setAttributeNS(null,'clip-path', 'none');
						}
						else
						{
						svgdoc.getElementById('dessin').setAttributeNS(null,'clip-path', 'url(#masque)');	
						}
}

function extracthtml(libelle,couche,id,raster)
{
	
	var reg=new RegExp("[;]", "g");
	var tablayers=couche.split(reg);	
	var nblayer = tablayers.length ;
	if(nblayer>1)
		{
			if(svgdoc.getElementById('control'+parseInt(tablayers[0])).getAttributeNS(null,'visibility') == 'visible' && window.top.document.getElementById('coche'+parseInt(tablayers[0])).checked==false)
				{
				svgdoc.getElementById('control'+parseInt(tablayers[0])).setAttributeNS(null,'visibility','hidden');
				window.top.document.getElementById('coche'+parseInt(tablayers[0])).checked=false;
				
							var cher=new RegExp("[|]", "g");
								var tableau=libelle.split(cher);
								for (var i=0; i<tableau.length; i++) 
								{
									suppvarraster(tableau[i]);
 								}
								if(raster=='')
								{
									for (var i=0; i<tableau.length; i++) 
									{
 									zlayer[tableau[i]].svg_visible='false';
									}
									
								}
						lecture_control();	
							for(i=0;i<nblayer;i++)
							{
				svgdoc.getElementById('control'+tablayers[i]).setAttributeNS(null,'visibility','hidden');
							window.top.document.getElementById('coche'+tablayers[i]).checked=false;
							}
					
				}
			else
			{
				
			svgdoc.getElementById('control'+parseInt(tablayers[0])).setAttributeNS(null,'visibility','visible');
			window.top.document.getElementById('coche'+parseInt(tablayers[0])).checked=true;
					if(raster=="raster")
							{	
								coucherastervisible+=libelle+";";
							}
					else
							{
								var cher=new RegExp("[|]", "g");
								var tableau=libelle.split(cher);
								for (var i=0; i<tableau.length; i++) 
								{
									zlayer[tableau[i]].svg_visible='true';
								}
							}
							lecture_control();
				for(i=0;i<nblayer;i++)
					{
						
						window.top.document.getElementById('coche'+tablayers[i]).checked=true;
						svgdoc.getElementById('control'+tablayers[i]).setAttributeNS(null,'visibility','visible');
					}			
				
				couche_init=0;
			}
		}
		else
		{
			
			if(svgdoc.getElementById('control'+couche).getAttributeNS(null,'visibility') == 'visible')
			{
				
				svgdoc.getElementById('control'+couche).setAttributeNS(null,'visibility','hidden');
				window.top.document.getElementById('coche'+couche).checked=false;
				var boucl=window.top.document.getElementById("leg" + parseInt(couche)).so;
				var testcontro=0;	
					for (i=1;i<=boucl;i++)
					{
						if(window.top.document.getElementById('coche'+parseInt(couche)+codalph(i)).checked==false)
						{
						testcontro=testcontro+0;	
						}
						else
						{
						testcontro=testcontro+1;
						}
						
					}
					
					
					if(testcontro==0)
						{
						window.top.document.getElementById('coche'+parseInt(couche)).checked=false;
						svgdoc.getElementById('control'+parseInt(couche)).setAttributeNS(null,'visibility','hidden');
						}
			
								
								suppvarraster(libelle);
								if(raster=='')
								{
								zlayer[libelle].svg_visible='false';
								}
								lecture_control();
								
								
			}
			
			else
			{
				
				svgdoc.getElementById('control'+couche).setAttributeNS(null,'visibility','visible');
				window.top.document.getElementById('coche'+couche).checked=true;
				if(isNaN(couche))
						 {
							window.top.document.getElementById('coche'+parseInt(couche)).checked=true;
						 }
						 
						if(raster=="raster")
							{	
								coucherastervisible+=libelle+";";
							}
						else
							{
								zlayer[libelle].svg_visible='true';
							}
							lecture_control();
							
			}
		}
	
}
function affect_couche(x)
{
couchesvgvisible=x;	
}
function test_type(x)
{
var exp=new RegExp("[;]+","g");	
var tabrasteur=coucherastervisible.split(';');
type="vector";
for (var i=0;i<tabrasteur.length;i++)
{
	if(tabrasteur[i]==x)
	{
	type="raster";
	}
}
return type;
}
function extraction(x)
{
	if(x=="controlraster")
	{
		var reg=new RegExp("( )", "g");
	coucherasteraenvoyer=coucherastervisible.replace(reg,"_");
	coucherasteraenvoyer=coucherasteraenvoyer.substr(0,coucherasteraenvoyer.length-1)
	var url="charge.php?sansplug="+sansplug+"&type=raster&raster="+coucherasteraenvoyer+"&layer=" + x + "&x="+ xnulcorner + "&y=" + ynulcorner + "&lar=" + nWidth  + "&hau=" + nHeight+ "&zoom=" + zoomVal  + "&sessionname=" + sessionname + "&sessionid=" + sessionid + "&xini=" + xini + "&yini=" + yini ;
	animation();
	getSVGObject(url,retour_extract);
	}
	else
	{
		if(nav==1)
	{
cou=convasc(couchesvgvisible);
var url='charge.php?sansplug='+sansplug+'&type=svg&raster='+ cou +'&layer=' + x + '&x='+ xnulcorner + '&y=' + ynulcorner + '&lar=' + nWidth  + '&hau=' + nHeight+ '&zoom=' + zoomVal  + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&xini=' + xini + '&yini=' + yini+ '&nav=' + nav + '&placid=' + placid;
	}
	else	{	
	var url='charge.php?sansplug='+sansplug+'&type=svg&raster='+couchesvgvisible+'&layer=' + x + '&x='+ xnulcorner + '&y=' + ynulcorner + '&lar=' + nWidth  + '&hau=' + nHeight+ '&zoom=' + zoomVal  + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&xini=' + xini + '&yini=' + yini+ '&nav=' + nav + '&placid=' + placid;}
	animation();
	getSVGObject(url,retour_extract);
	couchesvgvisible="";
	}
}

function convasc(data)
{
		var res='';
		var reg=new RegExp(String.fromCharCode(224), "g");
		var reg1=new RegExp(String.fromCharCode(233), "g");
		var reg2=new RegExp(String.fromCharCode(232), "g");
		var reg3=new RegExp(String.fromCharCode(234), "g");
		var reg4=new RegExp(String.fromCharCode(226), "g");
		var reg5=new RegExp(String.fromCharCode(231), "g");
		var reg6=new RegExp(String.fromCharCode(244), "g");
		var reg7=new RegExp(String.fromCharCode(238), "g");
		var reg8=new RegExp(String.fromCharCode(251), "g");
		var reg9=new RegExp(String.fromCharCode(60), "g");
		var reg10=new RegExp(String.fromCharCode(62), "g");
		//var reg11=new RegExp(String.fromCharCode(63), "g");
		var reg12=new RegExp(String.fromCharCode(34), "g");
		var reg13=new RegExp(String.fromCharCode(39), "g");
		var reg14=new RegExp(String.fromCharCode(35), "g");
		var reg15=new RegExp(String.fromCharCode(33), "g");
		var reg16=new RegExp(String.fromCharCode(95), "g");
		res=data.replace(reg,"chr(224)");
		res=res.replace(reg1,"chr(233)");
		res=res.replace(reg2,"chr(232)");
		res=res.replace(reg3,"chr(234)");
		res=res.replace(reg4,"chr(226)");
		res=res.replace(reg5,"chr(231)");
		res=res.replace(reg6,"chr(244)");
		res=res.replace(reg7,"chr(238)");
		res=res.replace(reg8,"chr(251)");
		res=res.replace(reg9,"chr(60)");
		res=res.replace(reg10,"chr(62)");
		//res=res.replace(reg11,"chr(63)");
		res=res.replace(reg12,"chr(34)");
		res=res.replace(reg13,"chr(39)");
		res=res.replace(reg14,"chr(35)");
		res=res.replace(reg15,"chr(33)");
		res=res.replace(reg16,"chr(95)");
		return res
}

function create_use(id,x,y,coul,size,su,lie,elem,symbo,rota,contenu)
{
	//new_node =svgdoc.createElementNS(svgns,"use");
	var target=svgdoc.getElementById(symbo);
	var new_node=target.cloneNode(false);
	if(rota!="")
	{
	new_node.setAttributeNS(null,"transform","matrix("+size+" 0 0 -"+size+" "+x+" "+y+") rotate("+rota+")");
	}
	else
	{
	new_node.setAttributeNS(null,"transform","matrix("+size+" 0 0 -"+size+" "+x+" "+y+")");	
	}
	//new_node.setAttributeNS(null,"transform","rotate("+x+","+y+","+rota+")");
	//new_node.setAttributeNS(null,"size",size);
	//new_node.setAttributeNS(null,"x",x);
	//new_node.setAttributeNS(null,"y",y);
	//new_node.setAttributeNS(null,"transform","scale(0.01)");
	//new_node.setAttributeNS(null,"transform","scale(0.9) rotate("+rota+","+x+","+y+")");
	//new_node.setAttributeNS(null,"transform","rotate(270,"+x+","+y+") scale("+size+")");
	
	//new_node.setAttributeNS(null,"transform","rotate("+rota+", "+x+", "+y+")");
	//new_node.setAttributeNS(null,"transform","translate(-"+x*(size-1)+", -"+y*(size-1)+") scale("+size+")");
	
	if(lie!="")
	{
	new_node.setAttributeNS(null,"onclick",lie);
	}
	if(coul!="")
	{
	new_node.setAttributeNS(null,"onmouseover",su+";showinfotip(evt,'"+contenu+"')");
	new_node.setAttributeNS(null,"onmouseout","switchColor(evt,'fill','"+coul+"','','"+id+"');hideinfotip(evt)");
	}
	new_node.setAttributeNS(null,"id",id);
	new_node.setAttributeNS(null,"fill",coul);
	//new_node.setAttributeNS(null,"visibility","visible");
	//new_node.setAttributeNS(xlinkns,"xlink:href","#"+symbo);
	svgdoc.getElementById(elem).appendChild(new_node);
}
function retour_extract(data)
{
var elem=data.getAttributeNS(null,"id");
if(elem=='controlraster')
		{
			var image = svgdoc.createElementNS(svgns,"image");
		image.setAttributeNS(null,"x",xnulcorner);
		image.setAttributeNS(null,"y",ynulcorner);
		image.setAttributeNS(null,"width",nWidth);
		image.setAttributeNS(null,"height",nHeight);
		image.setAttributeNS(null,"id","ima");
		image.setAttributeNS(xlinkns,"xlink:href",data.getAttributeNS(null,"n"));
		svgdoc.getElementById(elem).appendChild(image);
		}
		else if(data.getAttributeNS(null,"attribu")=="symbole")
		{
			
			coorx=data.getAttributeNS(null,"coorx").split("|");
			coory=data.getAttributeNS(null,"coory").split("|");
			ref=data.getAttributeNS(null,"ref").split("|");
			coul=data.getAttributeNS(null,"coul").split("|");
			ident=data.getAttributeNS(null,"ident").split("|");
			lie=data.getAttributeNS(null,"lie");
			surcoul=data.getAttributeNS(null,"surcoul");
			rotation=data.getAttributeNS(null,"rotation").split("|");
			contenu=data.getAttributeNS(null,"contenu").split("|");
			
			size=(Math.round(data.getAttributeNS(null,"taille")/2.4)/1000);
		for (var i=0; i<coorx.length; i++) 
		{
		su="switchColor(evt,'fill','"+surcoul+"','','"+ident[i]+"')";
		if(rotation!="")
		{
		create_use(ident[i],coorx[i],coory[i],coul[i],size,su,lie,elem,ref[i],rotation[i],contenu[i])
		}
		else
		{
		create_use(ident[i],coorx[i],coory[i],coul[i],size,su,lie,elem,ref[i],'',contenu[i])	
		}
		}
		
		}
		else
		{
svgdoc.getElementById(elem).appendChild(data);
		}
cache();
}

 function clear_legende()
 {
	var nb = layer.length;
n=nblayer-1;
	for(a=0;a<n;a++)
	{
	
		r=a+1; 
		if(window.top.document.getElementById("leg" + r).getAttribute("so")>0)
			{
				window.top.document.getElementById("coche"+r).checked=false;
				l=window.top.document.getElementById("leg" + r).getAttribute("so");
				for(z=1;z<=l;z++)
							{
							window.top.document.getElementById('coche'+r+codalph(z)).checked=false;
							}
			}
			else
			{
			window.top.document.getElementById("coche"+r).checked=false;	
			}
	}
}
 function lecture_control(id)
{
var nb = layer.length;
n=nblayer-1;
for(a=0;a<n;a++)
{
	
	r=a+1;
	if(controllay[a].zoommax<zoomVal || controllay[a].zoommin>zoomVal)
	{

		if(window.top.document.getElementById("leg" + r).getAttribute("so")>0)
			{
				l=window.top.document.getElementById("leg" + r).getAttribute("so");
				if(window.top.document.getElementById("imleg" + r).d== "2")
					{
						top.derou("leg" + r,l);
						for(z=1;z<=l;z++)
							{
							
							window.top.document.getElementById('coche'+r+codalph(z)).checked=false;
							window.top.document.getElementById("coche"+r+codalph(z)).disabled=true;
							}
						
					}
					for(z=1;z<=l;z++)
						{
							svgdoc.getElementById("control"+r+codalph(z)).setAttributeNS(null,'visibility','hidden');
							
							vari=window.top.document.getElementById("coche"+r+codalph(z)).getAttribute("ind");
							vari=layer[vari];
							suppvarraster(vari)
							if(controllay[a].type=='')
								{
								zlayer[vari].svg_visible='false';
								}
						}
						
			}
			else
			{
				vari=window.top.document.getElementById("coche"+r).getAttribute("ind");
				vari=layer[vari];
					if(controllay[a].type=='')
								{
								zlayer[vari].svg_visible='false';
								}
				suppvarraster(vari);
			}
			
			
			svgdoc.getElementById("control"+r).setAttributeNS(null,'visibility','hidden');
			window.top.document.getElementById("coche"+r).checked=false;
			window.top.document.getElementById("coche"+r).disabled=true;
		
			
			
	}
	else
	{
		window.top.document.getElementById("coche"+r).disabled=false;
		if(window.top.document.getElementById("leg" + r).getAttribute("so")>0)
			{
				l=window.top.document.getElementById("leg" + r).getAttribute("so");
				for(z=1;z<=l;z++)
							{
							
							window.top.document.getElementById("coche"+r+codalph(z)).disabled=false;
							}
			}
		
	}
	top.retourfocus();
}


	for (b=0;b<nb;b++)
	{
	var axex="nok";
	var axey="nok";
		if(zlayer[layer[b]].svg_visible=='true')
		{
			
			if(zlayer[layer[b]].svg_zoomraster>zoomVal || ((nWidth*3300/larmap)>5221 && zlayer[layer[b]].svg_partiel=='1'))
			{
				
				clear('control'+zlayer[layer[b]].svg_controle);
				zlayer[layer[b]].svg_zoom_charge='';
				suppvarraster(layer[b])	;
				coucherastervisible+=layer[b]+";";
				
			}
			else
			{
							
							suppvarraster(layer[b]);
							if((zlayer[layer[b]].svg_zoom_charge=='' || (zlayer[layer[b]].svg_force_charge=='1' && couche_init==1)) || layer[b]=='000.postit')
								{
									couchesvgvisible=layer[b];
									zlayer[layer[b]].svg_zoom_charge=zoomVal;
									zlayer[layer[b]].svg_position=xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
									clear('control'+zlayer[layer[b]].svg_controle)
									extraction('control'+zlayer[layer[b]].svg_controle);
								}
								else if(zlayer[layer[b]].svg_zoom_charge<=zoomVal || zlayer[layer[b]].svg_partiel!='1')
								{
									var cher=new RegExp("[ ]+", "g");
									var tableau=zlayer[layer[b]].svg_position.split(cher);
									lar1=parseFloat(tableau[0])+parseFloat(tableau[2]);
									lar2=xnulcorner+nWidth;
									hau1=parseFloat(tableau[1])+parseFloat(tableau[3]);
									hau2=ynulcorner+nHeight;
									
									if(parseFloat(tableau[0])<=xnulcorner && lar1>=lar2)
									{
										axex='ok';
									}
									if(parseFloat(tableau[1])<=ynulcorner && hau1>=hau2)
									{
										axey='ok';
									}
									if((axex!='ok' || axey!='ok') && zlayer[layer[b]].svg_partiel=='1')
									{
										couchesvgvisible=layer[b];
										zlayer[layer[b]].svg_zoom_charge=zoomVal;
										zlayer[layer[b]].svg_position=xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
										clear('control'+zlayer[layer[b]].svg_controle);
										extraction('control'+zlayer[layer[b]].svg_controle);
									}
									
								}
								else
								{
									couchesvgvisible=layer[b];
										zlayer[layer[b]].svg_zoom_charge=zoomVal;
										zlayer[layer[b]].svg_position=xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
										clear('control'+zlayer[layer[b]].svg_controle);
										extraction('control'+zlayer[layer[b]].svg_controle);
								}
								
				
			}
		}
	}
	if((coucherastervisible=="" || coucherastervisible==";" || coucherastervisible==";;") && couraster==0)
	{
	clear('controlraster');
	couraster=1;
	coucherastervisible="";
	}
	if(coucherastervisible!="" && coucherastervisible!=";" && coucherastervisible!=";;")
							{
							posiactu=xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
							if(posiactu!=coucherasterposi || coucherastervisible!=coucherasterold)
							{
							clear('controlraster');
							extraction('controlraster');
							couraster=0;
							coucherasterposi=xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
							coucherasterold=coucherastervisible;
							}
							}
							else
							{
							coucherasterposi="";
							coucherasterold="";
							}
														
}

function suppvarraster(x)
{
var exp=new RegExp("[;]+","g");
var tabrasteur=coucherastervisible.split(exp);
for (var i=0;i<tabrasteur.length;i++)
{
	if(tabrasteur[i]==x)
	{
	tabrasteur.splice(i,1);
	}
}
coucherastervisible="";
if(tabrasteur.length>0)
{
for (var i=0;i<tabrasteur.length;i++)
{
coucherastervisible+=tabrasteur[i]+";";	
}
}
if(coucherastervisible==";" || coucherastervisible==";;")
{
coucherastervisible="";
}
}

function animation(evt)
{
//window.top.document.getElementById('message_box').style.visibility="visible";
affiche_div('message_box');
 }
function cache()
{
//window.top.document.getElementById('message_box').style.visibility="hidden";
affiche_div('message_box');
}


function Zoomless(evt)
{
zoomVal = zoomVal - 50;
if(zoomVal<zoommin)
zoomVal=zoommin;

Zoomto(evt,zoomVal);
}

function Zoommore(evt)
{
zoomVal = zoomVal +50;
if(zoomVal>zoommax)
zoomVal=zoommax;

Zoomto(evt,zoomVal);
}

function beginPan(evt) 
{
	
	if(press==1)
	{
	endPan(evt);
	press=0;
	}
	else
	{
	press=1;
	
	root=svgdoc.getElementById("overviewmap");
	tx=root.currentTranslate.x;
	ty=root.currentTranslate.y;
	vtX=evt.clientX-tx;
	vtY=evt.clientY-ty;
	rect1Ovewidth = parseFloat(Rect1.getAttributeNS(null,'width'));
	rect1Oveheight = parseFloat(Rect1.getAttributeNS(null,'height'));
	rect1UlXCorner = parseFloat(Rect1.getAttributeNS(null,'x'));
	rect1UlYCorner = parseFloat(Rect1.getAttributeNS(null,'y'));
	}
	
}

function doPan(evt)
{
	
	if (press==1 ) 
		{
		
		rectOvewidth = parseFloat(svgRect.getAttributeNS(null,'width'));
		rectOveheight = parseFloat(svgRect.getAttributeNS(null,'height'));
		rectUlXCorner = parseFloat(svgRect.getAttributeNS(null,'x'));
		rectUlYCorner = parseFloat(svgRect.getAttributeNS(null,'y'));
		root=svgdoc.getElementById("overviewmap");
		tx=root.currentTranslate.x;
		ty=root.currentTranslate.y;
		newEvtX=evt.clientX-tx;
		newEvtY=evt.clientY-ty;
				
		pluginPixWidth = root.getAttribute("width");
		pluginPixHeight = root.getAttribute("height");
		var allWidth = largeurini;
		var allHeight = hauteurini;
	
			if(hauteurini*ratiovue>largeurini)
				{
				twidth = allHeight*ratiovue;
				theight = allHeight;
		
				}
			else
				{
				twidth = allWidth;
				theight = allWidth/ratiovue;
				}
				
		toMoveX = rectUlXCorner + ((newEvtX - vtX)/ratio)* twidth / pluginPixWidth;
		toMoveY = rectUlYCorner+((newEvtY - vtY)/ratio)* theight / pluginPixHeight;
		toMoveX1 = rect1UlXCorner + ((newEvtX - vtX)/ratio)* twidth / pluginPixWidth;
		toMoveY1 = rect1UlYCorner+((newEvtY - vtY)/ratio)* theight / pluginPixHeight;
		
	
			
			if (toMoveX < rectXcorner) 
				{
				svgRect.setAttributeNS(null,'x',rectXcorner);
				Rect1.setAttributeNS(null,'x',rectXcorner+(rectOvewidth/2)-(rect1Ovewidth/2));
				lin1.setAttributeNS(null,'x',rectXcorner+(rectOvewidth/2)-(rect1Ovewidth/2));
				lin2.setAttributeNS(null,'x',rectXcorner+(rectOvewidth/2));
				}
			else if ((toMoveX + rectOvewidth) >allWidth) 
				{
				
				svgRect.setAttributeNS(null,'x',rectXcorner + allWidth - rectOvewidth);
				Rect1.setAttributeNS(null,'x',rectXcorner + allWidth - rectOvewidth+(rectOvewidth/2)-(rect1Ovewidth/2));
				lin1.setAttributeNS(null,'x',rectXcorner + allWidth - rectOvewidth+(rectOvewidth/2)-(rect1Ovewidth/2));
				lin2.setAttributeNS(null,'x',rectXcorner + allWidth - rectOvewidth+(rectOvewidth/2));
				}
			else 
				{
				svgRect.setAttributeNS(null,'x',toMoveX);
				Rect1.setAttributeNS(null,'x',toMoveX1);
				lin1.setAttributeNS(null,'x',toMoveX1);
				lin2.setAttributeNS(null,'x',toMoveX1+(rect1Ovewidth/2));
				}
			if (toMoveY < rectYcorner) 
				{
				svgRect.setAttributeNS(null,'y',rectYcorner);
				Rect1.setAttributeNS(null,'y',rectYcorner+(rectOveheight/2)-(rect1Oveheight/2));
				lin1.setAttributeNS(null,'y',rectYcorner+(rectOveheight/2));
				lin2.setAttributeNS(null,'y',rectYcorner+(rectOveheight/2)-(rect1Oveheight/2));
				}
			else if ((toMoveY + rectOveheight) > (allHeight)) 
				{
				svgRect.setAttributeNS(null,'y',rectYcorner + allHeight - rectOveheight);
				Rect1.setAttributeNS(null,'y',rectYcorner + allHeight - rectOveheight+(rectOveheight/2)-(rect1Oveheight/2));
				lin1.setAttributeNS(null,'y',rectYcorner + allHeight - (rectOveheight/2));
				lin2.setAttributeNS(null,'y',rectYcorner + allHeight - (rectOveheight/2)-(rect1Oveheight/2));
				}
			else 
				{
				svgRect.setAttributeNS(null,'y',toMoveY);
				Rect1.setAttributeNS(null,'y',toMoveY1);
				lin1.setAttributeNS(null,'y',toMoveY1+(rect1Oveheight/2));
				lin2.setAttributeNS(null,'y',toMoveY1);
				}
		vtX = newEvtX;
		vtY = newEvtY;
		rectUlXCorner = parseFloat(svgRect.getAttributeNS(null,'x'));
		rectUlYCorner = parseFloat(svgRect.getAttributeNS(null,'y'));
		rect1UlXCorner = parseFloat(Rect1.getAttributeNS(null,'x'));
		rect1UlYCorner = parseFloat(Rect1.getAttributeNS(null,'y'));
		}
		
}

function endPan(evt) 
	{
	
if (press==1)
		{
	rectOveXcorner = parseFloat(svgRect.getAttributeNS(null,'x'));
	rectOveYcorner = parseFloat(svgRect.getAttributeNS(null,'y'));
	y = svgMainViewport.currentTranslate.y;
	x = svgMainViewport.currentTranslate.x;
	ynulcorner = parseFloat(rectOveYcorner + (y*100/zoomVal));
	xnulcorner = parseFloat(rectOveXcorner + (x*100/zoomVal));
	nWidth = parseFloat(svgRect.getAttributeNS(null,'width'));
	nHeight = parseFloat(svgRect.getAttributeNS(null,'height'));
	xcenter = rectOveXcorner + rectOvewidth / 2;
	ycenter = rectOveYcorner + rectOveheight / 2;
	newViewport = xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
	svgMainViewport.setAttributeNS(null,'viewBox',newViewport);
	lecture_control();
	
		}
		
	press=0;

}

function goEast(evt)
{
	if (theZoom !=100) 
		{
		
		x = svgMainViewport.currentTranslate.x;
		rectX = parseFloat(svgRect.getAttributeNS(null,'x'));
		w =  parseFloat(svgRect.getAttributeNS(null,'width'));
		z= rectX + w;
		if (z < (largeurini))
			{
			attribution('x',rectX,'+');
			lecture_control();
			}
		}
}

function goWest(evt)
	{
	if (theZoom !=100)
		{
		
		x = svgMainViewport.currentTranslate.x;
		rectX = parseFloat(svgRect.getAttributeNS(null,'x'));
		if (rectX > 0)
			{
			attribution('x',rectX,'-');
			lecture_control();
			}
		}
}

function goNorth(evt)
{
	if (theZoom!=100)
		{
		rectY = parseFloat(svgRect.getAttributeNS(null,'y'));
		if (rectY > 0)
			{
			attribution('y',rectY,'-');
			lecture_control();
			}
		}
}

function goSouth(evt)
{
	if (theZoom !=100) 
		{
		rectY = parseFloat(svgRect.getAttributeNS(null,'y'));
		h= parseFloat(svgRect.getAttributeNS(null,'height'));
		z= rectY+h;
			if (z < (hauteurini)) 
			{
			attribution('y',rectY,'+');
lecture_control();
			}
		}
}

function attribution(pos,rectval,signe)
{
	rectX = parseFloat(svgRect.getAttributeNS(null,pos));
		if(pos=='x')
		{
		att =  parseFloat(svgRect.getAttributeNS(null,'width'));
		}
		else
		{
		att =  parseFloat(svgRect.getAttributeNS(null,'height'));	
		}
		if(signe=='+')
		{
		rectX = rectval + att/6;
		l1=-att/6;
		l2=l1;
		r1=l1;
		}
		else
		{
		rectX = rectval - att/6
		l1=att/6;
		l2=l1;
		r1=l1;
		}
			svgRect.setAttributeNS(null,pos, rectX);
			rectOveXcorner = parseFloat(svgRect.getAttributeNS(null,'x'));
			rectOveYcorner = parseFloat(svgRect.getAttributeNS(null,'y'));
			y = svgMainViewport.currentTranslate.y;
			x = svgMainViewport.currentTranslate.x;
			ynulcorner = parseFloat(rectOveYcorner + (y*100/zoomVal));
			xnulcorner  = parseFloat(rectOveXcorner + (x*100/zoomVal));
			nWidth = parseFloat(svgRect.getAttributeNS(null,'width'));
			nHeight = parseFloat(svgRect.getAttributeNS(null,'height'));
			newViewport = xnulcorner + ' ' + ynulcorner + ' ' + nWidth + ' ' + nHeight;
			svgMainViewport.setAttributeNS(null,'viewBox',newViewport);
			lin1 = svgdoc.getElementById('lin1');
			xlin1 = parseFloat(lin1.getAttributeNS(null,pos));
	lin1.setAttributeNS(null,pos,(xlin1- l1));
	lin2 = svgdoc.getElementById('lin2');
	xlin2 = parseFloat(lin2.getAttributeNS(null,pos));
	lin2.setAttributeNS(null,pos,(xlin2 - l2));
	rect1 = svgdoc.getElementById('Rect1');
	xrect1 = parseFloat(rect1.getAttributeNS(null,pos));
	rect1.setAttributeNS(null,pos,(xrect1 - r1));
}

function Zoomin(evt)
{

	objbgrectevt = svgdoc.getElementById('bgrectevt');
	objbgrectevt.setAttributeNS(null,'pointer-events','visible');
	objbgrectevt.setAttributeNS(null,'visibility','visible');
	zoomtool = 'zoomin';
	svgdoc.getElementById('releasezoom').setAttributeNS(null,'visibility','visible');
	svgdoc.getElementById('releasezoom').setAttributeNS(null,'pointer-events','visible');
	
}

function beginResize(evt)
{
coordonne(evt);	

RevtX=xm;
RevtY=ym;

	if (zoomtool == 'zoomin')
		{
		var objrectevt;
		
		if ((RevtX > xnulcorner) && (RevtX < nWidth+xnulcorner) && (RevtY> ynulcorner ) && (RevtY <=  nHeight+ynulcorner))
			{
			Rpressed = 1;
			objrectevt = svgdoc.getElementById('rectevt');
			objrectevt.setAttributeNS(null,'x',RevtX);
			objrectevt.setAttributeNS(null,'y',RevtY);
			}
	}
}

function doResize(evt){
if ((Rpressed == 1) && (zoomtool == 'zoomin'))
	{
coordonne(evt);	
RnewevtX =xm;
RnewevtY =ym;
objrectevt = svgdoc.getElementById('rectevt');
	if ((RnewevtX >= xnulcorner) && (RnewevtX <= nWidth+xnulcorner))
		{
		if (RnewevtX > RevtX)
			{
			widthrect = RnewevtX - RevtX;
			}	
		else
			{
			objrectevt.setAttributeNS(null,'x',RnewevtX);
			widthrect = - (RnewevtX - RevtX);
			}
		}
	else
		{
		if (RnewevtX < xnulcorner)
			{
			objrectevt.setAttributeNS(null,'x',RnewevtX);
			widthrect = -(xnulcorner-RevtX);
			} 
		if (RnewevtX > nWidth+xnulcorner)
			{
			widthrect = nWidth+xnulcorner-RevtX;
			}
		}
	if ((RnewevtY> ynulcorner ) && (RnewevtY <= ynulcorner + nHeight))
		{	
		if (RnewevtY > RevtY)
			{
			heightrect = RnewevtY - RevtY;
			}
		else
			{
			objrectevt.setAttributeNS(null,'y',RnewevtY);
			heightrect = -(RnewevtY - RevtY);
			}
		}
	else
		{
		if (RnewevtY<= ynulcorner )
			{
			objrectevt.setAttributeNS(null,'y',RnewevtY);
			heightrect = -(ynulcorner - RevtY);
			}
		if (RnewevtY > ynulcorner + nHeight)	
			{
			heightrect = nHeight+ynulcorner - RevtY;
			}
		}
	objrectevt.setAttributeNS(null,'height',heightrect);
	objrectevt.setAttributeNS(null,'width',widthrect);
	objrectevt.setAttributeNS(null,'visibility','visible');
	}
}

function endResize(evt)
{
	if ((Rpressed == 1) && (zoomtool == 'zoomin'))
	{
	objrectevt = svgdoc.getElementById('rectevt');
	objrectevt.setAttributeNS(null,'visibility','hidden');
	rectOvewidth = objrectevt.getAttributeNS(null,'width');
	realzoom = parseFloat((nWidth/rectOvewidth)*(zoomVal));
	if (realzoom >= zoommax )
	{Zoomto(evt,zoommax);}
	else if (realzoom <= zoommin)
	{Zoomto(evt,zoommin);}
	else
	{Zoomto(evt,realzoom);}
	/*if (realzoom >= zoommax ) 
		{
		zmax=zoommin+parseFloat(intervale*18)
		Zoomto(evt,zoommax);
		}
		else
		{
	var debut=zoommin;
	var debut1=debut+intervale;
		
		for (i=0;i<17;i++)
		{
			
			if (realzoom < debut1 && realzoom >= debut) 
			{
			
			Zoomto(evt,debut1);
			}
			debut=debut+(intervale);
			debut1=debut1+(intervale);
		}
		}*/
		objbgrectevt = svgdoc.getElementById('bgrectevt');
		objbgrectevt.setAttributeNS(null,'pointer-events','none');
		objbgrectevt.setAttributeNS(null,'visibility','hidden');
		svgdoc.getElementById('releasezoom').setAttributeNS(null,'visibility','hidden');
	svgdoc.getElementById('releasezoom').setAttributeNS(null,'pointer-events','none');
	top.change_color_fond(2);
	zoomtool='';
	}
Rpressed = 0;
}
function sur2(evt,param1,valeur,param2,valeur2)
 {
	 idparam1="";idparam2="";retparam1="";retparam2="";
	 
	 if(ini_use==0)
	{
		node = evt.target;
	 ident = node.getAttribute("rel");
	 if(svgdoc.getElementById(ident))
	 {
	 if(param1!="")
	 {
	idparam1=param1;
	retparam1=svgdoc.getElementById(ident).getAttribute(param1);
	if(retparam1=="")
	{
		retparam1="none";
	}
	 svgdoc.getElementById(ident).setAttribute(param1,valeur);
	 }
	 if(param2!="")
	 {
	idparam2=param2;	 
	 retparam2=svgdoc.getElementById(ident).getAttribute(param2);
	 if(retparam2=="")
	{
		retparam2="none";
	}
	 svgdoc.getElementById(ident).setAttribute(param2,valeur2);
	 }
	 }
	}
 }
function hors2(evt)
{

if(ini_use==0)
	{
		node = evt.target;
ident = node.getAttribute("rel");
if(svgdoc.getElementById(ident))
{
if(svgdoc.getElementById(ident).getAttribute("fill")!='rgb(150,254,150)')
{
	if(retparam1!="")
	{
svgdoc.getElementById(ident).setAttribute(idparam1,retparam1);
	}
	if(retparam2!="")
	{
svgdoc.getElementById(ident).setAttribute(idparam2,retparam2);
	}
}
}
hideinfotip(evt);
	}
}
function inib_use()
{
	ini_use=1;
}
function desinib_use()
{
	ini_use=0;
}
function sur(evt,couleur,inf1,inf2)
 {
	var testcouleur=couleur;
	if(evt.target.correspondingUseElement)
	{
	node=evt.target.correspondingUseElement;
	}
	else
	{
	node = evt.target;
	}
	info="";
	if(ini_use==0)
	{
		if(inf1 || inf2)
			{	
				var spling="";
						var reg112=new RegExp("[$]+", "g");
						
						if(multi=="1")
									{
						
						spling = inf2.split(reg112);
									}
									else
									{
							spling = inf1.split(reg112);			
									}
						var nbsp = spling.length;
						for (k=0;k<=nbsp-1;k++)
							{
								if(multi=="1")
									{	
										info=info+'<rgb>rgb(0,0,255)</rgb><i>'+spling[k]+'\n ';
									}
								else
									{
										info=info+'<rgb>rgb(255,0,0)</rgb><i>'+spling[k]+'\n ';
									}
							}
						info=info.substring(0,info.length-1);	
					
			}
	coulfill=evt.currentTarget.style.getPropertyValue("fill");
	opacityfill=evt.currentTarget.style.getPropertyValue("fill-opacity");
	coulmofif="fill";
	if(coulfill=="none" || coulfill=="none")
	{
	coulfill=evt.currentTarget.style.getPropertyValue("stroke");
	opacityfill=evt.currentTarget.style.getPropertyValue("stroke-opacity");
	coulmofif="stroke";
	}
	
	if(coulfill!="")
	{
	var cher=new RegExp("[rgb(]", "g");
	var cher1=new RegExp("[)]", "g");
	coulfil=coulfill.replace(cher,"");
	coulfil=coulfil.replace(cher1,"");
	var exp=new RegExp("[,]","g");
	var tabcoul=coulfil.split(exp);
		if(tabcoul[0]>200)
	{
		tabcoul[0]=parseFloat(tabcoul[0])-200;
	}
	else
	{
		tabcoul[0]=parseFloat(tabcoul[0])+56;
	}

	coulfil="rgb(";
	for (var i=0;i<tabcoul.length;i++)
{
coulfil+=tabcoul[i]+",";	
}
coulfil=coulfil.substr(0,coulfil.length-1);
coulfil+=")";
	}
	else
	{
		coulfil="rgb(255,0,0)";
	}
	
	if(node.getAttribute("fill")!='rgb(150,254,150)' && testcouleur=='none')
{
	if(coulmofif=="fill")
		{node.setAttribute("fill",coulfil);}else{node.setAttribute("stroke",coulfil)}
}
if(noactive!=1)
{
if(testcouleur!='none' && node.getAttribute("fill")!='rgb(150,254,150)')
{
	if(coulmofif=="fill")
		{node.setAttribute("fill",couleur);
	node.setAttribute("fill-opacity","0.5");}else{node.setAttribute("stroke",couleur);
	node.setAttribute("stroke-opacity","0.5");}
}
if(info!='')
{
	showinfotip(evt,node.getAttribute("n")+" $ "+info);
}
else
{
showinfotip(evt,node.getAttribute("n"));

}}}
}

function hors(evt)
{
if(evt.target.correspondingUseElement)
	{
	node=evt.target.correspondingUseElement;
	}
	else
	{
	node = evt.target;
	}
if(ini_use==0)
{

if(node.getAttributeNS(null,"fill")!='rgb(150,254,150)')
{
	if(coulmofif=="fill")
	{node.setAttribute("fill",coulfill);
node.setAttribute("fill-opacity",opacityfill);}else{node.setAttribute("stroke",coulfill);
node.setAttribute("stroke-opacity",opacityfill);}
}
hideinfotip(evt);
}
}
function lien(evt,te,lhref,sel,nombre,target)
	{
		if(evt.target.correspondingUseElement)
	{
	node=evt.target.correspondingUseElement;
	}
	else
	{
	node = evt.target;
	}
		if(noactive!=1)
		{
			n_url=lhref.replace("|","&");
			if(multi=="1")
			{
				if(sel=="m")
					{
					if(tee=="")
					{
					tee=te;
					}
					if(tee==te)
					{
					clic="1";
					ur = node;
					urelle = ur.getAttribute("id"); 
					var inser='770'+urelle.substring(0,3)+'   '+urelle.substring(6)
					parcelle_appia.push(inser);
					parcelle_appia.push(urelle)
						if(selectio=="")
						{
						svgdoc.getElementById('valmultiple').setAttributeNS(null,'visibility','visible');
						id1=urelle;
						node.setAttribute("fill","rgb(150,254,150)");
						node.setAttribute("fill-opacity","0.7");
						selectio=urelle;
						parce="'"+urelle+"'";
						}
						else
						{
						var reg=new RegExp(",", "g");
						var longueur=selectio.split(reg);
						var nb = longueur.length;
							if(nombre!=""&&nb==nombre)
							{
							message("Ce type d'objet est limite a "+nb+" selections.");
							}
							else
							{
							node.setAttribute("fill","rgb(150,254,150)");
							node.setAttribute("fill-opacity","0.7");
							id1=id1+";"+urelle;
							selectio=selectio+","+urelle;
							parce=parce+",'"+urelle+"'";
							}
						}
	
					}
					else
					{
					message("Vous devez choisir le meme type d'objet");
					}
				}
				else
				{
					message("Objet disponible uniquement en mode selection unique");
				}
			}
			else
			{
			couche_init=1;	
			clic="0";
			urelle = node.getAttribute("id"); 
			var zer="li_lien"+urelle;
			var url=n_url+urelle;
			var param="_blank";
			ouvrepage(url,param,zer);	
			}
		}
}
function impression()
{
	couches="";
	var nb = layer.length;
	var reg=new RegExp("( )", "g");
	var coucherasteraimprimer=coucherastervisible.replace(reg,"_");
	coucherasteraimprimer=coucherasteraimprimer.substr(0,coucherasteraimprimer.length-1);
	couches="";
	if(coucherasteraimprimer!="" || coucherasteraimprimer!=";" || coucherasteraimprimer!=";;")
	   {
		couches=coucherasteraimprimer+";";
	   }
	 var separ=new RegExp("[;]+", "g");
	
			var tableau=couches.split(separ);  
	for (b=0;b<nb;b++)
	{
		var reg1=new RegExp(layer[b],"g");

		if(zlayer[layer[b]].svg_visible=='true')
		{
			couche=layer[b].replace(reg,"_");
			var layer_test=layer[b].replace(reg,"_");
				if (couches.match(layer_test)) 
				{
				}
				else
				{
					if(couches=="")
					{
					couches +=couche;
					}
					else
					{
					couches +=";"+couche;
					}
						
				}
			
		}
	}
	if(nav!="0")
	{
		couches=convasc(couches);
	}
	var nb = varcotations.length;
		for(a=0;a<nb;a++)
		{
		getSVGObject("cotation.php?eff=0&num="+a+"&cot="+varcotations[a],callback2);
		}
		if(nb==0)
		{
		getSVGObject("cotation.php?eff=1",callback2);	
		}
		if(parce!="")
		{
			ajo=","+parce+")";
		}
		else
		{
			ajo=")";
		}
		var url=protocol+"://"+serveur+"/interface/preprint.php?nav="+nav+"&raster="+couches+"&x="+ xnulcorner + "&y=" + ynulcorner + "&lar=" + nWidth  + "&hau=" + nHeight+ "&zoom=" + zoomVal  + "&xini=" + xini + "&yini=" + yini +"&nav="+nav+"&sessionname=" + sessionname + "&sessionid=" + sessionid +"&echini="+(nWidth*3780/larmap)+"&parce=('"+placid+"'"+ajo;
var param="_blank";
var zer="liprint";
ouvrepage(url,param,zer);
couches="";
}
function ouvrepage(url,param,zer)
{
	if((nav==0||(sansplug=='true')) && param!="")
	{
		open(url,'nom');
	}
	else
	{
		var tyu=svgdoc.getElementById(zer);
		tyu.setAttributeNS(xlinkns,'xlink:href',url);
		if(param!="")
		{
			tyu.setAttribute('target',param);
		}
	}
}
function selectunique(z)
{
			if(noactive==1)
	{
	bouton_distance=0;	
	traitpret=0	;
	noactive=0;
	clearobj();
	cotation=0;
	distance=0;
	surface=0;
	lx=0;
	svgdoc.getElementById("dessin").setAttributeNS(null,"pointer-events","visible");
	svgdoc.getElementById("desrect").setAttributeNS(null,"pointer-events","none");
	svgdoc.getElementById("desrectpostit").setAttributeNS(null,"pointer-events","none");
	svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");
	
	if(z==0 || z==1)
	{
		
		multi=z;
		
	}
	else
	{
	multi=1;
	}
	}
	
	if(z)
	{
		multi=z;
		
	}
	
	if(multi=="0")
	{
	multi="1";
	window.top.document.getElementById('selection').src='../doc_commune/'+ref_rep+'/skins/multiple.png';
	window.top.document.getElementById('fond2').setAttribute('lab','S&eacute;lection multiple');
	}
	else
	{
	multi="0";
	window.top.document.getElementById('selection').src='../doc_commune/'+ref_rep+'/skins/simple.png';
	window.top.document.getElementById('fond2').setAttribute('lab','S&eacute;lection unique');
	svgdoc.getElementById('valmultiple').setAttributeNS(null,'visibility','hidden');
	
	}

selectio="";	
if (id1!="")
	{
		effaceid1();
	}
typebascule=new Array();
coulbascule=new Array();
//}
}
function effaceid1()
{
	var reg=new RegExp(";", "g");


var tabla=id1.split(reg);	
var nb = tabla.length - 1;

for (var klayer = 0;klayer <= nb; klayer++)
{
	node=svgdoc.getElementById(tabla[klayer]).parentNode.getAttribute("id");
	node1=svgdoc.getElementById(node).parentNode.getAttribute("id");
	couleur=svgdoc.getElementById(node1).getAttribute("fill");
	opacite=svgdoc.getElementById(node1).getAttribute("fill-opacity");
	strok=svgdoc.getElementById(node1).getAttribute("stroke");
	svgdoc.getElementById(tabla[klayer]).setAttribute("fill",couleur);
	svgdoc.getElementById(tabla[klayer]).setAttribute("fill-opacity",opacite);
	svgdoc.getElementById(tabla[klayer]).setAttribute("stroke",strok);
}
selectio="";
tee="";
id1="";
parce="";
}
function validmulti()
{
svgdoc.getElementById('valmultiple').setAttributeNS(null,'visibility','hidden');	
var zer="livalide";
var url=n_url+selectio;
var param="_blank";
ouvrepage(url,param,zer);
effaceid1();
}

function recherche()
{
tape_autorise=0;
extraire_recherche();
}
function hideAbout()
{
about = svgdoc.getElementById('inforecherche');
about.setAttributeNS(null,'visibility','hidden');
svgdoc.getElementById("numer").setAttribute("visibility","hidden");
}
function extraire_recherche()
{
objet=window.top.document.getElementById('recherche').value;
window.top.document.getElementById('recherche').value="Recherche";
url='cherche.php?sansplug='+sansplug+'&indice=' + objet + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&code_insee=' + code_insee;

getSVGObject(url,retour)
}
function retour(data)
{
	var titre=data.getAttributeNS(null,"titre");
		 var resultat=data.getAttributeNS(null,"resultat");
		 var codage=data.getAttributeNS(null,"codage");
	
	resul=resultat.split("|");
	cod=codage.split("|");
	var conteneur="<table width=\"100%\"><tr align=\"center\"><td></td></tr><tr align=\"center\"><td><u><strong>"+titre+"</strong></u></td></tr>";
	var n=1;
	if(titre=="Sur l'adresse")
	{n=2;}
	if(resul[0]=='')
	{
	var conteneur="<table width=\"100%\"><tr align=\"center\"><td>&nbsp;</td></tr><tr align=\"center\"><td>&nbsp;</td></tr><tr align=\"center\"><td><strong>Parcelle non r"+String.fromCharCode(233)+"f"+String.fromCharCode(233)+"renc"+String.fromCharCode(233)+" dans notre base </strong></td></tr></table>";	
	}
	else
	{
		for (var i=0; i<resul.length-1; i++) {
 		conteneur+="<tr align=\"center\"><td onclick=\"svgWin.rechercheavance('"+resul[i]+"',"+n+",'"+cod[i]+"')\" onMouseOver=\"this.style.color='#f00';\" onMouseOut=\"this.style.color='#008';\"><strong>"+resul[i]+"</strong>				</td></tr>";
		}
	}
	//window.top.document.getElementById('inforecherche').style.visibility="visible";
	affiche_div('inforecherche');
	window.top.document.getElementById("resultat_recherche").innerHTML="<table>"+conteneur+"</table>";
}
function rechercheavance(val,z,c)
{
affiche_div('inforecherche');	
//window.top.document.getElementById('inforecherche').style.visibility="hidden";
if (z==1)
{
chargement=1;

var inser='770'+val.substring(0,3)+'   '+val.substring(6);
parcelle_appia.push(inser);

var url='locali.php?sansplug='+sansplug+'&parcelle=' + val + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&xini=' + xini + '&yini=' + yini;
getSVGObject(url,retourrecherche);
}
else
{
var cod=c;
var texteadresse=val;
codeadresse=val;
//window.top.document.getElementById('choix_adresse').style.visibility="visible";
affiche_div('choix_adresse');
window.top.document.getElementById("resultat_choix").innerHTML="<table align=\"center\"><tr align=\"center\"><td></td></tr><tr align=\"center\"><td><strong>N&deg;</strong><input id=\"num\" type=\"text\" size=\"4\"></td></tr><tr align=\"center\"><td><strong>"+val+"</strong></td></tr><tr align=\"center\"><td><input id=\"adre\" type=\"hidden\" value=\""+c+"\"></td></tr></table>";
}
}

function cadreparcelle(pa)
{
chargement=1;
var vale=pa;
var url='locali.php?sansplug='+sansplug+'&parcelle=' + vale + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&xini=' + xini + '&yini=' + yini+'t='+vale;
getSVGObject(url,retourrecherche);	
} 

function cadrage(pa)
{
chargement=1;
var tttt=pa.join(",");
var vale=tttt.substring(3,6)+'000'+tttt.substring(9);
var url='locali.php?sansplug='+sansplug+'&parcelle=' + vale + '&sessionname=' + sessionname + '&sessionid=' + sessionid + '&xini=' + xini + '&yini=' + yini+'t='+vale;
getSVGObject(url,retourrecherche);	
}
function parcelle_dossier()
{
var dossier="";
top.DDC_RechercherDossiersParcelles(dossier,parcelle_appia.join(";"));

for(a=0;a<parcelle_appia.length;a++)
{
parcelle_appia.pop();	
}
}
function retourrecherche(x)
{
chargement=0;
var fragment=x.getAttributeNS(null,"n").split("|");
placid=fragment[0].split("|");
placx=fragment[1].split("|");
placy=fragment[2].split("|");
if(placid=='point')
{
message("La num"+String.fromCharCode(233)+"rotation n'est pas valide la carte est positionn"+String.fromCharCode(233)+"e automatiquement sur la rue.");
}


rectOvewidth = parseFloat(svgRect.getAttributeNS(null,'width'));
rectOveheight = parseFloat(svgRect.getAttributeNS(null,'height'));
var x1=placx-(rectOvewidth/2);
var y1=Math.abs(placy)-(rectOveheight/2);
svgRect.setAttributeNS(null,'x',x1);
svgRect.setAttributeNS(null,'y',y1);
xnulcorner=parseFloat(svgRect.getAttributeNS(null,'x'));
ynulcorner=parseFloat(svgRect.getAttributeNS(null,'y'));;
	lin1.setAttributeNS(null,'x',placx-((Rect1lar/6)/2));
	lin1.setAttributeNS(null,'y',Math.abs(placy));
	lin2.setAttributeNS(null,'x',placx);
	lin2.setAttributeNS(null,'y',Math.abs(placy)-((Rect1hau/6)/2));
	Rect1.setAttributeNS(null,'x',placx-((Rect1lar/6)/2));
	Rect1.setAttributeNS(null,'y',Math.abs(placy)-((Rect1hau/6)/2));	
	rectOveXcorner = parseFloat(svgRect.getAttributeNS(null,'x'));
	rectOveYcorner = parseFloat(svgRect.getAttributeNS(null,'y'));
	y = svgMainViewport.currentTranslate.y;
	x = svgMainViewport.currentTranslate.x;
	rectOveYcorner = parseFloat(rectOveYcorner + (y*100/zoomVal));
	rectOveXcorner = parseFloat(rectOveXcorner + (x*100/zoomVal));
	newViewport = xnulcorner + ' ' + ynulcorner + ' ' + rectOvewidth + ' ' + rectOveheight;
	svgMainViewport.setAttributeNS(null,'viewBox',newViewport);
Zoomto('',zoomrecherche);
}
function recher()
{
tapenum_autorise=0	;
var adresse=window.top.document.getElementById('adre').value;
var num=window.top.document.getElementById('num').value;
//window.top.document.getElementById('choix_adresse').style.visibility='hidden'
affiche_div('choix_adresse');
var url='locali.php?sansplug='+sansplug+'&parcelle=&code=' + adresse + '&numero=' + num + '&sessionname=' + sessionname + '&sessionid=' + sessionid;
getSVGObject(url,retourrecherche);
}

function menu_outil(z)
{
	bouton_distance=z;
	multi="0";
	activetrait();
}
function menu_select(z)
{
	selectunique(z);
}
function activetrait(evt)
{
noactive=1;	
svgdoc.getElementById("dessin").setAttribute("pointer-events","none");
svgdoc.getElementById("desrect").setAttribute("pointer-events","visible");
window.top.change_color_fond(3);
if(bouton_distance==0)
{
clearobj();
cotation=0;
distance=1;
surface=0;
polygon=0;
indice="distance";
cumul=0;
longtrait=0;
window.top.document.getElementById('image_outil').src='../doc_commune/'+ref_rep+'/skins/mesure.png';
window.top.document.getElementById('fond3').setAttribute('lab',"Mesurer une distance");
}
else if(bouton_distance==1)
{
clearobj()	
svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");
cotation=1;
distance=0;
surface=0;
indice="cotation";
window.top.document.getElementById('image_outil').src='../doc_commune/'+ref_rep+'/skins/cotation.png';
window.top.document.getElementById('fond3').setAttribute('lab',"Ins&eacute;rer une cotation");
cumul=0;
}
else
{
clearobj();
cumul=0;
polygon=0;
svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");	
cotation=0;
distance=0;
surface=1;
indice="surface";
polyg=""
window.top.document.getElementById('image_outil').src='../doc_commune/'+ref_rep+'/skins/surface.png';
window.top.document.getElementById('fond3').setAttribute('lab',"Mesurer une surface");
}
if(indice!="surface")
{bouton_distance+=1;}
else
{bouton_distance=0;}
traitpret=0;
}
function createcircle(evt)
{
	
cumul=parseFloat(cumul+longtrait);
if(surface==1)
{
traitrouge(evt);
surface=2;
traitpret=1;
lx=xm;
ly=ym;
polyg = parseFloat(xini+xm)+ " " + parseFloat(yini-ym);
		polyfin=polyg;

}
else if(surface==2)
{
			if(ligne)
			{
			objet=svgdoc.getElementById("traits2");
			svgdoc.getElementById("dess").removeChild(objet);
			}
if(polygon==1)
{
svgdoc.getElementById("effacepolygo").setAttribute("visibility","visible");
svgdoc.getElementById("validepolygo").setAttribute("visibility","visible");
}
else
{
svgdoc.getElementById("effacesurface").setAttribute("visibility","visible");
svgdoc.getElementById("validesurface").setAttribute("visibility","visible");
}
countsurface=countsurface+1;
traitblue(evt);
polyg += ","+parseFloat(xini+xm)+ " " + parseFloat(yini-ym);	
lxdist=xm;
lydist=ym;
lx=xm;
ly=ym;
traitrouge(evt);
}
if(distance==1)
{
	
traitrouge(evt);
distance=2;
traitpret=1;
lx=xm;
ly=ym;
}
else if(distance==2)
{
			if(ligne)
			{
			objet=svgdoc.getElementById("traits2");
			svgdoc.getElementById("dess").removeChild(objet);
			}

svgdoc.getElementById("effacemesure").setAttribute("visibility","visible");
countrait=countrait+1;
traitblue(evt);
lxdist=xm;
lydist=ym;
lx=xm;
ly=ym;
traitrouge(evt);
affichetext(evt);
hideinfotip(evt);
}
if(cotation==1)
{
	if(lx!=0 && countrait>0)
	{
		objet=svgdoc.getElementById("traits2");
		svgdoc.getElementById("dess").removeChild(objet);
	}
	lxdist=0;
	lydist=0;
	traitrouge(evt);
cotation=2;
traitpret=1;
lx=xm;
ly=ym;
}
else if(cotation==2)
{
			if(ligne)
			{
			objet=svgdoc.getElementById("traits2");
			svgdoc.getElementById("dess").removeChild(objet);
			}
svgdoc.getElementById("effacemesure").setAttribute("visibility","visible");
countcotation=countcotation+1;
traitblue(evt);
cotation=1;
traitpret=0;
lx=0;
ly=0;
affichetext(evt);
hideinfotip(evt);
}
}
function bougetrait(evt)
{

if(traitpret==1)
{
coordonne(evt)	;
svgdoc.getElementById("traits2").setAttribute("x2",(xm));
svgdoc.getElementById("traits2").setAttribute("y2",(ym));
var carx=Math.pow(parseFloat(lx-xm),2);
var cary=Math.pow(parseFloat(ly-ym),2);
longtrait=Math.sqrt(carx+cary);
valtrait=Math.round(longtrait*100)/100;
if(lx<=xm && ly<=ym)
{
cosa=(ly-ym)/longtrait;
angle=(180*Math.acos(cosa)/Math.PI)-90;

}
else if(lx<=xm && ly>=ym)
{
cosa=(ly-ym)/longtrait;
angle=270+(180*Math.acos(cosa)/Math.PI);
}
else if(lx>=xm && ly<=ym)
{
cosa=(ym-ly)/longtrait;
angle=270+(180*Math.acos(cosa)/Math.PI);
}
else
{
cosa=(ym-ly)/longtrait;
angle=-90+(180*Math.acos(cosa)/Math.PI);
}
posix=lx+((xm-lx)/2);
posiy=ly+((ym-ly)/2);
if(surface==0)
{
showinfotip (evt,' '+valtrait+' ');
}
}

}
function fintrait(evt)
{
if(traitpret==1)
	{
lxpress=1;
	}
}
function effacetrait(evt)
{
if(indice=='surface')
{
var de=countsurface;
}
else if(indice=='cotation')
{
	var de=countcotation;
}
else
{
	var de=countrait;
}
var xold=svgdoc.getElementById(indice+de).getAttribute("x1");
var yold=svgdoc.getElementById(indice+de).getAttribute("y1");
objet=svgdoc.getElementById(indice+de);
svgdoc.getElementById("dess").removeChild(objet);
if(indice=="distance")
{
	for(var j=1;j<countrait;j++)
	{
	objet=svgdoc.getElementById(indice+j);
	svgdoc.getElementById("dess").removeChild(objet);
	objet=svgdoc.getElementById("tex"+indice+j);
	svgdoc.getElementById("dess").removeChild(objet);
	}
	objet=svgdoc.getElementById("tex"+indice+countrait);
	svgdoc.getElementById("dess").removeChild(objet);
countrait=0;		
count=countrait;
cumul=0;
longtrait=0;
}
if(indice!="cotation")
{
svgdoc.getElementById("traits2").setAttribute("x1", xold);
svgdoc.getElementById("traits2").setAttribute("y1", yold);
}
if(indice=='surface')
{
countsurface=countsurface-1;
count=countsurface;
lx=xold;
ly=yold;
}
else if(indice=='cotation')
{
objet=svgdoc.getElementById("tex"+indice+de);
svgdoc.getElementById("dess").removeChild(objet);
varcotations.pop();
countcotation=countcotation-1;
count=countcotation;
lx=xold;
ly=yold;
}
if(count==0)
{
	if(indice=="surface")
	{
		if(polygon==1)
		{
	svgdoc.getElementById("effacepolygo").setAttribute("visibility","hidden");	
	svgdoc.getElementById("validepolygo").setAttribute("visibility","hidden");
		}
		else
		{
	svgdoc.getElementById("effacesurface").setAttribute("visibility","hidden");	
	svgdoc.getElementById("validesurface").setAttribute("visibility","hidden");
		}
	traitpret=0;
	surface=1;
	lxdist=0;
	lx=0;
	ly=0;
	}
	if(indice=="cotation")
	{
	svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");	
	traitpret=0;
	cotation=1;
	lxdist=0;
	lx=0;
	ly=0;
	}
	if(indice=="distance")
	{
	svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");
	traitpret=0;
	distance=1;
	lxdist=0;
	lx=0;
ly=0;
	}
if(ligne && indice!="cotation")
			{
			objet=svgdoc.getElementById("traits2");
			svgdoc.getElementById("dess").removeChild(objet);
			}

}
if(indice=="surface")
{
   var chaine=polyg;
var reg=new RegExp("[,]+", "g");
var tableau=chaine.split(reg);
for (var i=0; i<tableau.length-1; i++) 
{
 if(i==0)
 {polyg=tableau[i];
 }
 else
 {
polyg += ","+tableau[i]; 
 }
}

}
}

function coordonne(evt)
{
	root=svgdoc.getElementById("mapid");
	x=root.getAttributeNS(null,'x');
	y=root.getAttributeNS(null,'y');
	rectOveXcorner = parseFloat(svgRect.getAttributeNS(null,'x'));
	rectOveYcorner = parseFloat(svgRect.getAttributeNS(null,'y'));
	rectOvewidth = parseFloat(svgRect.getAttributeNS(null,'width'));
	rectOveheight = parseFloat(svgRect.getAttributeNS(null,'height'));
	xm=rectOveXcorner+((((evt.clientX-offsetXmap)/ratio)-x)*rectOvewidth/larmap);
	ym=rectOveYcorner+((((evt.clientY-offsetYmap)/ratio)-y)*rectOveheight/haumap);
}

function traitrouge(evt)
{
coordonne(evt);
debuttrait_x=xm;
debuttrait_y=ym;
if(lxdist!=0)
{
	debuttrait_x=lxdist;
	debuttrait_y=lydist;
}
ligne=svgdoc.createElementNS(svgns, "line");
ligne.setAttribute("id","traits2");
ligne.setAttribute("x1",(debuttrait_x));
ligne.setAttribute("y1",(debuttrait_y));
ligne.setAttribute("x2",(xm));
ligne.setAttribute("y2",(ym));
if(cotation!=0)
{
ligne.setAttribute("marker-start","url(#extremite_mesure)");
}
ligne.setAttribute("stroke-width","0.5");
ligne.setAttribute("fill", "red");
ligne.setAttribute("stroke","red");
svgdoc.getElementById("dess").appendChild(ligne);
}
function traitblue(evt)
{
	var indice1=countrait;
	if(indice=='surface')
	{
		var indice1=countsurface;
	}
	else if(indice=='cotation')
	{
		var indice1=countcotation;
	}
coordonne(evt);
ligne1=svgdoc.createElementNS(svgns, "line");
ligne1.setAttribute("id",indice+indice1);
ligne1.setAttribute("x1",lx);
ligne1.setAttribute("y1",ly);
ligne1.setAttribute("x2",xm);
ligne1.setAttribute("y2",ym);
if(cotation!=0)
{
ligne1.setAttribute("marker-start","url(#debut_mesure)");
ligne1.setAttribute("marker-end","url(#fin_mesure)");
}
ligne1.setAttribute("stroke-width","0.5");
ligne1.setAttribute("fill", "blue");
ligne1.setAttribute("stroke","blue");
svgdoc.getElementById("dess").appendChild(ligne1);
varcotations[countcotation-1]=Math.round(lx*100)/100+"|"+Math.round(ly*100)/100+"|"+Math.round(xm*100)/100+"|"+Math.round(ym*100)/100+"|"+Math.round(angle*100)/100+"|"+Math.round(posix*100)/100+"|"+Math.round(posiy*100)/100+"|"+Math.round(longtrait*100)/100;
}
function affichetext(evt)
{
	if(distance>0)
	{
		pox=xm;
		poy=ym;
		aff=cumul;
		var indice1=countrait;
	}
	else
	{
		pox=posix;
		poy=posiy;
		aff=longtrait;
		var indice1=countcotation;
	}
texte=svgdoc.createElementNS(svgns, 'text');
texte.setAttribute("fill","red");
texte.setAttribute("id","tex"+indice+indice1);
texte.setAttribute("font-size","3");
texte.setAttribute("x",pox);
texte.setAttribute("y",poy);
if(cotation!=0)
{
texte.setAttribute("transform","rotate("+angle+","+pox+","+poy+")");
texte.setAttribute("text-anchor","middle");
}
text_content = svgdoc.createTextNode(Math.round(aff*100)/100);
texte.appendChild(text_content);
svgdoc.getElementById("dess").appendChild(texte);
}
function validesurface(evt)
{
	if(polyg=="")
	{
		polyg="0 0,1 1";
	}
url="surface.php?sansplug="+sansplug+"&polygo="+polyg+","+polyfin+"&sessionname=" + sessionname + "&sessionid=" + sessionid;
getSVGObject(url,retoursurface);
}

function retoursurface(x)
{
	message("la surface est de "+Math.floor(x.getAttributeNS(null,"n")*100)/100+" M2");	 
}
function clearobj()
{
	
	if(countsurface>0)
	{
		for(var j=1;j<countsurface+1;j++)
			{
			objet=svgdoc.getElementById("surface"+j);
			svgdoc.getElementById("dess").removeChild(objet);
			}
			polygo="";
			if(polygon==1)
			{
			svgdoc.getElementById("effacepolygo").setAttribute("visibility","hidden");	
			svgdoc.getElementById("validepolygo").setAttribute("visibility","hidden");
			}
			else
			{
			svgdoc.getElementById("effacesurface").setAttribute("visibility","hidden");	
			svgdoc.getElementById("validesurface").setAttribute("visibility","hidden");
			}
			traitpret=0;
			surface=1;
			lxdist=0;
			lx=0;
			ly=0;
			countsurface=0;
	}

	if(countrait>0)
	{
		for(var j=1;j<countrait+1;j++)
	{
	objet=svgdoc.getElementById("distance"+j);
	svgdoc.getElementById("dess").removeChild(objet);
	objet=svgdoc.getElementById("tex"+indice+j);
	svgdoc.getElementById("dess").removeChild(objet);
	}
	objet=svgdoc.getElementById("traits2");
	traitpret=0;
	distance=1;
	lxdist=0;
	lx=0;
ly=0;
countrait=0;
	}
	
		if(svgdoc.getElementById("traits2"))
	{
	objet=svgdoc.getElementById("traits2");
	svgdoc.getElementById("dess").removeChild(objet);
	}
}
function activpoly(evt)
{
noactive=1;	
clearobj();	
svgdoc.getElementById("dessin").setAttribute("pointer-events","none");
svgdoc.getElementById("desrectpostit").setAttribute("pointer-events","none");
svgdoc.getElementById("desrect").setAttribute("pointer-events","visible");
cotation=0;
distance=0;
surface=1;
polygon=1;
indice="surface";
polyg="";
traitpret=0;
}
function validepoly(evt)
{
	if(polyg=="")
	{
		polyg="0 0,1 1";
	}
var url="https://"+serveur+url_polygo+"?polygo="+polyg+","+polyfin+"&sessionname=" + sessionname + "&sessionid=" + sessionid;
var zer="livalidepolygo";
var param="_blank";
ouvrepage(url,param,zer);
clearobj();
couche_init=1;
selectunique();
top.change_color_fond(2);
}
function enregistre()
{
	image="";
	nom="";
	var ladate=new Date();
	var plus="M" + ladate.getMinutes() + "S" + ladate.getSeconds();
	nom=sessionid + plus;
	animation();
	var nb = layer.length;
	couche_svg="";
	for (b=0;b<nb;b++)
	{
	if(zlayer[layer[b]].svg_visible=='true')
		{
			if(couche_svg=="")
			{
			couche_svg +=layer[b];
			}
			else
			{
			couche_svg +=","+layer[b];
			}
			suppvarraster(layer[b]);
		}
	}
	var reg=new RegExp("( )", "g");
	coucherasteraenvoyer=coucherastervisible.replace(reg,"_");
	coucherasteraenvoyer=coucherasteraenvoyer.substr(0,coucherasteraenvoyer.length-1);
	raste="";
	if(coucherasteraenvoyer!="")
							{
				image="ok";
				raste=	coucherasteraenvoyer;			
		}
	
	droite=svgdoc.getElementById("droite").firstChild.data;
	var reg=new RegExp("'", "g");
	par=placid;
	if(parce.replace(reg,"")!="")
	{
	par +=","+parce.replace(reg,"");
	}
	if(nav!=0)
	{
		var nb = varcotations.length;
		for(a=0;a<nb;a++)
		{
		getSVGObject("cotation.php?sansplug="+sansplug+"&eff=0&num="+a+"&cot="+varcotations[a],callback2);
		}
		if(nb==0)
		{
		getSVGObject("cotation.php?sansplug="+sansplug+"&eff=1",callback2);	
		}
		couche_svg=convasc(couche_svg);
		raste=convasc(raste);
		var url=protocol + "://" + serveur + "/interface/enregistre.php?sansplug="+sansplug+"&droite="+droite+"&nom=" +nom+"&svg="+couche_svg+"&raster="+raste+"&x="+ xnulcorner + "&y=" + ynulcorner + "&lar=" + nWidth  + "&hau=" + nHeight+ "&zoom=" + zoomVal  + "&xini=" + xini + "&yini=" + yini +"&nav="+nav+"&parce="+par+"&sessionname=";
		
	}
	else
	{
	var nb = varcotations.length;
		for(a=0;a<nb;a++)
		{
		getSVGObject("cotation.php?sansplug="+sansplug+"&eff=0&num="+a+"&cot="+varcotations[a],callback2);
		}
		if(nb==0)
		{
		getSVGObject("cotation.php?sansplug="+sansplug+"&eff=1",callback2);	
		}	

var url=protocol + "://" + serveur + "/interface/enregistre.php?sansplug="+sansplug+"&droite="+droite+"&nom=" +nom+"&svg="+couche_svg+"&raster="+raste+"&x="+ xnulcorner + "&y=" + ynulcorner + "&lar=" + nWidth  + "&hau=" + nHeight+ "&zoom=" + zoomVal  + "&xini=" + xini + "&yini=" + yini +"&nav="+nav+"&parce="+par+"&sessionname=";
		}
		setTimeout("cache()",6000);
		var zer="lienre";
var param="_blank";
ouvrepage(url,param,zer);

}
function callback2(data)
{
if (!data) 
	message("nok");
}

function aide()
{
var url=protocol + "://" + serveur + "/interface/Manuel.pdf";
var param="_blank";
var zer="aide";	
ouvrepage(url,param,zer);	
}
function contacte()
{
var url=protocol + "://" + serveur + "/interface/mail/mailto.php";
var param="_blank";
var zer="contacte";	
ouvrepage(url,param,zer);	
}
function message(data)
{

	//window.top.document.getElementById('message').style.visibility="visible";
	affiche_div('message');
	window.top.document.getElementById("resultat_message").innerHTML="<table align=\"center\"><tr align=\"center\"><td><strong>"+data+"</strong></td></tr></table>";

}

function enregPref()
{
var url='pref.php?sessionname=' + sessionname + '&sessionid=' + sessionid + '&icon=' + window.top.document.getElementById('outils').style.visibility + '&legend=' + window.top.document.getElementById('legende').style.visibility+ '&legendx=' + window.top.document.getElementById('legende').style.left + '&legendy=' + window.top.document.getElementById('legende').style.top;
getSVGObject(url,callback2)
}

function affiche_div(z)
{
	
	if(window.top.document.getElementById(z).style.visibility=='visible')
{
	window.top.document.getElementById(z).style.visibility='hidden';
	if(z!="cache_fill" &&  z!="cache_stroke" && z!="outils" && z!="legende" && z!="outils_office")
	{
	window.top.document.getElementById(z).style.left='100%';
	}
}
else
{
	window.top.document.getElementById(z).style.visibility='visible';
	if(z!="cache_fill" &&  z!="cache_stroke" && z!="outils" && z!="legende" && z!="outils_office")
	{
	window.top.document.getElementById(z).style.left='50%';
	}
}
	
}
function navigation()
{
	if(svgdoc.getElementById('navigation').getAttributeNS(null,'pointer-events')=='visible')
{
	svgdoc.getElementById('navigation').setAttributeNS(null,'pointer-events',"none");
	svgdoc.getElementById('navigation').setAttributeNS(null,'opacity',"0");
	svgdoc.getElementById("t_navigation").setAttributeNS(xlinkns,"xlink:href","./collapsebtn2.gif");
	svgdoc.getElementById('retour_map').setAttributeNS(null,'x',"1000000");
}
else
{
	svgdoc.getElementById('navigation').setAttributeNS(null,'pointer-events',"visible");
	svgdoc.getElementById('navigation').setAttributeNS(null,'opacity',"1");
	svgdoc.getElementById("t_navigation").setAttributeNS(xlinkns,"xlink:href","./expandbtn2.gif");
	svgdoc.getElementById('retour_map').setAttributeNS(null,'x',"0");
}
}
function selec_appli()
{
if(va_appli>1)
{
if(svgdoc.getElementById('deroul_appli').getAttributeNS(null,'visibility')=='visible')
{
	svgdoc.getElementById('deroul_appli').setAttributeNS(null,'visibility',"hidden");
}
else
{
	svgdoc.getElementById('deroul_appli').setAttributeNS(null,'visibility',"visible");
}
}

}
function ouv_appli(bou,x,y,ul)
{
	
	if(ul.substr(0,1)=='/')
	{
		ul=ul.substr(1,ul.length);
	}
		var zer="liappli"+bou;
		if(y==1)
		{
			var url="https://"+serveur+"/"+ul;
			var param="_blank";
ouvrepage(url,param,zer);
		}
		
}

function postit()
{
noactive=1;	
clearobj();	
svgdoc.getElementById("effacemesure").setAttribute("visibility","hidden");
svgdoc.getElementById("dessin").setAttribute("pointer-events","none");
svgdoc.getElementById("desrect").setAttribute("pointer-events","none");
svgdoc.getElementById("desrectpostit").setAttribute("pointer-events","visible");
polyg="";
}
function pose_postit(evt)
{
coordonne(evt);
polyg = parseFloat(parseFloat(xini + xm)-parseFloat(9.8))+ " " + parseFloat(parseFloat(yini- ym)-parseFloat(2.5));
var url=protocol+"://"+serveur+"/interface/postit.php?polygo="+polyg;
var zer="lipostit";
var param="_blank";
ouvrepage(url,param,zer);
clearobj();
couche_init=1;
selectunique();
}

function bougez(evt,valeur,x)
{
if(scroll_appui_zoom=="true" && x==1 && valz!="")
{
		Zoomto(evt,valz);}

if(valeur=='false' && x==0)
{
	showinfotip(evt,'Zoom:'+theZoom+' %');
	}

scroll_appui_zoom=valeur;
}

function bougezoom(evt)
{
	
if (scroll_appui_zoom=="true" )
{

var ym=((evt.clientY-offsetYmap)/ratio)-2.5;
if(ym<30)
ym=30;
if(ym>109)
ym=109;
//testval=(-ym+109)/79;
if(ym>=30 && ym<=109)
{

svgdoc.getElementById("rectzoom").setAttributeNS(null,'y',ym);
//valz=Math.round(zoommin+(((109-ym)/79)*(zoommax-zoommin)));
valz=Math.round(((zoommax-zoommin)*(Math.pow((-ym+109)/79,3))+zoommin));
showinfotip(evt,'Zoom:'+valz+' %');
//showinfotip(evt,'Zoom:'+valz+' %');

gest_zoom(evt,valz);

}
	
	
}
}
