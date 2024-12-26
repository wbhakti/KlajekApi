<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuColection;
use App\Models\Category;
use App\Models\Menus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menu($merchant_id)
    {
        $menus = DB::table('menus')
            ->join('categories', 'menus.kategori', '=', 'categories.id')
            ->select('menus.*', 'categories.nama AS kategori', 'categories.id AS id_kategori')
            ->where('menus.merchant_id', '=', $merchant_id)->get();

        if ($menus) {
            return MenuColection::collection($menus);
        } else {
            return response()->json([
                "message" => "Menu Tidak ditemukan"
            ], 204);
        }
    }

    public function addMenu(Request $request)
    {
        DB::table('menus')->insert([
            'sku' => $request->sku,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'image' => $request->image,
            'kategori' => $request->kategori,
            'merchant_id' => $request->merchant_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return response()->json([
            "message" => "Menu Di tambahkan"
        ], 201);
    }

    public function category()
    {
        $merchants = DB::table('categories')->get();
        return response()->json($merchants);
    }

    public function addCategory(Request $request)
    {
        DB::table('categories')->insert([
            'nama' => $request->nama,
            'merchant_id' => $request->merchant_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return response()->json([
            "message" => "Kategori Di tambahkan"
        ], 201);
    }
}
