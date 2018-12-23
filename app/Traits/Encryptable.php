<?php

namespace App\Traits;

trait Encryptable 
{
	
	/**
	 * This method get the $key attribute from the current Model istance
	 * 
	 * @param unknown $key        	
	 * @return unknown
	 */
	public function getAttribute($key) {
		// Ottengo l'istanza dell'attributo dal metodo erediato dalla classe Model
		$value = parent::getAttribute ( $key );
		try {
			
			// Controllo che l'array encryptable esista, che contenga l'attributo passato al metodo e che non sia un null object
			if (isset ( $this->encryptable ) && in_array ( $key, $this->encryptable ) && (! is_null ( $value ))) {
				
				// Effettuo la crittografia e la serializzazione per poter crittografare anche oggetti non string type
				$value = unserialize ( \Crypt::decrypt ( $value ) );
			}
		} catch ( \Exception $e ) {
			return $value;
		}
		
		return $value;
	}
	
	/**
	 * This method set the $key attribute from the current Model istance
	 * 
	 * @param unknown $key        	
	 * @param unknown $value        	
	 * @return unknown
	 */
	public function setAttribute($key, $value) {
		// Controllo che l'array encryptable esista, che contenga l'attributo passato al metodo e che non sia un null object
		if (isset ( $this->encryptable ) && in_array ( $key, $this->encryptable ) && (! is_null ( $value ))) {
			
			// Serializzo ed effettuo la crittografia del valore passato
			$value = \Crypt::encrypt ( serialize ( $value ) );
		}
		
		// ritrovo il valore crttografato o meno al metodo della classe Model
		return parent::setAttribute ( $key, $value );
	}
	
	/**
	 * This method update the $key attribute
	 * 
	 * @param unknown $key        	
	 * @param unknown $value        	
	 * @return unknown
	 */
	public function updateKey($encryptionKey) {
		
		// Ottengo l'istanza della chiave
		$encrypter = new \Illuminate\Encryption\Encrypter ( $encryptionKey, Config::get ( 'app.cipher' ) );
		
		// Imposto la chiave
		if (isset ( $this->encryptable )) {
			foreach ( $this->encryptable as $key ) {
				$value = $this->getAttribute ( $key );
				if ($value != null) {
					$encryptedValue = $newEncrypter->encrypt ( $value );
					parent::setAttribute ( $key, $encryptedValue );
				}
			}
		}
	}
}
	
	
	
	

