<?php namespace Consensus\Traits;


trait Updates
{

    /**
     * Unir datos a nuevo Cliente
     * @param $cliente_antiguo
     * @param $cliente_nuevo
     * @return
     */
    public static function transferirDatosNuevoCliente($cliente_antiguo, $cliente_nuevo)
    {
        return self::withTrashed()->where('cliente_id', $cliente_antiguo)
                                    ->update(['cliente_id' => $cliente_nuevo]);
    }

    /**
     * Seleccionar columnas para luego poder verificar si estan vacias
     * @param $cliente
     * @return array
     */
    public static function seleccionarColumnas($cliente)
    {
        $columnas = [
            'dni','ruc','carnet_extranjeria',
            'pasaporte','partida_nacimiento',
            'otros','email','telefono','fax',
            'direccion','pais_id','distrito_id'
        ];

        $resultado = array_intersect_key($cliente, array_flip($columnas));

        return array_filter($resultado, function($valor){ return $valor !== ''; });
    }

}