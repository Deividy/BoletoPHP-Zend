<?php
class Lib_Boleto_Funcoes {
	
	public function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}


	public function fbarcode($valor){
		$code = '';
		$fino = 1 ;
		$largo = 3 ;
		$altura = 50 ;
	
	  	$barcodes[0] = "00110" ;
	  	$barcodes[1] = "10001" ;
	  	$barcodes[2] = "01001" ;
	  	$barcodes[3] = "11000" ;
	  	$barcodes[4] = "00101" ;
		$barcodes[5] = "10100" ;
		$barcodes[6] = "01100" ;
		$barcodes[7] = "00011" ;
		$barcodes[8] = "10010" ;
		$barcodes[9] = "01010" ;
	  	for($f1=9;$f1>=0;$f1--){ 
	   		for($f2=9;$f2>=0;$f2--){  
	        	$f = ($f1 * 10) + $f2 ;
	      		$texto = "" ;
	      		for($i=1;$i<6;$i++){ 
	        		$texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
	      		}
	      		$barcodes[$f] = $texto;
	    	}
	  	}
	  	
	  	$code .= "<img src='images/boleto/p.png' width='".$fino."' height='".$altura."' border='0' />";
	  	$code .= "<img src='images/boleto/b.png' width='".$fino."' height='".$altura."' border='0' />";
	  	$code .= "<img src='images/boleto/p.png' width='".$fino."' height='".$altura."' border='0' />";
	  	$code .= "<img src='images/boleto/b.png' width='".$fino."' height='".$altura."' border='0' />";
		$texto = $valor ;
		if((strlen($texto) % 2) <> 0){
			$texto = "0" . $texto;
		}
		while (strlen($texto) > 0) {
	 		$i = round($this->esquerda($texto,2));
	  		$texto = $this->direita($texto,strlen($texto)-2);
	  		$f = $barcodes[$i];
	  		for($i=1;$i<11;$i+=2){
	    		if (substr($f,($i-1),1) == "0") {
	      			$f1 = $fino ;
	    		}else{
	      			$f1 = $largo ;
	    		}
				$code .= "<img src='images/boleto/p.png' width='".$f1."' height='".$altura."' border='0' />";
	    		if (substr($f,$i,1) == "0") {
	      			$f2 = $fino ;
	    		}else{
	      			$f2 = $largo ;
	    		}
	    		$code .= "<img src='images/boleto/b.png' width='".$f2."' height='".$altura."' border='0' />"; 
	  		}
		}
		$code .= "<img src='images/boleto/p.png' width='".$largo."' height='".$altura."' border='0' />";
		$code .= "<img src='images/boleto/b.png' width='".$fino."' height='".$altura."' border='0' />";
		$code .= "<img src='images/boleto/p.png' width='1' height='".$altura."' border='0' />";
		return $code;
	}

	public function esquerda($entra,$comp){
		return substr($entra,0,$comp);
	}

	public function direita($entra,$comp){
		return substr($entra,strlen($entra)-$comp,$comp);
	}
	public function fator_vencimento($data) {
		$data = explode("/",$data);
		$ano = $data[2];
		$mes = $data[1];
		$dia = $data[0];
	    return(abs(($this->_dateToDays("1997","10","07")) - ($this->_dateToDays($ano, $mes, $dia))));
	}

	public function _dateToDays($year,$month,$day) {
	    $century = substr($year, 0, 2);
	    $year = substr($year, 2, 2);
	    if ($month > 2) {
	        $month -= 3;
	    } else {
	        $month += 9;
	        if ($year) {
	            $year--;
	        } else {
	            $year = 99;
	            $century --;
	        }
	    }
	    return ( floor((  146097 * $century)    /  4 ) +
	            floor(( 1461 * $year)        /  4 ) +
	            floor(( 153 * $month +  2) /  5 ) +
	            $day +  1721119);
	}

	public function modulo_10($num) { 
		$numtotal10 = 0;
        $fator = 2;
        for ($i = strlen($num); $i > 0; $i--) {
            $numeros[$i] = substr($num,$i-1,1);
            $temp = $numeros[$i] * $fator; 
            $temp0=0;
            foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
            $parcial10[$i] = $temp0; 
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2;
            }
        }
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }
        return $digito;	
	}

	public function modulo_11($num, $base=9, $r=0)  {
	    $soma = 0;
	    $fator = 2;
	    for ($i = strlen($num); $i > 0; $i--) {
	        $numeros[$i] = substr($num,$i-1,1);
	        $parcial[$i] = $numeros[$i] * $fator;
	        $soma += $parcial[$i];
	        if ($fator == $base) { 
	            $fator = 1;
	        }
	        $fator++;
	    }
	    if ($r == 0) {
	        $soma *= 10;
	        $digito = $soma % 11;
	        if ($digito == 10) {
	            $digito = 0;
	        }
	        return $digito;
	    } elseif ($r == 1){
	        $resto = $soma % 11;
	        return $resto;
	    }
	}

	public function modulo_11_invertido($num) { 
	   $ftini = 2;
	   $fator = $ftfim = 9;
	   $soma = 0;
		
	   for ($i = strlen($num); $i > 0; $i--) 
	   {
	      $soma += substr($num,$i-1,1) * $fator;
		  if(--$fator < $ftini) 
		     $fator = $ftfim;
	    }
		
	    $digito = $soma % 11;
		
		if($digito > 9) 
		   $digito = 0;
		
		return $digito;
	}

	public function geraCodigoBanco($numero) {
	    $parte1 = substr($numero, 0, 3);
	    $parte2 = $this->modulo_11($parte1);
	    return $parte1 . "-" . $parte2;
	}
	function dataJuliano($data) {
		$dia = (int)substr($data,1,2);
		$mes = (int)substr($data,3,2);
		$ano = (int)substr($data,6,4);
		$dataf = strtotime("$ano/$mes/$dia");
		$datai = strtotime(($ano-1).'/12/31');
		$dias  = (int)(($dataf - $datai)/(60*60*24));
	  return str_pad($dias,3,'0',STR_PAD_LEFT).substr($data,9,4);
	}

	function digitoVerificador_nossonumero($numero) {
		$resto2 = $this->modulo_11($numero, 9, 1);
	     $digito = 11 - $resto2;
	     if ($digito == 10 || $digito == 11) {
	        $dv = 0;
	     } else {
	        $dv = $digito;
	     }
		 return $dv;
	}


	function digitoVerificador_barra($numero) {
		$resto2 = $this->modulo_11($numero, 9, 1);
	     if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
	        $dv = 1;
	     } else {
		 	$dv = 11 - $resto2;
	     }
		 return $dv;
	}
}
