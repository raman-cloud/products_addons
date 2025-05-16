<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Products Listing</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        a {
            text-decoration: none !important;
            color: #0d6efd;
        }

        a:hover {
            text-decoration: underline !important;
        }

        .img-thumbnail {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .img-thumbnail:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }

        .pagination {
            justify-content: center;
        }

        .table th a {
            color: #000;
            font-weight: bold;
        }

        .table th a:hover {
            color: #198754;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Product List</h2>
        <a href="{{ url('/products/create') }}" class="btn btn-success">Add New Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($products->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white rounded shadow-sm">
            <thead class="table-light">
                <tr>
                    <th><a href="{{ url('/products') }}?sort=id&dir={{ $sort == 'id' && $dir == 'asc' ? 'desc' : 'asc' }}">ID</a></th>
                    <th><a href="{{ url('/products') }}?sort=title&dir={{ $sort == 'title' && $dir == 'asc' ? 'desc' : 'asc' }}">Title</a></th>
                    <th><a href="{{ url('/products') }}?sort=price&dir={{ $sort == 'price' && $dir == 'asc' ? 'desc' : 'asc' }}">Price</a></th>
                    <th>Image</th>
                    <th>Addons</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->title }}</td>
                    <td>₹{{ number_format($product->price, 2) }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" width="60" alt="Product Image" class="img-thumbnail" />
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>
                        @if($product->have_addon && $product->addons->count() > 0)
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $product->addons->count() }} Addon{{ $product->addons->count() > 1 ? 's' : '' }}
                                </button>
                                <ul class="dropdown-menu p-3" style="min-width: 300px;">
                                    @foreach($product->addons as $addon)
                                        <li><strong>{{ $addon->title }}</strong> — ₹{{ number_format($addon->price, 2) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <span class="text-muted">No Addons</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Centered -->
    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

    @else
        <div class="alert alert-info text-center">No products found.</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
