<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YoutubeAPI;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('video');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function CreateVideo(Request $request){ 
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $fullPathToVideo = $request->input('video');
        $obj = $request->input('Object');
        $privacyStatus = $request->input('status');
        //$scheduled_publish_time = $request->input('publishAt');
       // $datetime = date($scheduled_publish_time);
        
        $video = YoutubeAPI::upload($fullPathToVideo, [
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'tags'	      => $request->input('tags')
        ],$privacyStatus,$obj); 
        $videoId = $video['id'];
        $playlistId = $request->input('playlistId');
        $insert = YoutubeAPI::insertVideoInPlaylist($videoId,$playlistId,$obj);   
        $thumbnail = $request->input('thumbnail');
        YoutubeAPI::withThumbnail($thumbnail,$videoId);    
        return json_encode($insert);
    }
    public function GetAllPlayList(Request $request){
        $obj = $request->input('Object');
        $playlists =YoutubeAPI::getAllPlayList($obj);
        return json_encode($playlists);
    }
  
    // api tạo playlist
    public function CreatePlaylist(Request $request){
        $playlistName = $request->input('playlistName');
        $descriptions = $request->input('descriptions');
        $privacy = $request->input('privacy');
        $obj=$request->input('Object');
        $playlist = YoutubeAPI::createPlaylist($playlistName,$descriptions,$privacy, $obj);
    }
    // get token

    public function GetToken(){
        $obj = YoutubeAPI::GetObject();
        return $obj;
    }
}
