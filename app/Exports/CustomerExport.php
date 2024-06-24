<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Transform the array of objects into a Laravel Collection
        $collection = new Collection($this->data);

        // Transform each object in the collection
        $transformed = $collection->map(function ($item) {
            // Convert HTML entities to plain text
            $name = strip_tags($item['name']);
            $email = strip_tags($item['email']);
            $storeName = strip_tags($item['store_name']);
            // Other fields...

            // Return the transformed object
            return [
                'Name' => $name,
                'Email' => $email,
                'Mobile' => $item['mobile'],
                'Store Name' => $storeName,
                'Created At' => $item['created_at'],
                'Updated At' => $item['updated_at']
            ];
        });

        return $transformed;
    }

    public function headings(): array
    {
        // Define fixed headings here
        return [
            'Name',
            'Email',
            'Mobile',
            'Store Name',
            'Create At',
            'Updated At',
            // Add more headings as needed
        ];
    }
}
