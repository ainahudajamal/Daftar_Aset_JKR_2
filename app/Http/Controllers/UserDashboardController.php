<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard with statistics
     */
    public function index()
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id'      => $user->id,
            'component_id' => null,
            'title'        => 'Lihat Dashboard',
            'description'  => 'Lihat dashboard',
        ]);

        // Get statistics for current user only
        $stats = [
            'total_components' => Component::where('user_id', $user->id)->count(),
            'active_components' => Component::where('user_id', $user->id)->aktif()->count(),
            
            'total_main_components' => MainComponent::where('user_id', $user->id)->count(),
            'total_sub_components' => SubComponent::where('user_id', $user->id)->count(),
            
            // Total sistem dan subsistem (untuk reference, bukan filtered by user)
            'total_sistem' => Sistem::count(),
            'active_sistem' => Sistem::active()->count(),
            
            'total_subsistem' => Subsistem::count(),
            'active_subsistem' => Subsistem::active()->count(),
        ];

        // Get recent components created by user (last 5)
        $recentComponents = Component::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user's component activity by month
        $componentsByMonth = Component::where('user_id', $user->id)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();


        return view('components.index', compact('stats', 'recentComponents', 'componentsByMonth', 'sistemStats'));
    }

    /**
     * Get user's component activity details
     */
    public function myActivity()
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id'      => $user->id,
            'component_id' => null,
            'title'        => 'Lihat Aktiviti Saya',
            'description'  => 'Melihat aktiviti sendiri',
        ]);

        // Get detailed component breakdown for current user
        $activity = [
            'components' => Component::where('user_id', $user->id)
                ->with(['sistem', 'subsistem'])
                ->orderBy('created_at', 'desc')
                ->get(),
            
            'main_components' => MainComponent::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
            
            'sub_components' => SubComponent::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        ];

        // Summary counts
        $summary = [
            'total_components' => $activity['components']->count(),
            'total_main_components' => $activity['main_components']->count(),
            'total_sub_components' => $activity['sub_components']->count(),
            'active_components' => $activity['components']->where('status', 'aktif')->count(),
        ];

        return view('user.my-activity', compact('activity', 'summary'));
    }

    /**
     * Show user's component statistics
     */
    public function myStats()
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id'      => $user->id,
            'component_id' => null,
            'title'        => 'Lihat Statistik Saya',
            'description'  => 'Melihat statistik sendiri',
        ]);

        // Components by sistem
        $componentsBySistem = Sistem::withCount([
                'components' => function($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])
            ->having('components_count', '>', 0)
            ->orderBy('components_count', 'desc')
            ->get();

        // Components by subsistem
        $componentsBySubsistem = Subsistem::withCount([
                'components' => function($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])
            ->having('components_count', '>', 0)
            ->orderBy('components_count', 'desc')
            ->get();

        // Components by month (last 12 months)
        $componentsByMonth = Component::where('user_id', $user->id)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Components by status
        $componentsByStatus = Component::where('user_id', $user->id)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('user.my-stats', compact(
            'componentsBySistem',
            'componentsBySubsistem',
            'componentsByMonth',
            'componentsByStatus'
        ));
    }
}