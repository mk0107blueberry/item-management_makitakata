<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;

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
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        // 検索ワードがある場合
        if (isset($request->keyword)) {
            $items = Item::orderBy('address')
            ->where('user_id', auth()->id())
            ->where(function($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->keyword%")
                      ->orWhere('address', 'LIKE', "%$request->keyword%")
                      ->orWhere('tel', 'LIKE', "%$request->keyword%");
            })
            ->paginate(10);
        } else {
            // 飲食店一覧取得
            $items = Item::orderBy('address')
            ->where('user_id', auth()->id())
            ->paginate(10);
        }

        return view('item.index', compact('items', 'keyword'));
    }

    /**
     * 店舗登録
     */
    public function add(Request $request)
    {
        $categories = Category::all();

        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            
            //POSTされた画像ファイルデータ取得しbase64でエンコードする
            $image = $request->image;
            if (!empty($image)) {
                $image = "data:image/png;base64,". base64_encode(file_get_contents($request->image->getRealPath()));
            }

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
                'image' => $image,
            ]);

            $request->session()->flash('message', 'お店を登録しました');
            return redirect('/items');
        }

        return view('item.add', compact('categories'));
    }

    /**
     * 店舗詳細
     */
    public function detail($id)
    {
        // 店舗の取得
        $item = Item::find($id);

        // ユーザーIDが一致しているか判定
        $login_user = auth()->id();
        if ($item->user_id === $login_user) {
            return view('item.detail', compact('item'));
        } else {
            abort(403, '閲覧権限がありません');
        }
    }

    /**
     * 店舗詳細 メモ更新
     */
    public function memoUpdate(Request $request, $id)
    {
        $item = Item::find($id);
        $item->memo = $request->text;
        $item->save();
        return response()->json(['message' => 'Memo updated']);
    }

    /**
     * 店舗編集画面
     */
    public function edit($id)
    {
        // 店舗とカテゴリーの取得
        $item = Item::find($id);
        $categories = Category::all();

        // ユーザーIDが一致しているか判定
        $login_user = auth()->id();
        if ($item->user_id === $login_user) {
            return view('item.edit', compact('item', 'categories'));
        } else {
            abort(403, '閲覧権限がありません');
        }
    }

    /**
     * 店舗更新
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        $this->validate($request, [
            'name' => 'required|max:100',
            'category' => 'required',
            'address' => 'nullable|max:255',
            'tel' => 'nullable|max:30',
            'ex_link' => 'nullable|url',
        ]);
    
        $item->name = $request->name;
        $item->category_id = $request->category;
        $item->address = $request->address;
        $item->tel = $request->tel;
        $item->ex_link = $request->ex_link;
        $item->memo = $request->memo;
    
        if ($request->hasFile('image')) {
            // 新しい画像を64エンコードしてデータベースに保存
            $imageData = "data:image/png;base64," . base64_encode(file_get_contents($request->file('image')->getRealPath()));
            $item->image = $imageData;
        } elseif ($request->input('delete_image') == 'on') {
            // チェックボックスがチェックされている場合、元の画像を削除
            $item->image = null;
        }
            $item->save();

            $request->session()->flash('message', 'お店の情報を更新しました');
            return redirect('/items');
    }

    /**
     * 店舗削除
     */
    public function destroy(Request $request, $id)
    {
            $item = Item::find($id);

            $item->delete();

            $request->session()->flash('delete-message', 'お店の情報を削除しました');
            return redirect('/items');
    }

    /**
     * ピン留め ON/OFF：詳細画面
     */
    public function pin($id)
    {
        $item = Item::find($id);

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
     * ピン留め ON/OFF：一覧画面
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
     * カテゴリー毎の一覧
     */
    public function category(Request $request, $category_id)
    {
        $keyword = $request->keyword;
        // 検索ワードがある場合
        if (isset($request->keyword)) {
            $items = Item::orderBy('address')
                ->where('user_id', auth()->id())
                ->where('category_id', $category_id)
                ->where(function($query) use ($request) {
                    $query->where('name', 'LIKE', "%$request->keyword%")
                          ->orWhere('address', 'LIKE', "%$request->keyword%")
                          ->orWhere('tel', 'LIKE', "%$request->keyword%");
                })
                ->paginate(10);
        } else {
            // 飲食店一覧取得
            $items = Item::orderBy('address')
            ->where('user_id', auth()->id())
            ->where('category_id', $category_id)
            ->paginate(10);
        }

        return view('item.category'.$category_id, compact('items', 'keyword'));
    }
}
