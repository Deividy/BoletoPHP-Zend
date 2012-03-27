<?php
abstract class Lib_Boleto_Boleto {
	protected $_funcoes = null;
	
	private $valor = 0;
	private $taxa = 0;
	
	private $prazo = 3;
	
	private $vencimento = null;
	private $documento = null;
	private $processamento = null;
	
	private $nosso_numero = null;
	private $linha_digitavel = null;
	private $codigo_barras = null;
	private $codigo_banco_dv = null;
	
	private $cliente_nome = null;
	private $cliente_endereco = null;
	private $cliente_endereco1 = null;
	
	private $demonstrativo1 = null;
	private $demonstrativo2 = null;
	private $demonstrativo3 = null;
	
	private $instrucoes1 = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
	private $instrucoes2 = "- Receber até 10 dias após o vencimento";
	private $instrucoes3 = null;
	private $instrucoes4 = null;
	
	private $identificacao = null;
	private $cnpj = null;
	private $endereco = null;
	private $cidade_uf = null;
	private $cedente = null;
	public function __construct() {
		$func = new SSGC_Boleto_Funcoes();
		$this->_funcoes = $func;
	}
	public function setCliente(Cliente $cliente) {
		$this->setCliente_nome($cliente->getNome());
		$this->setCliente_endereco($cliente->getRua());
		$this->setCliente_endereco1($cliente->getCidade().' / '.$cliente->getEstado());
	}
	public function getLinha_digitavel() {
		return $this->linha_digitavel;
	}

	public function getCodigo_barras() {
		return $this->fbarcode($this->codigo_barras);
	}

	public function getCodigo_banco_dv() {
		return $this->codigo_banco_dv;
	}

	public function setLinha_digitavel($linha_digitavel) {
		$this->linha_digitavel = $linha_digitavel;
	}

	public function setCodigo_barras($codigo_barras) {
		$this->codigo_barras = $codigo_barras;
	}

	public function setCodigo_banco_dv($codigo_banco_dv) {
		$this->codigo_banco_dv = $codigo_banco_dv;
	}

	public function getPrazo() {
		return $this->prazo;
	}

	public function setPrazo($prazo) {
		$this->prazo = $prazo;
	}
	
	public function getValor() {
		return $this->valor;
	}

	public function getTaxa() {
		return $this->taxa;
	}

	public function getVencimento() {
		return date('d/m/Y', strtotime(str_replace('/', '-', $this->vencimento) . $this->getPrazo()." days"));
	}

	public function getDocumento() {
		return $this->documento;
	}

	public function getProcessamento() {
		return $this->processamento;
	}

	public function getNosso_numero() {
		return $this->nosso_numero;
	}

	public function getCliente_nome() {
		return $this->cliente_nome;
	}

	public function getCliente_endereco() {
		return $this->cliente_endereco;
	}

	public function getCliente_endereco1() {
		return $this->cliente_endereco1;
	}

	public function getDemonstrativo1() {
		return $this->demonstrativo1;
	}

	public function getDemonstrativo2() {
		return $this->demonstrativo2;
	}

	public function getDemonstrativo3() {
		return $this->demonstrativo3;
	}

	public function getInstrucoes1() {
		return $this->instrucoes1;
	}

	public function getInstrucoes2() {
		return $this->instrucoes2;
	}

	public function getInstrucoes3() {
		return $this->instrucoes3;
	}

	public function getInstrucoes4() {
		return $this->instrucoes4;
	}

	public function getIdentificacao() {
		return $this->identificacao;
	}

	public function getCnpj() {
		return $this->cnpj;
	}

	public function getEndereco() {
		return $this->endereco;
	}

	public function getCidade_uf() {
		return $this->cidade_uf;
	}

	public function getCedente() {
		return $this->cedente;
	}

	public function setValor($valor) {
		$this->valor = number_format($valor,2,',','.');
	}

	public function setTaxa($taxa) {
		$this->taxa = $taxa;
	}

	public function setVencimento($vencimento) {
		$this->vencimento = $vencimento;
	}

	public function setDocumento($documento) {
		$this->documento = $documento;
	}

	public function setProcessamento($processamento) {
		$this->processamento = $processamento;
	}

	public function setNosso_numero($nosso_numero) {
		$this->nosso_numero = $nosso_numero;
	}

	public function setCliente_nome($cliente_nome) {
		$this->cliente_nome = $cliente_nome;
	}

	public function setCliente_endereco($cliente_endereco) {
		$this->cliente_endereco = $cliente_endereco;
	}

	public function setCliente_endereco1($cliente_endereco1) {
		$this->cliente_endereco1 = $cliente_endereco1;
	}

	public function setDemonstrativo1($demonstrativo1) {
		$this->demonstrativo1 = $demonstrativo1;
	}

	public function setDemonstrativo2($demonstrativo2) {
		$this->demonstrativo2 = $demonstrativo2;
	}

	public function setDemonstrativo3($demonstrativo3) {
		$this->demonstrativo3 = $demonstrativo3;
	}

	public function setInstrucoes1($instrucoes1) {
		$this->instrucoes1 = $instrucoes1;
	}

	public function setInstrucoes2($instrucoes2) {
		$this->instrucoes2 = $instrucoes2;
	}

	public function setInstrucoes3($instrucoes3) {
		$this->instrucoes3 = $instrucoes3;
	}

	public function setInstrucoes4($instrucoes4) {
		$this->instrucoes4 = $instrucoes4;
	}

	public function setIdentificacao($identificacao) {
		$this->identificacao = $identificacao;
	}

	public function setCnpj($cnpj) {
		$this->cnpj = $cnpj;
	}

	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}

	public function setCidade_uf($cidade_uf) {
		$this->cidade_uf = $cidade_uf;
	}

	public function setCedente($cedente) {
		$this->cedente = $cedente;
	}

	/* Boleto Funcoes */
	public function getFuncoes() {
		return new SSGC_Boleto_Funcoes();
	}
	
	public function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		$func = $this->getFuncoes();
		return $func->formata_numero($numero,$loop,$insert,$tipo = "geral");
	}
	public function fbarcode($valor){
		$func = $this->getFuncoes();
		return $func->fbarcode($valor);
	}

	public function esquerda($entra,$comp){
		$func = $this->getFuncoes();
		return $func->esquerda($entra,$comp);
	}

	public function direita($entra,$comp){
		$func = $this->getFuncoes();
		return $func->direita($entra,$comp);
	}
	public function fator_vencimento($data) {
		$func = $this->getFuncoes();
		return $func->fator_vencimento($data);
	}

	public function _dateToDays($year,$month,$day) {
		$func = $this->getFuncoes();
		return $func->_dateToDays($year,$month,$day);
	}

	public function modulo_10($num) { 
		$func = $this->getFuncoes();
		return $func->modulo_10($num);
	}

	public function modulo_11($num, $base=9, $r=0)  {
	   	$func = $this->getFuncoes();
		return $func->modulo_11($num, $base=9, $r=0);
	}

	public function modulo_11_invertido($num) { 
	   	$func = $this->getFuncoes();
		return $func->modulo_11_invertido($num);
	}

	public function geraCodigoBanco($numero) {
	   	$func = $this->getFuncoes();
		return $func->geraCodigoBanco($numero);
	}
	function dataJuliano($data) {
	   	$func = $this->getFuncoes();
		return $func->dataJuliano($data);
	}

	function digitoVerificador_nossonumero($numero) {
	   	$func = $this->getFuncoes();
		return $func->digitoVerificador_nossonumero($numero);
	}
	function digitoVerificador_barra($numero) {
	   	$func = $this->getFuncoes();
		return $func->digitoVerificador_barra($numero);
	}
	
}
