<?php

namespace App\Http\Controllers;

use App\Models\HttpCode;
use App\Services\customer\CustomerInviteService;
use Exception;
use Illuminate\Http\Request;

class CustomerInviteController extends Controller
{
    protected $customerInviteService;

    public function __construct(CustomerInviteService $customerInviteService)
    {
        $this->customerInviteService = $customerInviteService;
    }

    public function getCustomerInvites(Request $request)
    {
        try {
            $customerInvites = $this->customerInviteService->getCustomerInvites($request);
            return response()->json($customerInvites, HttpCode::SUCCESS_OK);

        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);

        }
    }


    public function saveCustomerInviteCsv(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                $file = $request->file('csv_file');
                $csvParse = $this->customerInviteService->saveCustomerInviteCsv($file);

                return response()->json($csvParse, HttpCode::SUCCESS_OK);
            } else {
                return response()->json("No CSV file provided.", HttpCode::BAD_REQUEST);
            }
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

}
