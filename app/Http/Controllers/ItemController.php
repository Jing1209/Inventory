<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Status;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ItemImage;
use Barryvdh\DomPDF\Facade\PDF;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        // $categories = Category::orderBy('id','desc')->paginate(0);
        // $items = Item::orderBy('id','desc')->paginate(5);
        $items = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->join('sponsors', 'items.sponsored', '=', 'sponsors.id')
            ->join('itemimages','itemimages.item_id','=','items.id')
            ->where(function ($query) use ($request) {
                if ($term = $request->term) {
                    $query->orWhere('items.title', 'like', '%' . $term . '%')
                        ->orWhere('categories.category', 'like', '%' . $term . '%');
                }
            })
            ->select('items.id', 'items.title', 'items.price', 'statuses.status', 'sponsors.name', 'categories.category', 'items.description', 'items.item_id','itemimages.url')
            ->orderBy('id', 'asc')->paginate(10);
        // $image = DB::table('items')
        //     ->join('itemimages', 'items.id', '=', 'itemimages.item_id')
        //     ->select('itemimages.url')
        //     ->where('itemimages.item_id', '=', $item->id)->get();
        $countBad = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Bad%')->count();
        $countGood = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Good%')->count();
        $countMedium = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Medium%')->count();
        $countBroken = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Broken%')->count();
        // dd($countBad);

        return view('Item.index')->with(compact('items'))->with(compact('countBad'))->with(compact('countGood'))->with(compact('countMedium'))->with(compact('countBroken'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        $categories = Category::orderBy('id', 'desc')->get();
        $status = Status::orderBy('id', 'desc')->get();
        $sponsor = Sponsor::orderBy('id', 'desc')->get();
        return view('Item.create')->with(compact('categories'))->with(compact('status'))->with(compact('sponsor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $request ->validate([

        // ]);
        // Item::create($request->post());
        $request->validate(['id'=>'unique:items', 'item_id'=> 'unique:items']);
        
        $item = new Item();
        $item['title'] = $request->title;
        $item['description'] = $request->description;
        $item['price'] = $request->price;
        $item['status'] = $request->status;
        $item['category_id'] = $request->category_id;
        $item['sponsored'] = $request->sponsored;
        $item['item_id'] = $request->item_id;
        $item->save();

        $quantity = Category::find($request->category_id);
        $quantity->quantity += 1;
        $quantity->save();

        $data = new ItemImage();

        if ($request->file('images')) {
            $file = $request->file('images');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $data['url'] = $filename;
        }
        $data['item_id'] = $item->id;
        $data->save();


        return redirect()->route('items.index')->with('success', 'Item has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
        $items = DB::table('items')
            ->join('itemimages', 'items.id', '=', 'itemimages.item_id')
            ->select('items.id', 'items.title', 'items.price', 'items.status')
            ->where('items.id', '=', $item->id)
            ->get();
        $image = DB::table('items')
            ->join('itemimages', 'items.id', '=', 'itemimages.item_id')
            ->select('itemimages.url')
            ->where('itemimages.item_id', '=', $item->id)->get();
        $categories = Category::orderBy('id', 'desc')->get();
        $status = Status::orderBy('id', 'desc')->get();
        $sponsor = Sponsor::orderBy('id', 'desc')->get();
        return view('Item.edit')->with(compact('categories'))->with(compact('status'))->with(compact('sponsor'))->with(compact('item'))->with(compact('items'))->with(compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //

        $item->fill($request->post())->save();

        $image = ItemImage::where('item_id', '=', $item->id);
        // dd($image);

        return redirect()->route('items.index')->with('success', 'Item Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
        // dd($item->id);
        $deleteImage = DB::table('itemimages')->where('item_id', '=', $item->id)->delete();
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item Has Been removed successfully');
    }

    public function createPDF(){
        // dd('hello');
        $data = DB::table('items')->select('title')->distinct()->get();
        // dd($data[0]->title);
        $countBad = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            // ->where('items.title','like',$data[0]->title)
            ->where(function($query) use ($data){
                    foreach($data as $data1){
                        $query->where('items.title','like',$data1->title,'or');
                    }
            })
            ->where('statuses.status', 'like', '%Bad%')->get();
            // dd($countBad);

        $countGood = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            // ->where('items.title','like',$data[0]->title)
            ->where(function($query) use ($data){
                foreach($data as $data1){
                    $query->where('items.title','like',$data1->title,'or');
                }
        })
            ->where('statuses.status', 'like', '%Good%')->get();
            // dd($countGood);

        $countMedium = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            // ->where('items.title','like',$data[0]->title)
            ->where(function($query) use ($data){
                foreach($data as $data1){
                    $query->where('items.title','like',$data1->title,'or');
                }
        })
            ->where('statuses.status', 'like', '%Medium%')->get();

        $countBroken = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            // ->where('items.title','like',$data[0]->title)
            ->where(function($query) use ($data){
                foreach($data as $data1){
                    $query->where('items.title','like',$data1->title,'or');
                }
        })
            ->where('statuses.status', 'like', '%Broken%')->get();


        return view('Item.itemPDF')->with(compact('data'))->with(compact('countBad'))->with(compact('countGood'))->with(compact('countBroken'))
        ->with(compact('countMedium'));    
    }
   
}
