// Exemple d'appel:
// onMouseOver="toolTip('texte à insérer')";
// onMouseOut="toolTip()";
// -ou-
// onMouseOver="toolTip('texte à insérer avec couleur bordure et fond', '#FFFF00', 'orange')";
// onMouseOut="toolTip()"; 
/*
à insérer dans <body>:
<div id="toolTipLayer" style="position:absolute; visibility: hidden"></div>
<script language="JavaScript"><!--
initToolTips(); //--></script>
*/
var ns4 = document.layers;
var ns6 = document.getElementById && !document.all;
var ie4 = document.all;
bullX = 10;
bullY = 20;
var toolTipSTYLE="";
function initToolTips()
{
  if(ns4||ns6||ie4)
  {
    if(ns4) toolTipSTYLE = document.toolTipLayer;
    else if(ns6) toolTipSTYLE = document.getElementById("toolTipLayer").style;
    else if(ie4) toolTipSTYLE = document.all.toolTipLayer.style;
    if(ns4) document.captureEvents(Event.MOUSEMOVE);
    else
    {
      toolTipSTYLE.visibility = "visible";
      toolTipSTYLE.display = "none";
    }
    document.onmousemove = moveToMouseLoc;
  }
}
function toolTip(msg, fg, bg)
{
  if(toolTip.arguments.length < 1) // hide
  {
    if(ns4) toolTipSTYLE.visibility = "hidden";
    else toolTipSTYLE.display = "none";
  }
  else // show
  {
    if(!fg) fg = "#777777";
    if(!bg) bg = "#FFFFFF";
    var content =
    '<table border="0" cellspacing="0" cellpadding="1" bgcolor="' + fg + '"><td>' +
    '<table border="0" cellspacing="0" cellpadding="1" bgcolor="' + bg + 
    '"><td align="center" bgcolor="' + bg +'><font face="sans-serif" color="' + fg +
    '" size="-2">&nbsp\;' + msg +
    '&nbsp\;</font></td></table></td></table>';
    if(ns4)
    {
      toolTipSTYLE.document.write(content);
      toolTipSTYLE.document.close();
      toolTipSTYLE.visibility = "visible";
    }
    if(ns6)
    {
      document.getElementById("toolTipLayer").innerHTML = content;
      toolTipSTYLE.display='block'
    }
    if(ie4)
    {
      document.all("toolTipLayer").innerHTML=content;
      toolTipSTYLE.display='block'
    }
  }
}
function moveToMouseLoc(e)
{
  if(ns4||ns6)
  {
    xbul = e.pageX;
    ybul = e.pageY;
  }
  else
  {
    xbul = event.x; /*event.x + document.body.scrollLeft;*/
    ybul = event.y;/* + document.body.scrollTop;*/
  }
  toolTipSTYLE.left = xbul-440+bullX;
  toolTipSTYLE.top = ybul-20+bullY;
  return true;
}
 
