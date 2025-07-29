<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'endpoint',
        'method',
        'request_data',
        'response_data',
        'response_code',
        'response_time',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Project::class, 'id', 'id', 'project_id', 'user_id');
    }

    public function isSuccessful()
    {
        return $this->response_code >= 200 && $this->response_code < 300;
    }

    public function getStatusClass()
    {
        if ($this->isSuccessful()) {
            return 'bg-green-100 text-green-800';
        } elseif ($this->response_code >= 400 && $this->response_code < 500) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-red-100 text-red-800';
        }
    }
} 