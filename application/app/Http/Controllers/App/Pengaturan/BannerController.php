<?php

namespace TheFarrelHotel\Http\Controllers\App\Pengaturan;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Pengaturan\Banner;


use DB, Form;

class BannerController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Banner::orderBy("urutan", "asc")->get();
        return view('pengaturan.banner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('selet');
        return view('pengaturan.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try
        {
            foreach ($request->file as $file) {
                $path = $file->store('banners');

                \Storage::makeDirectory('thumbnails/banners');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(1600, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $banner = new Banner();
                $banner->banner_path = $path;
                $banner->banner_path_thumb = 'thumbnails/'.$path;
                $banner->save();
            }
            DB::commit();

            return response()->json(['redirect_url' => url('pengaturan/banner')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Banner berhasil ditambah',
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
        return redirect('pengaturan.banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('pengaturan/banner');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['banner'] = Banner::findOrFail($id);
        return view('pengaturan.banner.edit', $this->data);
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

        DB::beginTransaction();
        try
        {
            /*foreach ($request->file as $file) {
                    $path = $file->store('banners');
                    $banner = Banner::findOrFail($id);
                    $banner->banner_path = $path;
                    $banner->save();
            }*/

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Banner berhasil diubah',
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
        return redirect('pengaturan/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // ! GA SIDO DIGAWE
        try
        {
            $detail = Banner::where('id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->banner_path));
                unlink(storage_path('app/public/'.$detail->banner_path_thumb));
                $detail->delete();
            }
            notify()->flash('Success!', 'success', [
                'text' => 'Banner berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('pengaturan/banner');
    }

    public function deleteGambar(Request $request)
    {
        $id = $request->id;
        $path = $request->path;
        try
        {
            $banner = Banner::find($id);
            $banner->urutan = null;
            $banner->save();
            $banner->delete();
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
        return response()->json(url('pengaturan/banner'));
    }

    public function simpanUrutan(Request $request)
    {
        $urutan = $request->urutan;
        DB::beginTransaction();
        try
        {
            foreach ($urutan as $index => $id) {
                $banner = Banner::find($id);
                if($banner) {
                    $banner->urutan = $index+1;
                    $banner->save();
                }
            }
            DB::commit();
            return response()->json(url('pengaturan/banner'));
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            return response()->json("error", 500);
        }
        return response()->json("error", 500);
    }
}
