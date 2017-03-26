<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgMenuNavegacao.php
  Função: página do menu de navegação dos produtos
  Data de Criação: 10/02/2011 - 10:35
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgMenuNavegacao.php
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  BuscarDadosMenu()  //busca pelos dados para montar o menu de navegação - monta o select e o executa
  CriarMenuNavegacao()  //cria o menu de navegação
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgMenuNavegacao{
    
      private $Fbd;
      private $oDadosMenu;
    
      function __construct(){
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->BuscarDadosMenu();
        $this->CriarMenuNavegacao();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }

      
	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/ConexaoBD.php");
	  }


	  //inicializa variáveis
	  function InicializarVariaveis(){
        $this->Fbd = Conexao::GetInstanciaConexao();
	  }
	  
      
      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          //echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>";
          //echo "<script type='text/javascript' src='./jQuery/js/jquery-1.4.4.min.js'></script>"; //pgCabecalho.class.php
          echo "<script type='text/javascript' src='./jQuery/plugin/ddaccordion.js'></script>";
          echo "<script type='text/javascript' src='./js/jPgMenuNavegacao.js'></script>";
          echo "<link rel='stylesheet' href='./css/cPgMenuNavegacao.css' type='text/css' />";
        echo "</head>";
      }
      
      
      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }
      
      
      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divMenuNavegacao' name='divMenuNavegacao' id='divMenuNavegacao'>";
      }


      //busca pelos dados para montar o menu de navegação - monta o select e o executa
      function BuscarDadosMenu(){
        $sSql = "SELECT gru.cdGrupo,gru.nome AS nome_grupo,sub_gru.cdSubGrupo,sub_gru.nome AS nome_sub_grupo, ";
        $sSql .= " (SELECT COUNT(c.cdCamiseta) FROM camiseta c"; //trazer somente os sub-grupo que tenham camiseta
        $sSql .= " WHERE c.cdFkSubGrupo = sub_gru.cdSubGrupo) AS 'tot'";
        $sSql .= " FROM grupo gru";
        $sSql .= " JOIN sub_grupo sub_gru ON gru.cdGrupo = sub_gru.cdFkGrupo";
        $sSql .= " ORDER BY nome_grupo, nome_sub_grupo";
        $this->oDadosMenu = $this->Fbd->PesquisarSQL($sSql);
      }


      //cria o menu de navegação
      function CriarMenuNavegacao(){
        $sGrupo = "";
        $nTotMenu = 0;
        if($this->oDadosMenu){
          echo "<div class='urbangreymenu'>";
          foreach($this->oDadosMenu as $oRegistro){
            //imprime novo grupo
            if($oRegistro->tot > 0){ //existe camiseta para este sub-grupo
              if($sGrupo != $oRegistro->nome_grupo){
                //fecha o menu anterior
                if($nTotMenu > 0){
                  echo "</ul>";
                }
                echo "<h3 class='headerbar'>";
                  echo "<a href='#'>". $oRegistro->nome_grupo ."</a>";
                echo "</h3>";
                echo "<ul class='submenu'>";
                $sGrupo = $oRegistro->nome_grupo;
                $nTotMenu++;
              }
              //imprime item do menu
              echo "<li>";
                //echo "<a href='#' onClick='NavegandoMenuNavegacao(".$oRegistro->cdSubGrupo.");'>". $oRegistro->nome_sub_grupo ."</a>";
                                echo "<a href='javascript:NavegandoMenuNavegacao(".$oRegistro->cdSubGrupo.",\"".$oRegistro->nome_sub_grupo."\");'>". $oRegistro->nome_sub_grupo ."</a>";
              echo "</li>";
            } //fim - ($oRegistro->tot > 0)
          } //fim - foreach
          echo "</ul>";
          echo "</div>";
        }
        else{
          echo "Menu não pode ser montado.";
        }
      } //fim - CriarMenuNavegacao();


      //finaliza a div principal
      function FecharDivPrincipal(){
        echo "</div>";
      }
      

      //finaliza a tag body
      function FecharBody(){
        echo "</body>";
      }


      //finaliza HTML
      function FecharHTML(){
        echo "</html>";
      }

    } //fim - class MenuNavegacao
?>
