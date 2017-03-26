$(document).ready(function() {
    alert('Documento Pronto');

    $('#aLink1').click(function(evt){
      evt.preventDefault();
      var nP = $('div.divTeste1').has('p');
      alert(nP.length);
    });
    
    $('#aLink2').click(function(evt){
      evt.preventDefault();
      var x = $('div.divTeste1');
      alert(x.length);
      
      x.each(function(a){
        alert($(this).html());
      });
    });

});
