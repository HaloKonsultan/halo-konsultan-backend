<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Xendit\Xendit;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'createDisbursement'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'getTransanction',
            'createInvoice'
        ]]);
    }

    public function update($id) {
        $data = Consultation::findOrFail($id);
        if(Gate::denies('user-consultation', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->status = "active";
        $data->save();
        return response()->json([
            'data' => $data,
            'message' => 'data updated'
        ],200);
    }

    public function end($id) {
        $data = Consultation::findOrFail($id);
        if(auth('consultants-api')->user()->cannot('update', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->status = "done";
        $data->save();
        return response()->json([
            'data' => $data,
            'message' => 'data updated'
        ],200);
    }

    public function createInvoice(Request $request, $id) {
        Xendit::setApiKey(env('XENDIT_KEY'));
        $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $data = Consultation::findOrFail($id);
        $external_id = 'HK#'.$data->id.'#'.$data->consultant_id.'#'.$data->user_id.'#'.Str::random(15);
        $params = [
            'external_id' => $external_id,
            'amount' => $request->amount,
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        $newTransaction = new Transaction();
        $newTransaction->external_id = $external_id;
        $newTransaction->amount = $request->amount;
        $newTransaction->status_invoice = $createInvoice["status"];
        $newTransaction->invoice_url = $createInvoice["invoice_url"];
        $newTransaction->expiry_date = $createInvoice["expiry_date"];
        $newTransaction->consultation_id = $id;
        $newTransaction->save();
        return response()->json([
            'code' => 201,
            'data' => $newTransaction,
            'message' => 'created'
        ],200);
    }

    public function invoiceCallback(Request $request) {
        $transcation = Transaction::where('external_id', $request->external_id)->first();
        $transcation->status_invoice = $request->status;
        $transcation->save();
        $consultationUpdate = Consultation::findOrFail($transcation->consultation_id);
        $consultationUpdate->status = "active";
        $consultationUpdate->save();
        return response()->json([
            'code' => 200,
            'message' => 'Masuk bro'
        ], 200);
    }

    public function getTransanction($id) {
        try {
            $data = Transaction::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => $data
            ],200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function createDisbursement(Request $request, $id) {
        Xendit::setApiKey(env('XENDIT_KEY'));
        $request->validate([
            'bank_code' => ['string'],
            'account_holder_name' => ['string'],
            'account_number' => ['string']
        ]);

        $transaction = Transaction::where('consultation_id', $id)->first();
        $amount = (int)$transaction->amount * 0.9;
        $params = [
            'external_id' => $transaction->external_id,
            'amount' => $amount,
            'bank_code' => $request->bank_code,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'description' => Str::random(10)
        ];

        $createDisbursements = \Xendit\Disbursements::create($params);
        $transaction->bank_code = $createDisbursements["bank_code"];
        $transaction->status_disbursment = $createDisbursements["status"];
        $transaction->account_holder_name = $createDisbursements["account_holder_name"];
        $transaction->account_number = $request->account_number;
        $transaction->save();
        return response()->json([
            'code' => 201,
            'data' => new TransactionResource($transaction)
        ], 201);
    }

    public function disbursmentCallback(Request $request) {
        $transaction = Transaction::where('external_id', $request->external_id)->first();
        $transaction->status_disbursment = $request->status;
        $transaction->save();
        return response()->json([
            'code' => 200,
            'data' => $transaction
        ], 200);
    }
}
