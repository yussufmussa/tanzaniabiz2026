<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageFeature extends Model
{
     protected $fillable = ['package_id', 'feature_id', 'value'];
    
    /**
     * Get the package
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the feature
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    /**
     * Get formatted value based on feature type
     */
    public function getFormattedValue(): string
    {
        return match($this->feature->type) {
            'boolean' => $this->value === 'true' ? 'Yes' : 'No',
            'numeric' => $this->value,
            'unlimited' => $this->value === 'unlimited' ? 'Unlimited' : $this->value,
            default => $this->value
        };
    }

    /**
     * Check if boolean feature is enabled
     */
    public function isEnabled(): bool
    {
        return $this->feature->type === 'boolean' && $this->value === 'true';
    }

    /**
     * Get numeric value as integer
     */
    public function getNumericValue(): ?int
    {
        if ($this->feature->type !== 'numeric') {
            return null;
        }

        return is_numeric($this->value) ? (int)$this->value : null;
    }
}
