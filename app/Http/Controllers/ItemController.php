<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * ユーザーログインの判定をおこなう
     * ログインしていない場合は認証ページへリダイレクト
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 飲食店一覧
     */
    public function index()
    {
        // 飲食店一覧取得
        $items = Item::orderBy('address')->get();

        return view('item.index', compact('items'));
    }

    /**
     * 店舗登録
     */
    public function add(Request $request)
    {
        $categories = Category::all();

        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'category' => 'required',
                'address' => 'nullable|max:255',
                'tel' => 'nullable|max:30',
                'ex_link' => 'nullable|url',
            ]);

            // 店舗登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'category_id' => $request->category,
                'address' => $request->address,
                'tel' => $request->tel,
                'ex_link' => $request->ex_link,
                'memo' => $request->memo,
            ]);

            return redirect('/items');
        }

        return view('item.add', compact('categories'));
    }

    /**
     * 詳細
     */
    public function detail($id)
    {
        // 詳細店舗の取得
        $item = Item::find($id);
        return view('item.detail', compact('item'));
    }
}
