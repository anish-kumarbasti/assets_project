<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Stock;
use App\Models\AssetType;
use App\Models\Disposal;
use App\Models\Issuence;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartDashboardController extends Controller
{
    public function index(Request $request)
    {
        $assetbycategory = AssetType::all();
        $assetbytype = Asset::all();
        $outOfStockCount = Stock::where('quantity', '<=', 1)->count();

        $assetCounts = [];
        $assetbyTypeCounts = []; // Use a different variable name for counts

        foreach ($assetbycategory as $asset) {
            $assetCount = Stock::where('asset_type_id', $asset->id)->count();
            $assetCounts[$asset->name] = $assetCount;
        }

        foreach ($assetbytype as $assetty) {
            $count = Stock::where('asset', $assetty->id)->count(); // Use a different variable name for the count
            $assetbyTypeCounts[$assetty->name] = $count;
        }

        $labels = [];
        $series = [];

        foreach ($assetCounts as $assetName => $count) {
            $labels[] = $assetName;
            $series[] = $count;
        }

        $labels1 = [];
        $series1 = [];

        foreach ($assetbyTypeCounts as $assetTypeName => $count) {
            $labels1[] = $assetTypeName;
            $series1[] = $count;
        }
        $monthlyCountsByAssetType = [];

        foreach ($assetbycategory as $assetbymonth) {
            $monthlyAssetType = $assetbymonth->id;

            $monthlyCounts = Stock::selectRaw('
            COUNT(*) as count,
            MONTH(created_at) as month
        ')
                ->where('asset_type_id', $monthlyAssetType)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Initialize an array to store counts for each month
            $monthlyCountsArray = array_fill(1, 12, 0);

            // Populate the array with counts from the database results
            foreach ($monthlyCounts as $count) {
                $monthlyCountsArray[$count->month] = $count->count;
            }

            // Store the monthly counts in the result array, keyed by the asset type ID
            $monthlyCountsByAssetType[$monthlyAssetType] = $monthlyCountsArray;
        }
        // dd($monthlyCountsByAssetType);
        $id = '5';
        $instock = Stock::where('status_available', $id)->count();
        $issue = Issuence::all();
        $totalissue = $issue->count();
        $despose = Disposal::all()->count();
        $maintenance = Maintenance::all()->count();
        return view('Backend.Page.home', compact('labels', 'series', 'labels1', 'series1', 'outOfStockCount', 'monthlyCountsByAssetType', 'assetbycategory', 'totalissue', 'despose', 'instock', 'maintenance'));
    }

    public function userDashboard(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user) {
                auth()->user()->unreadNotifications->where('id', $user)->markAsRead();
            }
            $user = Auth::user()->employee_id;
            $manager = Auth::user()->id;
            $issuedata = Issuence::where('employee_id', $user)
                ->orWhere('employee_manager_id', $manager)->first();
            $productIds = json_decode($issuedata->product_id);
            $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
            return view('Backend.Page.user_dashboard', compact('products', 'issuedata'));
        } else {
            return redirect('/');
        }
    }
}
