<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Folio;
use App\Models\Company;
use App\Models\QuotationItem;

class SalesController extends Controller
{

    public function getNextFolio(Request $request)
    {

        $type = $request->type;

        $company = Company::where('user_id', auth()->id())->first();
        $companyName = $company->name;

        $companyPrefix = strtoupper(substr($companyName, 0, 2));


        $last = Folio::where('folio_type',$type)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        if(!$last){
            $number = 1;
        } else {
            $parts = explode('-', $last->folio);
            $lastNumber = (int) end($parts);
            $number = $lastNumber + 1;
        }

        $folio = $companyPrefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'folio' => $folio
        ]);
    }

    public function create(Request $request){

        $userId = $request->user_id;

        $company = Company::where('user_id', $userId)->first();
        $prefix = strtoupper(substr($company->name, 0, 2));
        $type = 'COT';

        $last = Folio::where('folio_type', $type)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        $number = $last ? ((int) explode('-', $last->folio)[2] +1) : 1;
        
        $folioText = $prefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $folio =  Folio::create([
            'user_id' => $userId,
            'company_id' => $company->id,
            'folio_type' => $type,
            'folio' => $folioText
        ]);

        $quotation = Quotation::create([
            'company_id' => $company->id,
            'client_id' => $request->client_id,
            'contact_name' => $request->contact_name,
            'quotation_date' => $request->quotation_date,
            'folio_id' => $folio->id,
            'currency' => $request-> currency
        ]);

        foreach ($request->products as $item) {
            $quotationItem = QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'discount' => $item['discount'],
                'tax' => $item['tax'],
                'total' => $item['total']
            ]);
        }

        return response()->json([
            'quotation' => $quotation,
            'folio' => $folioText,
            'quotationItem' => $quotationItem
        ]);
    }

    public function getQuotations(){
        $company = Company::where('user_id',auth()->id())->first();

        $quotations = Quotation::with(['client','folio'])
            ->where('company_id', $company->id)
            ->get();
        return response()->json($quotations);
    }

}
