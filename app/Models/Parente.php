<?php

namespace App\Models;

use App\Models\Patient\PazientiFamiliarita;
use Illuminate\Database\Eloquent\Model;
use App\Models\CodificheFHIR\RelationshipType;

class Parente extends Model {
	//
	protected $table = 'tbl_Parente';
	protected $primaryKey = 'id_parente';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_parente' => 'int',
			'eta' => 'int',
			'eta_decesso' => 'int',
	        'decesso' => 'bool'
	
	];
	protected $dates = [ 
			'data_nascita',
			'data_decesso' 
	
	];
	protected $fillable = [ 
			'descrizione',
			'nome',
			'cognome',
			'sesso',
	        'decesso',
	        'telefono',
	        'mail'
	
	];
	
	// Get methods for Controllers
/*	public function getID() {
		return $this->id_Parente;
	}
	public function getCF() {
		return $this->codice_fiscale;
	}
	public function getNome() {
		return $this->nome;
	}
	public function getCognome() {
		return $this->cognome;
	}
	public function getSesso() {
		return $this->sesso;
	}
	public function getDataN() {
		return $this->data_nascita;
	}
	public function getEta() {
		return $this->età;
	}
	public function getDecesso() {
		return $this->decesso;
	}
	public function getEDecesso() {
		return $this->età_decesso;
	}
	public function getDataDecesso() {
		return $this->data_decesso;
	}
	*/
	// Set Methods
	
	public function setCF($CF) {
		$this->codice_fiscale = $CF;
	}
	public function setNome($Nome) {
		$this->nome = $Nome;
	}
	public function setCognome($Cognome) {
		$this->cognome = $Cognome;
	}
	public function setSesso($Sesso) {
		$this->sesso = $Sesso;
	}
	public function setDataN($DataN) {
		$this->data_nascita = $DataN;
	}
	public function setEta($Eta) {
		$this->età = $Eta;
	}
	public function setDecesso($Decesso) {
		$this->decesso = $Decesso;
	}
	public function setEDecesso($ED) {
		$this->età_decesso = $ED;
	}
	public function setDataDecesso($DD) {
		$this->data_decesso = $DD;
	}
	
	public function tbl_Parente()
	{
		return $this->hasMany(\App\Models\AnamnesiF::class, 'id_parente');
	}
	
	public function	FamilyCondition()
	{
		return $this->hasOne(\App\Models\History\FamilyCondiction::class, 'id_parente');
	}
	
	//FHIR
	
	public function getId()
	{
	    return $this->id_parente;
	}
	
	public function isActive()
	{
	    $active = "false";
	    if ($this->decesso == 1) {
	        $active = "true";
	    }
	    
	    return $active;
	}
	
	public function getIdPaziente()
	{
	    $paz = PazientiFamiliarita::where('id_parente', $this->getId())->first();
	    return $paz->id_paziente;
	}
	
	public function getRelazione()
	{
	    $paz = PazientiFamiliarita::where('id_parente', $this->getId())->first();
	    return $paz->getRelazione();
	}
	
	public function getRelazioneCode(){
	    $paz = PazientiFamiliarita::where('id_parente', $this->getId())->first();
	    $rel = RelationshipType::where('Code', $paz->relazione)->first();
	    return $rel->Code;
	}
	
	public function getNome()
	{
	    return $this->nome;
	}
	
	public function getCognome()
	{
	    return $this->cognome;
	}
	
	public function getFullName()
	{
	    return $this->getNome()."-".$this->getCognome();
	}
	
	public function getFullName1()
	{
	    return $this->getNome()." ".$this->getCognome();
	}
	
	public function getMail()
	{
	    return $this->mail;
	}
	
	public function getTelefono()
	{
	    return $this->telefono;
	}
	
	public function getTelecom()
	{
	    return $this->getTelefono()."-".$this->getMail();
	}
	
	public function getSesso()
	{
	    return $this->sesso;
	}
	
	public function getDataNascita(){
	    $data = date_format($this->data_nascita,"Y-m-d");
	    return $data;
	}
	
	public function isDecesso() {
	    $ret = "false";
	    if($this->decesso){
	        $ret = "true";
	    }
	    return $ret;
	}
}
