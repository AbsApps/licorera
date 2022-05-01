<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

use App\Http\Requests\StoreClient;

use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Client::orderBy('id', 'desc')
            ->where('active', '=', 1)
            ->paginate(20);
        return  response()->json($client, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {



        /**
         * Asignacion Masiva validada por FormRequest 
         * y protegida por el modelo
         */
        try {

            $client = Client::create($request->all());
            return response()->json($client->toArray(), 200);
        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), 500);
            return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $name = $request->name;
        $code = $request->code;

    
        $client = new Client();
        $result =  $client::orderBy('id', 'DESC')
            ->where('active', '=', 1);

        // Building Query
        if (!empty($name)) {
            $result->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($code)) {
            $result->where('code', '=', $code);
        }


        if (empty($result->get()->toArray())) {
            return  response()->json('Not found records!', 200);
        }
        return  response()->json($result->get()->toArray(), 200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClient $request)
    {
        /**
         * Validaciones aplicadas con form-request
         */

        $client = Client::findOrFail($request->id);
        $client->name = $request->name;
        $client->code = $request->code;
        $client->ruc = $request->ruc;
        $client->email = $request->email;
        $client->updated_at = now();
        $client->save();

        // return $client;

        return  response()->json($client->get()->toArray(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /**
         * Validate
         */

        $validator = Validator::make(['id' => $request->id], [
            'id' => 'int',
        ]);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }

        /**
         * Applying logical erase
         */
        $client = Client::findOrFail($request->id);
        $client->active = 0;
        $client->save();

        return 204;
    }
}
