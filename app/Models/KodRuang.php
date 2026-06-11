<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\KodAras;
use App\Models\KemasanRuang;

class KodRuang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kod_ruangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kod',
        'kod_sub_ruang',
        'nama',
        'luas',
        'tinggi',
        'fungsi_ruang',
        'ada_kemasan',
        'kategori',
        'is_active',
        'status',
        'aras_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active kod ruang.
     * Supports both 'status' and 'is_active' columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'aktif')->orderBy('kod');
        }
        return $query->where('is_active', true)->orderBy('kod');
    }

    /**
     * Scope a query to search by kod or nama.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('kod', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by kategori.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $kategori
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get the full display name (kod + nama).
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->kod . ' - ' . $this->nama;
    }

    /**
     * Check if a kod already exists.
     *
     * @param  string  $kod
     * @return bool
     */
    public static function kodExists($kod)
    {
        return self::where('kod', $kod)->exists();
    }

    /**
     * Get all unique categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getCategories()
    {
        return self::where('is_active', true)
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();
    }

    // Relationship dengan KodAras
    public function aras()
    {
        return $this->belongsTo(KodAras::class, 'aras_id');
    }

    // Relationship dengan KemasanRuang (multiple records allowed)
    public function kemasan()
    {
        return $this->hasMany(KemasanRuang::class, 'ruang_id')->orderBy('created_at', 'asc');
    }

    // Get the latest kemasan record
    public function latestKemasan()
    {
        return $this->hasOne(KemasanRuang::class, 'ruang_id')->latestOfMany();
    }
}
