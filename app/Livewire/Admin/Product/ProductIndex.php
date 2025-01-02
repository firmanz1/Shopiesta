<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Shop\Entities\Product;
use Illuminate\Support\Str;
use Modules\Shop\Entities\Category;

class ProductIndex extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $product_name, $price, $category_id , $status, $slug, $type, $productId, $perPage = 10, $search;

    public function render()
    {
        $categories = Category::all(); //ngambilin data dari tabel category di database
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.product.product-index', compact('products', 'categories'));
    }

    public function openModalForNewProduct()
    {
        $this->resetInputFields();
        $this->showModal = true;
        $this->editMode = false;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->showModal = false;
    }

    public function saveProduct()
    {
        $this->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'status' => 'required|string',
            'category_id' => 'required|uuid|exists:shop_categories,id',
        ]);

        // Simpan produk baru
        $product = Product::create([
            'name' => $this->product_name,
            'price' => $this->price,
            'user_id' => auth()->id(), // Pastikan pengguna login
            'sku' => strtoupper(Str::random(8)), // Contoh SKU unik
            'type' => $this->type,
            'slug' => Str::slug($this->product_name, '-'),
            'status' => 'Active',
        ]);

        // Simpan relasi produk dengan kategori
        $product->categories()->attach($this->category_id);

        session()->flash('success', 'New product created successfully!');
        $this->closeModal();
        $this->resetInputFields();
    }



    public function editProduct($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->product_name = $product->name;
        $this->price = $product->price;

        $this->showModal = true;
        $this->editMode = true;
    }

    public function updateProduct()
    {
        $this->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($this->id);
        $product->update([
            'name' => $this->product_name,
            'price' => $this->price,
        ]);

        session()->flash('success', 'Product updated successfully!');
        $this->closeModal();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted successfully!');
    }

    private function resetInputFields()
    {
        $this->product_name = null;
        $this->price = null;
        $this->productId = null;
        $this->editMode = false;
    }
    public function changePerPage($value)
    {
        $this->perPage = (int) $value;
        $this->perPage = is_numeric($value) && $value > 0 ? (int) $value : 10; // Default 10 jika input tidak valid
    }
}
