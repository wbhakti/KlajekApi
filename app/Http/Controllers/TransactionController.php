<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailTransactionColection;
use App\Http\Resources\TransactionColection;
use App\Models\Customer;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $customer = new Customer();
        $customer->full_name = $request->full_name;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->save();
        $cutomer_id = $customer->id;

        $transaction = new Transaction();
        $transaction->customer_id = $cutomer_id;
        $transaction->merchant_id = $request->merchant_id;
        $transaction->total = $request->total;
        $transaction->ongkir = $request->ongkir;
        $transaction->fee = $request->fee;
        $transaction->save();
        $transaction_id = $transaction->id;

        $detailTransaction = new DetailTransaction;
        foreach ($request->details as $detail) {
            $detailTransaction = new DetailTransaction;
            $detailTransaction->transaction_id = $transaction_id;
            $detailTransaction->menu_id = $detail['menu_id'];
            $detailTransaction->note = $detail['note'];

            $detailTransaction->save();
        }

        return response()->json([
            "message" => "Order berhasil ditambahkan"
        ], 201);
    }

    public function order($transaction_id)
    {
        $data = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('merchants', 'transactions.merchant_id', '=', 'merchants.id')
            ->select('transactions.*', 'customers.full_name', 'customers.phone_number', 'merchants.nama  AS merchant_name', 'customers.phone_number')
            ->where('transactions.id', '=', $transaction_id)->get();

        if ($data) {
            return TransactionColection::collection($data);
        } else {
            return response()->json([
                "message" => "Order Tidak ditemukan"
            ], 204);
        }
    }

    public function orderAll()
    {
        $data = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('merchants', 'transactions.merchant_id', '=', 'merchants.id')
            ->select('transactions.*', 'customers.full_name', 'customers.phone_number', 'merchants.nama  AS merchant_name', 'customers.phone_number')
            ->get();

        if ($data) {
            return TransactionColection::collection($data);
        } else {
            return response()->json([
                "message" => "Order Tidak ditemukan"
            ], 204);
        }
    }

    public function orderDetail($transaction_id)
    {
        $data = DB::table('detail_transactions')
            ->join('menus', 'detail_transactions.menu_id', '=', 'menus.id')
            ->select('detail_transactions.*', 'menus.*')
            ->where('detail_transactions.transaction_id', '=', $transaction_id)
            ->get();

        if ($data) {
            return DetailTransactionColection::collection($data);
        } else {
            return response()->json([
                "message" => "Detail Order Tidak ditemukan"
            ], 204);
        }
    }
}
