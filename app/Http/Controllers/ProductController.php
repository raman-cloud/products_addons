<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AddonMenu;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show the product creation form
    public function create()
    {
        return view('products.create');
    }

    // Display the list of products
    public function index(Request $request)
    {
        $sortable = ['id', 'title', 'price'];
        $sort = $request->get('sort', 'id');
        $dir = $request->get('dir', 'asc');

        if (!in_array($sort, $sortable)) $sort = 'id';
        if (!in_array($dir, ['asc', 'desc'])) $dir = 'asc';

        $products = Product::with('addons')
                    ->orderBy($sort, $dir)
                    ->paginate(5)
                    ->appends(['sort' => $sort, 'dir' => $dir]);

        return view('products.index', compact('products', 'sort', 'dir'));
    }


    // Handle the form submission and store the product (and its addons)
    public function store(Request $request)
    {
        // Filter out empty addons
        $filteredAddons = [];
        if ($request->has('addons')) {
            foreach ($request->addons as $addon) {
                if (!empty($addon['title']) || !empty($addon['price'])) {
                    $filteredAddons[] = $addon;
                }
            }
        }
        $request->merge(['addons' => $filteredAddons]);

        // Validate
        $validatedData = $request->validate([
            'title'            => 'required|string',
            'description'      => 'required|string',
            'price'            => 'required|numeric',
            'image'            => 'nullable|image',
            'addons.*.title'   => 'required_if:have_addon,on|string',
            'addons.*.price'   => 'required_if:have_addon,on|numeric'
        ]);

        // Store the product
        $product = new Product();
        $product->title       = $request->input('title');
        $product->description = $request->input('description');
        $product->price       = $request->input('price');
        $product->have_addon  = $request->has('have_addon');

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $filename);
            $product->image = 'uploads/' . $filename;
        }

        $product->save();

        // Save addons
        if ($product->have_addon && $request->has('addons')) {
            foreach ($request->addons as $addon) {
                AddonMenu::create([
                    'product_id' => $product->id,
                    'title'      => $addon['title'],
                    'price'      => $addon['price']
                ]);
            }
        }

        return redirect('/products')->with('success', 'Product created successfully!');
    }
}
