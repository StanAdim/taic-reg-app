<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    public function handleBillSubmission($request, Closure $next){
        $apiKey = $request->header('API_KEY');
        
        if ($apiKey !== config('services.external_service.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
        Log::info($request);
    }

}
