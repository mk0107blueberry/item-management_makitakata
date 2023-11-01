<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Item::orderBy('address')
        ->where('user_id', auth()->id())
        ->where('pin', 'pinned')
        ->get();
        return view('home', compact('items'));
    }

    /**
     * 個別ピン留め ON/OFF：ダッシュボード
     */
    public function pinIndex(Request $request)
    {
        $item = Item::find($request->itemId);

        if($item->pin === null) {
            $item->pin = 'pinned';
            $item->save();
        } else {
            $item->pin = null;
            $item->save();
        }

        return response()->json(['message' => 'OK', 'status' => $item->pin]);
    }    

    /**
     * 一括ピン留め ON/OFF：ダッシュボード
     */
    public function pinItems(Request $request)
{
    $itemIds = $request->input('itemIds');

    foreach ($itemIds as $itemId) {
        $item = Item::find($itemId);

        if ($item->pin === null) {
            $item->pin = 'pinned';
            $item->save();
        } else {
            $item->pin = null;
            $item->save();
        }
    }

    return response()->json(['message' => 'OK']);
    }
}
