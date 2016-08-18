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
        insegnanteValue+="   "+value;
    });
  }




  var w = 600;
  var h = 400;
  var l = Math.floor((screen.width-w)/2);
  var t = Math.floor((screen.height-h)/2);
  var style = "<style>.popUpItem{background: #f0f0f0;margin-top:5px;margin-bottom:5px;}.thead{font-weight:bold}</style>";




  var content = "<div id='data'class='popUpItem'><span class='thead'>Data: </span><span class='value'>"+tableObj["0"]+"</span></div>";
  content+="<div id='dalle' class='popUpItem'><span class='thead'>Dalle: </span><span class='value'>"+tableObj["1"]+"</span></div>";
  content+="<div id='alle' class='popUpItem'><span class='thead'>Alle: </span><span class='value'>"+tableObj["2"]+"</span></div>";
  content+="<div id='sala' class='popUpItem'><span class='thead'>Sala: </span><span class='value'>"+salaValue+"</span></div>";
  content+="<div id='tipo' class='popUpItem'><span class='thead'>Tipo: </span><span class='value'>"+tipoValue+"</span></div>";
  content+="<div id='organico' class='popUpItem'><span class='thead'>Organico: </span><span class='value'>"+tableObj["6"]+"</span></div>";
  content+="<div id='programma' class='popUpItem'><span class='thead'>Programma: </span><span class='value'>"+tableObj["7"]+"</span></div>";
  content+="<div id='insegnanti' class='popUpItem'><span class='thead'>Insegnanti: </span><span class='value'>"+insegnanteValue+"</span></div>";
  var popUp = window.open(url+"/dettagli_convocazione.html","Dettagli convocazione","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l+",location=no,titlebar=no,status=no");




/*
  popUp.document.getElementsByClassName('value')[0].text=tableObj["0"];
  popUp.document.getElementsByClassName('value')[1].text=tableObj["1"];
  popUp.document.getElementsByClassName('value')[2].text=tableObj["2"];
  popUp.document.getElementsByClassName('value')[3].text=tableObj["3"];
  popUp.document.getElementsByClassName('value')[4].text=tableObj["4"];
  popUp.document.getElementsByClassName('value')[6].text=tableObj["6"];
  popUp.document.getElementsByClassName('value')[7].text=tableObj["7"];
  popUp.document.getElementsByClassName('value')[8].text=tableObj["8"];
*/
  //var popUp = window.open(url,"","directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no");

  popUp.document.write(" <head>\n");
  popUp.document.write("  <title>Dettagli convocazione</title>\n");
  popUp.document.write("  <basefont size=2 face=Tahoma>\n");
  popUp.document.write(" </head>\n");
  popUp.document.write(style);
  popUp.document.write(content);
  popUp.document.close();

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
