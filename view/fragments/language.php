<?php
function language(){
	$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$text = ['CompleteRM'];
	if ($language == 'en'){
		$timezone_reduction= 0;
		$txt = [
			'CompleteRM',
			'Home',
			'Search',
			'Logout',
			'Leads',
			'Clients',//5
			'Dependents',
			'Interests',
			'Products',
			'Reports',
			'Users',//10
			'Configurations',
			'Lead',
			'Dependent of',
			'Client',
			'Mail',//15
			'Phone',
			'Status',
			'Update',
			'Address',
			'Birth',//20
			'Creation',
			'Source',
			'Owner',
			'Observation',
			'More info',//25
			'Notes',
			'View',
			'List',
			'Search results for ',
			'Name',//30
			'No data here',
			'Add',
			'Parent',
			'Enter',
			'Submit',//35
			'Cancel',
			'No parent',
			'Add note',
			'posted:',
			'Deals',//40
			'Write',
			'Note',
			'No notes here',
			'No deal with this',
			'sold',//45
			'to',
			'Close deal',
			'Delete',
			'showed interest',
			'No interests registered',//50
			'Register interest',
			'Remove',
			'Interest',
			'Description',
			'Interested',//55
			'No one is interested yet',
			'Deactivate',
			'Product',
			'Sold',
			'Sign in to use the system',//60
			'Sign in',
			'Login',
			'Password',
			'User',
			'Administrator',//65
			'Active',
			'Deactivated',
			'New',
			'Status',
			'Sources',//70
			'Configuration',
			'Parent of',
			'Dependent',
			'in',
			'All',//75
			'Only',
			'Excluding',
			'New',
			'Generate',
			'Report',//80
			'New',
			'Start date',
			'End date',
			'Current date',
			'Filters',//85
			'Owners',
			'All',
			'All',
			'Back',
			'Sale Date',//90
			'Leads report',
			'Deals report',
			'Generated',
			'Print',
		];
	}
	if ($language == 'pt') {
		$timezone_reduction= 10800;
		$txt = [
			'CompleteRM',
			'Página Inicial',
			'Pesquisar',
			'Sair',
			'Potenciais clientes',
			'Clientes',//5
			'Dependentes',
			'Interesses',
			'Produtos',
			'Relatórios',
			'Usuários',//10
			'Configurações',
			'Potencial cliente',
			'Dependente de',
			'Cliente',
			'E-mail',//15
			'Telefone',
			'Situação',
			'Atualizar',
			'Endereço',
			'Nascimento',//20
			'Criação',
			'Origem',
			'Proprietário',
			'Observações',
			'Mais informações',//25
			'Notas',
			'Visualizar',
			'Listar',
			'Resultados da busca por ',
			'Nome',//30
			'Nenhuma informação aqui',
			'Adicionar',
			'Responsável',
			'Preencher',
			'Enviar',//35
			'Cancelar',
			'Sem responsável',
			'Adicionar nota',
			'escreveu:',
			'Negócios',//40
			'Escrever',
			'Nota',
			'Nenhuma nota aqui',
			'Nenhum negócio com este',
			'vendeu',//45
			'para',
			'Fechar negócio',
			'Apagar',
			'demonstrou interesse',
			'Nenhum interesse registrado',//50
			'Registrar interesse',
			'Remover',
			'Interesse',
			'Descrição',
			'Interessados',//55
			'Ninguém se interessou ainda',
			'Desativar',
			'Produto',
			'Vendas',
			'Entre para usar o sistema',//60
			'Entrar',
			'Login',
			'Senha',
			'Usuário',
			'Administrador',//65
			'Ativo',
			'Inativo',
			'Nova',
			'Situações',
			'Origens',//70
			'Configuração',
			'Responsável por',
			'Dependente',
			'em',
			'Todos',//75
			'Apenas',
			'Exceto',
			'Novo',
			'Gerar',
			'Relatório',//80
			'Novos',
			'Data inicial',
			'Data final',
			'Data atual',
			'Filtros',//85
			'Proprietários',
			'Todos',
			'Todas',
			'Voltar',
			'Data da venda',//90
			'Relatório de potenciais clientes',
			'Relatório de vendas',
			'Gerado em',
			'Imprimir',
		];
	}
	return $txt;
}
function timezone_difference(){
	$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if ($language == 'en'){
		$timezone_reduction= 0;
	}
	if ($language == 'pt') {
		$timezone_reduction= 10800;
	}
	return $timezone_reduction;
}
?>