<?php

namespace TheFarrelHotel\Http\Controllers\App\Pengaturan;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Pengaturan\About;
use DB;

class AboutController extends AppController
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
            $getData = About::select('*')->where('abouts.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('pengaturan/tentang-kami/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>';
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('pengaturan.tentang-kami.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('pengaturan/tentang-kami');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('pengaturan/tentang-kami');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        return view('errors.404');
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['about'] = About::findOrFail($id);
        return view('pengaturan.tentang-kami.edit', $data);
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
            'about_us' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $about = About::findOrFail($id);
            $about->about_us = $request->about_us;
            $about->about_us_eng = $request->about_us_eng;
            $about->save();
            //dd($request->all());
            DB::commit();
            notify()->flash('Sukses!', 'success', [
                'text' => 'Tentang Kami berhasil diubah',
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
        return redirect('pengaturan/tentang-kami');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect('pengaturan/tentang-kami');
    }
}
