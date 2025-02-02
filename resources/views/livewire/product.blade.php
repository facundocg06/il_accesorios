<div>
    <div class="app-ecommerce">

        <!-- Add Product -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">{{ $product_id ? 'Actualizar Producto' : 'Registrar un Nuevo Producto' }}</h4>
                <p class="text-muted">CAMBIAR TEXTO AQUI</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <button class="btn btn-label-primary">Cancelar</button>
            </div>
            <button wire:click="submit" class="btn btn-primary">
                {{ $product_id ? 'Actualizar Producto' : 'Crear Producto' }}
            </button>
        </div>

    </div>

    <div class="row">

        <!-- First column-->
        <div class="col-12 col-lg-8">
            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="name">Titulo</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            wire:model="name" placeholder="Product title" aria-label="Titulo del Producto" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                for="category_id">
                                <span>Categoría</span>
                            </label>
                            <select id="category_id" wire:model="category_id"
                                class="select2 form-select @error('category_id') is-invalid @enderror"
                                data-placeholder="Seleccionar Categoría">
                                <option value="">Seleccionar Categoría</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Marca -->
                        <div class="col-md-6">
                            <label class="form-label mb-1" for="brand_id">Marca</label>
                            <select id="brand_id" wire:model="brand_id"
                                class="select2 form-select @error('brand_id') is-invalid @enderror"
                                data-placeholder="Seleccionar Marca">
                                <option value="">Seleccionar Marca</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description"
                            rows="3" placeholder="Escribe aquí..."></textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- /Product Information -->
        </div>
        <!-- /First column -->

        <!-- Second column -->
        <div class="col-12 col-lg-4">
            <!-- Pricing Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Precio Producto</h5>
                </div>
                <div class="card-body">
                    <!-- Base Price -->
                    <div class="mb-3">
                        <label class="form-label" for="price">Precio de Venta</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            wire:model="price" placeholder="Precio" aria-label="Precio del Producto">
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="barcode">Barcode</label>
                        <input type="number" class="form-control @error('barcode') is-invalid @enderror" id="barcode"
                            wire:model="barcode" placeholder="Código de Producto" aria-label="Código de Producto">
                        @error('barcode')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Instock switch -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <h6 class="mb-0">En stock</h6>
                        <div class="w-25 d-flex justify-content-end">
                            <label class="switch switch-primary switch-sm me-4 pe-2">
                                <input type="checkbox" class="switch-input" checked="">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">
                                        <span class="switch-off"></span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Pricing Card -->
        </div>
        <!-- /Second column -->
    </div>



    <!-- Media -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 card-title">Fotos y/o Videos del Producto</h5>
        </div>
        <div class="card-body">
            <div class="dropzone needsclick" id="dropzone-basic">
                <div class="dz-message needsclick">
                    <p class="fs-4 note needsclick pt-3 mb-1">Arrastra y suelta tus imágenes aquí</p>
                    <p class="text-muted d-block fw-normal mb-2">o</p>
                    <span class="note needsclick btn bg-label-primary d-inline" id="btnBrowse">Buscar imagen</span>
                </div>
                <div class="fallback">
                    <input type="file" class="form-control @error('files') is-invalid @enderror" wire:model="files" multiple>
                </div>
            </div>
            @error('files') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>
    <!-- /Media -->

</div>