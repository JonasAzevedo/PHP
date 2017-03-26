// JavaScript Document 
//Input somente numeros usado: onkeypress="return campo_numerico(event)" 
function campo_numerico(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode;
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}
//Mascaras Uso: onkeyup="mascara(this.value, this.id, '####.##.##.#######-#/#', event)"
function mascara(valor, id, mascara, evento){

//inicializa a variavel que vai conter o valor final
var valorFinal = "";
//verifica o que foi digitada para que seja verificado se é somente números ou não
var tecla = evento.keyCode;
//manetem o tamanho original do campo sem retirar a máscara
var valorOriginal = valor;
//inicializa um array com todos os caracteres que serão retirado
var arrNaoPermitidos = new Array("-", ".", "/", "\\", "|", "(", ")", ":", " ");
//retira qualquer máscatra que já tenho sido colocada
for(i1=0;i1<valor.length;i1++)
{
for(i2=0;i2<arrNaoPermitidos.length;i2++)
{
if(valor.charAt(i1) == arrNaoPermitidos[i2])
{
valor = valor.toString().replace( arrNaoPermitidos[i2], "" );
}
}
}
//verifica se foi precionado o backspae
if(tecla != 8)
{
//verifica se já não ultrapassou o tamanha máximo da máscara
if(mascara.length >= valorOriginal.length)
{
//loop em cima do valor do campo sem a máscara
jaTemMascara = false;
for(i=0;i<valor.length;i++)
{
//verifica se a string já recebeu alguma máscara ou não
if(jaTemMascara == false)
{
//verifica se o tipo da entrada de dados tem que ser némerica
if(mascara.charAt(i) == "#")
{
//verifica se foi digitado somente números
if(((tecla > 95) && (tecla < 106)) || ((tecla > 47) && (tecla < 58)) || tecla == 9 || tecla == 16)
{
//0 = 96 ou 48
//1 = 97 ou 49
//2 = 98 ou 50
//3 = 99 ou 51
//4 = 100 ou 52
//5 = 101 ou 53
//6 = 102 ou 54
//7 = 103 ou 55
//8 = 104 ou 56
//9 = 105 ou 57
//tecla == 9 = tab
valorFinal = valorFinal+ valor.charAt(i);
}
else//se não foi digitado um número é retirado o caracter da string
{
valorFinal = valorOriginal.substring(0, valorOriginal.length -1);
}
}
else if(mascara.charAt(i) == "@")//verifica se o tipo da entrada é qualquer caracter
{
valorFinal = valorFinal+ valor.charAt(i);
}
else//se não for quelaquer caracter é algum elemento da máscara
{
//verifica se o próxima depois da máscara é númerica 
if(mascara.charAt(i + 1) == "#")
{
//verifica se foi digitado somente números
if(((tecla > 95) && (tecla < 106)) || ((tecla > 47) && (tecla < 58)) || tecla == 9 || tecla == 16)
{
//0 = 96 ou 48
//1 = 97 ou 49
//2 = 98 ou 50
//3 = 99 ou 51
//4 = 100 ou 52
//5 = 101 ou 53
//6 = 102 ou 54
//7 = 103 ou 55
//8 = 104 ou 56
//9 = 105 ou 57
//tecla == 9 = tab
valorFinal = valorFinal + mascara.charAt(i + jaTemMascara)+ valor.charAt(i);
jaTemMascara = jaTemMascara + 1;
}
else//se não foi digitado um número é retirado o caracter da string
{
valorFinal = valorOriginal.substring(0, valorOriginal.length -1);
}
}
else// se não é númerico então pode ser qualuqer caracter
{
valorFinal = valorFinal + mascara.charAt(i + jaTemMascara)+ valor.charAt(i);
jaTemMascara = jaTemMascara + 1;
}
}
}
else//else da verificação da máscara
{
//verifica se foi digitado somente números
if(mascara.charAt(i + jaTemMascara) == "#")
{
//verifica se foi digitado somente números
if(((tecla > 95) && (tecla < 106)) || ((tecla > 47) && (tecla < 58)) || tecla == 9 || tecla == 16)
{
//0 = 96 ou 48
//1 = 97 ou 49
//2 = 98 ou 50
//3 = 99 ou 51
//4 = 100 ou 52
//5 = 101 ou 53
//6 = 102 ou 54
//7 = 103 ou 55
//8 = 104 ou 56
//9 = 105 ou 57
//tecla == 9 = tab
valorFinal = valorFinal+ valor.charAt(i);
}
else//se não foi digitado um número é retirado o caracter da string
{
valorFinal = valorOriginal.substring(0, valorOriginal.length -1);
}
}
else if(mascara.charAt(i + jaTemMascara) == "@")//verifica se o tipo da entrada é qualquer caracter
{
valorFinal = valorFinal+ valor.charAt(i);
}
else
{
//verifica se foi digitado somente números
if(mascara.charAt(i + jaTemMascara +1) == "#")
{
//verifica se foi digitado somente números
if(((tecla > 95) && (tecla < 106)) || ((tecla > 47) && (tecla < 58)) || tecla == 9 || tecla == 16)
{
//0 = 96 ou 48
//1 = 97 ou 49
//2 = 98 ou 50
//3 = 99 ou 51
//4 = 100 ou 52
//5 = 101 ou 53
//6 = 102 ou 54
//7 = 103 ou 55
//8 = 104 ou 56
//9 = 105 ou 57
//tecla == 9 = tab
valorFinal = valorFinal + mascara.charAt(i + jaTemMascara)+ valor.charAt(i);
jaTemMascara = jaTemMascara + 1;
}
else//se não foi digitado um número é retirado o caracter da string
{
valorFinal = valorOriginal.substring(0, valorOriginal.length -1);
}
}
else// se não é númerico então pode ser qualuqer caracter
{
valorFinal = valorFinal + mascara.charAt(i + jaTemMascara)+ valor.charAt(i);
jaTemMascara = jaTemMascara + 1;
}
}
}//fim da verificação da máscara
}
}
else
{
valorFinal = valorOriginal.substring(0, mascara.length);
}//final da verificação do tamanha máximo da string
}
else
{
//valorFinal = valorOriginal.substring(0, valorOriginal.length -1)
valorFinal = valorOriginal.substring(0, valorOriginal.length);
}//final da verificação do backspace
document.getElementById(id).value = valorFinal;
}







// FUNÇÃO RESPONSÁVEL DE CONECTAR A UMA PAGINA EXTERNA NO NOSSO CASO A BUSCA_NOME.PHP 
// E RETORNAR OS RESULTADOS 

function ajax(url){
    //alert(nick);
    //alert(dest);
    //alert(msg);
    
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest){
      req = new XMLHttpRequest();
      req.onreadystatechange = processReqChange;
      req.open("GET",url,true);
      req.send(null);
      // Procura por uma versão ActiveX (IE)
    } else if (window.ActiveXObject) {
      req = new ActiveXObject("Microsoft.XMLHTTP");
      if (req) {
        req.onreadystatechange = processReqChange;
        req.open("GET",url,true);
        req.send();
      }
    }
} 

function processReqChange(){
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
      // apenas se o servidor retornar "OK"
      if (req.status ==200) {
        // procura pela div id="pagina" e insere o conteudo
        // retornado nela, como texto HTML
        if(req.responseText == 'O Valor Declarado é obrigatório para este serviço') {
          alert('O valor declarado é obrigatório para o cálculo do frete.');
        } else {
          if(req.responseText == 'Serviço indisponível para o trecho informado') {
          alert('Serviço indisponível para o destino informado');
        } else {
          document.getElementById('resultado').value = req.responseText;
        }
      }
      } else {
        alert("Houve um problema ao obter os dados:n" + req.statusText);
      }
    }
} 

function Checacep(servico,origem,destino,peso,valor){
    //FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
    url="calcular.php?servico="+servico+"&origem="+origem+"&destino="+destino+"&peso="+peso+"&valor="+valor;
    ajax(url);
} 
