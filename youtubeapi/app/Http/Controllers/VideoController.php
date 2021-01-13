<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Youtube;

class VideoController extends Controller
{
    public function index()
    {
        return view('video');
    }
    public function store(Request $request)
    {
        $video = Youtube::upload($request->file('video')->getPathName(), [
            'title'       => $request->input('title'),
            'description' => $request->input('description')
        ]);
 
        return "Video uploaded successfully. Video ID is ". $video->getVideoId();
    }
    public function YoutubeVideo(Request $request){
        $video =$request->input('video');
        $fullpathToImage = $request->input('thumbnail');
        $video = Youtube::upload($video, [
            'title'       => $request->input('title'),
            'description' => $request->input('description')
        ])->withThumbnail($fullpathToImage);
        return $video->getVideoId();
    }
    public function CreatePlaylist(Request $request) {
        $redirect_url ='http://localhost/youtube-uploader/public/youtube/callback/another_callback';
        $youtube = Youtube::setRedirectUrl($redirect_url)
                          ->createPlaylist('TITLE', 'DESCRIPTION');
  
        // Get playlist id
        $playlist_id = $youtube->createdPlaylistId();
  }
}
