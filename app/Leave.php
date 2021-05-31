<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
    protected $table = 'leave_requests';

    protected $fillable =[
        'user_id', 'issue_by', 'leave_type', 'start_date', 'end_date', 'message', 'leave_approval', 'approved_by', 'approved_date', 'paid_status', 'response_message', 'leave_time', 'created_by'
    ];

    public function getUserleave($id = 0) {
        $profile_data = Profile::where('user_id',$id)->get()->count();
        return $profile_data;        
    }
}
