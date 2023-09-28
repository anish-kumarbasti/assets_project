<?php

namespace App\Helpers;

use App\Models\Timeline;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
class TimelineHelper
{
    public static function logAction(
        $action,
        $productId = null,
        $assetTypeId = null,
        $assetId = null,
        $issuanceId = null,
        $issuanceBy = null,
        $transferId = null,
        $transferBy = null,
        $disposalId = null,
        $disposalBy = null,
        $maintenanceId = null,
        $maintenanceBy = null,
        $returnId = null,
        $returnBy = null
    ) {
        $user = Auth::user(); // Assuming you're using Laravel's built-in authentication
        if ($user) {
            $timeline = new Timeline();
            $timeline->user_id = $user->id;
            $timeline->product_id = $productId;
            $timeline->action = $action;
            $timeline->asset_type_id = $assetTypeId;
            $timeline->asset_id = $assetId;
            $timeline->issuance_id = $issuanceId;
            $timeline->issuance_by = $issuanceBy;
            $timeline->transfer_id = $transferId;
            $timeline->transfer_by = $transferBy;
            $timeline->disposal_id = $disposalId;
            $timeline->disposal_by = $disposalBy;
            $timeline->maintenance_id = $maintenanceId;
            $timeline->maintenance_by = $maintenanceBy;
            $timeline->return_id = $returnId;
            $timeline->return_by = $returnBy;
            $timeline->save();
        }
    }
    
    
}
