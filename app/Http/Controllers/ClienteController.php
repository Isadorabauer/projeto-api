<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function listar()
    {
        $customers =  Cliente::all();
        return ApiResponse::success('lista de Clientes', $customers);
    }
    public function listarPeloId(int $id)
    
    {
        $customers =  Cliente::findOrFail($id);
        return ApiResponse::success('Informações dos Clientes', $customers);
    }
    public function salvar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação',
             $validator->errors());
        }

        $customer = Cliente::create($request->all());
        return ApiResponse::success('Salvo com sucesso!',
         $customer);
    }
    public function editar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação',
             $validator->errors());
        }

        $customer = Cliente::findOrFail($id);
        $customer->update($request->all());
        return ApiResponse::success('Salvo com sucesso!',
         $customer);
    }
    public function deletar(int $id)
    {
        $customers =  Cliente::findOrFail($id); 
        $customers->delete();
        return ApiResponse::success('Informações dos Clientes', $customers);
    }
}