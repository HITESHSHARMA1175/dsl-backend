<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

use Exception;



use App\Models\Owner;
use Maatwebsite\Excel\Concerns\ToModel;

class OwnersImport implements ToCollection, WithHeadingRow
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
            // dd($data);

            //$client = Client::where('company_name', $data['company_name'])->first();

            // if (!$client) {
            //     throw new Exception('The specified company name does not exist in the clients table.');
            // }

       

            $addOwner = Owner::create([
                'first_name' => $data['full_name'],
                'relative_name' => $data['relative_name'],
                'email' => $data['email'],
                'mobile_no' => $data['mobile_no'],
                'per_address' => $data['per_address'],
                'pan_card_no' => $data['pan_card_no'],
                'aadhar_card_no' => $data['aadhar_card_no'],
            ]);

           
        }
       
    }
}
