<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\ExportSubCategory;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SubcategoryController extends Controller
{
     public function index()
    {


        return view('backend.business.subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.business.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:sub_categories,id',
            'photo' => 'nullable|mimes:png,jpg,webp,svg|max:2048',
            'name' => 'required|unique:sub_categories|max:255',
        ]);

        $newPhotoName = null;
        if ($request->hasFile('photo')) {

              $thumbnailsDir = public_path('uploads/SubCategoryPhotos');
            if (!file_exists($thumbnailsDir)) {
                mkdir($thumbnailsDir, 0755, true);
            }

            $newPhotoName = Str::uuid() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/SubCategoryPhotos/'), $newPhotoName);
        }

        SubCategory::create([
            'photo' => $newPhotoName,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('subcategories.index')->with(['message' => 'Sub Category Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::active()
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.business.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {

        $request->validate([
            'category_id' => 'required|exists:sub_categories,id',
            'photo' => 'nullable|mimes:png,jpg,webp,svg|max:2048',
            'name' => 'required|max:255|unique:sub_categories,name,' . $subcategory->id,
        ]);

        if ($request->hasFile('photo')) {

            if($subcategory->photo && File::exists('uploads/SubCategoryPhotos/' . $subcategory->photo)){
            $photoPath = public_path() . '/uploads/SubCategoryPhotos/' . $subcategory->photo;
            File::delete($photoPath);
            }

            $newPhotoName = Str::uuid() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/SubCategoryPhotos/'), $newPhotoName);

            $subcategory->photo = $newPhotoName;
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'photo' => $subcategory->photo,
        ]);

        return redirect()->route('subcategories.index')->with(['message' => 'Sub Category Updated Successfully']);
    }

   public function export(Request $request)
    {
        $format = $request->get('format', 'excel');

        $subcategories = SubCategory::query()
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
            $totalRecords = $subcategories->count();

            $pdf = Pdf::loadView('backend.business.subcategories.export_pdf', compact('subcategories', 'generatedAt', 'totalRecords'));
            
            return $pdf->download('subcategories_' . date('Y_m_d') . '.pdf');
        }

        return Excel::download(new ExportSubCategory($subcategories), 'subcategories_' . date('Y_m_d') . '.xlsx');
    }

    public function destroy(SubCategory $subcategory)
    {

        if($subcategory->photo && File::exists('uploads/SubCategoryPhotos/' . $subcategory->photo)){
            $photoPath = public_path() . '/uploads/SubCategoryPhotos/' . $subcategory->photo;
            File::delete($photoPath);
        }

        $subcategory->delete();

        return redirect()->route('subcategories.index')->with(['message' => 'Sub Category  Deleted Successfully']);
    }
}
