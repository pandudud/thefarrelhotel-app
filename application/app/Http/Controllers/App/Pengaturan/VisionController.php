<?php

namespace TheFarrelHotel\Http\Controllers\App\Pengaturan;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Pengaturan\Vision;
use DB;

class VisionController extends AppController
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
            $getData = Vision::select('*')->where('visions.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                       '<a href="'.url('pengaturan/visi-misi/'.$value->vision_id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>';
                        

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('pengaturan.visi-misi.index');
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
        $data['visi'] = Vision::findOrFail($id);
        return view('pengaturan.visi-misi.edit', $data);
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
            'vision' => 'required',
            'mission' => 'required',
            'vision_eng' => 'required',
            'mission_eng' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $visi = Vision::findOrFail($id);
            $visi->vision = $request->vision;
            $visi->vision_eng = $request->vision_eng;
            $visi->mission = $request->mission;
            $visi->mission_eng = $request->mission_eng;

            $visi->save();
            //dd($request->all());
            DB::commit();
            notify()->flash('Sukses!', 'success', [
                'text' => 'Visi dan Misi berhasil diubah',
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
        return redirect('pengaturan/visi-misi');
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
