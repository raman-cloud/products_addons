<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .addon-group .form-control {
            min-width: 150px;
        }

        .btn-add-addon {
            background-color: #e9ecef;
            color: #333;
            border: 2px solid #ced4da;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .btn-add-addon:hover {
            background-color: #198754;
            color: #fff;
            border-color: #198754;
            transform: translateY(-1px) scale(1.03);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #dee2e6;
            border: 2px solid #adb5bd;
            border-radius: 6px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 4px;
        }

        /* Checked state */
        .switch input:checked + .slider {
            background-color: #198754;
            border-color: #198754;
        }

        .switch input:checked + .slider:before {
            transform: translateX(28px);
        }

    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center">Add New Product</h3>

                    <!-- Validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/products" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Product Title" value="{{ old('title') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Product Description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" name="price" step="0.01" class="form-control" placeholder="Enter price" value="{{ old('price') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="have_addon" class="form-label d-block">Has Addons?</label>
                            <label class="switch">
                                <input type="checkbox" id="have_addon" name="have_addon" {{ old('have_addon') ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>


                        <!-- Addons Section -->
                        <div id="addons-section" style="{{ old('have_addon') ? '' : 'display: none;' }}">
                            <h5 class="mb-3">Addons</h5>
                            <div id="addon-container"></div>
                           <button type="button" class="btn btn-add-addon mb-3" onclick="addAddon()">+ Add Addon</button>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/custom.js"></script>
</body>
</html>
