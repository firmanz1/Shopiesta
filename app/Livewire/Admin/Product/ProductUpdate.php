<?php

namespace App\Livewire\Admin\Product;

use App\Models\ShopProduct;
use Livewire\WithFileUploads;
use Livewire\Component;
use Modules\Shop\Entities\Product;
//use Modules\Shop\Entities\Product;

use Illuminate\Http\Request;

class ProductUpdate extends Component
{
    use WithFileUploads;

    public $product; // Menyimpan data produk
    public $sku, $name, $price, $status, $stock_status, $description;
    public $featured_image;

    // Mengambil data produk berdasarkan ID yang diberikan
    public function mount($id)
    {
        $this->product = Product::findOrFail($id);

        // Mengisi field dengan data produk
        $this->sku = $this->product->sku;
        $this->name = $this->product->name;
        $this->price = $this->product->price;
        $this->status = $this->product->status;
        $this->stock_status = $this->product->stock_status;
        $this->description = $this->product->body;
        $this->featured_image = $this->product->featured_image; // Mengambil data gambar yang sudah ada
    }

    // Fungsi untuk menyimpan perubahan
    public function updateProduct()
    {
        $this->validate([
            'sku' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'stock_status' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Mengunggah gambar jika ada
        if ($this->featured_image) {
            // Pindahkan file gambar ke storage folder yang benar
            $imagePath = $this->featured_image->store('product_images', 'public');
        } else {
            // Gunakan gambar lama jika tidak ada gambar baru
            $imagePath = $this->product->featured_image;
        }

        // Update produk
        $this->product->update([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'status' => $this->status,
            'stock_status' => $this->stock_status,
            'featured_image' => $imagePath, // Menyimpan path gambar terbaru
            'body' => $this->description,
        ]);

        // Pesan sukses
        session()->flash('success', 'Berhasil memperbarui produk.');

        // Kembali ke halaman index atau halaman lainnya
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.product.product-update');
    }
}
