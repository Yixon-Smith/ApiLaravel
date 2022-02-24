<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductos;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{

  
    public function store(StoreProductos $request){
        $productos = new Productos;

        $productos->referencia_precio = $request->referencia_precio;
        $productos->cantidad = $request->cantidad;
        $productos->descripcion = $request->descripcion;
        $productos->activo = true;

        if($request->hasFile("image")){
            $image = $request->file('image')->store('public/images');
            $productos->ruta_imagen_producto = Storage::url($image);
        }

        $productos->save();

        return response()->json([
             'status' => 200,
             'response' => 'Producto Creado',
         ], 200);
    }

    public function show(){
        $select = [
            'productos.producto_id', 
            'productos.referencia_precio', 
            'productos.cantidad', 
            'productos.descripcion', 
            'productos.ruta_imagen_producto', 
            'productos.activo',
        ];

        extract(request()->only(['producto_id', 'limit', 'page']));
  
    
        $records =
        DB::table('productos')
            ->where('productos.producto_id','=', $producto_id)
            ->where('productos.activo', '=', true)
            ->select($select);

        
        $count = $records->count();

        $records->limit($limit)
            ->skip($limit * ($page - 1));

        $results = $records->get()->toArray();

        $data =  [
            'data' => $results,
            'count' => $count,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function update($id, StoreProductos $request){
        if (Productos::where([['producto_id', $id], ['activo', '=', true]])->count() == 0){
            return response()->json([
                'status' => 422,
                'response' => 'No encontrado',
            ], 422);
        }

        $productos = Productos::where([['producto_id', $id], ['activo', '=', true]])->first();

        $productos->referencia_precio = $request->referencia_precio;
        $productos->cantidad = $request->cantidad;
        $productos->descripcion = $request->descripcion;
        $productos->activo = true;

        if($request->hasFile("imagen")){
            if( $productos->ruta_imagen_producto != null ){
                $url = str_replace('storage', 'public', $productos->ruta_imagen_producto);
                Storage::delete($url);
            }

            $image = $request->file('image')->store('public/images');
            $productos->ruta_imagen_producto = Storage::url($image);
        }

        $productos->update();

        return response()->json([
             'status' => 200,
             'response' => 'Producto Actualizado',
         ], 200);
    }

    public function destroy($id){
        $producto = Productos::find($id);

        if( $producto->ruta_imagen_producto != null ){
            $url = str_replace('storage', 'public', $producto->ruta_imagen_producto);
            Storage::delete($url);
        }

        $producto ->delete();

        return response()->json([
            'status' => 200,
            'response' => 'Producto Eliminado',
        ], 200);
    }
}
