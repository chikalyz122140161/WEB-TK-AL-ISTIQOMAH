<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'activity';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['description'];

    /**
     * Buat entri activity log baru. Prefix otomatis dengan nama + role user yang login.
     */
    public static function log(string $description): self
    {
        $user = Auth::user();
        $prefix = '';

        if ($user) {
            $roleLabel = match ($user->role) {
                'admin'    => 'Admin',
                'guru'     => 'Guru',
                'orangtua' => 'Orang Tua',
                default    => '-',
            };
            $prefix = $roleLabel . ' ' . ($user->name ?? '-') . ' — ';
        }

        return self::create([
            'description' => $prefix . $description,
        ]);
    }
}
