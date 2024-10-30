<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\View\View;
use \DataTables;


class EncoderController extends Controller
{

    /**
     * Fetch encoder videos
    */
    public function fetchVideos(): View
    {
        $videos = Video::where('status', Video::$VIDEO_STATUS_ENCODING)->
        orderBy('id', 'DESC')->select(['id', 'file_name', 'video_id', 'progress', 'created_at'])->get();

        return view('pages.encoder.fetch_video', compact('videos'));
    }

    /**
     * Response all Encoding videos
    */
    public function getAllEncodingVideos(): JsonResponse
    {
        $videos = Video::where('status', Video::$VIDEO_STATUS_ENCODING)
            ->orderBy('id', 'DESC')
            ->select(['id', 'file_name', 'video_id', 'progress', 'created_at'])
            ->get()
            ->map(function ($video) {
                // Format the created_at attribute
                $video->fetched_at = $video->created_at->format('d-m-Y H:i:A');
                return $video;
            });

        return response()->json($videos);
    }


    /**
     * Fetch all videos
    */
    public function fetchAllVideos(): View
    {
        $videos = Video::select(['id', 'file_name', 'video_id', 'status', 'created_at'])->
                        orderBy('id', 'DESC')
                        ->get();

        return view('pages.encoder.all-videos', compact('videos'));
    }

    /**
     * Encoding video List
    */
    public function encodingList(): View
    {
        return view('pages.encoder.encoding_list');
    }

    /**
     * Get getEncodingList
    */
    public function getEncodingList(Request $request)
    {
        Artisan::call('app:fetch-and-store-videos');

        $videos = Video::query()
            ->where('status', Video::$VIDEO_STATUS_PENDING)
            ->orderBy('id', 'DESC');

        return DataTables::eloquent($videos)
            ->addColumn('action', function ($video) {
                return '
                <p class="text-center">
                    <input type="checkbox" class="btn btn-primary encodingCheckbox" data-id="' . $video->id . '" />
                </p>
                ';
            })->rawColumns(['action'])->make(true);
    }

    /**
     * Encoded Videos view
    */
    public function encodedVideos(): View
    {
        $videos = Video::where('status', Video::$VIDEO_STATUS_COMPLETED)->
        orderBy('id', 'DESC')->get();

        return view('pages.encoder.encoded_videos', compact('videos'));
    }
}
