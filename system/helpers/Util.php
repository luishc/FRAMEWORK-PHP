<?php
/**
 * Classe estática com métodos Utilitários
 * @author Luis Henrique Carvalho Nascimento
 * @version 1.0.0
 */
class Util
{
	/**
	 * [debug description]
	 * @access public
	 * @param  [type]  $var [description]
	 * @param  boolean $pre [description]
	 * @return [type]       [description]
	 */
	public static function debug( $var, $pre = true )
	{
		if( $pre )
			print "<pre>" . print_r( $var, true ) . "</pre>" ;
		
		else
			print_r( $var ) ;
	}

	/**
	 * Retorna a extensão de $filename
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	public static function ext( $filename )
	{ 
		$filename = strtolower( $filename) ;
		$exts = explode( ".", $filename ) ;
		$n = count( $exts ) - 1 ;
		$exts = $exts[$n] ;

		return $exts ;
	} 

	/**
	 * Transforma um str em parâmetro de url amigável
	 * @param  String $str Str de entrada
	 * @return String      Str pronta para url
	 */
	public static function strToUrl( $str )
	{
	    $str = strtolower(utf8_decode($str)); $i=1;
	    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
	    $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
	    while($i>0) $str = str_replace('--','-',$str,$i);
	    if (substr($str, -1) == '-') $str = substr($str, 0, -1);
	    return $str;
	}

	/**
	 * Converte uma array k[v] para um parametro array padrão de url
	 * @param  array $data 	Array em questão
	 * @return String      	Parametro para a url
	 */
	public static function arrayToUrl( $data )
	{
		$ret = '' ;

		if( is_array( $data ) )
		{
			$tmp = array() ;

			foreach( $data as $k => $v )
			{
				$tmp[] = "{$k}={$v}" ;
			}

			$ret = base64_encode( implode( '&', $tmp ) ) ;
		}

		return $ret ;
	}

	/**
	 * Converte um parametro array padrão de url para array k[v]
	 * @param String $data      Parametro para a url
	 * @return array 			Array em questão
	 */
	public static function urlToArray( $data )
	{
		$ret = array() ;

		if( ! empty( $data ) )
		{
			$tmp = array() ;
			$data = explode( '&', base64_decode( $data ) ) ;
			
			foreach( $data as $item )
			{
				list( $k, $v ) = explode( '=' , $item ) ;
				$tmp[$k] = $v ;
			}
			
			$ret = $tmp ;
		}

		return $ret ;
	}
}
?>