<?php

namespace App\Http\Controllers;

use App\Http\Resources\MerchantColection;
use App\Models\Merchants;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = DB::table('merchants')->get();

        return MerchantColection::collection($merchants);
    }

    public function addMerchant(Request $request)
    {
        $merchant = new Merchants;
        $merchant->nama = $request->nama;
        $merchant->deskripsi = $request->deskripsi;
        $merchant->image = $request->image;
        $merchant->latitude = $request->latitude;
        $merchant->longitude = $request->longitude;
        $merchant->save();

        return response()->json([
            "message" => "Merchant Di tambahkan"
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $merchant = DB::table('merchants')->where('id', $id)->first();

        if ($merchant) {
            $affected = DB::table('merchants')
                ->where('id', $id)
                ->update(
                    [
                        'nama' => is_null($request->nama) ? $merchant->nama : $request->nama,
                        'deskripsi' => is_null($request->deskripsi) ? $merchant->deskripsi : $request->deskripsi,
                        'image' => is_null($request->image) ? $merchant->image : $request->image,
                        'latitude' => is_null($request->latitude) ? $merchant->latitude : $request->latitude,
                        'longitude' => is_null($request->longitude) ? $merchant->longitude : $request->longitude
                    ]
                );

            return response()->json([
                "message" => "Merchant Di Update"
            ], 200);
        } else {
            return response()->json([
                "message" => "Merchant tidak ditemukan"
            ], 402);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $imageName = 'merchant_' . $request->merchant_id . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // return $request->image;

        return response()->json([
            "data" => [
                "image_name" => $imageName,
                "message" => "berhasil di unggah",
            ]
        ], 200);
    }


    public function ongkir(Request $request)
    {
        $merchant = DB::table('merchants')->where('id', $request->merchant_id)->first();
        $mlatitude = $merchant->latitude;
        $mlongitude = $merchant->longitude;

        // Replace 'YOUR_API_KEY' with your OpenWeather API key
        $apiKey = 'AIzaSyB1kT5Kf-JiXJtg4taoWOZ5WuvqPertrjg';

        // Create a new Guzzle client instance
        $client = new Client();
        $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations={$request->latitude},{$request->longitude}&origins={$mlatitude},{$mlongitude}&key={$apiKey}";

        try {
            // Make a GET request to the OpenWeather API
            $response = $client->get($apiUrl);

            // Get the response body as an array
            $data = json_decode($response->getBody(), true);

            $distance = $data['rows'][0]['elements'][0]['distance']['value'];
            $fee = 2000;
            $biaya_antar = 10000;
            $distance_min = 4000;
            $price_km = 2000;

            if ($distance > $distance_min) {
                $distance_diff = round(($distance - $distance_min) / 1000, 0);
                $biaya_antar = $biaya_antar + ($distance_diff * $price_km);
            }

            return response()->json([
                "data" => [
                    "jarak" => round($distance / 1000, 1),
                    "biaya antar" => $biaya_antar,
                    "fee" => $fee
                ]
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return response()->json([
                "message" => "Tidak ditemukan"
            ], 204);
        }
    }
}
