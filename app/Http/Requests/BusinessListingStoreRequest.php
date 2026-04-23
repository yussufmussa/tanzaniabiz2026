<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessListingStoreRequest extends FormRequest
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
            'name'               => 'required|string|unique:business_listings,name',
            'logo'               => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description'        => 'required|string',
            'phone'              => 'required|digits:10',
            'website'            => 'required|url',
            'email'              => 'required|email|unique,business_listings,email',
            'location'           => 'required|string',
            'latitude'           => 'nullable|string',
            'longitude'          => 'nullable|string',
            'youtube_video_link' => 'nullable|url',
            'status'             => 'boolean',
            'is_featured'        => 'boolean',
            'category_id'        => 'required|exists:categories,id',
            'city_id'            => 'required|exists:cities,id',

            'sub_category_ids'    => 'nullable|array',
            'sub_category_ids.*'  => 'exists:sub_categories,id',

            'photos'      => 'nullable|array',
            'photos.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'products'                => 'nullable|array',
            'products.*.name'         => 'required_with:products|string',
            'products.*.description'  => 'required_with:products|string',
            'products.*.price'        => 'nullable|numeric',
            'products.*.photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'social_media'                   => 'nullable|array',
            'social_media.*.social_media_id' => 'required_with:social_media|exists:social_media,id',
            'social_media.*.link'            => 'nullable|url',

            'working_hours'               => 'nullable|array',
            'working_hours.*.open_time'   => 'nullable|string',
            'working_hours.*.close_time'  => 'nullable|string',
            'working_hours.*.is_24_7'     => 'nullable|boolean',
            'working_hours.*.is_closed'   => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.digits' => 'Phone number must be 10 digits.',
            // Relations
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category is invalid.',
            'city_id.required' => 'City is required.',
            'city_id.exists' => 'Selected city is invalid.',

            // Sub categories
            'sub_category_ids.array' => 'Sub categories must be an array.',
            'sub_category_ids.*.exists' => 'One of the selected sub categories is invalid.',

            // Photos
            'photos.array' => 'Photos must be an array.',
            'photos.*.image' => 'Each photo must be an image.',
            'photos.*.mimes' => 'Photos must be jpeg, png, jpg, gif, or webp.',
            'photos.*.max' => 'Each photo must not exceed 2MB.',

            // Products
            'products.array' => 'Products must be an array.',
            'products.*.name.required_with' => 'Product name is required.',
            'products.*.description.required_with' => 'Product description is required.',
            'products.*.price.numeric' => 'Product price must be a number.',
            'products.*.photo.image' => 'Product photo must be an image.',
            'products.*.photo.mimes' => 'Product photo must be jpeg, png, jpg, gif, or webp.',
            'products.*.photo.max' => 'Product photo must not exceed 2MB.',

            // Social media
            'social_media.array' => 'Social media must be an array.',
            'social_media.*.social_media_id.required_with' => 'Social media type is required.',
            'social_media.*.social_media_id.exists' => 'Selected social media is invalid.',
            'social_media.*.link.url' => 'Enter a valid social media link.',

            // Working hours
            'working_hours.array' => 'Working hours must be an array.',
            'working_hours.*.is_24_7.boolean' => '24/7 field must be true or false.',
            'working_hours.*.is_closed.boolean' => 'Closed field must be true or false.',
        ];
    }
}
