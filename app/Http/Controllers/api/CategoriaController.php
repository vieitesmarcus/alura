<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Categoria::paginate(5), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Categoria();
        if (!($request->input('titulo') && $request->input('cor'))) {
            $f = json_encode("Campos obrigátorios");
            return response()->json($f, 404);
        }
        $categoria->titulo = $request->titulo;
        $categoria->cor = $request->cor;
        $categoria->save();

        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        dd($id);
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json("não encontrado", 302, ['Content-Type' => 'application/json']);
        }
//        dd(str_contains($request->getRequestUri(), 'videos'));

        if(str_contains($request->getRequestUri(), 'videos')){
            $categoria->videos;
        }

        return response()->json($categoria, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json('nada encontrado', 404);
        }
        if (!($request->input('titulo') && $request->input('cor'))) {
            $f = json_encode("faltando informações");
            return response()->json($f, 404);
        }
        $categoria->titulo = $request->titulo;
        $categoria->cor = $request->cor;
        $categoria->save();

        return response()->json($categoria, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Categoria::destroy($id)) {
            return response()->json("excluído com sucesso", 200);
        }
        return response()->json("erro ao excluir", 200);
    }
}
