<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'api_token',
        'webhook_url',
        'is_active',
        'request_limit',
        'requests_used',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requests()
    {
        return $this->hasMany(ProjectRequest::class);
    }

    public static function generateApiToken()
    {
        return 'pk_' . Str::random(32);
    }

    public function getUsagePercentageAttribute()
    {
        if ($this->request_limit == 0) {
            return 0;
        }
        return round(($this->requests_used / $this->request_limit) * 100, 2);
    }

    public function canMakeRequest()
    {
        return $this->is_active && $this->requests_used < $this->request_limit;
    }

    public function incrementRequests()
    {
        $this->increment('requests_used');
    }
} 