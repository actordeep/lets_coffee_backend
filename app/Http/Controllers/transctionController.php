<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class transctionController extends Controller
{
    public function index()
    {
        // Retrieve all sales
        $sales = DB::table('transactions')->get();  

        return response()->json(['data' => $sales]);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',  
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create a new sale
        $saleId = DB::table('transactions')->insertGetId([
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total_amount' => $request->input('total_amount'),
            'created_at' => Carbon::now(),
        ]);



        $sale = DB::table('transactions')->find($saleId);

        return response()->json(['success' => true, 'message' => 'Sale created successfully', 'data' => $sale]);

        
    }
   
    public function weekSales()
    {
        // Retrieve week sales
        $weekSales =Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        return response()->json(['data' => $weekSales]);
    }

    public function daySales()
    {
        // Retrieve day sales
        $daySales =Transaction::whereDate('created_at', '=', Carbon::now()->toDateString())->get();
        // return 0;

        return response()->json(['data' => $daySales]);
    }



    public function order(Request $req){

        $validator = Validator::make($req->all(), [
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sales= DB::table('product')->where('id',$req->product_id)->first();
        if($sales){
            $data=DB::table('product')->where('id',$req->product_id)->decrement('quantity', 1);
            DB::table('tranction_')->insert([
                'product_id' => $sales->id,
                'quantity' => $req->quantity,
                'total_amount' => ($sales->price)*$req->quantity,
            ]
        
        );
            
      
        return response()->json(['success' => true, 'message' => 'Sale created successfully', 'data' => $sales]);

        }
        else{
            return 0;
        }
     }

  
}

