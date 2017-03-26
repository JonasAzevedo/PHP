$(document).ready(function(){
   //código a executar quando o DOM estiver pronto para receber instruções.
   alert('Carregou. Será inserido agora um evento ao link');
   $("a").click(function(evento){
      alert("Clicou no link!");
      evento.preventDefault(); //cancela comportamento 'href' do link. O onClick é executado.
   });
});
