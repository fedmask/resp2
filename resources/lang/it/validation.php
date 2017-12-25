<?php

return array(
 
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
 
    "accepted"             => "Devi accettare :attribute.",
    "active_url"           => ":attribute non è un URL valido.",
    "after"                => ":attribute deve contenere una data successiva a :date.",
    "alpha"                => ":attribute può contenere solo lettere.",
    "alpha_dash"           => ":attribute può contenere solo lettere, numeri, e trattini.",
    "alpha_num"            => ":attribute può contenere solo numeri e lettere.",
    "array"                => ":attribute deve essere un array.",
    "before"               => ":attribute deve essere una data precedente a :date.",
    "between"              => array(
        "numeric" => ":attribute deve essere un numero compreso tra :min e :max.",
        "file"    => "Il file :attribute deve essre tra :min e :max kilobytes.",
        "string"  => ":attribute deve essere compreso tra :min e :max caratteri.",
        "array"   => ":attribute può contenere un numero di oggetti compreso tra :min e :max.",
    ),
    "confirmed"            => "Il campo :attribute di conferma non corrisponde.",
    "date"                 => "Il campo :attribute non contiene una data valida.",
    "date_format"          => "Il campo :attribute non rispetta il formato :format.",
    "different"            => "I campi :attribute e :other non possono coincidere.",
    "digits"               => "Il campo :attribute deve essere composto da :digits cifre.",
    "digits_between"       => "Il campo :attribute deve contenere un numero compreso tra :min e :max cifre.",
    "email"                => "Il campo :attribute deve contenere un'email valida.",
    "exists"               => ":attribute non è un campo valido.",
    "image"                => "il file :attribute deve essere un'immagine .",
    "in"                   => ":attribute non è valido.",
    "integer"              => "Il campo :attribute deve contenere un numero intero.",
    "ip"                   => "Il campo :attribute deve contenere un indirizzo IP valido.",
    "max"                  => array(
        "numeric" => "Il campo :attribute non può avere un numero maggiore di :max.",
        "file"    => "Il file :attribute non può superare i :max kilobytes.",
        "string"  => "Il campo :attribute non può superare i :max caratteri.",
        "array"   => "Il campo :attribute non può avere più di :max oggetti.",
    ),
    "mimes"                => "Il file :attribute deve essere del tipo: :values.",
    "min"                  => array(
        "numeric" => "Il campo :attribute deve essere maggiore o uguale a :min.",
        "file"    => "Il file :attribute deve essere almeno di :min kilobytes.",
        "string"  => "Il campo :attribute deve essere di almeno :min caratteri.",
        "array"   => "Il campo :attribute deve possedere almeno :min oggetti.",
    ),
    "not_in"               => ":attribute non è valido.",
    "numeric"              => ":attribute deve contenere un numero.",
    "regex"                => ":attribute è invalido.",
    "required"             => "Il campo :attribute è obbligatorio.",
    "required_if"          => ":attribute è richiesto quando :other e uguale a :value.",
    "required_with"        => ":attribute è richiesto quando :values è presente.",
    "required_with_all"    => ":attribute e richiesto quando tutti :values sono presenti.",
    "required_without"     => ":attribute è richiesto quando :values non è presente.",
    "required_without_all" => ":attribute è richiesto quando nessundo di :values è presente.",
    "same"                 => "I campi :attribute e :other devono coincidere.",
    "size"                 => array(
        "numeric" => ":attribute deve corrispondere a :size.",
        "file"    => ":attribute deve essere un file di :size kilobytes.",
        "string"  => ":attribute deve contenere :size caratteri.",
        "array"   => ":attribute deve contenere :size oggetti.",
    ),
    "unique"               => ":attribute è già stato usato.",
    "url"                  => ":attribute non è formattato correttamente.",
 
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
 
    'custom' => array(
        'attribute-name' => array(
            'rule-name' => 'custom-message',
        ),
    ),
 
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
 
    'attributes' => array(),
 
);