<?php

namespace TheFarrelHotel\Http\Controllers\App\Pengaturan;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Pengaturan\SocialMedia;
use DB;

class SocialMediaController extends AppController
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
            $getData = SocialMedia::select('*')->where('social_medias.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('pengaturan/sosial-media/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>';
                        

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('pengaturan.sosial-media.index');
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
        //
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
        $data['socialmedia'] = SocialMedia::findOrFail($id);
        return view('pengaturan.sosial-media.edit', $data);
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
            'instagram' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'youtube' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $socialmedia = SocialMedia::findOrFail($id);
            $socialmedia->instagram = $request->instagram;
            $socialmedia->facebook = $request->facebook;
            $socialmedia->twitter = $request->twitter;
            $socialmedia->youtube = $request->youtube;
            $socialmedia->save();
            //dd($request->all());
            DB::commit();
            notify()->flash('Sukses!', 'success', [
                'text' => 'Sosial Media berhasil diubah',
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
        return redirect('pengaturan/sosial-media');
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
