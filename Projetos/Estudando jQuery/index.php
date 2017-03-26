<?php
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
  echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
    echo "<head>";
      echo "<script language='JavaScript' src='./jquery-1.4.4.min.js'></script>";
      echo "<script language='JavaScript' src='./jIndex.js'></script>";
    echo "</head>";
    
    echo "<body>";
      echo "<a href='' id='aLink1'>Selecionando as Div's que contem o elemento P</a>";
      echo "<br />";
      echo "<a href='' id='aLink2'>Percorrendo as Div's</a>";
      echo "<br />";echo "<br />";echo "<br />";
      
      echo "<div class='divTeste1' id='div1'>";
        echo "DIV 1";
        echo "<p>";
          echo "Parágrafo 1";
        echo "</p>";
        echo "<p>";
          echo "Parágrafo 2";
        echo "</p>";
      echo "</div>";
      
      echo "<div class='divTeste1' id='div2'>";
        echo "DIV 2";
      echo "</div>";
      
      echo "<div class='divTeste1' id='div3'>";
        echo "DIV 3";
      echo "</div>";
      
    echo "</body>";
  echo "</html>";
?>
