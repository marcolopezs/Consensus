<?php namespace Consensus\Repositories;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

abstract class BaseRepo {

    abstract public function getModel();

    //BUSCAR POR ID Y URL
    public function findIdUrl($id, $url)
    {
        return $this->getModel()->where('id', $id)->where('slug_url', $url)->first();
    }

    //BUSCAR POR URL
    public function findUrl($url)
    {
        return $this->getModel()->where('slug_url', $url)->first();
    }

    //BUSCAR Y MOSTRAR ERROR
    public function findOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    //ORDENAR
    public function orderBy($field, $order)
    {
        return $this->getModel()->orderBy($field, $order)->get();
    }

    //PAGINACION
    public function paginate($value)
    {
        return $this->getModel()->paginate($value);
    }

    //LISTAR TODOS LOS REGISTROS
    public function listAll($field, $id)
    {
        return $this->getModel()->lists($field, $id)->all();
    }

    //LISTAR
    public function lists($field, $id)
    {
        return $this->getModel()->lists($field, $id);
    }

    //WITH
    public function with(){
        return $this->getModel()->with();
    }

    //MOSTRAR
    public function all(){
        return $this->getModel()->all();
    }

    //ORDERNAR Y PAGINAR
    public function orderByPagination($field, $order, $value)
    {
        return $this->getModel()->orderBy($field, $order)->paginate($value);
    }

    //SELECT
    public function where($field, $value)
    {
        return $this->getModel()->where($field, $value);
    }

    public function create($entity, array $data)
    {
        $entity->save();
        return $entity;
    }

    public function update($entity, array $data)
    {
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    public function delete($entity)
    {
        if (is_numeric($entity))
        {
            $entity = $this->findOrFail($entity);
        }
        $entity->delete();
        return $entity;
    }

    public function findTrash($id)
    {
        return $this->getModel()->onlyTrashed()->findOrFail($id);
    }

    //LISTAR TITULO Y ID DE REGISTROS EN DONDE ESTADO ES ACTIVO Y PASARLO A ARRAY
    public function estadoListArray()
    {
        return $this->getModel()->where('estado', '1')->orderBy('titulo','asc')->lists('titulo', 'id')->toArray();
    }



    /* URL AMIGABLE */
    public function SlugUrl($texto){
        return $this->getUrlAmigable($this->eliminarTextoURL($texto));
    }

    public function eliminarTextoURL($str) {
        $search = array('&lt;', '&gt;', '&quot;', '&amp;');
        $str = str_replace($search, '', $str);
        $search = array('&aacute;','&Aacute;','&eacute;','&Eacute;','&iacute;','&Iacute;','&oacute;','&Oacute;','&uacute;','&Uacute;','&ntilde;','&Ntilde;');
        $replace = array('a','a','e','e','i','i','o','o','u','u','n','n');
        $search = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ü', 'ü', 'Ñ', 'ñ', '_', '-');
        $replace = array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'u', 'u', 'n', 'n', ' ', ' ');
        $str = str_replace($search, $replace, $str);
        $str = preg_replace('/&(?!#[0-9]+;)/s', '', $str);
        $search = array(' a ', ' de ', ' con ', ' por ', ' en ', ' y ', ' e ', ' o ', ' u ', ' la ', ' el ', ' lo ', ' las ', ' los ', ' fue ', ' del ', ' se ', ' su ', ' una ');
        $str = str_replace($search, ' ', strtolower($str));
        $str = str_replace($search, $replace, strtolower(trim($str)));
        $str = preg_replace("/[^a-zA-Z0-9\s]/", '', $str);
        $str = preg_replace('/\s\s+/', ' ', $str);
        $str = str_replace(' ', '-', $str);
        return  $str;
    }

    public function getUrlAmigable($s){
        $s = strtolower($s);
        $s = preg_replace("[áàâãäª@]","a",$s);
        $s = preg_replace("[éèêë]","e",$s);
        $s = preg_replace("[íìîï]","i",$s);
        $s = preg_replace("[óòôõºö]","o",$s);
        $s = preg_replace("[úùûü]","u",$s);
        $s = preg_replace("[ç]","c",$s);
        $s = preg_replace("[ñ]","n",$s);
        $s = preg_replace( "/[^a-zA-Z0-9\-]/", "-", $s );
        $s = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $s);

        return trim($s, '-');
    }

    //GENERAR CODIGO ALEATORIO
    public function CodigoAleatorio($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
    {
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
    }

    //GENERAR CODIGO ALEATORIO
    public function CodigoAleatorioUpp($length=10,$n=TRUE,$sc=FALSE)
    {
        $source = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
    }
    
    //GENERAR NOMBRE ALETORIO
    public function NombreAleatorio($min=7, $max=10)
    {
        $vocales 	= ['a','e','i','o','u'];
        $consonantes = ['b','c','d','f','g','h','j','l','m','n','p','r','s','t'];
        $tamano 	= intval(rand($min, $max));
        $actual		= intval(rand(1,2));
        $nombre 	= '';
        for($x=0;$x<$tamano;$x++)
        {
            if($actual == 0)
            {
                $actual	= 1;
                $pos 	= rand(0,count($vocales)-1);
                $nombre	.=  $vocales[$pos];
            }
            else
            {
                $actual	= 0;
                $pos 	= rand(0,count($consonantes)-1);
                $nombre	.=  $consonantes[$pos];
            }
        }
        return $nombre;
    }

    /*
     * UPLOAD DE ARCHIVOS
     */

    //UPLOAD DE ARCHIVO
    /**
     * @param $type = Tipo de archivo: Documentos o Upload (imagen)
     * @param $file = Archivo
     */
    public function UploadFile($type, $file)
    {
        $this->CrearCarpeta($type);
        $path = $type."/".$this->FechaCarpeta();
        $upload = $this->FileMove($file, $path);
        $carpeta = $this->FechaCarpeta();

        $archivo['nombre'] = $upload['original'];
        $archivo['extension'] = $upload['extension'];
        $archivo['archivo'] = $upload['archivo'];
        $archivo['carpeta'] = $carpeta;

        return $archivo;
    }

    //MOVER ARCHIVO
    public function FileMove($file, $path)
    {
        $name = $file->getClientOriginalName();                 //NOMBRE Y EXTENSION DE ARCHIVO
        $extension = $file->getClientOriginalExtension();       //EXTENSION DE ARCHIVO
        $archive = basename($name, ".".$extension);             //NOMBRE DE ARCHIVO
        $pathName = $this->SlugUrl($archive)."-".date('YmdHi'); //CONVERTIR NOMBRE SIN ESPACIOS
        $filename = $pathName.".".$extension;                   //NOMBRE Y EXTENSION SIN ESPACIOS
        $file->move($path, $filename);                          //MOVER ARCHIVO A NUEVA CARPETA

        $archivo['original'] = $archive;                           //DEVOLVER SOLO NOMBRE ORIGINAL
        $archivo['extension'] = $extension;                     //DEVOLVER SOLO EXTENSION
        $archivo['archivo'] = $filename;                        //DEVOLVER NOMBRE CON EXTENSION

        return $archivo;
    }

    //CARPETA CON NOMBRE DEL MES ACTUAL
    public function FechaCarpeta()
    {
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $mes = date('n')-1; // devuelve el número del mes
        $ano = date('Y'); // devuelve el año
        $fechaCarpeta = $meses[$mes]."".$ano."/";
        return $fechaCarpeta;
    }

    /* CREACION DE CARPETA */
    public function CrearCarpeta($type){
        $nombre_carpeta=$this->FechaCarpeta();
        $ruta = public_path($type."/".$nombre_carpeta);
        if(!is_dir($ruta)){
            @mkdir($ruta, 0755);
            $carpeta=$ruta;
        }else{
            $carpeta=$ruta;
        }
        return $carpeta;
    }

    /* FECHA TEXTO */
    public function fechaTexto($datetime)
    {
        Date::setLocale('es');
        $fecha = Date::create($datetime->year, $datetime->month, $datetime->day, $datetime->hour, $datetime->minute, $datetime->second);
        $fecha = $fecha->format('d \\d\\e F \\d\\e\\l Y');
        return $fecha;
    }



    /*
     * BUSQUEDAS DE REGISTROS
     */

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR TITULO
    public function findTituloEstadoOrderTitulo(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->orderBy('titulo', 'asc')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS
    public function findAndPaginate(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->publicar($request->get('publicar'))
                    ->orderBy('titulo', 'asc')
                    ->paginate();
    }

    //BUSQUEDAS DE REGISTROS ELIMINADOS
    public function findAndPaginateDeletes(Request $request)
    {
        return $this->getModel()
                    ->onlyTrashed()
                    ->titulo($request->get('titulo'))
                    ->orderBy('deleted_at', 'desc')
                    ->paginate();
    }


    //GUARDAR HISTORIAL
    public function saveHistory($entity, Request $request, $type)
    {
        $contenido = json_encode($request->except('_method','_token'));

        $entity->histories()->create([
            'user_id' => auth()->user()->id,
            'type' => $type,
            'opcion' => 'text',
            'descripcion' => $contenido
        ]);
    }

    //GUARDAR HISTORIAL
    public function saveHistoryEstado($entity, $estado, $type)
    {
        $contenido = '{"estado":"'.$estado.'"}';

        $entity->histories()->create([
            'user_id' => auth()->user()->id,
            'type' => $type,
            'opcion' => 'text',
            'descripcion' => $contenido
        ]);
    }

    public function saveHistoryFile($entity, $archivo, $type)
    {
        $contenido = json_encode($archivo);

        $entity->histories()->create([
            'user_id' => auth()->user()->id,
            'type' => $type,
            'opcion' => 'file',
            'descripcion' => $contenido
        ]);
    }

    public function saveHistoryDocumento($entity, Request $request, $type)
    {
        $contenido = json_encode($request->only(['documento','carpeta']));

        $entity->histories()->create([
            'user_id' => auth()->user()->id,
            'type' => $type,
            'opcion' => 'file',
            'descripcion' => $contenido
        ]);
    }

    //GUARDAR HISTORIAL DE DOCUMENTO
    public function saveDocumento($entity, Request $request, $type)
    {
        $entity->documentos()->create([
            'user_id' => auth()->user()->id,
            'documento' => $request->input('documento'),
            'carpeta' => $request->input('carpeta'),
            'type' => $type,
        ]);
    }
    
    //BUSCAR HISTORIAL
    public function findHistory($entity, $id)
    {
        $row = $entity->histories()->find($id);

        return $row;
    }

    //GUARDAR AJUSTES
    public function saveAjustes($entity, Request $request)
    {
        $contenido = json_encode($request->except('_token'));

        $entity->update([
            'contenido' => $contenido
        ]);
    }

    /**
     * Listar registros por estado ACTIVO
     * y los ordenará por Titulo
     * @return mixed
     */
    public function listarRegistrosActivos()
    {
        return $this->getModel()->where('estado', 1)->orderBy('titulo','asc')->get();
    }

}