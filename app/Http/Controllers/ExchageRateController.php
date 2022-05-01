<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;
use App\Http\Requests\StoreExchangeRate;
use Illuminate\Support\Facades\Validator;

class ExchageRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = ExchangeRate::orderBy('date', 'desc')
            ->where('active', '=', 1)
            ->paginate(10);
        return  response()->json($client, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreExchangeRate  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExchangeRate $request)
    {


        // echo 'llega hasta aqui';
        // exit;
        /**
         * Asignacion Masiva validada por FormRequest 
         * y protegida por el modelo
         */
        try {

            $client = ExchangeRate::create($request->all());
            return response()->json($client->toArray(), 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
            // return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'rate' => 'required|numeric',
            'date' => 'required|date|unique:exchange_rates,date,' . $request->id,
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }

        try {
            $client = ExchangeRate::findOrFail($request->id);
            $client->rate = trim($request->rate);
            $client->date = trim($request->date);
            $client->active = $request->active;
            $client->updated_at = now();
            $client->save();

            return  response()->json($client->toArray(), 200);
        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), 500);
            return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), ['id'=> 'required|int']);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }

    

        try{
            $client = ExchangeRate::findOrFail($request->id);
            $client->active = 0;        
            $client->updated_at = now();
            $client->save();

            return  response()->json($client->toArray(), 200);

        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), 500);
            return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
    }
}
