<?php namespace Consensus\Traits;


trait Updates
{

    /**
     * Transferir datos a nuevo Cliente
     * @param $cliente_antiguo
     * @param $cliente_nuevo
     * @return
     */
    public static function transferirDatosNuevoCliente($cliente_antiguo, $cliente_nuevo)
    {
        return self::withTrashed()->where('cliente_id', $cliente_antiguo)
                                    ->update(['cliente_id' => $cliente_nuevo]);
    }

}