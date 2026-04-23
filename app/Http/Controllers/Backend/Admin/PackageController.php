<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business\Feature;
use App\Models\Business\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['packageFeatures.feature'])
                            ->orderBy('sort_order')
                            ->orderBy('name')
                            ->paginate(10);

        return view('backend.business.packages.index', compact('packages'));
    }

    public function create()
    {
        $features = Feature::where('is_active', true)
                    ->orderBy('category')
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();

        return view('backend.business.packages.create', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:packages',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_period' => 'required|in:monthly,yearly,lifetime',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        $package = Package::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'billing_period' => $validated['billing_period'],
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        // Attach features
        if (!empty($validated['features'])) {
            foreach ($validated['features'] as $featureId => $value) {
                if (!empty($value)) {
                    $package->packageFeatures()->create([
                        'feature_id' => $featureId,
                        'value' => $value,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    public function edit(Package $package)
    {
        $features = Feature::where('is_active', true)
                        ->orderBy('category')
                        ->orderBy('sort_order')
                        ->orderBy('name')
                        ->get();

        $package->load('packageFeatures.feature');

        return view('backend.business.packages.edit', compact('package', 'features'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:packages,slug,' . $package->id,
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_period' => 'required|in:monthly,yearly,lifetime',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        // Update package
        $package->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'billing_period' => $validated['billing_period'],
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        // Sync features - delete old ones and create new ones
        $package->packageFeatures()->delete();

        if (!empty($validated['features'])) {
            foreach ($validated['features'] as $featureId => $value) {
                if (!empty($value)) {
                    $package->packageFeatures()->create([
                        'feature_id' => $featureId,
                        'value' => $value,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }
}

