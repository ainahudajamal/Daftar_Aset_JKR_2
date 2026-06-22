<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use App\Models\KodBlok;

class KodAras extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kod_aras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kod',
        'nama',
        'tingkat',
        'is_active',
        'status',
        'blok_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tingkat' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active kod aras.
     * Support both 'status' and 'is_active' columns for flexibility.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'aktif')->orderBy('tingkat');
        }
        return $query->where('is_active', true)->orderBy('tingkat');
    }

    /**
     * Scope a query to only include inactive kod aras.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'tidak_aktif')->orderBy('tingkat');
        }
        return $query->where('is_active', false)->orderBy('tingkat');
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
     * Scope to filter by tingkat range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $min
     * @param  int  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTingkatRange($query, $min, $max)
    {
        return $query->whereBetween('tingkat', [$min, $max]);
    }

    /**
     * Scope to get only ground floor and above.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroundAndAbove($query)
    {
        return $query->where('tingkat', '>=', 0)->orderBy('tingkat');
    }

    /**
     * Scope to get only basement floors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBasement($query)
    {
        return $query->where('tingkat', '<', 0)->orderBy('tingkat');
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
     * Get the tingkat display with proper formatting.
     *
     * @return string
     */
    public function getTingkatDisplayAttribute()
    {
        if ($this->tingkat < 0) {
            return 'B' . abs($this->tingkat); // Basement
        } elseif ($this->tingkat == 0) {
            return 'Ground Floor';
        } else {
            return 'Floor ' . $this->tingkat;
        }
    }

    /**
     * Check if this is ground floor or above.
     *
     * @return bool
     */
    public function isGroundOrAbove()
    {
        return $this->tingkat >= 0;
    }

    /**
     * Check if this is basement.
     *
     * @return bool
     */
    public function isBasement()
    {
        return $this->tingkat < 0;
    }

    /**
     * Check if this is ground floor.
     *
     * @return bool
     */
    public function isGroundFloor()
    {
        return $this->tingkat == 0;
    }

    /**
     * Check if a kod already exists.
     *
     * @param  string  $kod
     * @param  int|null  $excludeId
     * @return bool
     */
    public static function kodExists($kod, $excludeId = null)
    {
        $query = self::where('kod', '=', $kod, 'and');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get status badge color.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $this->status === 'aktif' ? 'success' : 'secondary';
        }
        return $this->is_active ? 'success' : 'secondary';
    }

    /**
     * Get status display text.
     *
     * @return string
     */
    public function getStatusDisplayAttribute()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        }
        return $this->is_active ? 'Aktif' : 'Tidak Aktif';
    }
    // Relationship dengan Blok
    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id');
    }
}
