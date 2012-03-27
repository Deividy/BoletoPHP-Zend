<?php
class Lib_Boleto_SantanderBanespa extends Lib_Boleto_Boleto {
	private $quantidade = null;
	private $valor_unitario = null;
	private $aceite = null;
	private $especie = 'R$';
	private $especie_doc = null;
	
	private $codigo_cliente = null;
	private $agencia = null;
	private $agencia_dv = null;
	private $carteira = '102';
	private $carteira_descricao = 'COBRANÇA SIMPLES - CSR';
	
	public function __construct(Zend_Config_Ini $config = null) {
		if ($config && $config instanceof Zend_Config_ini) {
			$this->setIdentificacao($config->identificacao);
			$this->setCnpj($config->cnpj);
			$this->setEndereco($config->endereco);
			$this->setCidade_uf($config->cidade_uf);
			$this->setCedente($config->cedente);
			
			$this->setAgencia($config->agencia);
			$this->setCodigo_cliente($config->codigo_cliente);
		}
	}
	public function gerarBoleto() {
		$codigobanco = "033";
		$codigo_banco_com_dv = $this->geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fixo     = "9";   
		$ios	  = "0"; 
		$fator_vencimento = $this->fator_vencimento($this->getVencimento());

		$valor = $this->formata_numero($this->getValor(),10,0,"valor");
		$carteira = $this->getCarteira();
		
		$codigocliente = $this->formata_numero($this->getCodigo_cliente(),7,0);
		
		$nnum = $this->formata_numero($this->getNosso_numero(),7,0);
		$dv_nosso_numero = $this->modulo_11($nnum,9,0);
		$nossonumero = "00000".$nnum.$dv_nosso_numero;
		
		$vencimento = $this->getVencimento();
		
		$vencjuliano = $this->dataJuliano($vencimento);
		
		$barra = "$codigobanco$nummoeda$fator_vencimento$valor$fixo$codigocliente$nossonumero$ios$carteira";
		$dv = $this->digitoVerificador_barra($barra);
		
		$linha = substr($barra,0,4) . $dv . substr($barra,4);
		
		$this->setCodigo_barras($linha);
		$this->setLinha_digitavel($this->monta_linha_digitavel($linha));
		$this->setNosso_numero($nossonumero);
		$this->setCodigo_banco_dv($codigo_banco_com_dv);
	}
	
	function monta_linha_digitavel($codigo) { 
		$campo1 = substr($codigo,0,3) . substr($codigo,3,1) . substr($codigo,19,1) . substr($codigo,20,4);
		$campo1 = $campo1 . $this->modulo_10($campo1);
	  	$campo1 = substr($campo1, 0, 5).'.'.substr($campo1, 5);
		$campo2 = substr($codigo,24,10);
		$campo2 = $campo2 .$this->modulo_10($campo2);
	  	$campo2 = substr($campo2, 0, 5).'.'.substr($campo2, 5);
		$campo3 = substr($codigo,34,10);
		$campo3 = $campo3 . $this->modulo_10($campo3);
	  	$campo3 = substr($campo3, 0, 5).'.'.substr($campo3, 5);
		$campo4 = substr($codigo, 4, 1);
		$campo5 = substr($codigo, 5, 4) . substr($codigo, 9, 10);
		return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
	}
	
	public function getNumeroCodigoCliente() {
		$tmp2 = $this->getCodigo_cliente();
     	$tmp2 = substr($tmp2,0,strlen($tmp2)-1).'-'.substr($tmp2,strlen($tmp2)-1,1);
     	return $tmp2;
	}
	public function getNumeroNosso_numero() {
		$tmp = $this->getNosso_numero();
	    $tmp = substr($tmp,0,strlen($tmp)-1).'-'.substr($tmp,strlen($tmp)-1,1);
	    return $tmp;
	}
	public function getQuantidade() {
		return $this->quantidade;
	}

	public function getValor_unitario() {
		return $this->valor_unitario;
	}

	public function getAceite() {
		return $this->aceite;
	}

	public function getEspecie() {
		return $this->especie;
	}

	public function getEspecie_doc() {
		return $this->especie_doc;
	}

	public function getCodigo_cliente() {
		return $this->codigo_cliente;
	}

	public function getAgencia() {
		return $this->agencia;
	}

	public function getAgencia_dv() {
		return $this->agencia_dv;
	}

	public function getCarteira() {
		return $this->carteira;
	}

	public function getCarteira_descricao() {
		return $this->carteira_descricao;
	}

	public function setQuantidade($quantidade) {
		$this->quantidade = $quantidade;
	}

	public function setValor_unitario($valor_unitario) {
		$this->valor_unitario = $valor_unitario;
	}

	public function setAceite($aceite) {
		$this->aceite = $aceite;
	}

	public function setEspecie($especie) {
		$this->especie = $especie;
	}

	public function setEspecie_doc($especie_doc) {
		$this->especie_doc = $especie_doc;
	}

	public function setCodigo_cliente($codigo_cliente) {
		$this->codigo_cliente = $codigo_cliente;
	}

	public function setAgencia($agencia) {
		$this->agencia = $agencia;
	}

	public function setAgencia_dv($agencia_dv) {
		$this->agencia_dv = $agencia_dv;
	}

	public function setCarteira($carteira) {
		$this->carteira = $carteira;
	}

	public function setCarteira_descricao($carteira_descricao) {
		$this->carteira_descricao = $carteira_descricao;
	}

	

}
