<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Promotion;
use TheFarrelHotel\Http\Models\DetailPromotion;

use DB, Form;

class PromotionController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $getData = Promotion::select('*')->where('promotions.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('promosi/'.$value->id.'').'" class="btn btn-xs blue " >Detail</a>'.
                        '<a href="'.url('promosi/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'post', 'route' => [ 'promosi.destroypromotion', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Promosi '.$value->id.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('promosi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promosi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->wantsJson() || !$request->ajax()) {
            return redirect('promosi');
        }

        $validator = \Validator::make($request->all(), [
            'promotion_name' => 'required',
            'promotion_name_eng' => 'required',
            'promotion_description' => 'required',
            'promotion_description_eng' => 'required',
        ]);

        if($validator->fails()) {
            $errorMsg = '';
            $errors = $validator->errors();
            foreach ($errors->all() as $error) {
                $errorMsg .= $error.'<br />';
            }
            return response()->json($errorMsg, 422);
        }

        DB::beginTransaction();
        try
        {
            $promotion = new Promotion();
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_name_eng = $request->promotion_name_eng;
            $promotion->promotion_name_slug = str_slug($promotion->promotion_name);
            $promotion->promotion_description = $request->promotion_description;
            $promotion->promotion_description_eng = $request->promotion_description_eng;
            if($promotion->save())
            {
                foreach ($request->file as $file) {
                    $path = $file->store('picture_promotions');

                    \Storage::makeDirectory('thumbnails/picture_promotions');
                    $img = \Image::make(storage_path('app/public/' . $path));
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(storage_path('app/public/thumbnails/' . $path));

                    $modelDetail = new DetailPromotion();
                    $modelDetail->promotion_id = $promotion->id;
                    $modelDetail->picture_path = $path;
                    $modelDetail->picture_path_thumb = 'thumbnails/'.$path;
                    $modelDetail->save();
                }
            }

            $promotion->save();

            DB::commit();

            notify()->flash('Success!', 'success', [
                'text' => 'Data Promosi berhasil ditambah',
            ]);
            return response()->json(['redirect_url' => url('promosi')]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            $pesan = config('app.debug') ? ' Pesan kesalahan: '.$e->getMessage() : '';
            return response()->json('Terjadi kesalahan pada database.'.$pesan, 500);
        }
        return response()->json('error', 500);
    }
    public function gambar($id)
    {
        return view('promosi.gambar', compact('id'));
    }

    public function storewith(Request $request)
    {
        DB::beginTransaction();
        try
        {
            foreach ($request->file as $file) {
                $path = $file->store('picture_promotions');

                \Storage::makeDirectory('thumbnails/picture_promotions');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $modelDetail = new DetailPromotion();
                $modelDetail->promotion_id = $request->promotion_id;
                $modelDetail->picture_path = $path;
                $modelDetail->picture_path_thumb = 'thumbnails/'.$path;
                $modelDetail->save();
            }
            DB::commit();

            return response()->json(['redirect_url' => url('promosi')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Promosi berhasil ditambah',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            $pesan = config('app.debug') ? ' Pesan kesalahan: '.$e->getMessage() : '';
            notify()->flash('Gagal!', 'error', [
                'text' => 'Terjadi kesalahan pada database.'.$pesan,
            ]);
        }
        return redirect('promosi');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DetailPromotion::where('promotion_id', $id)->get();
        return view('promosi.show', compact('data', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['promotion'] = Promotion::findOrFail($id);
        return view('promosi.edit', $this->data);
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
        $this->validate($request, [
            'promotion_name' => 'required',
            'promotion_description' => 'required'
        ]);

        DB::beginTransaction();
        try
        {
            $promotion = Promotion::findOrFail($id);
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_name_eng = $request->promotion_name_eng;
            $promotion->promotion_description = $request->promotion_description;
            $promotion->promotion_description_eng = $request->promotion_description_eng;
            $promotion->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Promosi berhasil diubah',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            $pesan = config('app.debug') ? ' Pesan kesalahan: '.$e->getMessage() : '';
            notify()->flash('Gagal!', 'error', [
                'text' => 'Terjadi kesalahan pada database.'.$pesan,
            ]);
        }
        return redirect('promosi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try
        {
            $detail = DetailPromotion::where('promotion_id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->picture_path));
                unlink(storage_path('app/public/'.$detail->picture_path_thumb));
                $detail->delete();
            }
            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Promosi berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('promosi');
    }

    public function destroypromotion($id)
    {
       try
        {
            $detail = DetailPromotion::where('promotion_id', $id)->get();
            foreach ($detail as $item) {
                unlink(storage_path('app/public/'.$item->picture_path));
                unlink(storage_path('app/public/thumbnails/'.$item->picture_path));
            }

            Promotion::destroy($id);
            notify()->flash('Success!', 'success', [
                'text' => 'Promosi berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('promosi');
    }

    public function deleteGambar(Request $request)
    {
        $id = $request->id;
        $path = $request->path;
        try
        {
            DetailPromotion::destroy($id);
            unlink(storage_path('app/public/'.$path));
            unlink(storage_path('app/public/thumbnails/'.$path));
            notify()->flash('Success!', 'success', [
                'text' => 'Gambar berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
        return response()->json(url('promosi'));
    }
}
