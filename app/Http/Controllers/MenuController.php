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
            ->where('menus.merchant_id', '=', $merchant_id)
            ->where('is_delete', false)->get();

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

    public function updateMenu(Request $request, $id)
    {
        $merchant = DB::table('menus')->where('id', $id)->first();

        if ($merchant) {
            $affected = DB::table('menus')
                ->where('id', $id)
                ->update(
                    [
                        'sku' => is_null($request->sku) ? $merchant->sku : $request->sku,
                        'nama' => is_null($request->nama) ? $merchant->nama : $request->nama,
                        'harga' => is_null($request->harga) ? $merchant->harga : $request->harga,
                        'image' => is_null($request->image) ? $merchant->image : $request->image,
                        'kategori' => is_null($request->kategori) ? $merchant->kategori : $request->kategori
                    ]
                );
            return response()->json([
                "message" => "Menu berhasil diupdate"
            ], 200);
        } else {
            return response()->json([
                "message" => "Menu tidak ditemukan"
            ], 201);
        }
    }

    public function deleteMenu(Request $request)
    {
        $merchant = DB::table('menus')->where('id', $request->id)->first();

        if ($merchant) {
            $affected = DB::table('menus')
                ->where('id', $request->id)
                ->update(
                    [
                        'is_delete' => true,
                    ]
                );
            return response()->json([
                "message" => "Menu berhasil dihapus"
            ], 200);
        } else {
            return response()->json([
                "message" => "Menu tidak dihapus"
            ], 201);
        }
    }

    public function category($merchant_id)
    {
        $merchants = DB::table('categories')
            ->where('merchant_id', '=', $merchant_id)
            ->get();
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

    public function uploadMenu(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required',
            'sku' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $imageName = $request->merchant_id . '_' . $request->sku . '.' . $request->image->extension();
        $request->image->move(public_path('images/menus/' . $request->merchant_id), $imageName);

        return response()->json([
            "data" => [
                "image_name" => $imageName,
                "message" => "Foto menu berhasil di unggah",
            ]
        ], 200);
    }
}
