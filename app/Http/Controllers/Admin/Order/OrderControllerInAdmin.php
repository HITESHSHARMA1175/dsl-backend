<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;


use App\Models\Property;
use App\Models\Order;


class OrderControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Order::query();
        
        if ($request->searchtext != '') {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('last_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('email', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('mobile', 'like', '%'.$request->searchtext.'%');
            });
        }

        if ($request->parent_id != '') {
            $query->whereJsonContains('service_id', (int) $request->parent_id);
        }
        
        $query->orderBy('id', 'desc');
        
        $orders = $query->paginate(10);
        $orderCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.order.index', compact('orders','orderCount', 'services','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $services = Property::where('parent_id', 0)->get();

        return view('admin.order.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order_info = Order::where('id', $id)->first();

        return view('admin.order.details', compact('order_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $order_info = Order::where('id', $id)->first();

        $services = Property::where('parent_id', 0)->get();

        return view('admin.order.update', compact('order_info', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function order_status($id)
    {
        $data = Order::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect()
            ->back()
            ->with('success', 'Order ' . $msg . ' Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
     
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()
            ->back()
            ->with('success', 'Order has been Deleted Successfully!!');
    }
}
