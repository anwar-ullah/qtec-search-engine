<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \App\Models\User;
use \Modules\Lead\Entities\Lead;
use \Modules\Lead\Entities\LeadHistory;

use DB, DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    
    public function index(Request $request)
    {
        /*
        for ($i=0; $i < 500; $i++) { 
            $lead = Lead::create([
                'name' => \Str::random(12),
                'phone' => rand(10000000000, 99999999999),
                'goods_id' => rand(1000, 9999),
                'publisher_id' => rand(1000, 9999),
                'leads_id' => rand(1000, 9999),
                'status' => 'new',
            ]);

            LeadHistory::create([
                'lead_id' => $lead->id,
                'status' => 'new',
                'user_id' => auth()->user()->id,
            ]);
        }
        */

        if(request()->has('lead-history')){
            $data = [
                'lead' => Lead::with([
                    'histories.user'
                ])->findOrFail(request()->get('lead-history'))
            ];

            return view('dashboard::history', $data);
        }

        if(request()->has('lead-status')){
            $data = [
                'lead' => Lead::with([
                    'histories.user'
                ])->findOrFail(request()->get('lead-status'))
            ];

            return view('dashboard::status', $data);
        }

        if(request()->has('update-lead-status')){
            $request->validate([
                'status' => 'required',
            ]);

            $lead = Lead::with([
                'histories.user'
            ])->findOrFail(request()->get('update-lead-status'));

            LeadHistory::create([
                'lead_id' => $lead->id,
                'status' => $request->status,
                'comment' => $request->comment,
                'user_id' => auth()->user()->id,
            ]);

            $lead->status = $request->status;
            $lead->save();

            return response()->json([
                'success' => true,
                'message' => "Lead Status has been updated Successfully!"
            ]);
        }

        if (request()->ajax()) {
            return DataTables::of(Lead::when(!datatableOrdering(), function($query){
                    return $query->orderBy('id', 'desc');
                }))
                ->addIndexColumn()
                ->addColumn('lead_ID', function($lead){
                    return $lead->id;
                })
                ->filterColumn('lead_ID', function($query, $keyword){
                    return $query->where('id', 'LIKE', '%'.$keyword.'%');
                })
                ->orderColumn('lead_ID', function ($query, $order) {
                    return $query->orderBy('id', $order);
                })
                ->addColumn('goods_ID', function($lead){
                    return $lead->goods_id;
                })
                ->filterColumn('goods_ID', function($query, $keyword){
                    return $query->where('goods_id', 'LIKE', '%'.$keyword.'%');
                })
                ->orderColumn('goods_ID', function ($query, $order) {
                    return $query->orderBy('goods_id', $order);
                })
                ->addColumn('publisher_ID', function($lead){
                    return $lead->publisher_id;
                })
                ->filterColumn('publisher_ID', function($query, $keyword){
                    return $query->where('publisher_id', 'LIKE', '%'.$keyword.'%');
                })
                ->orderColumn('publisher_ID', function ($query, $order) {
                    return $query->orderBy('publisher_id', $order);
                })
                ->editColumn('status', function($lead){
                    return ucwords(str_replace('-', ' ', $lead->status));
                })
                ->addColumn('actions', function($lead){
                    return view('dashboard::actions', [
                        'lead' => $lead
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('dashboard::index', [
            'headerColumns' => [
                ['SL', 'SL', 'text-center'],
                ['lead_ID', 'lead_ID', 'text-center'],
                ['name', 'name', 'text-center'],
                ['phone', 'phone', 'text-center'],
                ['goods_ID', 'goods_ID', 'text-center'],
                ['publisher_ID', 'publisher_ID', 'text-center'],
                ['status', 'status', 'text-center'],
                ['actions', 'actions', 'text-center']
            ]
        ]);
    }
    
    public function toggleStatus(Request $request)
    {
        $row = \DB::table($request->table)
                    ->where('id',$request->id)
                    ->first();
        if(isset($row->id)){
            $old_status = $row->status;
            $new_status = $old_status == 1 ? 0 : 1;
            
            $old_class = $old_status == 1 ? 'btn-success' : 'btn-danger';
            $new_class = $new_status == 1 ? 'btn-success' : 'btn-danger';

            $new_text = $new_status == 1 ? '<i class="fa fa-check text-white"></i>' : '<i class="fa fa-ban text-white"></i>';
            
            $update = \DB::table($request->table)
                        ->where('id',$request->id)
                        ->update([
                            'status' => $new_status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);


            if(isset($row->updated_by)){
               \DB::table($request->table)
                    ->where('id',$request->id)
                    ->update([
                        'updated_by' => auth()->user()->id
                    ]);
            }

            if($update){
                return response()->json([
                    'success' => true,
                    'old_class' => $old_class,
                    'new_class' => $new_class,
                    'new_text' => $new_text,
                    'message' => 'Data has been updated!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data not found!'
        ]);
    }
}
