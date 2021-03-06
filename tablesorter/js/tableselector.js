/*
 *
 * TableSelector 0.1 - Client-side musiccum custom table selector!
 * Version 0.1.0
 * @requires jQuery v1.2.3
 *
 * Copyright (c) 2016 Clip Art - Paolo Alberti
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
/**
 *
 * @description Create a selector for custom table
 *
 *
 * @type jQuery
 *
 * @name TableSelector
 *
 * @cat Plugins/TableSelector
 *
 * @author Paolo Alberti paolo.alberti@clipart.it
 */
 // define custom function
 String.prototype.replaceAt=function(index, character) {
   //console.log(this.substr(0, index) + character + this.substr(index+character.length+1));
   return this.substr(0, index) + character + this.substr(index+character.length+1);
 }

var showItem = function (cellToShow) {
  jQuery('tbody tr').each(function (){
    jQuery(this).css('display','none');
  });
  jQuery('.'+cellToShow).each(function (){
    jQuery(this).css('display','table-row');
  });
};
var showItems = function (cellToShowArray) {
  jQuery('tbody tr').each(function (){
    jQuery(this).css('display','none');
  });
  var l = cellToShowArray.length;
  for (var i=0; i<l; i++){
    var cellToShow=cellToShowArray[i];
    jQuery('.'+cellToShow).each(function (){
      jQuery(this).css('display','table-row');
    });
  }
};
var showAllItems = function () {
  jQuery('tbody tr').each(function (){
    jQuery(this).css('display','table-row');
  });
};

var showDetails = function (tableObj, saleObj,insegnantiObj,tipoObj,url) {



  var salaValue="";
  jQuery.each( saleObj, function( key, value ) {
    if (tableObj["3"]===key)
      salaValue=value;
  });
  var tipoValue="";
  jQuery.each( tipoObj, function( key, value ) {
    if (tableObj["4"]===key)
      tipoValue=value;
  });
  var insegnanteValue="";
  console.log(tableObj["8"]);
  var insegnantiInTable = tableObj["8"].split(" ");
  for (var i in insegnantiInTable) {
    jQuery.each( insegnantiObj, function( key, value ) {
      if (insegnantiInTable[i]===key)
        insegnanteValue+=value+" ";
    });
  };
  var organicoObj={'CCAM':'Coro da camera','CMIS':'Coro misto','CFEM':'Coro femminile','CORI':'Cori','ORCH':'Orchestra'};
  var organicoValue=tableObj["6"];
  jQuery.each( organicoObj, function( key, value ) {
    if(tableObj["6"].indexOf(key) !== -1 ){
      organicoValue = organicoValue.replace(key,value+" - ");
    }
  });
  // replace last ","
  var indices = [];
  var strLength=organicoValue.length;
  for(var i=0; i<strLength;i++) {
    if (organicoValue[i] === "-") {indices.push(i);console.log(i);};
  }
  var lastOccIndex=indices[(indices.length)-1];
  console.log(lastOccIndex+" "+strLength);
  if ((strLength-lastOccIndex)>1 && (strLength-lastOccIndex)<3){organicoValue = organicoValue.replaceAt(lastOccIndex, "");}





  var w = 600;
  var h = 400;
  var l = Math.floor((screen.width-w)/2);
  var t = Math.floor((screen.height-h)/2);
  var style = "<style>.popUpItem{background: #f0f0f0;margin-top:5px;margin-bottom:5px;}.popUpThead{font-weight:bold;background-color: #01b8c6;}</style>";




  var content = "<div id='data'class='ca-popUpItem'><span class='ca-popUpThead'>Data: </span><span class='ca-value'>"+tableObj["0"]+"</span></div>";
  content+="<div id='dalle' class='ca-popUpItem'><span class='ca-popUpThead'>Dalle: </span><span class='ca-value'>"+tableObj["1"]+"</span></div>";
  content+="<div id='alle' class='ca-popUpItem'><span class='ca-popUpThead'>Alle: </span><span class='ca-value'>"+tableObj["2"]+"</span></div>";
  content+="<div id='sala' class='ca-popUpItem'><span class='ca-popUpThead'>Sala: </span><span class='ca-value'>"+salaValue+"</span></div>";
  content+="<div id='tipo' class='ca-popUpItem'><span class='ca-popUpThead'>Tipo: </span><span class='ca-value'>"+tipoValue+"</span></div>";
  content+="<div id='organico' class='ca-popUpItem'><span class='ca-popUpThead'>Organico: </span><span class='ca-value'>"+organicoValue+"</span></div>";
  content+="<div id='programma' class='ca-popUpItem'><span class='ca-popUpThead'>Programma: </span><span class='ca-value'>"+tableObj["7"]+"</span></div>";
  content+="<div id='insegnanti' class='ca-popUpItem'><span class='ca-popUpThead'>Insegnanti: </span><span class='ca-value'>"+insegnanteValue+"</span></div>";
  //var popUp = window.open(url+"/dettagli_convocazione.html","Dettagli convocazione","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l+",location=no,titlebar=no,status=no");

  var containerEl = document.getElementsByClassName("column_attr")[0];

  var contentEl = document.getElementsByClassName("ca-popup-content")[0];
  contentEl.innerHTML=content;

  var tableEl = document.getElementById("tablesorter-demo");
  var refEl = document.getElementsByClassName("mcb-section-inner")[0];

  var refElW = refEl.offsetWidth;
  var tableElW = tableEl.offsetWidth;
  var W = document.body.offsetWidth;
  var H = screen.height;
  console.log("Width: "+H);
  var w=tableElW;
  var h=H/2;
  var l = Math.floor((W-w)/2);
  var t = Math.floor((H-h)/2);

  console.log(tableElW);

  var modal = document.getElementById('ca-myModal');
  modal.style.display = "table";
  modal.style.top = t+"px";
  modal.style.left = l+"px";
  modal.style.width = (w-42)+"px";// subtract padding
  var modalContent = document.getElementsByClassName('ca-modal-content')[0];
  modalContent.style.display = "table";
  modalContent.style.top = t+"px";
  modalContent.style.left = l+"px";
  modalContent.style.width = (w)+"px";// subtract padding
  //modalContent.style.height = h+"px";
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("ca-close")[0];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      modalContent.style.display = "none";
      modal.style.display = "none";
  }

  var contentEl = document.getElementsByClassName("ca-popup-content")[0];
  contentEl.innerHTML=content;


  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("ca-close")[0];




  /*var popUp = window.open(url,"","directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no");

  popUp.document.write(" <head>\n");
  popUp.document.write("  <title>Dettagli convocazione</title>\n");
  popUp.document.write("  <basefont size=2 face=Tahoma>\n");
  popUp.document.write(" </head>\n");
  popUp.document.write(style);
  popUp.document.write(content);
  popUp.document.close();
*/
};

var showDetailsxxx = function (tableObj, salaObj,direttoriObj,appuntamentiObj,url) {

  var W = screen.width;
  var H = screen.height;
  var w=W/2;
  var h=H/2;
  var l = Math.floor((W-w)/4);
  var t = Math.floor((H-h)/4);
console.log(l);
  var content="";
  jQuery.get(url, function(response) {
     content = response;

     jQuery('.popUp').html(content);
     jQuery('.popUp').css('position','fixed');
     jQuery('.popUp').css('z-index','10000000');
     jQuery('.popUp').css('display','block');
     jQuery('.popUp').css('background','blue');
     jQuery('.popUp').css('width',w+'px');
     jQuery('.popUp').css('height',h+'px');
     jQuery('.popUp').css('left',l+'px');
     jQuery('.popUp').css('top',t+'px');

});


};
