<?php

namespace App\Models;

class Userprofile extends BaseModel
{
    protected $casts = [
        'date_of_birth' => 'datetime',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    protected $completionFields = [
        'general_details' => ['name', 'email', 'mobile', 'gender','address'],
        'interests' => ['interests'],
        'occupation' => ['occupation_name', 'college_name', 'specialization'],
        'hobbies' => ['hobbies'],
        'social_links' => ['url_facebook', 'url_youtube', 'url_instagram', 'url_linkedin','url_website']
    ];

    public function calculateCompletion()
    {
        $completionPercentages = [];
        $totalFields = 0;
        $completedFields = 0;

        $categoryCoins = \App\Models\Coin::all()
        ->unique('category')  // Ensure no duplicate categories
        ->keyBy('category');  // Key by category for easy lookup

        foreach ($this->completionFields as $category => $fields) {
            $categoryTotal = count($fields);
            $categoryCompleted = 0;
            $categoryCoinValue = $categoryCoins->has($category) ? $categoryCoins[$category]->coins_per_category : 0; // Default to 0 if category not found

            foreach ($fields as $field) {
                if (!empty($this->$field)) {
                    $categoryCompleted++;
                }
            }

            // Calculate percentage for each category
            $categoryPercentage = ($categoryTotal > 0)
                ? ($categoryCompleted / $categoryTotal) * 100
                : 0;

            // Store both percentage and coins for each category
            $completionDetails[$category] = [
                'percentage' => round($categoryPercentage, 2),
                'coins' => $categoryCoinValue,
            ];

            $totalFields += $categoryTotal;
            $completedFields += $categoryCompleted;
        }

        // Overall completion percentage
        $completionDetails['overall'] = round(($completedFields / $totalFields) * 100, 2);

        return $completionDetails;
    }

    /**
     * Retrieves the associated User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
