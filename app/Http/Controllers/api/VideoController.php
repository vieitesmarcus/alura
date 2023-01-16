<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Video::paginate(5), 200, ['Content-Type' => 'application/json']);
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
        //CASO QUEIRA INSERIR MAIS DE UM VIDEO AO MESMO TEMPO NO BANCO DE DADOS
//        dd($request->all());
//        foreach ($request->all() as $item){
//            $video = new Video();
////            dd($item['titulo']);
//            if (!($item['titulo'] && $item['descricao'] && $item['url'])) {
//                $f = json_encode("faltando informações");
//                return response()->json($f, 404);
//            }
//            $video->titulo = $item['titulo'];
//            $video->descricao = $item['descricao'];
//            $video->url = $item['url'];
//            $video->categoria_id = $item['categoria_id']??1;
//            $video->save();
//        }

        $video = new Video();
            if (!($request->input('titulo') && $request->input('descricao') && $request->input('url'))) {
                $f = json_encode("faltando informações");
                return response()->json($f, 404);
            }
            $video->titulo = $request->input('titulo');
            $video->descricao = $request->input('descricao');
            $video->url = $request->input('url');
            $video->categoria_id = $request->input('categoria_id')??1;
            $video->save();

        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $url = $request->getRequestUri();
        if (str_contains($url, 'search')) {
            $arrSearch = explode('/', $url);
            if (isset($arrSearch[4])) {
                $video = Video::where('titulo', 'LIKE', "%".$arrSearch[4]."%")->get();
                return response($video, 200, ['Content-Type' => 'application/json']);
            }
        }

        $video = Video::find($id);
        if (!$video) {
            return response('sem videos por aqui', 404, ['Content-Type' => 'application/json']);
        }
        return response($video, 200, ['Content-Type' => 'application/json']);
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
        $video = Video::find($id);
        if (!$video) {
            return response()->json('erro ao achar', 404);
        }
        if (!($request->input('titulo') && $request->input('descricao') && $request->input('url') && $request->input('categorias_id'))) {
            $f = json_encode("faltando informações");
            return response()->json($f, 404);
        }
        $video->titulo = $request->titulo;
        $video->descricao = $request->descricao;
        $video->url = $request->url;
        $video->categorias_id = $request->categorias_id;
        $video->save();

        return response()->json($video, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Video::destroy($id), 200);
    }
}
