<?php

?>
<!--
  gráficos disponíveis
  Jonas da Silva Azevedo
  Criado: 26/01/2010 - 21:19
  Atualizado em: 03/03/2010 - 14:23
-->

<!-- insira o seguinte código de javascript em sua página. -->

<script language='Javascript'>

// construindo o calendário
function popdate(obj,div,tam,ddd)
{
    if (ddd)
    {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "/")
            {
                c++;
                s++;
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }
        ddd = mmonth + "/" + day + "/" + ano
    }

    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}

    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)

    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)

    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}
    txt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>X</b></a></td></tr></table></td></tr>"
    txt += "<tr><td colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    txt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    txt += "<tr bgcolor='#330099'><td width='14%' class='dia' align=center><b>Dom</b></td><td width='14%' class='dia' align=center><b>Seg</b></td><td width='14%' class='dia' align=center><b>Ter</b></td><td width='14%' class='dia' align=center><b>Qua</b></td><td width='14%' class='dia' align=center><b>Qui</b></td><td width='14%' class='dia' align=center><b>Sex<b></td><td width='14%' class='dia' align=center><b>Sab</b></td></tr>"
    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;

    for (n=1;n<= 42;n++)
    {
        if (week == 1)  txt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start)
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" )
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  d + "/" + (mmonth+1).toString() + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            d ++
        }
        else
        {
            txt += "<td class='data' align=center> </td>"
        }
        week ++
        if (week == 8)
        {
            week = 1; txt += "</tr>"}
        }
        txt += "</table>"
        div2 = eval (div)
        div2.innerHTML = txt
}

// função para exibir a janela com os meses
function pop_month(obj, div, tam, ano)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"')>" + umonth[n] +"</a></td></tr>" }
  txt += "</table>"
  popd.innerHTML = txt
}

// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) txt += "<tr>"
     txt += "<td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"')>" + n + "</a></td>"
     l++
     if (l == 4)
        {txt += "</tr>"; l = 1 }
  }
  txt += "</tr></table>"
  popd.innerHTML = txt
}

// função para fechar o calendário
function force_close(div)
    { div2 = eval (div); div2.innerHTML = ''}

// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div)
{
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data
}

</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  
   <script type="text/javascript" src="./jQuery/js/jquery-1.3.2.min.js">
    </script>

    <style type="text/css">
      ul {
        margin:0;
        padding:0;
        list-style:none;
      }
    
      ul#accordion-container {
        width:200px;
        padding:2px;
      }
    
      ul#accordion-container > li {
        margin-top:1px;
        background:#555;
      }
    
      ul#accordion-container > li > a {
        display:block;
        padding: 4px;
        color: #fff;
        text-decoration:none;
        outline:none;
      }
    
      ul#accordion-container > li > a:hover {
        background: #000;
      }

      ul.accordion-menu {
        display:none;
        background:#ccc;
      }
    
      ul.accordion-menu a {
        display:block;
        padding-left: 4px;
        background:#ccc;
        color:#555;
        text-decoration:none;
        outline:none;
      }
    
      ul.accordion-menu a:hover {
        color:#fff;
      }
    </style>

    <script language="javascript">
      $(document).ready(function(){
        $('#accordion-container > li > a').bind('click',function() {
          var $next = $(this).next();
          if ($next.is(':visible')) return false;
          $(this).parent().parent().find('li > ul:visible').slideUp('normal');
          $next.slideDown('normal');
          return false;
        });
      });
    </script>
    
    <script language="javascript">
      function selecionaGrafico(vlr){
        document.frmSelParametros.btnGrafico.value = vlr;
        document.forms["frmSelParametros"].submit();
      }
    </script>

    <script language="JavaScript">
      <!--
      function dataPesquisa(){
        hoje = new Date();
        dia = hoje.getDate();
        mes = hoje.getMonth() + 1;
        ano = hoje.getYear();
        if (dia < 10){
          dia = "0" + dia;
        }
        if (mes < 10){
          mes = "0" + mes;
        }
        if (ano < 2000) {
          ano = 1900 + ano;
        }
        document.frmSelParametros.edDataInicio.value = "01" + "/" + mes + "/" + ano;
        document.frmSelParametros.edDataFinal.value = dia + "/" + mes + "/" + ano;
      }
      -->
    </script>
  
    <style>
      .dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF}
      .data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
      .mes {font-family: helvetica, arial; font-size: 8pt}
      .Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
    </style>
    <link rel="stylesheet" type="text/css" href="estilos.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  </head>
  <body OnLoad="dataPesquisa()">
    <center>
        <a href="index.php" target="_parent">Principal</a> <br><br><br>
        <form name="frmSelParametros" method="POST" target="frmGrafico" action="exibeGrafico.php">

          <span><b>Selecione o Gráfico:</b></span><br>
          <ul id="accordion-container">
            <li>
            <a href="#">Geral</a>
            <ul class="accordion-menu">
              <li><a href="#" OnClick="selecionaGrafico('Geral de OS')">Geral de OS</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Ofensores por Segmento')">Ofensores por Segmento</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Ofensores por Responsável')">Ofensores por Responsável</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Causa Ofensores')">Causa Ofensores</a></li>
            </ul>
            </li>
            <li>
            <a href="#">Meta Prisma</a>
            <ul class="accordion-menu">
              <li><a href="#" OnClick="selecionaGrafico('Meta Prisma - VOZ_AV')">VOZ AV</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Meta Prisma - CD')">CD</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Meta Prisma - TX')">TX</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Meta Prisma - Eficiência')">Eficiência</a></li>
            </ul>
            </li>
            <li>
            <a href="#">Mensal</a>
            <ul class="accordion-menu">
              <li><a href="#" OnClick="selecionaGrafico('Mensal - Meta Prisma - VOZ_AV')">VOZ AV</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Mensal - Meta Prisma - CD')">CD</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Mensal - Meta Prisma - TX')">TX</a></li>
              <li><a href="#" OnClick="selecionaGrafico('Mensal - Meta Prisma - Eficiência')">Eficiência</a></li>
            </ul>
            </li>
          </ul>
          
          <input type="hidden" name="btnGrafico" /> <br>
          
          </center>
          <div id='divExibeCalendario'>
            <span id="pop1" style="position:absolute"></span><!--Exibição Data Inicial-->
            <span id="pop2" style="position:absolute"></span><!--Exibição Data Final-->
          </div>
          <div id='divSelecaoData'>
          <!-- data Início -->
            <p>Pesquisar por Período:</p>
            <input name="edDataInicio" size="10" maxlength="10" value="">
            <input type="button" name="btnDataInicio" value="..." Onclick="javascript:popdate('document.frmSelParametros.edDataInicio','pop1','150',document.frmSelParametros.edDataInicio.value)">
            <br><br>
            <!-- data Final -->
            <input name="edDataFinal" size="10" maxlength="10" value="">
            <input type="button" name="btnDataFinal" value="..." Onclick="javascript:popdate('document.frmSelParametros.edDataFinal','pop2','150',document.frmSelParametros.edDataFinal.value)">
          </div>
        </form>

  </body>
</html>
