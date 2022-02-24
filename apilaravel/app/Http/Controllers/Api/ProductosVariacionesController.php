<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductosVariaciones;
use App\Models\Productos;
use App\Models\ProductosVariaciones;
use Illuminate\Support\Facades\DB;


class ProductosVariacionesController extends Controller
{
    public function store(StoreProductosVariaciones $request){
        if (Productos::where([['producto_id', $request->producto_id], ['activo', '=', true]])->count() == 0){
            return response()->json([
                'status' => 422,
                'response' => 'Error en guardar',
            ], 422);
        }

        $productos = new ProductosVariaciones;

        $productos->producto_id = $request->producto_id;
        $productos->referencia = $request->referencia;
        $productos->precio = $request->precio;
        $productos->descripcion = $request->descripcion;
       

 

        $productos->save();

        return response()->json([
             'status' => 200,
             'response' => 'Producto Variacion Creado',
         ], 200);
    }

    public function show(){
        $select = [
            'productos.producto_id',
            'productos_variaciones.variacion_producto_id', 
            'productos_variaciones.referencia', 
            'productos_variaciones.precio', 
            'productos_variaciones.descripcion'
        ];

        extract(request()->only(['variacion_producto_id', 'limit', 'page']));
  
    
        $records =
        DB::table('productos_variaciones')
            ->leftJoin('productos', 'productos.producto_id', '=', 'productos_variaciones.producto_id')
            ->where('productos_variaciones.variacion_producto_id','=', $variacion_producto_id)
            ->where('productos.activo', '=', true)
            ->select($select);

        
        $count = $records->count();

        if ($count == 0){
            return response()->json([
                'status' => 422,
                'response' => 'Datos No encontrados',
            ], 422);
        }

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

    public function update($id, StoreProductosVariaciones $request){
        if (Productos::where([['producto_id', $request->producto_id], ['activo', '=', true]])->count() == 0){
            return response()->json([
                'status' => 422,
                'response' => 'Error En guardar',
            ], 422);
        }

        if (ProductosVariaciones::where([['variacion_producto_id', $id]])->count() == 0){
            return response()->json([
                'status' => 422,
                'response' => 'Error En guardar',
            ], 422);
        }

        $productos = ProductosVariaciones::where([['variacion_producto_id', $id]])->first();

        $productos->producto_id = $request->producto_id;
        $productos->referencia = $request->referencia;
        $productos->precio = $request->precio;
        $productos->descripcion = $request->descripcion;

        $productos->update();

        return response()->json([
             'status' => 200,
             'response' => 'Producto variaciones Actualizado',
         ], 200);
    }

    public function destroy($id){
        $producto = ProductosVariaciones::find($id);

        $producto ->delete();

        return response()->json([
            'status' => 200,
            'response' => 'Producto Variaciones Eliminado',
        ], 200);
    }
}
