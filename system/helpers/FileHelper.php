<?php

/**
* 
*/
class FileHelper
{
	private $_pasta;
	

	/*
	 * Metodo construtor
	 * @param $pasta = Nome da pasta para upload
	 * @param $altura_padrao = Definir uma altura padrão para os arquivos
	 */
	function __construct($pasta = FILES)
	{

		$this->_pasta 			=  $pasta;

		//VERIFICA SE A PASTA JÁ EXISTE, SE NÃO EXISTIR, ELA SERÁ CRIADA
		if (!is_dir($this->_pasta)) 
			@mkdir( $this->_pasta );
	}



	//GETTER AND SETTER
	public function __set($atrib, $value){  $this->$atrib = $value; }
	public function __get($atrib){  return $value; }

	public function DeleteFile($path){
		unlink($path);
	}
	

	public function UploadFile($file, $rename = true){
		$arquivo = $file;
		$_UP['pasta'] = $this->_pasta;
		$_UP['tamanho'] = 1024 * 1024 * 5; // 2Mb
		$_UP['extensoes'] = array('pdf','doc', 'docx', 'txt');

		// Array com os tipos de erros de upload do PHP 
		$_UP['erros'][0] = 'Não houve erro'; 
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP'; 
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML'; 
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente'; 
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro 
		if ($file['error'] != 0) { 
			die( "Não foi possível fazer o upload, erro:<br />" . $_UP[ 'erros' ][ $file['error'] ] ); 
			exit;
		}

		$arquivo = $file['name'];
		$extensao = substr($arquivo,-3);

		if (array_search($extensao, $_UP['extensoes']) === false) { 
			echo "Por favor, envie arquivos com as seguintes extensões: docx, doc, pdf ou txt."; 
		}

		else if ($_UP['tamanho'] < $file['size']) { 
			echo "O arquivo enviado é muito grande, envie arquivos de até 5Mb."; 
		}

		else { 
			if ($rename == true) { 
				$nome_final = $this->Rename($arquivo);
			} else { 
				$nome_final = $arquivo;
			}

			//echo $_UP['pasta'] . $nome_final;

			if (move_uploaded_file($file['tmp_name'], $_UP['pasta'] . $nome_final)) {
				// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo 
				// echo "Seu arquivo foi inserido com sucesso!";
				return $nome_final;
			} else { 
			// Não foi possível fazer o upload. Algum problema com a pasta 
				echo utf8_encode('Não foi possível enviar este arquivo, tente novamente'); 
			} 
		}
	}



	/*
	 * Metodo Rename
	 * Remove acentos, espaços e caracteres especiais e cria um nome aleatório.
	 * @param $string = string a ser limpa
	 */
	public function Rename( $string ) 
	{
		// Converte todos os caracteres para minusculo
		$string = strtolower($string);

		// Remove os acentos
		$string = preg_replace('[á|à|ã|â|ä|Á|À|Ã|Â|Ä]', 'a', $string);
		$string = preg_replace('[é|è|ê|ë|É|È|Ê|Ë]',		'e', $string);
		$string = preg_replace('[í|ì|î|ï|Í|Ì|Î|Ï]', 	'i', $string);
		$string = preg_replace('[ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö]', 'o', $string);
		$string = preg_replace('[ú|ù|û|ü|Ú|Ù|Û|Ü]', 	'u', $string);
		
		// Remove o cedilha e o ñ
		$string = preg_replace('[ç]', 'c', $string);
		$string = preg_replace('[ñ]', 'n', $string);
		
		// Substitui os espaços em brancos por underline
		$string = preg_replace('[ ]', '', $string);
		$string = preg_replace('[%|#|&]', '', $string);
		
		// Remove hifens duplos
		$string = preg_replace('[--]', '', $string);
		
		return md5(uniqid(time())).$string;	
	}
}