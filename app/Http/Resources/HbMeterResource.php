<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class HbMeterResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id hbmeter' => $this->id_hbmeter,
            'id utente' => $this->id_utente,
            'Analisi giorno' => $this->analisi_giorno,
            'Analisi valore' => $this->analisi_valore,
            'Analisi laboratorio' => $this->analisi_laboratorio,
            'Immagine palpebra' => $this->img_palpebra
        ];
    }
}
