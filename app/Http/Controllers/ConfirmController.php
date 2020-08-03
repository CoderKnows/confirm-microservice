<?php

namespace App\Http\Controllers;

use App\Code;
use App\ConfirmType;
use App\Services\AbstractTypeService;
use App\Services\ConfirmService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConfirmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sendCode(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'email',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::EMAIL]]))),
                ],
            'phone' => [
                'string',
                sprintf('required_without_all:%s', implode(',', ConfirmType::listTypesWithout([ConfirmType::listTypesAll()[ConfirmType::PHONE]]))),
            ],
            'code' => ['string', Rule::exists(Code::class, 'code')]
        ]);

        $queryData = $request->all();

        /** @var ConfirmService $service */
        $service = app()->get(ConfirmService::class);
        if ($service->forConfirming($queryData)) {
            $service->confirm($queryData);
        } else {
            /** @var AbstractTypeService $typeService */
            $typeService = $service->getVerifyingService($queryData);
            dd($typeService);

            //$typeService->send();
        }



        if (! $typeService instanceof AbstractTypeService) {
            return response()->json(['status' => 'success', 'version' => app()->version()]);
        }

        return response()->json(['status' => 'success', 'version' => app()->version()]);
    }
}
