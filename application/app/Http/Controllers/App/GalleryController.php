<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Gallery;

use Illuminate\Support\Facades\Storage;

use DB, Form;

class GalleryController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $getData = Gallery::select('*')->where('galleries.deleted_at','=',null);

    //         $datatables = Datatables::of($getData)
    //             ->addColumn('action', function ($value) {

    //                 $html =
    //                     \Form::open([ 'method'  => 'delete', 'route' => [ 'galeri.destroy', $value->around_id ], 'style' => 'display: inline-block;' ]).
    //                     '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Sekeliling '.$value->gallery_path.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
    //                     .\Form::close();

    //                 return $html;
    //             })
    //             ->rawColumns(['action']);
    //         return $datatables->make(true);
    //     }
    //     return view('galeri.index');
    // }

    public function index(Request $request)
    {
        $data = Gallery::all();
        return view('galeri.index_new', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('selet');
        return view('galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // AJAX Request
        // $this->validate($request, [
        //     'file' => 'required'
        // ]);

        DB::beginTransaction();
        try
        {
            foreach ($request->file as $file) {
                $path = $file->store('galleries');

                \Storage::makeDirectory('thumbnails/galleries');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $gallery = new Gallery();
                $gallery->gallery_path = $path;
                $gallery->gallery_path_thumb = 'thumbnails/'.$path;
                $gallery->save();
            }
            DB::commit();

            return response()->json(['redirect_url' => url('galeri')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Gallery berhasil ditambah',
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
        return redirect('galeri');
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
        $this->data['gallery'] = Gallery::findOrFail($id);
        return view('galeri.edit', $this->data);
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
            'file' => 'required'
        ]);

        DB::beginTransaction();
        try
        {
            // $gallery = Gallery::findOrFail($id);
            // $gallery->gallery_path = $request->gallery_path;
            // $gallery->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Gallery berhasil diubah',
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
        return redirect('galeri');
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
            Gallery::destroy($id);
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
        return redirect('galeri');
    }

    public function deleteGambar(Request $request)
    {
        $id = $request->id;
        $path = $request->path;
        try
        {
            Gallery::destroy($id);
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
        return response()->json(url('galeri'));
    }
}
