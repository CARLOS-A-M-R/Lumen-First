<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use Carbon\Carbon;


class ArticuloController extends Controller{

    public function index() {

        $datosArticulos =  Articulo::all();

        return response()->json($datosArticulos);
    }

    public function save(Request $request) {
        
        $datosArticulos = new Articulo;

        if($request->hasFile('imagen')) {

            $nombreArchivoOriginal = $request->file('imagen')->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchivoOriginal;
            $carpetaDestino = './upload/';
            $request->file('imagen')->move($carpetaDestino, $nuevoNombre);
            $datosArticulos->codigo_producto=$request->codigoProducto;
            $datosArticulos->descripcion=$request->descripcion;
            $datosArticulos->imagen = ltrim($carpetaDestino, '.').$nuevoNombre;
            $datosArticulos->save();

        }
    
        return response()->json($nuevoNombre);
    }

    public function viewByID($id) {
        
        $datosArticulos = new Articulo;
        $datosEncontrados = $datosArticulos->find($id);
        return response()->json($datosEncontrados);
    }

    public function delete($id) {

        $datosArticulos = Articulo::find($id);

        if($datosArticulos) {
            $rutaArchivo = base_path('public').$datosArticulos->imagen;

            if(file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $datosArticulos->delete();
        }

        return response()->json('Registro Borrado');
    }

    public function update(Request $request, $id) {

        $datosArticulos = Articulo::find($id);

        if($request->hasFile('imagen')) {

            if($datosArticulos) {
                $rutaArchivo = base_path('public').$datosArticulos->imagen;
    
                if(file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
    
                $datosArticulos->delete();
            }   

            $nombreArchivoOriginal = $request->file('imagen')->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$nombreArchivoOriginal;
            $carpetaDestino = './upload/';
            $request->file('imagen')->move($carpetaDestino, $nuevoNombre);
            $datosArticulos->imagen = ltrim($carpetaDestino, '.').$nuevoNombre;
            $datosArticulos->save();

        }

        if($request->input('codigoProducto') || $request->input('descripcion')) {
            $datosArticulos->codigo_producto = $request->input('codigoProducto');
            $datosArticulos->descripcion = $request->input('descripcion');
        }

        $datosArticulos->save();

        return response()->json('Datos actualizados');
    }
}