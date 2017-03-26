// JavaScript Document
var lastModal  = null;
jQuery.fn.modal = function(parametros) {
	var img = 'imgs/loading.gif';
		option = jQuery.extend({
		id        : 'modalPadrao',  // id da modal
		title     : null,  // titulo da modal 
		width     : 100,   // largura inicial da modal
		height    : null,  // altura fixa da modal
		buttons   : null,  // botoes
		container : null,  // conteudo da modal
		url       : null,  // ajax - carrega conteudo dinamico a ser exibido,
		cutContent: true,  // recorta ou clona o conteúdo da modal
		blockClose: false, // bloqueia o fechamento da modal, permitindo somente pelos botoes
		classe    : null,  // classe da modal
		onSuccess : null,  // fn a ser executada após a execução da requisição ** apenas para requisições ajax
		isDrag    : false, // deixa modal drag
		isFixed   : false  // torna a modal fixa e centralizado utilizando o plug-in fixedbox
  }, parametros);
	lastModal = option.id;	
	/* verifica se a modal já foi criada anteriormente */
	if (!isModal(option.id)) {
		/* cria a div pai da modal */
		createModal(option);
	}
	
	modal = '#'+option.id;

	/* título da modal */
	$(modal).find('.header span').html(option.title);

	/* conteúdo da modal */
	if (option.url) {
		$(modal+' .text-container').html('<img src="' +img+ '" align="absmiddle" />&nbsp;&nbsp;Aguarde...')
				  .load(option.url, {}, 
						function() {
							if (option.isFixed == true) {
								$(modal).fixedBox();
							}
							if (option.onSuccess) {
								eval(option.onSuccess);	
							}
						});
	}
	else if (option.container) {
		/* append do conteudo para a div container da modal */
		$(modal+' .text-container').append(option.container.clone());
		/* remove a div do conteúdo copiado */
		option.container.remove();
	}

	/* aplica drag se estiver configurado */
	if (option.isDrag == true) {
		$(modal).draggable({handle:'.header'});
	}
	
	/** 
	 * aplica o plug-in fixebox na modal
	 * OBS.: para utilizar este recurso, o plug-in deve estar declarado na página
	 */
	if (option.isFixed == true) {
		$(modal).fixedBox();
	}
	
	
	/* exibe a modal */
	$(modal).show();

	function isModal(id) {
		return ($('#'+id)[0])?true:false;
	}
	
	function createModal(option) {
		/* cria a div pai da modal */
		div = document.createElement('div');
		/* adiciona classe e seta atributos necessários */
		$(div).addClass('modal size-modal')
		      .attr({'id'    : option.id})
			  .css({'width'  : option.width});
			  
		/* altura */
		if (option.height) {
			$(div).height(option.height+'px');
		}

		/* cria a estrutura da modal */
		/* identifica se o botão de fechar da modal será exibido */
		if (option.blockClose == true) {
			$(div).html('<div class="intern"><div class="header"><span></span></div><div class="container"><div class="text-container"></div><div class="divButtons"></div></div></div>');			
		} else {
			$(div).html('<div class="intern"><div class="header"><span></span><a  href="javascript:void(0);" onclick="javascript:closeModal(\''+ option.id +'\')" class="close" title="Fechar">x</a></div><div class="container"><div class="text-container"></div><div class="divButtons"></div></div></div>');
		}
		
		/* adiciona a modal no body */
		$('body').append(div);

		/* cria os botões da modal */
		$(div).find('.divButtons').empty().show();
		
		if (option.buttons) {
			var input, btn;
			for (i=0; i< option.buttons.length; i++) {
				btn   = option.buttons[i];
				/* cria o elemento botao */
				input = document.createElement("input");
				/* seta os atributos necessários */
				$(input).attr({'type'  : 'button', 
							   'name'  : btn.id,
							   'id'    : btn.id,
							   'value' : btn.name
							  });
				/* seta para o botao a funcao e ser executada no evento click */ 
				setTimeout('$(\'#' + btn.id + '\').click(function(){eval('+btn.action+')})', 0);
				/* append dos botões na modal */
				$(div).find('.divButtons').append(input);
			}
		}
	}
};
