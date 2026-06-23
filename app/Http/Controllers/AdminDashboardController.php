<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Dashboard',
            'description'  => 'Lihat dashboard',
        ]);

        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'admin_users' => User::admins()->count(),
            'regular_users' => User::regularUsers()->count(),
            
            'total_components' => Component::count(),
            'active_components' => Component::aktif()->count(),
            
            'total_main_components' => MainComponent::count(),
            'total_sub_components' => SubComponent::count(),
            
            'total_sistem' => Sistem::count(),
            'active_sistem' => Sistem::active()->count(),
            
            'total_subsistem' => Subsistem::count(),
            'active_subsistem' => Subsistem::active()->count(),
        ];

        // Get recent users (last 5)
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        // ✅ UBAH INI - Get user activity menggunakan relationship user_id
        $userActivity = User::withCount('components')
            ->orderBy('components_count', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                // Tambah total_components untuk kegunaan view
                $user->total_components = $user->components_count;
                return $user;
            });

        // Get sistem statistics
        $sistemStats = Sistem::withCount('subsistems')->get();

        // Get components grouped by sistem (for chart)
        $componentsBySistem = Sistem::withCount('components')
            ->orderBy('components_count', 'desc')
            ->get();

        // Get recent audit log entries (last 8)
        $recentAuditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'userActivity', 'sistemStats',
            'componentsBySistem', 'recentAuditLogs'
        ));
    }

    /**
     * Get user activity details
     */
    public function userActivity()
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Aktiviti Pengguna',
            'description'  => 'Melihat aktiviti pengguna',
        ]);

        // ✅ UBAH INI - Get detailed component count per user menggunakan relationship
        $users = User::withCount([
                'components',
                'mainComponents',
                'subComponents'
            ])
            ->orderBy('components_count', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'department' => $user->department,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at,
                    'last_login_at' => $user->last_login_at,
                    // Count komponen yang betul
                    'total_components' => $user->components_count,
                    'total_main_components' => $user->main_components_count,
                    'total_sub_components' => $user->sub_components_count,
                ];
            });

        return view('admin.user-activity', compact('users'));
    }

    /**
     * Show system statistics
     */
    public function systemStats()
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Statistik Sistem',
            'description'  => 'Melihat statistik sistem',
        ]);

        // ✅ UBAH INI - Component statistics by user menggunakan relationship
        $componentsByUser = User::withCount('components')
            ->orderBy('components_count', 'desc')
            ->get();

        // Components by month (kekal sama)
        $componentsByMonth = Component::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.system-stats', compact('componentsByUser', 'componentsByMonth'));
    }
}