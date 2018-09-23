<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Patient;

use App\Models\Patient\PazientiDescessi;
use App\Models\CodificheFHIR\MaritalStatus;
use App\Models\FHIR\PatientContact;
use App\Models\CodificheFHIR\Language;


use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pazienti
 *
 * @property int $id_paziente
 * @property int $id_utente
 * @property int $id_stato_matrimoniale
 * @property string $paziente_nome
 * @property string $paziente_cognome
 * @property \Carbon\Carbon $paziente_nascita
 * @property string $paziente_codfiscale
 * @property string $paziente_sesso
 * @property bool $paziente_gruppo
 * @property string $pazinte_rh
 * @property bool $paziente_donatore_organi
 *
 * @property \App\Models\Utenti $tbl_utenti
 * @property \Illuminate\Database\Eloquent\Collection $tbl_contatti_pazientis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosi_eliminates
 * @property \Illuminate\Database\Eloquent\Collection $tbl_effetti_collateralis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_esami_obiettivis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmaci_vietatis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_files
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_parametri_vitalis
 * @property \App\Models\PazientiDecessi $tbl_pazienti_decessi
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_familiarita
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_taccuinos
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class Pazienti extends Eloquent {
	protected $table = 'tbl_pazienti';
	protected $primaryKey = 'id_paziente';
	public $timestamps = false;
	protected $casts = [ 
			'id_utente' => 'int',
			'paziente_donatore_organi' => 'bool',
	        'id_paziente' => 'int',
	];
	protected $dates = [ 
			'paziente_nascita' 
	];
	protected $fillable = [ 
	        'id_paziente',
			'id_utente',
			'id_stato_matrimoniale',
			'paziente_nome',
			'paziente_cognome',
			'paziente_nascita',
			'paziente_codfiscale',
			'paziente_sesso',
			'paziente_gruppo',
			'pazinte_rh',
			'paziente_donatore_organi',
	        'paziente_lingua'
	];
	
	
	/**
	 * FHIR FUNCTIONS *
	 */
	
	/**
	 * Restituisce l'id del paziente loggato
	 */
	public function getID_Paziente()
	{
	    return $this->id_paziente;
	}
	
	/**
	 * Restituisce "false" se il paziente non è decesso, true altrimenti
	 */
	public function getDeceased()
	{
	    $deceased = "false";
	    $pazDec = PazientiDecessi::all();
	    
	    foreach($pazDec as $pc){
	        if($pc->id_paziente == $this->id_paziente){
	            $deceased = "true";
	        }
	    }
	  
	    return $deceased;
	}
	
	/**
	 * Restituisce "true" se non è decesso ed attivo, "false" altrimenti
	 */
	public function isActive()
	{
	    $active = "true";
	    $pazDec = PazientiDecessi::all();
	    
	    foreach($pazDec as $pc){
	        if($pc->id_paziente == $this->id_paziente){
	            $active = "false";
	        }
	    }
	    
	    return $active;
	}
	
	/**
	 * Restituisce il nome del paziente loggato
	 */
	public function getName()
	{
	    return $this->paziente_nome;
	}
	
	/**
	 * Restituisce il cognome del paziente loggato
	 */
	public function getSurname()
	{
	    return $this->paziente_cognome;
	}
	
	/**
	 * Restituisce nome e cognome del paziente logggato
	 */
	public function getFullName()
	{
	    return $this->getName() . " " . $this->getSurname();
	}
	
	/**
	 * Restituisce la mail del paziente loggato
	 */
	public function getMail(){
	    return $this->user ()->first ()->utente_email;
	}
	
	/**
	 * Restituisce il numero di telefono del paziente loggato
	 */
	public function getPhone(){
	    return $this->user ()->first ()->contacts ()->first ()->contatto_telefono;
	}
	
	/**
	 * Restituisce la mail e il numero di telefono del paziente loggato
	 */
	public function getTelecom() {
	    return $this->getPhone()." - ".$this->getMail();
	}
	
	/**
	 * Restituisce il sesso del paziente loggato secondo la codfica del FHIR
	 */
	public function getGender()
	{
	    return $this->paziente_sesso;
	}
	
	/**
	 * Restituisce la data di nascita del paziente loggato nel formato gg/mm/aaaa
	 */
	public function getBirth()
	{
	    $data = date_format($this->paziente_nascita,"Y-m-d");
	    return $data;
	}
	
	/**
	 * Restituisce la via dell'indirizzo del paziente loggato
	 */
	public function getLine() {
	    return $this->user ()->first ()->getAddress ();
	}
	
	/**
	 * Restituisce la città dell'indirizzo del paziente loggato
	 */
	public function getCity() {
	    return $this->user ()->first ()->getLivingTown ();
	}
	
	/**
	 * Restituisce il codice postale dell'indirizzo del paziente loggato
	 */
	public function getPostalCode() {
	    return $this->user ()->first ()->getCapLivingTown ();
	}
	
	/**
	 * Restituisce la nazione dell'indirizzo del paziente loggato
	 */
	public function getCountryName() {
	    return $this->user ()->first ()->contacts ()->first ()->town ()->first ()->tbl_nazioni ()->first ()->getCountryName ();
	}
	
	/**
	 * Restituisce tutte le informazioni dell'indirizzo del paziente loggato
	 */
	public function getAddress()
	{
	    return $this->getLine()." ".$this->getCity()." ".$this->getCountryName()." ".$this->getPostalCode();
	}
	
	/**
	 * Restituisce la codifica FHIR dello stato matrimoniale del paziente loggato
	 */
	public function getMaritalStatusCode()
	{
	    return $this->id_stato_matrimoniale;
	}
	
	/**
	 * Restituisce la descrizione della codifica FHIR dello stato matrimoniale del paziente loggato
	 */
	public function getMaritalStatusDisplay()
	{
	    $marital_status_display = MaritalStatus::where('code', $this->getMaritalStatusCode())->first();
	    
	    return $marital_status_display['Text'];
	}
	
	/**
	 * Restituisce i contatti associati al paziente loggato
	 */
	public function getContact()
	{
	    $patient_contact = PatientContact::where('id_patient', $this->getID_Paziente())->get();
	    return $patient_contact;
	}
	
	/**
	 * Restituisce le lingue del paziente loggato
	 */
	public function getLanguage()
	{
	    $language = Language::where('Code', $this->paziente_lingua)->first()->Display;
	    
	    return $language;
	}
	
	/**
	 * Restituisce true se il paziente loggato ha accettato il consenso per la donazione
	 * degli organi, false altrimenti
	 */
	public function isDonatoreOrgani(){
	    $res = "false";
	    if($this->paziente_donatore_organi == '1'){
	        $res ="true";
	    }
	    return $res;
	}
	
	/**
	 * END FHIR *
	 */
	
	
	
	
	
	
	
	
	public function tbl_utenti()
	{
	    return $this->belongsTo(\App\Models\TblUtenti::class, 'id_utente');
	}
	
	public function tbl_stati_matrimoniali()
	{
	    return $this->belongsTo(\App\Models\TblStatiMatrimoniali::class, 'id_stato_matrimoniale', 'id_stato_matrimoniale');
	}
	
	public function gender()
	{
	    return $this->belongsTo(\App\Models\Gender::class, 'paziente_sesso');
	}
	
	public function language()
	{
	    return $this->belongsTo(\App\Models\Language::class, 'paziente_lingua');
	}
	
	public function allergy_intollerances()
	{
	    return $this->hasMany(\App\Models\AllergyIntollerance::class, 'recorder');
	}
	
	public function consenso_paziente()
	{
	    return $this->hasOne(\App\Models\ConsensoPaziente::class, 'Id_Paziente');
	}
	
	public function dispositivo_impiantabiles()
	{
	    return $this->hasMany(\App\Models\DispositivoImpiantabile::class, 'id_paziente');
	}
	
	public function moduli__gruppo__sanguignos()
	{
	    return $this->hasMany(\App\Models\ModuliGruppoSanguigno::class, 'Id_Paziente');
	}
	
	public function patient_contact()
	{
	    return $this->hasOne(\App\Models\PatientContact::class, 'Id_Patient');
	}
	
	public function farmaci_assunti()
	{
	    return $this->hasOne(\App\Models\FarmaciAssunti::class, 'id_paziente');
	}
	
	public function tbl_anamnesi_familiare()
	{
	    return $this->hasOne(\App\Models\TblAnamnesiFamiliare::class, 'id_paziente');
	}
	
	public function tbl_cpp_pazientes()
	{
	    return $this->hasMany(\App\Models\TblCppPaziente::class, 'id_paziente');
	}
	
	public function tbl_diagnosis()
	{
	    return $this->hasMany(\App\Models\TblDiagnosi::class, 'id_paziente');
	}
	
	public function tbl_diagnosi_eliminates()
	{
	    return $this->hasMany(\App\Models\TblDiagnosiEliminate::class, 'id_utente');
	}
	
	public function tbl_effetti_collateralis()
	{
	    return $this->hasMany(\App\Models\TblEffettiCollaterali::class, 'id_paziente');
	}
		
	
	public function tbl_pazienti_contattis()
	{
	    return $this->hasMany(\App\Models\TblPazientiContatti::class, 'id_paziente');
	}
	
	
	public function tbl_proc_terapeutiches()
	{
	    return $this->hasMany(\App\Models\TblProcTerapeutiche::class, 'Paziente');
	}
	
	
	
	
	
	/**
	 * Costanti per i gruppi sanguigni e fattori RH
	 */
	const BLOODGROUP_0 = 0;
	const BLOODGROUP_A = 1;
	const BLOODGROUP_B = 2;
	const BLOODGROUP_AB = 3;
	const BLOODRH_POS = "POS";
	const BLOODRH_NEG = "NEG";
	
	
	public function user() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function statusWedding() {
		return $this->belongsTo ( \App\Models\Patient\StatiMatrimoniali::class, 'id_stato_matrimoniale' );
	}
	public function patient_contacts() {
		return $this->hasMany ( \App\Models\Patient\PazientiContatti::class, 'id_paziente' );
	}
	public function cpp_patients() {
		return $this->hasMany ( \App\Models\CareProvider\CppPaziente::class, 'id_paziente' );
	}
	public function diagnosis() {
		return $this->hasMany ( \App\Models\Diagnosis\Diagnosi::class, 'id_paziente' );
	}
	public function erased_diagnosis() {
		return $this->hasMany ( \App\Models\Diagnosis\DiagnosiEliminate::class, 'id_utente' );
	}
	public function collateral_effects() {
		return $this->hasMany ( \App\Models\EffettiCollaterali::class, 'id_paziente' );
	}
	public function tbl_esami_obiettivis() {
		return $this->hasMany ( \App\Models\EsamiObiettivi::class, 'id_paziente' );
	}
	public function tbl_farmaci_vietatis() {
		return $this->hasMany ( \App\Models\Drugs\FarmaciVietati::class, 'id_paziente' );
	}
	public function tbl_files() {
		return $this->hasMany ( \App\Models\File::class, 'id_paziente' );
	}
	public function tbl_indaginis() {
		return $this->hasMany ( \App\Models\InvestigationCenter\Indagini::class, 'id_paziente' );
	}
	public function tbl_parametri_vitalis() {
		return $this->hasMany ( \App\Models\Patient\ParametriVitali::class, 'id_paziente' );
	}
	public function tbl_pazienti_decessi() {
		return $this->hasOne ( \App\Models\Patient\PazientiDecessi::class, 'id_paziente' );
	}
	public function tbl_pazienti_familiarita() {
		return $this->hasMany ( \App\Models\Patient\PazientiFamiliarita::class, 'id_paziente' );
	}
	public function tbl_pazienti_visites() {
		return $this->hasMany ( \App\Models\Patient\PazientiVisite::class, 'id_paziente' );
	}
	public function tbl_taccuinos() {
		return $this->hasMany ( \App\Models\Patient\Taccuino::class, 'id_paziente' );
	}
	public function tbl_vaccinaziones() {
		return $this->hasMany ( \App\Models\Vaccine\Vaccinazione::class, 'id_paziente' );
	}
	
	public function tbl_proc_ter()
	{
	    return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'id_Procedure_Terapeutiche');
	}
	
}
