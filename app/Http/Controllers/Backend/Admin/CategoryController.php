<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\CategoryExport;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
     public function index()
    {

        return view('backend.business.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backend.business.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'icon' => 'nullable|mimes:png,jpg,webp,svg|max:2048',
        ]);

        $newPhotoName = null;
        if ($request->hasFile('icon')) {

            $thumbnailsDir = public_path('uploads/categoryPhotos');
            if (!file_exists($thumbnailsDir)) {
                mkdir($thumbnailsDir, 0755, true);
            }

            $newPhotoName = Str::uuid() . '.' . $request->photo->extension();
            $request->icon->move(public_path('uploads/categoryPhotos/'), $newPhotoName);

        }


        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $newPhotoName,
        ]);

        return redirect()->route('categories.index')->with(['message' => 'Category Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('backend.business.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'icon' => 'nullable|mimes:png,jpg,webp,svg|max:2048',
        ]);


        if ($request->hasFile('icon')) {

            if ($category->photo && File::exists('uploads/categoryPhotos/' . $category->photo)) {
                $photoPath = public_path() . '/uploads/categoryPhotos/' . $category->photo;
                File::delete($photoPath);
            }

            $newPhotoName = Str::uuid() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/categoryPhotos/'), $newPhotoName);

            $category->photo = $newPhotoName;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $category->icon,
        ]);

        return redirect()->route('categories.index')->with(['message' => 'Category Updated Successfully']);
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');

        $categories = Category::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->statusFilter && $request->statusFilter !== 'all', function ($query) use ($request) {
                $query->where('is_active', $request->statusFilter === 'active' ? 1 : 0);
            })
            ->when($request->productFilter === 'with_products', function ($query) {
                $query->has('business_listings');
            })
            ->when($request->productFilter === 'without_products', function ($query) {
                $query->doesntHave('business_listings');
            })
            ->orderBy('name', 'asc')
            ->withCount('business_listings')
            ->get();

        if ($format === 'pdf') {
            $generatedAt = now();
            $totalRecords = $categories->count();

            $pdf = Pdf::loadView('backend.business.categories.export_pdf', compact('categories', 'generatedAt', 'totalRecords'));
            
            return $pdf->download('categories_' . date('Y_m_d') . '.pdf');
        }

        return Excel::download(new CategoryExport($categories), 'categories_' . date('Y_m_d') . '.xlsx');
    }

    public function destroy(Category $category)
    {

         if ($category->photo && File::exists('uploads/categoryPhotos/' . $category->photo)) {
                $photoPath = public_path() . '/uploads/categoryPhotos/' . $category->photo;
                File::delete($photoPath);
        }
        $category->delete();

        return redirect()->route('categories.index')->with(['message' => 'Category deleted succefully']);
    }

     public function getSubCategories(Request $request){
        $category = Category::find($request->id);
        $subcategories = $category->subcategories;

        return  response()->json($subcategories);
    }

    
}
