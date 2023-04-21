<?php
namespace App\Http\Controllers\Api;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Spatie\FlareClient\Api;

class MessageController extends Controller
{
    public function index(){
        $messages=Message::latest()->paginate(3);
        if (count($messages)>0)
        {
            if ($messages->total() > $messages->perPage())
            {
                $counter=0;
                $links=[];
                for ($i = 0; $i < $messages->lastPage(); $i++)
                {
                    $counter=$i+1;
                    $links["page $counter"]=$messages->url($i + 1);
                }
                $data=
                [
                    'records'=> MessageResource::collection($messages),
                    'pagination links'=>
                    [
                        'current page'=>$messages->currentPage(),
                        'per page'=>$messages->perPage(),
                        'total'=>$messages->total(),
                        'links'=>$links,
                    ],
                ];
            }
            else
            {
                $data=MessageResource::collection($messages);
            }
            return ApiResponse::sendResponse(200,"All Messages",$data);
        }
        return ApiResponse::sendResponse(200,"No Messages yet",[]);
    }
    public function search(Request $request){
        $word=$request->input('search') ?? null;
        $messages=Message::when($word !=null , function($query) use ($word)
        {
            $query->where('message','like','%'. $word . '%');
        })->latest()
        ->get();
        if (count($messages)>0)
        {
            return ApiResponse::sendResponse(200,"Messages",$messages);
        }
        return ApiResponse::sendResponse(200,"Doesn`t match",[]);
    }
    
}
