<?php
  /* Geração de arquivo .PDF
  Jonas da Silva Azevedo
  Criado: 27/01/2010 - 17:12
*/
  class arquivoPDF {
  
    private function redimensionaFigura(){
     $imagempng = $_SESSION['imagemGrafico'];
     $larguraNova = 1400;
     $alturaNova = 750;
     $img = imagecreatefrompng($imagempng);
     $larguraOriginal = imagesX($img);
     $alturaOriginal = imagesY($img);
     $novaFigura = ImageCreateTrueColor($larguraNova,$alturaNova);
     imagecopyresampled($novaFigura, $img, 0, 0, 0, 0, $larguraNova, $alturaNova, $larguraOriginal,  $alturaOriginal);
     imagepng($novaFigura,$_SESSION['imagemGrafico']);
    }

    public function geraPDF($opc,$legenda,$descricao,$data){
      require("dompdf-0.5.1/dompdf_config.inc.php");
      require_once("conexaoBD.php");
      $dompdf = new DOMPDF();
      $bd = new conexao("localhost","root","","aprovisionamento");
       ini_set("memory_limit", "32M");
      ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
      session_start();
      $this->redimensionaFigura();

      $html = "<p align=right>";
      $html = $html . "<img src='./img/logo1.png' width='10' height='10' />";
      $html = $html . "</p>";
      //título
      //$html = $html . "<p align=center>";
      $html = $html . "<center>";
      $html = $html . "<font size='20' color='black'><b>";
      $html = $html . $opc;
      $html = $html . "</b></font>";
      $html = $html . "</center>";
      $html = $html . "<br/><br/>";
      
//      $html = $html . "</p>";
      //CORPO DO ARQUIVO
      //gráfico
      $html = $html . "<p align=center>";
      $html = $html . "<img src='" . $_SESSION['imagemGrafico'] . "' width='50' height='30' >";
      $html = $html . "</p>";
      $html = $html . "<br>";
      //descrição
      if($descricao<>""){
        $html = $html . "<p align=justify>";
        $html = $html . "<font size='10' color='black'><i>";
        $html = $html . "<blockquote>";
        $html = $html . "Descrição: " . $descricao;
        $html = $html . "</i></font>";
        $html = $html . "</blockquote>";
      }
      //RODAPÉ
      //data e hora da geração do arquivo
/*      $html = $html . "<p align=right> <i>";
      $html = $html . "Arquivo gerado em: " . $data;
      $html = $html . "</i> </p>";
*/
      $dompdf->load_html($html);
      //$dompdf->load_html_file("a2.php");
      $dompdf->set_paper('letter', 'landscape');
      $dompdf->render();
      $dompdf->stream("arquivo.pdf");
    }
  }
?>
