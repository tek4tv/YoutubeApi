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
    public function GetAccount(Request $request)
    {
        $GOOGLE_CLIENT_ID = $request->input('GOOGLE_CLIENT_ID');
        $GOOGLE_CLIENT_SECRET = $request->input('GOOGLE_CLIENT_SECRET');
        $this->setEnvironmentValue('GOOGLE_CLIENT_ID', $GOOGLE_CLIENT_ID);
        $this->setEnvironmentValue('GOOGLE_CLIENT_SECRET', $GOOGLE_CLIENT_SECRET);
        return "true";
    }
    public function CreateVideo(Request $request){ 
        $fullPathToVideo = $request->input('video');
        
        $fullpathToImage = storage_path('app/public/anh2.jpg');
        $video = YoutubeAPI::upload($fullPathToVideo, [
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'tags'	      => $request->input('tags'),
        ])->withThumbnail($fullpathToImage);      
        return json_encode($video);
    }
    public function GetAllPlayList(Request $request){
        $playlists =YoutubeAPI::getAllPlayList();
        return json_encode($playlists);
    }
    public function GetPlaylistById(Request $request){
        $playlistId =$request->input('playlistId');
        $playlist = YoutubeAPI::playListInfoById($playlistId);
        return json_encode($playlist);
    }
    public function InsertToPlaylist(Request $request){
        $videoId = $request->input('videoId');
        $playlistId = $request->input('playlistId');
        $insert = YoutubeAPI::insertVideoInPlaylist($videoId,$playlistId);;
        return json_encode($insert);
    }
    public function CreatePlaylist(Request $request){
        $playlistName = $request->input('playlistName');
        $descriptions = $request->input('descriptions');
        $privacy = $request->input('privacy');
        $playlist = YoutubeAPI::createPlaylist($playlistName,$descriptions,$privacy);
    }
    public function DeleteVideo(Request $request){
        $videoId = $request->input('videoId');
        $video = YoutubeAPI::delete($videoId);
        return json_encode($video);
    }
}
