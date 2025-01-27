<div>
    <div class="app-ecommerce">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Registrar Compra</h4>
            </div>
            <div class="d-flex align-items-center justify-content-end gap-3">
                <button class="btn btn-label-primary">Cancelar</button>
                <button wire:click="submit" class="btn btn-primary">
                    Crear Producto
                </button>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- One column -->
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Factura</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="nit_supplier">Nit Proveedor</label>
                        <input type="number" class="form-control @error('nit_supplier') is-invalid @enderror"
                            wire:model="nit_supplier" placeholder="Código de Producto"
                            aria-label="Código de Producto">
                        @error('nit_supplier')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="reason_social">Proveedor</label>
                        <input type="text" class="form-control" id="reason_social" wire:model="reason_social" placeholder="Nombre Del Proveedor"
                            aria-label="Nombre del Proveedor" readonly>
                    </div>
                    <!-- Base Price -->
                    <div class="mb-3">
                        <label class="form-label" for="purchase_date">Fecha</label>
                        <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                            id="purchase_date" wire:model="purchase_date" placeholder="Fecha" aria-label="Fecha">
                        @error('purchase_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- monto total --}}
                    <div class="mb-3">
                        <label class="form-label" for="total_quantity">Monto Total</label>
                        <input type="number" class="form-control @error('total_quantity') is-invalid @enderror"
                            id="total_quantity" wire:model="total_quantity" placeholder="Monto Total"
                            aria-label="Monto Total">
                        @error('total_quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
            </div>
        </div>
        <!-- /one column -->

        <!-- Second column-->
        <div class="col-12 col-lg-8">

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
                        <div class="col-md-6">
                            <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                for="category_id">
                                <span>Categoría</span>
                            </label>
                            <select id="category_id" wire:model="category_id"
                                class="select2 form-select @error('category_id') is-invalid @enderror"
                                data-placeholder="Seleccionar Categoría">
                                <option value="">Seleccionar Categoría</option>

                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1" for="brand_id">Marca</label>
                            <select id="brand_id" wire:model="brand_id"
                                class="select2 form-select @error('brand_id') is-invalid @enderror"
                                data-placeholder="Seleccionar Marca">
                                <option value="">Seleccionar Marca</option>

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
        </div>
    </div>


</div>


