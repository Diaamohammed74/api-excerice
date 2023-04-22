<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AdResource;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\Api;

class AdController extends Controller
{
    // retrive all ads with pagination
    public function index(){
        $ads=Ad::latest()->paginate(1);
        if (count($ads)>0)
        {
            if ($ads->total()>$ads->perPage())
            {
                $data=[
                    'records'=> AdResource::collection($ads),
                    'pagination links'=>[
                        'current page'=>$ads->currentPage(),
                        'per page'=>$ads->perPage(),
                        'total'=>$ads->total(),
                    ],
                ];
            }
            else
            {
                $data=AdResource::collection($ads);
            }
            return ApiResponse::sendResponse(200,"all ads with pagination ", $data);
        }
        return ApiResponse::sendResponse(200,"No ads yet", []);
    }
        // search about ad title
    public function search(Request $request){
        $word=$request->input('search') ?? null;
        $ad=Ad::when($word!=null , function($query) use($word){
            $query->where('title',"like", "%".$word."%");
        })->latest()->get();
        if (count($ad)>0) {
            return ApiResponse::sendResponse(200,"Search ad",AdResource::collection($ad));
        }
        return ApiResponse::sendResponse(200,"Does`t match",[]);
    }
    //create ads
    public function create(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>['required','string','max:255'],
            'text'=>['required'],
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422,'creation Validation Errror',$validator->messages()->all());
        }
        $ad=Ad::create([
            'title'=>$request->title,
            'text'=>$request->text,
            'user_id'=>$request->user()->id,
        ]);
        return ApiResponse::sendResponse(201,"Ad Created Successfuly",[]);
    }

    public function update(Request $request,$ad_id){
        $ad=Ad::findOrFail($ad_id);
        if ($ad->user_id != $request->user()->id) {
            return ApiResponse::sendResponse(403,"You Are not allowed to take this action",[]);
        }
        $validated=Validator::make($request->all(),[
            'title'=>['required','max:255'],
            'text'=>['required','max:255'],
        ]);
        if ($validated->fails()) {
            return ApiResponse::sendResponse(422,"Validation Erros",$validated->messages()->all());
        }
        $ad->update($request->except('user_id'));
        return ApiResponse::sendResponse(201,"Ads Updated Successfuly",[]);
    }

    public function delete(Request $request,$ad_id){
        $ad=Ad::findOrFail($ad_id);
        if ($ad->user_id !=$request->user()->id) {
            return ApiResponse::sendResponse(422,"Sorry You Don`t Have Permissions To Delete this Ad",[]);
        }
        $ad->delete();
        return ApiResponse::sendResponse(200,"Deleted Succesfuly",[]);
    }
    public function myAds(Request $request){
        $ads=Ad::where('user_id',$request->user()->id)->latest()->get();
        if (count($ads)>0) {
            return ApiResponse::sendResponse(200,"Your Ads ",AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(200,"You don`t have ads yet ",[]);

    }
}
