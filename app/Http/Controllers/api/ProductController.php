<?php

namespace App\Http\Controllers\Api; // Pastikan namespace sesuai dengan penamaan direktori Anda
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'nama_product' => 'required|unique:product',
            'deskripsi' => 'required',
            'harga_product' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Simpan data lapak ke dalam basis data
        $product = new Product([
            'nama_product' => $request->input('nama_product'),
            'deskripsi' => $request->input('deskripsi'),
            'harga_product' => $request->input('harga_product'),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/product_images', $imageName);
            $product->image = $imageName;
        }

        $product->save();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data product berhasil disimpan'], 201);
    }

    public function getProduct()
    {
        $product = Product::all();

        // Mengubah data yang dikembalikan
        $productData = $product->map(function ($product) {
            return [
                'id' => $product->id,
                'nama_product' => $product->nama_product,
                'deskripsi' => $product->area,
                'harga_product' => $product->harga_product,
                'image' => asset('storage/product_images/' . $product->image), // Mengembalikan URL gambar
            ];
        });

        // Kembalikan data lapak dalam format JSON
        return response()->json($productData, 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Data product tidak ditemukan'], 404);
        }

        // Validasi hanya bidang-bidang tertentu yang diizinkan diubah
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'harga_barang' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product->deskripsi = $request->input('deskripsi');
        $product->harga_barang = $request->input('harga_barang');
        $product->save();

        return response()->json(['message' => 'Data product berhasil diperbarui'], 200);
    }


    public function deleteProduct($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Data product tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Data product berhasil dihapus'], 200);
    }
}
