<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\User;
use \Modules\Lead\Entities\Lead;
use \Modules\Lead\Entities\LeadHistory;
use DB;

class LeadController extends Controller
{
    public function postLead(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required|unique:leads',
            'goods_id' => 'required',
            'publisher_id' => 'required',
            'leads_id' => 'required',
        ]);

        $token = $this->getToken($request);
        if(!$token['success']){
            return response()->json([
                'message' => $token['message']
            ], 500);
        }

        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $lead = Lead::create($request->all());
                LeadHistory::create([
                    'lead_id' => $lead->id,
                    'status' => 'new',
                    'comment' => isset($request->comment) ? $request->comment : '',
                    'user_id' => auth()->user()->id,
                ]);

                DB::commit();
                return response()->json([
                    'message' => "Lead has been saved successfully",
                    'lead' => $this->getLead($lead)
                ], 200);
                
            }catch (Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function leadBank(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            try{

                $token = $this->getToken($request);
                if(!$token['success']){
                    return response()->json([
                        'message' => $token['message']
                    ], 500);
                }
        
                return response()->json([
                    'leads' => Lead::orderBy('id', 'desc')->get([
                        'id',
                        'name',
                        'phone',
                        'goods_id',
                        'publisher_id',
                        'leads_id',
                        'status'
                    ]),
                ], 200);
            }catch (Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function leadStatus(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'lead_id' => 'required',
        ]);

        if ($validator->passes()) {
            try{

                $token = $this->getToken($request);
                if(!$token['success']){
                    return response()->json([
                        'message' => $token['message']
                    ], 500);
                }

                $lead = Lead::with([
                    'histories.user'
                ])->findOrFail($request->lead_id);
                
                $histories = [];
                if($lead->histories->count() > 0){
                    foreach($lead->histories as $key => $history){
                        array_push($histories, [
                            'status' => $history->status,
                            'comment' => $history->comment,
                            'user' => $history->user->name,
                            'datetime' => date('Y-m-d g:i a', strtotime($history->created_at))
                        ]);
                    }
                }

                return response()->json([
                    'lead' => $this->getLead($lead),
                    'histories' => $histories
                ], 200);
            }catch (Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function getLead($lead)
    {
        return [
            'id' => $lead->id,
            'name' => $lead->name,
            'phone' => $lead->phone,
            'goods_id' => $lead->goods_id,
            'publisher_id' => $lead->publisher_id,
            'leads_id' => $lead->leads_id,
            'status' => !empty($lead->status) ? $lead->status : 'new'
        ];
    }

    public function getToken($request)
    {
        try{
            $user = User::where('email', $request->email)->first();
            if(isset($user->id)){
                if(\Hash::check($request->password, $user->password)){
                    auth()->loginUsingId($user->id);
                    DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
                    session()->put('token', $user->createToken('crm')->plainTextToken);
                    return [
                        'success' => true,
                        'message' => "Logged in Successfully!"
                    ];
                }

                return [
                    'success' => false,
                    'message' => "Password is incorrect!"
                ];
            }

            return [
                'success' => false,
                'message' => "User Not Found!"
            ];
        }catch (Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
