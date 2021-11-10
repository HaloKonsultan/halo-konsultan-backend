<?php

namespace App\Http\Controllers;

use App\ConsultantVirtualAccount;
use Illuminate\Http\Request;

class ConsultantVirtualAccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api');
    }
    
    public function destroy($id) {
        $data = ConsultantVirtualAccount::findOrFail($id);
        $data->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Data deleted'
        ], 200);
    }
}
