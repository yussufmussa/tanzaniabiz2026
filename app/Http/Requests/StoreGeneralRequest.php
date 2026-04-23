<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255|unique:business_listings,name',
            'logo'            => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description'     => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'youtube_video_link' => 'nullable|max:255',
            'website'         => 'nullable|url|max:255',
            'category_id'     => 'required|exists:categories,id',
            'subcategory_id'  => 'required|exists:sub_categories,id',
            'city_id'         => 'required|exists:cities,id',
            'location'        => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => 'Listing name is required.',
            'name.unique' => 'Listing name already exists.',

            'logo.required' => 'Please upload a logo.',
            'logo.image'    => 'The logo must be an image file.',
            'logo.mimes'    => 'Logo must be a PNG, JPG, JPEG, or WEBP file.',
            'logo.max'      => 'Logo size must not exceed 2MB.',

            'category_id.exists' => 'Please select a valid category.',
            'subcategory_id.exists' => 'Please select a valid subcategory.',
            'city_id.exists' => 'Please select a valid city.',

            'description.required' => 'Please provide a description.',
            'phone.required' => 'Phone number is required.',
            'website.url' => 'Please enter a valid website URL.',
            'category_id.required'    => 'Please select a category.',
            'city_id.required'        => 'Please select a city.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'city_id.required'        => 'Please select a city.',
            'location.required' => 'Location is required.',
        ];
    }
}
