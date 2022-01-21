<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataOrder = Order::select(['typeroom', DB::raw('count(*) as y')])->groupBy('typeroom')->get();
        $order = Order::orderBy('created_at', 'desc')->first();
        $label = [];
        $data = [];

        foreach ($dataOrder as $k => $v) {
            $label[$k] = ucfirst($v->typeroom);
            $data[$k] = $v->y;
        }

        return view('home', ['order' => $order, 'label' => $label, 'data' => $data]);
    }
}
