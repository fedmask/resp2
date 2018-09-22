<?php

namespace App\Models\CodificheFHIR;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    protected $table = 'MaritalStatus';
    protected $primaryKey = 'code';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'text'
    ];
    
    public function getCode() {
        return $this->code;
    }
    
    public function getDisplay() {
        return $this->text;
    }
}
