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
