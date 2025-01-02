<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Products
                    </div>
                    <h2 class="page-title">
                        List of Products
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" wire:click="openModalForNewProduct" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            New Product
                        </a>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                         <input type="number" wire:model.defer="perPage" wire:change="changePerPage($event.target.value)" class="form-control form-control-sm" size="3" aria-label="Entries per page" style="width: 50px">
                                    </div>
                                    entries
                                </div>
                                <div class="ms-auto text-secondary">
                                    Search:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" wire:model.live="search" class="form-control form-control-sm" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-3">
                            @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Stock</th>
                                        <th>SKU</th>
                                        <th>Jenis</th>
                                        <th>Nama Product</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Stock</th>
                                        <th>Stock status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <span class="avatar me-3" style="background-image: url('{{ asset('storage/' . $product->featured_image) }}')"></span>
                                        </td>
                                        
                                        <td>
                                            {{ $product->manage_stock }}
                                        </td>
                                        <td>
                                            {{ $product->sku }}
                                        </td>
                                        <td>
                                            {{ $product->type }}
                                        </td>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            {{ $product->price }}
                                        </td>
                                        <td>
                                            {{ $product->sale_price }}
                                        </td>
                                        <td>
                                            {{ $product->status }}
                                        </td>
                                        <td>
                                            {{ $product->stock_status }}
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-outline-primary btn-sm btn-pill w-20" href="{{ route('admin.products.update', [$product->id]) }}"> Edit </a>
                                            <a wire:click="delete('{{ $product->id }}')" wire:confirm="Yakin bg?" class="btn btn-outline-danger btn-sm btn-pill w-20" href="#"><span class="danger"> Delete </span></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3">
                                            Product is empty.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between px-3 py-2">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>                                               
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <!-- Product Modal -->
        @if ($showModal)
            <div class="modal modal-blur fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $editMode ? 'Update' : 'New' }} Product</h5>
                            <button type="button" wire:click="closeModal" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" wire:model.defer="product_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" wire:model.defer="price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" wire:model="category_id" class="form-control">
                                    <option value="">-- Pilih Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" wire:model.defer="type" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" wire:model="status" class="form-control" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            @if ($editMode)
                                <button type="button" wire:click="updateProduct" class="btn btn-primary">Update</button>
                            @else
                                <button type="button" wire:click="saveProduct" class="btn btn-primary">Save</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>    
</div>