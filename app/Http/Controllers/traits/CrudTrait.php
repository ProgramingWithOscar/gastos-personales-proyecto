<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait CrudTrait
{
    public function index()
    {
        $all = $this->model::all();

        return response()->json([
            'data' => $all
        ]);
    }

    public function store(Request $request)
    {
        $recordSaved = $this->model::create($request->all());

        return response()->json([
            'data' => $recordSaved,
            'message' => 'Registro creado exitosamente'
        ], 201);
    }

    public function show($id)
    {
        $recordFind = $this->model::findOrFail($id);

        return response()->json([
            'data' => $recordFind,
            'message' => 'Registro consultado exitosamente'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $recordFind = $this->model::findOrFail($id);
        $recordFind->update($request->all());

        return response()->json([
            'data' => $recordFind,
            'message' => 'Registro actualizado exitosamente'
        ], 200);
    }

    public function destroy($id)
    {
        $recordFind = $this->model::findOrFail($id);
        $recordFind->delete();

        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 200);
    }
}
