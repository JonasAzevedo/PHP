// Função que fecha o pop-up ao clicar no botao fechar
function fechar(){
  document.getElementById('popup').style.display = 'none';
}


// Aqui definimos o tempo para fechar o pop-up automaticamente
function abrir(){
  document.getElementById('popup').style.display = 'block';
  setTimeout ('fechar()', 3000);
}
