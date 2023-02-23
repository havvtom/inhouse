<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function getComposerNameAttribute(){

        $composer_id = $this->created_by_id;

        return User::find($composer_id)->name;
    } 

    public function getRecipientAttribute(){
        
        return User::find($this->sending_to_id)->name;
    }

    public function getReadAttribute(){
        if($this->seen != null){
            return true;
        }
        return false;
    }

}
