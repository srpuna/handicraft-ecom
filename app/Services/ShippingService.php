<?php

namespace App\Services;

use App\Models\ShippingZone;
use App\Models\ShippingRate;

class ShippingService
{
    /**
     * Calculate shipping rates based on items and destination country.
     *
     * @param array $items Array of ['product' => Product, 'quantity' => int]
     * @param string $country Country code or name
     * @return array
     */
    public function calculateShipping(array $items, string $country)
    {
        // 1. Determine Zone containing the country
        // We assume 'countries' value in DB is JSON array of strings (codes or names)
        // Try direct match; if not found, try code→name and name→code fallbacks using config('countries.map')

        $zone = ShippingZone::whereJsonContains('countries', $country)->first();

        if (!$zone) {
            $map = config('countries.map', []);
            $upper = strtoupper(trim($country));

            // If provided as code, try name
            if (isset($map[$upper])) {
                $name = $map[$upper];
                $zone = ShippingZone::whereJsonContains('countries', $name)->first();
            }

            // If provided as name, try code (inverse lookup)
            if (!$zone) {
                $inverseCode = null;
                foreach ($map as $code => $label) {
                    if (strcasecmp(trim($country), $label) === 0) {
                        $inverseCode = $code;
                        break;
                    }
                }
                if ($inverseCode) {
                    $zone = ShippingZone::whereJsonContains('countries', $inverseCode)->first();
                }
            }
        }

        if (!$zone) {
            return []; // No shipping zone found for this country
        }

        // 2. Calculate Weights
        $totalActualWeight = 0;
        // We'll accumulate total volume to divide later
        $totalVolume = 0;

        foreach ($items as $item) {
            $product = $item['product'];
            $qty = $item['quantity'];

            // Actual Weight
            $totalActualWeight += ($product->weight * $qty);

            // Dimensions logic as per README:
            // "Actual dimension of breath is multiplied by the number of quantity"
            $l = $product->length;       // Length
            $w = $product->width * $qty; // Breath (Width) * Qty
            $h = $product->height;       // Height

            // "Add 4 cm to each side L, B, H from actual dimension for packing material / boxes(buffer)"
            $l_packed = $l + 4;
            $w_packed = $w + 4;
            $h_packed = $h + 4;

            // Calculate volume for this "packed" line item
            // Note: If multiple DIFFERENT products are in cart, we sum their weights.
            // But for volume? The readme says "if different products are added to the same cart total weight should be added".
            // It doesn't explicitly say how to handle volume for mixed carts, but "total weight should be added" 
            // implies we treat them as accumulation. 
            // We will sum the volumes of each line-item packing calculation.
            $volume = $l_packed * $w_packed * $h_packed;
            $totalVolume += $volume;
        }

        // Divisor logic
        // "if weight is more than 500kg volumetric calculation is measured by LxBxH/6000"
        // We use Total Actual Weight to decide the divisor.
        $divisor = ($totalActualWeight > 500) ? 6000 : 5000;

        $totalVolumetricWeight = $totalVolume / $divisor;

        // "To apply shipping charges greater value of actual weight and volumetric weight; whichever is greater"
        $chargeableWeight = max($totalActualWeight, $totalVolumetricWeight);

        // 3. Find Rates
        // Search for rates in the found zone where chargeable weight falls within min/max
        $rates = $zone->rates()
            ->with('provider')
            ->where('min_weight', '<=', $chargeableWeight)
            ->where('max_weight', '>=', $chargeableWeight)
            ->get();

        $results = [];
        foreach ($rates as $rate) {
            if ($rate->provider && $rate->provider->is_active) {
                $results[] = [
                    'provider_name' => $rate->provider->name,
                    'price' => $rate->price,
                    'currency' => '$', // Assumption
                    'details' => [
                        'actual_weight' => round($totalActualWeight, 3),
                        'volumetric_weight' => round($totalVolumetricWeight, 3),
                        'chargeable_weight' => round($chargeableWeight, 3),
                        'zone' => $zone->name,
                    ]
                ];
            }
        }

        return $results;
    }
}
