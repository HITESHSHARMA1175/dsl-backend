<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

use Exception;


use App\Models\Owner;
use App\Models\Builder;
use App\Models\Society;
use App\Models\Master;
use App\Models\PropertyCategory;
use App\Models\Property;
use Maatwebsite\Excel\Concerns\ToModel;

class PropertyImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $row)
    {
        // Validate
        $validator = Validator::make(
            $row->toArray(),
            [
                '*.company_name' => 'required|exists:clients,company_name',
                '*.file_number' => 'required|unique:receivings,file_number',
                '*.container' => 'required|unique:receivings,container',
                '*.cargo_id' => 'required|unique:cargos,cargo_id',
                // '*.ctn_count' => 'required',
                // '*.total_wt' => 'required',
                // '*.total_cbm' => 'required',
                // '*.whse_id' => 'required',
                // '*.po' => 'required',
                // '*.fba_id' => 'required',
            ],
            [
                '*.company_name.required' => 'The company name field is required.',
                '*.company_name.exists' => 'The company name does not exist.',
                // '*.cargo_id.required' => 'Cargo ID Required for all rows.',
            ],
        );

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        // }

        //$validator->validate();

        $rows = $row->toArray();
        $receiving_id = '';
        foreach ($rows as $data) {
             //dd($data); 

            $builder = Builder::where('builder_name', $data['select_builder'])->first();
            $society = Society::where('society_name', $data['select_society'])->first();
            $propertycategory = PropertyCategory::where('category_name', $data['property_category'])->first();
            $propertysubcategory = PropertyCategory::where('category_name', $data['property_sub_category'])->first();
            
            // if (!$client) {
            //     throw new Exception('The specified company name does not exist in the clients table.');
            // }

            
            $addProperty = Property::create([
                'property_name' => $data['property_name'],
                'owner_id' => $data['owner_id'],
                'builder_id' => $builder->id,
                'society_id' => $society->id,
                'property_category' => $propertycategory->id,
                'property_sub_category' => $propertysubcategory->id,
                'country_id' => $society->country_id,
                'state_id' => $society->state_id,
                'city_id' => $society->city_id,
                'area' => $society->address,
                'street' => $society->address,
                'pincode' => $society->pincode,
                
            ]);

           
        }
       
    }
}
