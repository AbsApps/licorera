<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Http\Requests\StoreInvoice;
use Illuminate\Cache\RateLimiting\Limit;
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
        $invoice = new Invoice();
        $result = $invoice::join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('exchange_rates', 'exchange_rates.id', '=', 'invoices.exchange_rate_id')
            ->orderBy('invoices.created_at', 'DESC')
            ->select(
                'invoices.*',
                'clients.name as client',
                'clients.ruc as client_ruc',
                'clients.code as client_code',
                'exchange_rates.id as rate_id ',
                'exchange_rates.rate',
                'exchange_rates.date as rate_date',
            );

        return $result->paginate(10);
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
    public function detail(Request $request)
    {

        $invoice = new InvoiceDetail();
        $result = $invoice::join('products', 'products.id', '=', 'invoice_details.product_id')
            ->join('invoices', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('exchange_rates', 'exchange_rates.id', '=', 'invoices.exchange_rate_id')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->orderBy('invoice_details.created_at', 'ASC')
            ->where('invoice_details.active', '=', 1)
            // ->where('invoice_details.invoice_id', '=', $request->id)
            ->where('invoices.code', '=', $request->invoice_code)
            ->select(
                'invoices.id as invoice_id',
                'invoices.code as invoice_code',
                'clients.id as client_id',
                'clients.ruc as client_ruc',
                'invoice_details.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'products.description as product_description',
                'products.price as product_price',
                'exchange_rates.id as rate_id ',
                'exchange_rates.rate',
                'exchange_rates.date as rate_date'
            );

        if (count($result->get()) <= 0) {
            return response()->json(['res' => false, 'msg' => 'Not found record!'], 200);
            exit;
        }

        /**
         * Generate Invoice
         */
        $data = [];
        $iva = 0.15;
        $data['invoice_detail'] = $result->get();
        $data['total_sub'] = 0;


        // total_sub 
        foreach ($data['invoice_detail'] as $key => $value) {
            $data['total_sub'] += round($value['product_price'], 2);
        }


        
        $data['iva'] = round(($data['total_sub'] * $iva), 2);
        $data['total'] = round($data['total_sub'] + $data['iva'], 2);

        return $data;
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
            return response()->json($e->getMessage(), 500);
            // return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
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
        $validator = Validator::make($request->all(), ['id' => 'required|int']);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }

        try {
            $client = Invoice::findOrFail($request->id);
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
