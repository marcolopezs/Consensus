<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL válida.',
    'after'                => ':attribute debe ser una fecha posterior a :date.',
    'alpha'                => ':attribute solo debe contener letras.',
    'alpha_dash'           => ':attribute solo debe contener letras, números y guiones.',
    'alpha_num'            => ':attribute solo debe contener letras y números.',
    'array'                => ':attribute debe ser un conjunto.',
    'before'               => ':attribute debe ser una fecha anterior a :date.',
    'between'              => [
        'numeric' => ':attribute tiene que estar entre :min - :max.',
        'file'    => ':attribute debe pesar entre :min - :max kilobytes.',
        'string'  => ':attribute tiene que tener entre :min - :max caracteres.',
        'array'   => ':attribute tiene que tener entre :min - :max ítems.',
    ],
    'boolean'              => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed'            => 'La confirmación de :attribute no coincide.',
    'date'                 => ':attribute no es una fecha válida.',
    'date_format'          => ':attribute no corresponde al formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe tener :digits dígitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max dígitos.',
    'distinct'             => 'El campo :attribute contiene un valor duplicado.',
    'email'                => ':attribute no es un correo válido',
    'exists'               => ':attribute es inválido.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => ':attribute es inválido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => ':attribute debe ser un número entero.',
    'ip'                   => ':attribute debe ser una dirección IP válida.',
    'json'                 => 'El campo :attribute debe tener una cadena JSON válida.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        'file'    => ':attribute no debe ser mayor que :max kilobytes.',
        'string'  => ':attribute no debe ser mayor que :max caracteres.',
        'array'   => ':attribute no debe tener más de :max elementos.',
    ],
    'mimes'                => ':attribute debe ser un archivo con formato: :values.',
    'min'                  => [
        'numeric' => 'El tamaño de :attribute debe ser de al menos :min.',
        'file'    => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'string'  => ':attribute debe contener al menos :min caracteres.',
        'array'   => ':attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => ':attribute es inválido.',
    'numeric'              => ':attribute debe ser numérico.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato de :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando :values estén vacios.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El tamaño de :attribute debe ser :size.',
        'file'    => 'El tamaño de :attribute debe ser :size kilobytes.',
        'string'  => ':attribute debe contener :size caracteres.',
        'array'   => ':attribute debe contener :size elementos.',
    ],
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido registrado.',
    'url'                  => 'El formato :attribute es inválido.',

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

    'custom'               => [
        'expediente_ttipo' => [
            'required_if' => 'Seleccionar el tipo de Expediente'
        ],
        'expediente' => [
            'required_if' => 'Ingresar manualmente el Expediente',
            'required_with' => 'Seleccionar el Expediente del Cliente'
        ],
        'poder' => [
            'required_with' => 'Activar la casilla de Fecha de Poder'
        ],
        'vencimiento' => [
            'required_with' => 'Activar la casilla de Fecha de Vencimiento'
        ],
        'fecha_poder' => [
            'required_if' => 'El campo Fecha de Poder es obligatorio'
        ],
        'fecha_vencimiento' => [
            'required_if' => 'El campo Fecha de Vencimiento es obligatorio'
        ],
        'abogado_id' => [
            'required_if' => 'El campo Abogado es obligatorio cuando ha activado la casilla de Abogado'
        ],
        'check_asistente' => [
            'required_with' => 'Active la casilla de Asistente, en caso haya seleccionado un registro'
        ],
        'asistente_id' => [
            'required_if' => 'El campo Asistente es obligatorio cuando ha activado la casilla de Asistente'
        ],
    ],

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

    'attributes'           => [
        'name'                  => 'Nombre',
        'username'              => 'Usuario',
        'email'                 => 'Email',
        'first_name'            => 'Nombres',
        'last_name'             => 'Apellidos',
        'password'              => 'Contraseña',
        'password_confirmation' => 'confirmar Contraseña',
        'city'                  => 'Ciudad',
        'country'               => 'País',
        'pais'                  => 'País',
        'address'               => 'Dirección',
        'phone'                 => 'teléfono',
        'mobile'                => 'celular',
        'age'                   => 'edad',
        'sex'                   => 'sexo',
        'gender'                => 'género',
        'year'                  => 'año',
        'month'                 => 'mes',
        'day'                   => 'día',
        'hour'                  => 'hora',
        'minute'                => 'minuto',
        'second'                => 'segundo',
        'title'                 => 'Título',
        'body'                  => 'Contenido',
        'description'           => 'Cescripción',
        'excerpt'               => 'extracto',
        'date'                  => 'Fecha',
        'time'                  => 'Hora',
        'subject'               => 'Asunto',
        'message'               => 'Mensaje',
        'expediente_tipo'       => 'tipo de Expediente',
        'expediente_opcion'     => 'opción de Expediente',
        'auto'                  => 'Automático',
        'manual'                => 'Manual',
        'expediente'            => 'Expediente',
        'kardex'                => 'Kardex',
        'check_abogado'         => 'Abogado',
        'check_asistente'       => 'Asistente',
        'cliente'               => 'Cliente',
        'moneda'                => 'Moneda',
        'tarifa'                => 'Tarifa',
        'fecha_inicio'          => 'Fecha de Inicio',
        'fecha_fin'             => 'Fecha de Término',
        'fecha_termino'         => 'Fecha de Término',
        'servicio'              => 'Servicio',
        'materia'               => 'Materia',
        'entidad'               => 'Entidad',
        'instancia'             => 'Instancia',
        'area'                  => 'Área',
        'estado'                => 'Estado',
        'dni'                   => 'DNI',
        'ruc'                   => 'RUC',
        'carnet_extranjeria'    => 'Carnet de Extranjería',
        'pasaporte'             => 'Pasaporte',
        'partida_nacimiento'    => 'Partida Nacimiento',
        'otros'                 => 'Otros',
        'abrev'                 => 'Abreviatura o Letra',
        'direccion'             => 'Dirección',
        'contacto'              => 'Contacto',
        'nombre'                => 'Nombre',
        'apellidos'             => 'Apellidos',
        'bienes'                => 'Bienes',
        'especial'              => 'Situación Especial',
        'exito'                 => 'Éxito',
        'referencia'            => 'Referencia',
        'monto'                 => 'Monto',
        'money_id'              => 'Moneda',
        'distrito'              => 'Distrito',
        'titulo'                => 'Titulo'
    ],

];
