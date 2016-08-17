<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Facturacion;

class FacturacionRepo extends BaseRepo {

    public function getModel()
    {
        return new Facturacion();
    }

    //BUSQUEDA DE REGISTROS
    public function filterPaginate(Request $request)
    {
        return $this->getModel()
                    ->clienteId($request->get('cliente'))
                    ->comprobanteId($request->get('comprobante_tipo'))
                    ->comprobanteNumero($request->get('comprobante_numero'))
                    ->fecha($request->get('fecha_from'), $request->get('fecha_to'))
                    ->monedaId($request->get('moneda'))
                    ->importe($request->get('importe'), $request->get('operador'))
                    ->expedienteId($request->get('expediente'))
                    ->descripcion($request->get('descripcion'))
                    ->with('cliente','money','comprobante_tipo')
                    ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->clienteId($request->get('cliente'))
                    ->comprobanteId($request->get('comprobante_tipo'))
                    ->comprobanteNumero($request->get('comprobante_numero'))
                    ->fecha($request->get('fecha_from'), $request->get('fecha_to'))
                    ->monedaId($request->get('moneda'))
                    ->importe($request->get('importe'), $request->get('operador'))
                    ->expedienteId($request->get('expediente'))
                    ->descripcion($request->get('descripcion'))
                    ->with('cliente','money','comprobante_tipo','expedientes')
                    ->get();
    }
}