<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\State;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::select('name', 'id')->orderBy('name')->get();
        return view('app.subscription.index', compact('states'));
    }

    public function index_ajax(Request $request)
    {
        $data = $request->all();

        $response = [];
        $req_filter = $data["search"]['value'];        
        $req_orderdir = $data['order'][0]['dir'];
        $req_orderby = 'email';
        $req_start = $data['start'];
        $req_length = $data['length'];
        $req_draw = $data["draw"];

        try{
            if ((isset($req_filter)) || (isset($req_orderby)) || (isset($req_orderdir)) || 
            (isset($req_start)) || (isset($req_length))) {
                $orderBy = $req_orderby;
                $orderDir = $req_orderdir;
                $start = $req_start;
                $length = $req_length;
                $query = Subscription::with('State')->orderBy($orderBy, $orderDir);

                if (isset($req_filter)) {
                    $search = $req_filter;
                    $query = $query->where('email', 'like', '%'.$search.'%');
                }
                $subscriptions_count = $query->count();
                $subscriptions = $query->skip($start)->take($length);
                $subscriptions = $subscriptions->get();        
            } else {
                $br = Subscription::with('State')->query();
                $subscriptions_count = $br->count();
                $subscriptions = $br->get();
            }

            $response['draw'] = $req_draw;
            $response['recordsTotal'] = $subscriptions_count;
            $response['recordsFiltered'] = $subscriptions_count;
            $response['data'] = $subscriptions->toArray();
            
        }catch(\Exception $ex){
            $response['draw'] = $req_draw;
            $response['recordsTotal'] = 0;
            $response['recordsFiltered'] = 0;
            $response['data'] = [];
        }
        
        return response()->json($response);
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
        $data = $request->all();
        $response = [
            'error' => false,
            'mensaje' => ""
        ];
        
        try{
            $subscription = new Subscription();
            $subscription->email = $data['email'];
            $subscription->state_id = $data['state_id'];
            if( $subscription->save() ){
                $response['mensaje'] = "La suscripción se guardo con éxito.";
            } else {
                $response = [
                    'error' => true,
                    'mensaje' => "No se pudo guardar la suscripción."
                ];
            }
        } catch(\Exception $ex){
            $response = [
                'error' => true,
                'mensaje' => "Ocurrió un error al guardar la suscripción."
            ];
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
