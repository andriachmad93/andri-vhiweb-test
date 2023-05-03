<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhotoController extends BaseController
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $photos = Photo::all();

        return $this->send_response($photos, "Successfully Get Photos");
    }

    public function show($id)
    {
        $photo = DB::table('photos')->find($id);

        return is_null($photo) ? $this->send_error("Data not Found") : $this->send_response($photo, "Successfully Get Photos") ;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // validation
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required|mimes:jpeg,png,jpg,gif'
        ]);

        if($validator->fails()){
            return $this->send_error('Validation Error.', $validator->errors()); 
        }

        $filename = $request->file('photo');
        $generate_file = $this->izrand(5) . '-' . str_replace(" ", "", $filename->getClientOriginalName());

        $this->upload_file($generate_file, $filename);

        $id = DB::table('photos')->insertGetId([
            'title' => $input['title'] ?? "",
            'description' => $input['description'] ?? "",
            'photo' => $generate_file ?? "",
            'is_like' => 0,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id
        ]);

        return $this->send_response(['id' => $id], "Successfully Create Photo");
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        // validation
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required|mimes:jpeg,png,jpg,gif'
        ]);

        if($validator->fails()){
            return $this->send_error('Validation Error.', $validator->errors());       
        }

        $photo = DB::table('photos')->find($id);

        if (is_null($photo)) {
            return $this->send_error("Data not Found");
        }

        $filename = $request->file('photo');
        $generate_file = $this->izrand(5) . '-' . str_replace(" ", "", $filename->getClientOriginalName());

        $this->upload_file($generate_file, $filename);

        DB::table('photos')->where('id', $id)->update([
            'title' => $input['title'] ?? "",
            'description' => $input['description'] ?? "",
            'photo' => $generate_file ?? "",
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);

        return $this->send_response([], "Successfully Update Photo");
    }

    public function destroy($id)
    {
        $photo = DB::table('photos')->find($id);

        if (is_null($photo)) {
            return $this->send_error("Data not Found");
        }
        
        DB::table('photos')->where('id', $id)->delete();
        
        return $this->send_response([], "Successfully Delete Photo");
    }

    public function like($id, $type)
    {
        $photo = DB::table('photos')->find($id);

        if (is_null($photo)) {
            return $this->send_error("Data not Found");
        }

        DB::table('photos')->where('id', $id)->update([
            'is_like' => $type == 'like' ? 1 : 0,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);

        return $this->send_response([], "Successfully Like Photo");
    }
}
