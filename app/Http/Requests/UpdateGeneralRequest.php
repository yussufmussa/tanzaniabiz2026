<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGeneralRequest extends FormRequest
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
        $listingId = $this->route('listing');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('business_listings', 'name')->ignore($listingId),
            ],
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'youtube_video_link' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'required|array',
            'subcategory_id.*' => 'required|integer|exists:sub_categories,id',
            'city_id' => 'required|integer|exists:cities,id',
            'location' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => 'Listing name is required.',

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
