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
    public function GetToken(Request $request)
    {
        
        return YoutubeAPI::getLatestAccessTokenFromDB();
    }
    public function CreateVideo(Request $request){ 
        $fullPathToVideo = $request->input('video');
        $inputToken = $request->input('Token');
        $video = YoutubeAPI::upload($fullPathToVideo, [
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'tags'	      => $request->input('tags'),
            'publishAt'   => $request->input('publishAt')
        ],'private',$inputToken);             
        $videoId = $video['id'];
        $thumbnail = $request->input('thubnail');
        YoutubeAPI::SetThumbnail($thumbnail,$videoId,$inputToken);
        $playlistId = $request->input('playlistId');
        $insert = YoutubeAPI::insertVideoInPlaylist($videoId,$playlistId,$inputToken);
        return json_encode($insert);
    }
    public function GetAllPlayList(Request $request){
        $inputToken = $request->input('Token');
        $playlists =YoutubeAPI::getAllPlayList($inputToken);
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
        $inputToken=$request->input('Token');
        $playlist = YoutubeAPI::createPlaylist($playlistName,$descriptions,$privacy,$inputToken);
    }
    public function DeleteVideo(Request $request){
        $videoId = $request->input('videoId');
        $video = YoutubeAPI::delete($videoId);
        return json_encode($video);
    }
}
