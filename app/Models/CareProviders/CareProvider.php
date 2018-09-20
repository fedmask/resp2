<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CareProvider
 *
 * @property int $id_cpp
 * @property int $id_cpp_tipologia
 * @property int $id_utente
 * @property string $cpp_nome
 * @property string $cpp_cognome
 * @property \Carbon\Carbon $cpp_nascita_data
 * @property string $cpp_codfiscale
 * @property string $cpp_sesso
 * @property string $cpp_n_iscrizione
 * @property string $cpp_localita_iscrizione
 *
 * @property \App\Models\Utenti $tbl_utenti
 * @property \App\Models\CppTipologie $tbl_cpp_tipologie
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class CareProvider extends Eloquent {
	protected $table = 'tbl_care_provider';
	protected $primaryKey = 'id_cpp';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_cpp' => 'int',
			'id_cpp_tipologia' => 'int',
			'id_utente' => 'int',
	        'active' => 'bool'
	];
	
	protected $dates = [
	    'cpp_nascita_data'
	];
	
	protected $fillable = [
	    'id_utente',
	    'cpp_nome',
	    'cpp_cognome',
	    'cpp_nascita_data',
	    'cpp_codfiscale',
	    'cpp_sesso',
	    'cpp_n_iscrizione',
	    'cpp_localita_iscrizione',
	    'specializzation',
	    'cpp_lingua',
	    'active'
	];
	
	public function tbl_utenti()
	{
	    return $this->belongsTo(\App\Models\TblUtenti::class, 'id_utente');
	}
	
	public function language()
	{
	    return $this->belongsTo(\App\Models\Language::class, 'cpp_lingua');
	}
	
	public function gender()
	{
	    return $this->belongsTo(\App\Models\Gender::class, 'cpp_sesso');
	}
	
	public function allergy_intollerances()
	{
	    return $this->hasMany(\App\Models\AllergyIntollerance::class, 'recorder');
	}
	
	public function consenso_c_p()
	{
	    return $this->hasOne(\App\Models\ConsensoCP::class, 'Id_Cpp');
	}
	
	public function cpp_qualification()
	{
	    return $this->hasOne(\App\Models\CppQualification::class, 'id_cpp');
	}
	
	public function dispositivo_impiantabiles()
	{
	    return $this->hasMany(\App\Models\DispositivoImpiantabile::class, 'id_cpp');
	}
	
	public function visita_c_p()
	{
	    return $this->hasOne(\App\Models\VisitaCP::class, 'id_cpp');
	}
	
	public function tbl_cpp_paziente()
	{
	    return $this->hasOne(\App\Models\TblCppPaziente::class, 'id_cpp');
	}
	
	public function tbl_cpp_specializations()
	{
	    return $this->hasMany(\App\Models\TblCppSpecialization::class, 'id_cpp');
	}
	
	public function tbl_indaginis()
	{
	    return $this->hasMany(\App\Models\TblIndagini::class, 'id_cpp');
	}
	
	public function tbl_pazienti_visites()
	{
	    return $this->hasMany(\App\Models\TblPazientiVisite::class, 'id_cpp');
	}
	
	public function tbl_proc_terapeutiches()
	{
	    return $this->hasMany(\App\Models\TblProcTerapeutiche::class, 'CareProvider');
	}
	
	public function tbl_vaccinaziones()
	{
	    return $this->hasMany(\App\Models\TblVaccinazione::class, 'id_cpp');
	}
	
	
	public function users() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function careprovider_types() {
		return $this->belongsTo ( \App\Models\CareProvider\CppTipologie::class, 'id_cpp_tipologia' );
	}
	public function carprovider_diagnosis() {
		return $this->hasMany ( \App\Models\CareProvider\CppDiagnosi::class, 'id_cpp' );
	}
	public function careprovider_patients() {
		return $this->hasMany ( \App\Models\CareProvider\CppPaziente::class, 'id_cpp' );
	}
	public function patient_visits() {
		return $this->hasMany ( \App\Models\Patient\PazientiVisite::class, 'id_cpp' );
	}
	public function vaccines() {
		return $this->hasMany ( \App\Models\Vaccine\Vaccinazione::class, 'id_cpp' );
	}
	public function contacts() {
		return $this->hasMany ( \App\Models\CurrentUser\Recapiti::class, 'id_utente' );
	}
	public function getID() {
		return $this->id_cpp;
	}
	public function getId_cpp_tipologia() {
		return $this->id_cpp_tipologia;
	}
	public function getCpp_nome() {
		return $this->cpp_nome;
	}
	public function getCpp_cognome() {
		return $this->cpp_cognome;
	}
	public function getSpecializzation() {
		return $this->specializzation;
	}
	public function getCpp_type() {
		return $this->careprovider_types ()->first ();
	}
	public function getCpp_FullName() {
		return getCpp_nome () . " " . getCpp_cognome ();
	}
	public function getCpp_nascita_data() {
		return $this->cpp_nascita_data;
	}
	public function getCpp_codfiscale() {
		return $this->cpp_codfiscale;
	}
	public function getCpp_sesso() {
		return $this->cpp_sesso;
	}
	public function getCpp_n_iscrizione() {
		return $this->cpp_n_iscrizione;
	}
	public function getCpp_localita_iscrizione() {
		return $this->cpp_localita_iscrizione;
	}
	public function getUser() {
		return $this->id_utente;
	}

	public function getSpecializationDesc() {
	    return $this->Specialization_Cpp()->first()->getSpecializzation();
	}
	public function setID($ID) {
		$this->id_cpp = $ID;
	}
	public function setCpp_nome($Nome) {
		$this->cpp_nome = $Nome;
	}
	public function setCpp_cognome($Cognome) {
		$this->cpp_cognome = $Cognome;
	}
	public function setCpp_nascita_data($DataN) {
		$this->cpp_nascita_data = $DataN;
	}
	public function setCpp_codfiscale($CF) {
		if (CareProvider::checkCF ( $CF )) {
			$this->cpp_codfiscale = $CF;
		}
	}
	public function setCpp_sesso($Sesso) {
		$this->cpp_sesso = $Sesso;
	}
	public function setCpp_n_iscrizione($N_Iscrizione) {
		$this->cpp_n_iscrizione = $N_Iscrizione;
	}
	public function setCpp_localita_iscrizione($Località) {
		$this->cpp_localita_iscrizione = $Località;
	}
	public function setSpecializzation($Special) {
		$this->specializzation = $Special;
	}
	
	
	public static function checkCF($CF) {
		if ($length ( CF ) == 16) {
			return true;
		}
	}
	public function tbl_proc_ter() {
		return $this->hasMany ( \App\Models\ProcedureTerapeutiche::class, 'id_Procedure_Terapeutiche' );
	}
	
	public function Specialization_Cpp(){
	    return $this->hasMany(\App\Models\CppSpecialization::class, 'id_cpp');
	}
	
	public function VaccinazioneCpp(){
		return $this->hasMany(\App\Models\Vaccinazione::class, 'id_cpp');
	}
	
	
}

