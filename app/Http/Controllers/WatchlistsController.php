<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Watchlist;

use App\Http\Resources\WatchlistCollection;

use App\Services\WatchlistService;

class WatchlistsController extends Controller
{
    private $watchlistService;
    private $watchlist;

    public function __construct(WatchlistService $watchlistService, Watchlist $watchlist) {
      $this->watchlistService = $watchlistService;
      $this->watchlist = $watchlist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $watchlists = $this->watchlist->get();

        return new WatchlistCollection($watchlists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $watchlist = Watchlist::create([
        //   'name' => $request->watchlist,
        //   'user_id' => 1,
        // ]);
        $created = $this->watchlistService->create($request);

        if($created) return response()->json('Success add watchlist');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
