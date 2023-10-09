<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
        'assigned_by',
    ];

    public static function listOfTickets() {
        return self::select('id','title', 'status')->where('status', '!=', 'closed')->orderBy('id', 'DESC');
    }

    public function getDetails() {
        return self::where('id', $this->id)->first();
    }

    public function userDetails() {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }

    public static function createTicket($data) {
        return self::create($data);
    }

    public function updateTicket($data) {
        return self::where('id', $this->id)->update([
            'title'       => $data['title'],
            'description' => $data['description'],
            'assigned_to' => $data['assigned_to'],
            'status'      => $data['status']
        ]);
    }

    public function closeTicket() {
        return self::where('id', $this->id)->update([
            'status' => 'closed'
        ]);
    }
}
