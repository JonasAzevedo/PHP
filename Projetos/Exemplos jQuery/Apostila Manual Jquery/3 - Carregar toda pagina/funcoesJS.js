$(document).ready(function(){
   //c�digo a executar quando o DOM estiver pronto para receber instru��es.
   alert('Carregou. Ser� inserido agora um evento ao link');
   $("a").click(function(evento){
      alert("Clicou no link!");
      evento.preventDefault(); //cancela comportamento 'href' do link. O onClick � executado.
   });
});
