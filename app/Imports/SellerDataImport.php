<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

use Exception;



use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\PropertyCategory;
use App\Models\Owner;
use App\Models\Builder;
use App\Models\Society;
use App\Models\SellerLead;
use App\Models\MasterValue;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class SellerDataImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $row)
    {
        // Validate
        $validator = Validator::make(
            $row->toArray(),
            [
                //'*.company_name' => 'required|exists:clients,company_name',
                //'*.file_number' => 'required|unique:receivings,file_number',
                //'*.container' => 'required|unique:receivings,container',
                //'*.cargo_id' => 'required|unique:cargos,cargo_id',
                // '*.ctn_count' => 'required',
                // '*.total_wt' => 'required',
                // '*.total_cbm' => 'required',
                // '*.whse_id' => 'required',
                // '*.po' => 'required',
                // '*.fba_id' => 'required',
            ],
            [
                //'*.company_name.required' => 'The company name field is required.',
                //'*.company_name.exists' => 'The company name does not exist.',
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
            // dd($data);

            //$client = Client::where('company_name', $data['company_name'])->first();

            // if (!$client) {
            //     throw new Exception('The specified company name does not exist in the clients table.');
            // }

            /*$addOwner = new Owner();
            $addOwner->first_name = $lead->name;
            $addOwner->mobile_no = $lead->mobile_no;
            $addOwner->alt_mobile_no = $lead->alt_mobile_no;
            $addOwner->email = $lead->email;
            $addOwner->addby = auth()->user()->id;
            $addOwner->save();*/
            
            /*$addBuilder = new Builder();
            $addBuilder->builder_name = $lead->builder_name;
            $addBuilder->addby = auth()->user()->id;
            $addBuilder->save();*/
            
            /*$saveSociety = new Society();
            $saveSociety->builder_id = $addBuilder->id;
            $saveSociety->society_name = $lead->project_name;
            $saveSociety->country_id = $property_country->id;
            $saveSociety->state_id = $property_state->id;
            $saveSociety->city_id = $property_city->id;
            $saveSociety->address = $lead->address;
            $saveSociety->pincode = $lead->pincode;
            $saveSociety->save();*/
            
            @$randomFieldPerson = User::where('emp_type', '=', 'Staff')->inRandomOrder()->first();
            @$sale_type = MasterValue::where('MasterValue', $data['sale_type'])->first();
            @$project_country = Country::where('name', $data['country_name'])->first();
            @$project_state = State::where('name', $data['state_name'])->first();
            @$project_city = City::where('name', $data['city_name'])->first();
            @$property_category = PropertyCategory::where('category_name', $data['property_category'])->first();
            @$property_sub_category = PropertyCategory::where('category_name', $data['property_sub_category'])->where('parent_id', @$property_category->id)->first();
            
            $addOwner = Owner::where('mobile_no', $data['mobile_no'])->first();
            if (!$addOwner) {
                $addOwner = Owner::create([
                    'first_name' => $data['name'],
                    'mobile_no' => $data['mobile_no'],
                    'alt_mobile_no' => $data['alt_mobile_no'],
                    'email' => $data['email'],
                    'addby' => auth()->user()->id,
                ]);
            }
            
            $addBuilder = Builder::where('builder_name', $data['builder_name'])->first();
            if (!$addBuilder) {
                $addBuilder = Builder::create([
                    'builder_name' => $data['builder_name'],
                    'addby' => auth()->user()->id,
                ]);
            }
            
            $addSociety = Society::where('society_name', $data['project_name'])->first();
            if (!$addSociety) {
                $addSociety = Society::create([
                    'builder_id' =>@$addBuilder->id,
                    'society_name' => $data['project_name'],
                    'country_id' => $project_country->id,
                    'state_id' => $project_state->id,
                    'city_id' => $project_city->id,
                    'address' => $data['address'],
                    'pincode' => $data['pincode'],
                    'addby' => auth()->user()->id,
                ]);
            }

            $addSellerdata = SellerLead::create([
                'name' => $data['name'],
                'mobile_no' => $data['mobile_no'],
                'alt_mobile_no' => $data['alt_mobile_no'],
                'email' => $data['email'],
                'property_name' => $data['property_name'],
                'owner_id' => @$addOwner->id,
                'builder_id' => @$addBuilder->id,
                'society_id' => @$addSociety->id,
                'property_category' => @$property_category->id,
                'property_sub_category' => @$property_sub_category->id,
                'property_size' => $data['property_size'],
                'property_bhk' => $sale_type->id,
                'country_id' => @$project_country->id,
                'state_id' => @$project_state->id,
                'city_id' => @$project_city->id,
                'area' => $data['address'],
                'street' => $data['locality'],
                'pincode' => $data['pincode'],
                'floor_name' => $data['floor_name'],
                'unit_no' => $data['unit_no'],
                'tower_no' => $data['tower_no'],
                'salable_area' => $data['salable_area'],
                'base_rate' => $data['base_rate'],
                'unit_value' => $data['unit_value'],
                'total_cost' => $data['total_cost'],
                'outstanding_principle' => $data['outstanding_principle'],
                'broker_name' => $data['broker_name'],
                'assign_emp' => @$randomFieldPerson->id,
                'assign_date' => now(),
                'assign_by' => auth()->user()->id,
                'addby' => auth()->user()->id,
            ]);

           
        }
       
    }
}
