<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Around;


use DB, Form;

class AroundController extends AppController
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
            $getData = Around::select('*')->where('arounds.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('sekeliling/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'sekeliling.destroy', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Sekeliling '.$value->around_name.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('sekeliling.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //dd('selet');
        return view('sekeliling.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'around_name' => 'required',
                'around_name_eng' => 'required',
                'around_description' => 'required',
                'around_description_eng' => 'required',
                'link_map' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
           foreach ($request->file as $file) {
                $path = $file->store('arounds');

                \Storage::makeDirectory('thumbnails/arounds');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $around = new Around();
                $around->around_name = $request->around_name;
                $around->around_name_eng = $request->around_name_eng;
                $around->around_description = $request->around_description;
                $around->around_description_eng = $request->around_description_eng;
                $around->link_map = $request->link_map;
                //$facility->path = $request->path;
                $around->path = $path;
                $around->path_thumb = 'thumbnails/'.$path;
                $around->save();
                //dd($facility);
            }
            DB::commit();
            //return response()->json($request->file);
            return response()->json(['redirect_url' => url('sekeliling')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Data Sekeliling berhasil ditambah',
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
        return redirect('sekeliling');
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
        $this->data['around'] = Around::findOrFail($id);
        return view('sekeliling.edit', $this->data);
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
                'around_name' => 'required',
                'around_description' => 'required',
                'around_name_eng' => 'required',
                'around_description_eng' => 'required',
                'link_map' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
            $around = Around::findOrFail($id);
            $around->around_name = $request->around_name;
            $around->around_description = $request->around_description;
            $around->around_name_eng = $request->around_name_eng;
            $around->around_description_eng = $request->around_description_eng;
            $around->path = $request->path;
            $around->link_map = $request->link_map;
            $around->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Data Sekeliling berhasil diubah',
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
        return redirect('sekeliling');
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
            $detail = Around::where('id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->path));
                unlink(storage_path('app/public/thumbnails/'.$detail->path));
                $detail->delete();
            }
            Around::destroy($id);
            notify()->flash('Success!', 'success', [
                'text' => 'Data Sekeliling berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('sekeliling');
    }
}
