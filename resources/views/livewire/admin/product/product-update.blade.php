<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form wire:submit.prevent="updateProduct">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" id="sku" wire:model="sku" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis</label>
                            <input type="text" id="type" wire:model="type" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" wire:model="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" id="price" wire:model="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">diskon</label>
                            <input type="number" id="sale_price" wire:model="sale_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" wire:model="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stock_status" class="form-label">Stock Status</label>
                            <select id="stock_status" wire:model="stock_status" class="form-control" required>
                                <option value="IN_STOCK">In Stock</option>
                                <option value="OUT_OF_STOCK">Out of Stock</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Upload Gambar</label>
                            <input type="file" id="featured_image" wire:model="featured_image" class="form-control">
                            @if ($this->featured_image && $this->featured_image instanceof \Livewire\TemporaryUploadedFile)
                            <img src="{{ $this->featured_image->temporaryUrl() }}" alt="{{ $this->product->name }}">
                        @elseif ($this->product->featured_image)
                            <img src="{{ asset('storage/' . $this->product->featured_image) }}" alt="{{ $this->product->name }}">
                        @endif
                        </div>                        
                        <div class="mb-3">
                            <label for="kutipan" class="form-label">Kutipan </label>
                            <textarea id="kutipan" wire:model="kutipan" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" wire:model="description" class="form-control"></textarea>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
