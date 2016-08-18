<?php


require_once 'PHPExcel.php';




class ExcelReader{
    protected $excelReader;

    public function __construct(){

    }

    public function printSheet($sheet_uri) {
      setlocale(LC_TIME, 'it_IT');




/*
      $supportedLangs = array('it');

      $languages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

      foreach($languages as $lang) {
        echo $lang;
        if(in_array($lang, $supportedLangs))
        {
            // Set the page locale to the first supported language found
            setLocale(LC_TIME, $lang);
        }
      }
*/
      if(file_exists($sheet_uri)){
        $objPHPExcel = PHPExcel_IOFactory::load($sheet_uri);
      }
      else {echo "no file";return;}

      $objPHPExcel->setActiveSheetIndex(0);
      $objCalendarioSheet = $objPHPExcel->getActiveSheet();
      $calendarioRows = $objCalendarioSheet->getHighestRow();
      $calendarioCols = PHPExcel_Cell::columnIndexFromString($objCalendarioSheet->getHighestColumn());
      $objPHPExcel->setActiveSheetIndex(1);
      $objSalaSheet = $objPHPExcel->getActiveSheet();
      $salaRows = $objSalaSheet->getHighestRow();
      $salaCols = PHPExcel_Cell::columnIndexFromString($objSalaSheet->getHighestColumn());
      $salaObjString="{";
      for ($r=1; $r<$salaRows; $r++){
        $key=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$r)->getValue();
        $value=str_replace(","," ",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$r)->getValue());
        $value=str_replace(":"," ",$value);
        $value=str_replace("'"," ",$value);
        $salaObjString=$salaObjString."\"".$key."\":\"".$value."\",";
      }
      $salaObjString=$salaObjString."}";

      $objPHPExcel->setActiveSheetIndex(2);
      $objDirettoriSheet = $objPHPExcel->getActiveSheet();
      $direttoriRows = $objDirettoriSheet->getHighestRow();
      $direttoriCols = PHPExcel_Cell::columnIndexFromString($objDirettoriSheet->getHighestColumn());
      $direttoriObjString="{";
      for ($r=1; $r<$direttoriRows; $r++){
        $key=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$r)->getValue();
        $value=str_replace(","," ",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$r)->getValue());
        $value=str_replace(":"," ",$value);
        $value=str_replace("'"," ",$value);
        $direttoriObjString=$direttoriObjString."\"".$key."\":\"".$value."\",";
      }
      $direttoriObjString=$direttoriObjString."}";

      $objPHPExcel->setActiveSheetIndex(3);
      $objAppuntamentiSheet = $objPHPExcel->getActiveSheet();
      $appuntamentiRows = $objAppuntamentiSheet->getHighestRow();
      $appuntamentiCols = PHPExcel_Cell::columnIndexFromString($objAppuntamentiSheet->getHighestColumn());
      $tipoAppuntamentiObjString="{";
      for ($r=1; $r<$direttoriRows; $r++){
        $key=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$r)->getValue();
        $value=str_replace(","," ",$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$r)->getValue());
        $value=str_replace(":"," ",$value);
        $value=str_replace("'"," ",$value);
        $tipoAppuntamentiObjString=$tipoAppuntamentiObjString."\"".$key."\":\"".$value."\",";
      }
      $tipoAppuntamentiObjString=$tipoAppuntamentiObjString."}";


      //echo $appuntamenti->numRows."<br/>";
      //echo $appuntamenti->numCols."<br/>";
      $objPHPExcel->setActiveSheetIndex(0);

      $table_id="tablesorter-demo";
    	$table_class="tablesorter tablesaw tablesaw-stack";
    	$th_class="header";
    	$td_class="td";
    	$span_class="span";
      $popupUrl=get_bloginfo($show = 'wpurl');

      // Create popup in windows
      echo "<div class='popUp' style='position.absolute;z-index:100;min-width:400px;min-height:400px;background:white;display:none'></div>";

      echo "<button onClick='showItem(\"ORCH\")'>Solo ORCHESTRA</button>";
      echo "<button onClick='showItem(\"CMIS\")'>Solo CORO MISTO</button>";
      echo "<button onClick='showItem(\"CFEM\")'>Solo CORO FEMMINILE</button>";
      echo "<button onClick='showItem(\"CCAM\")'>Solo CORO DA CAMERA</button>";
      echo "<button onClick='showItems([\"CCAM\",\"CMIS\",\"CFEM\",\"CORI\"])'>Solo CORI</button>";
      echo "<button onClick='showAllItems()'>RIPRISTINA TABELLA</button>";

      echo "<table id='".$table_id."' class='".$table_class."'  data-tablesaw-mode='stack'>";
      echo "<thead>";
        echo "<tr>";
        for($c=0; $c<$calendarioCols; $c++) {
          if($c !== 5 /* esclude il campo nascosto nella testata */) {
            $cellValue=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($c,1)->getValue();
            echo "<th class='".$th_class."'>".$cellValue."</th>";
          }
        }
        echo "</tr>";
      echo "</thead>";

      for ($r=2; $r<$calendarioRows; $r++){
        if ($r % 2 == 0) {
          $tr_class="odd";
        }
        else {$tr_class="even";}
        // Give the "organico" as class for select mode

        $cellValueArray=[];
        // Fill the array for using on js parameters function call
        for($c=0; $c<$calendarioCols; $c++) {
            $cell=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($c,$r);
            $cellValue=$cell->getFormattedValue();
            if($c==0) {
              $unixTimeStamp = PHPExcel_Shared_Date::ExcelToPHP($cell->getValue());
              $cellValue = strftime("%a", $unixTimeStamp)."<br/>".strftime("%d %b %Y", $unixTimeStamp);
            }
            array_push($cellValueArray,$cellValue);
        }
        $tableObjString="{";
        for ($i=0; $i<count($cellValueArray); $i++){
          $tempValue=str_replace(","," ",$cellValueArray[$i]);
          $tempValue=str_replace(":"," - ",$tempValue);
          $tempValue=str_replace("<br/>"," ",$tempValue);
          $tempValue=str_replace("'","&apos;",$tempValue);

          $tableObjString=$tableObjString."\"".$i."\":\"".$tempValue."\",";
        }
        $tableObjString=$tableObjString."}";

        //$popupUrl=plugins_url( '/dettagliconvocazione.html', __FILE__ );

        echo "<tr onClick='showDetails(";
        echo $tableObjString.",".$salaObjString.",".$direttoriObjString.",".$tipoAppuntamentiObjString.",\"".$popupUrl."\"" ;
        echo ")' VALIGN='middle' class='cliccable ".$tr_class." ".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5,$r)->getValue()."'>";

        for($c=0; $c<$calendarioCols; $c++) {
          if($c !== 5 /* esclude il campo nascosto */) {

            echo "<td VALIGN='middle' class='".$td_class."'>".$cellValueArray[$c]."</td>";
          }
        }
        echo "</tr>";
      }

      echo "</table>";
    }

    public function getSheetAsArray($sheet_uri,$sheetIndex){

      if(file_exists($sheet_uri)){
        $objPHPExcel = PHPExcel_IOFactory::load($sheet_uri);
      }
      $objPHPExcel->setActiveSheetIndex($sheetIndex);
      $objWorksheet = $objPHPExcel->getActiveSheet();
      $rows = $objWorksheet->getHighestRow();
      $cols = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
      $sheetArray= Array ();
      for ($r=1; $r<$rows; $r++) { /* PHPExcel rows start from 1 */
        $rowArray = Array (); // Columns (0 to cols)
        for ($c=0; $c<$cols; $c++)
        {
          $cell=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($c,$r);
          $cellValue=$cell->getFormattedValue();
          if($c==0 && $r!=1) {
            $unixTimeStamp = PHPExcel_Shared_Date::ExcelToPHP($cell->getValue());
            $cellValue = strftime("%a %n %d %b %Y", $unixTimeStamp);
          }
          array_push($rowArray,$cellValue);
        }
        array_push($sheetArray,$rowArray);
      }
      return $sheetArray;
    }


}
