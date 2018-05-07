<?php

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;

class IndaginiEliminate extends Eloquent
{
        protected $table = 'tbl_indagini_eliminate';
        protected $primaryKey = 'id_indagine_eliminata';
        public $incrementing = false;
        public $timestamps = false;
        
        protected $casts = [
            'id_indagine_eliminata' => 'int',
            'id_utente' => 'int',
            'id_indagine' => 'int'
        ];
        
        protected $fillable = [
            'id_utente',
            'id_indagine'
        ];
        
        public function indagini()
        {
            return $this->belongsTo(\App\Models\InvestigationCenter\Indagini::class, 'id_indagine');
        }
}
