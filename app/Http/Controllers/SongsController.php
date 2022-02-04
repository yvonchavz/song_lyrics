<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use DataTables;

class SongsController extends Controller
{
    // Songs Lists
    public function index() {
        return view('song-lyrics');
    }

    // Add Song
    /*
    public function addSong(Request $request) {
        
        $validator = \Validator::make($request->all(), [
            'title' => 'required|unique:songs',
            'artist' => 'required',
            'lyrics' => 'required'
        ]);

        if(!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $song = new Song();
            $song->title = $request->title;
            $song->artist = $request->artist;
            $song->lyrics = $request->lyrics;
            $query = $song->save();

            if($query){
                return response()->json(['code'=>1,'msg'=>'New Song has been successfully saved']);
            }else{
                return response()->json(['code'=>0,'msg'=>'Hmm... something went wrong']);
            }
        }
    }
    */

    // Get All Songs
    public function getSongLyrics(Request $request){
        $songs = Song::all();
        return DataTables::of($songs)
                            ->addColumn('actions', function($row){
                                return '<div class="btn-group">
                                            <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editSongBtn">Update</button>
                                            <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteSongBtn">Delete</button>
                                        </div>';
                            })
                        
                            ->rawColumns(['actions'])
                            ->make(true);
    }

    //Get Song
    public function getSong(Request $request){
        $id = $request->id;
        $songItem = Song::find($id);
        return response()->json(['item'=>$songItem]);
    }

    //Update Song
    public function saveSong(Request $request){
        $id = $request->id;

        $validator = \Validator::make($request->all(),[
            'title' => 'required|unique:songs,title,'.$id,
            'artist' => 'required',
            'lyrics' => 'required'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
            if( !is_null($id) )
                $song = Song::find($id);
            else
                $song = new Song();

            $song->title = $request->title;
            $song->artist = $request->artist;
            $song->lyrics = $request->lyrics;
            $query = $song->save();

            if($query){
                if( !is_null($id) )
                    return response()->json(['code'=>1, 'msg'=>'Song have been updated.']);
                else
                    return response()->json(['code'=>1,'msg'=>'New Song has been successfully saved']);
            }else{
                return response()->json(['code'=>0,'msg'=>'Hmm... something went wrong']);
            }
        }
    }

    // Delete Song
    public function deleteSong(Request $request){
        $id = $request->id;
        $query = Song::find($id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'Song has been deleted from database']);
        }else{
            return response()->json(['code'=>0,'msg'=>'Hmm... something went wrong']);
        }
    }
}
