<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoice;
use Illuminate\Support\Facades\Validator;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreInvoice  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request)
    {
        /**
         * Asignacion Masiva validada por FormRequest 
         * y protegida por el modelo
         */
        try {

            $client = Invoice::create($request->all());
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
            'client_id' => 'required|int',
            'exchange_rate_id' => 'required|int',
            'code' => 'required|max:25|min:3|unique:invoices,code,' . $request->id,
            'description' => 'required',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }


        try {
            $client = Invoice::findOrFail($request->id);
            $client->code = trim($request->code);
            $client->client_id = trim($request->client_id);
            $client->exchange_rate_id = trim($request->exchange_rate_id);
            $client->description = trim($request->description);
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
    public function destroy($id)
    {
        //
    }
}
