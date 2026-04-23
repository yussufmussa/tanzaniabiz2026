<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; 

class GeneralSettingController extends Controller
{
    public function index()
    {


        $setting = GeneralSetting::first();

        return view('backend.general_pages.general_settings', compact('setting'));
    }

    public function store(Request $request)
    {


        $generalDir = public_path('uploads/general');
        if (!file_exists($generalDir)) {
            mkdir($generalDir, 0755, true);
        }

        $setting = GeneralSetting::findOrFail($request->id);

        $updatedData = [
            'email' => $request->email,
            'mobile_phone' => $request->mobile_phone,
            'name' => $request->name,
            'location' => $request->location,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'google_business' => $request->google_business,
            'tiktok' => $request->tiktok,
            'telegram' => $request->telegram,
            'getyourguide' => $request->getyourguide,
            'tripadvisor' => $request->tripadvisor,
        ];

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('logo')) {

            $request->validate([
                'logo' => 'image|mimes:png,jpg,jpeg|max:2048',
            ]);

            // Delete old logo
            if (!empty($setting->logo)) {
                File::delete(public_path('uploads/general/' . $setting->logo));
            }

            $newName = Str::uuid() . '.webp';

            $image = $manager->read($request->file('logo'));

            $image->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->toWebp(85)->save(
                public_path('uploads/general/' . $newName)
            );

            $updatedData['logo'] = $newName;
        }


        if ($request->hasFile('favicon')) {

            $request->validate([
                'favicon' => 'image|mimes:png,jpg,jpeg|max:2048',
            ]);

            // Delete old favicon
            if (!empty($setting->favicon)) {
                File::delete(public_path('uploads/general/' . $setting->favicon));
            }

            $newName = Str::uuid() . '.webp';

            $image = $manager->read($request->file('favicon'));

            $image->resize(512, 512, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->toWebp(85)->save(
                public_path('uploads/general/' . $newName)
            );

            $updatedData['favicon'] = $newName;
        }

        if ($request->hasFile('hero_bg')) {

            $request->validate([
                'hero_bg' => 'image|mimes:png,jpg,jpeg|max:2048',
            ]);

            // Delete old hero bg
            if (!empty($setting->hero_bg)) {
                File::delete(public_path('uploads/general/' . $setting->hero_bg));
            }

            $newName = Str::uuid() . '.webp';

            $image = $manager->read($request->file('hero_bg'));

            $image->resize(1920, 1024,  function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->toWebp(85)->save(
                public_path('uploads/general/' . $newName)
            );

            $updatedData['hero_bg'] = $newName;
        }


        $setting->update($updatedData);

        return back()->with(['message' => 'General Information updated succefully']);
    }
}
