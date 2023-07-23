<?php

namespace App\Services\customer;

use App\Models\customer\CustomerInvite;
use App\Traits\DateUtility;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class CustomerInviteService
{

    use DateUtility;

    public function saveCustomerInviteCsv($file)
    {
        // Truncate the CustomerInvite table to start with a clean slate
        CustomerInvite::truncate();

        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        try {
            foreach ($data as $row) {
                if ($row[0] !== 'trans_type') {
                    $customerInvite = new CustomerInvite([
                        'trans_type' => $row[0] ?? null,
                        'trans_date' => $row[1] ?? null,
                        'trans_time' => $row[2] ?? null,
                        'cust_num'   => $row[3] ?? null,
                        'cust_fname' => $row[4] ?? null,
                        'cust_email' => $row[5] ?? null,
                        'cust_phone' => $row[6] ?? null,
                    ]);
                    $customerInvite->save();
                }
            }

            return true;
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }




    public function getCustomerInvites()
    {
        $today = Carbon::create(2023, 3, 5); // set date to March 5, 2023.
        $sevenDaysAgo = $today->subDays(7);

        $customerInvites = CustomerInvite::query()->get();

        // create array to keep track of seen customer records
        $seenCustomerRecords = [];

        return $customerInvites->transform(function ($customerInvite) use (&$seenCustomerRecords, $sevenDaysAgo) {
            // check if customer record has a duplicate
            $hasDuplicate = $this->hasDuplicateRecord($customerInvite, $seenCustomerRecords);

            // check if customer invite was sent within the last 7 days
            $isSent = $this->isInviteWithinLastSevenDays($customerInvite, $sevenDaysAgo);

            // if it has duplicate, only set isSent to true if the record's trans_date is within the last 7 days
            if ($hasDuplicate && $isSent) {
                $isSent = false;
            }
            // add the customer record to the seen list
            $seenCustomerRecords[] = $customerInvite;

            // contact method used for sending invite
            $isSentVia = $this->getSentViaMethod($customerInvite);

            return [
                'id'          => $customerInvite->id,
                'transType'   => strtoupper($customerInvite->trans_type),
                'transDate'   => $customerInvite->trans_date,
                'date'        => $this->parseDateFormat1($customerInvite->trans_date),
                'transTime'   => $customerInvite->trans_time,
                'custNum'     => $customerInvite->cust_num,
                'custFname'   => $customerInvite->cust_fname,
                'custEmail'   => $customerInvite->cust_email,
                'custPhone'   => $customerInvite->cust_phone,
                'description' => $customerInvite->description,
                'isSent'      => $isSent,
                'isSentVia'   => $isSentVia,
                'isDuplicate' => $hasDuplicate,
                '$seenCustomerRecords' => $seenCustomerRecords,
            ];
        });
    }

// helper function to check if customer record has a duplicate
    private function hasDuplicateRecord($customerRecord, $seenCustomerRecords)
    {
        foreach ($seenCustomerRecords as $seenRecord) {
            if (
                ($seenRecord->cust_email && $seenRecord->cust_email === $customerRecord->cust_email)
                || ($seenRecord->cust_phone && $seenRecord->cust_phone === $customerRecord->cust_phone)
                || ($seenRecord->cust_num && $seenRecord->cust_num === $customerRecord->cust_num)
            ) {
                return true; // record has a duplicate
            }
        }

        return false; // record does not have a duplicate
    }

// helper function to check if the customer invite was sent within the last 7 days
    private function isInviteWithinLastSevenDays($customerInvite, $sevenDaysAgo)
    {
        return Carbon::parse($customerInvite->trans_date)->gte($sevenDaysAgo);
    }

// helper function to determine the contact method used for sending the invite
    private function getSentViaMethod($customerInvite)
    {
        $customerPhone = $customerInvite->cust_phone;
        $customerEmail = $customerInvite->cust_email;

        return $customerPhone && $customerEmail ? 'PHONE' : ($customerEmail ? 'EMAIL' : 'PHONE');
    }

}
