<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Facility;


use DB, Form;

class FacilityController extends AppController
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
            $data = Facility::query();

            $datatables = Datatables::of($data)
                ->addColumn('action', function ($value) {
                    $html =
                        '<a href="'.url('fasilitas/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'fasilitas.destroy', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Sekeliling '.$value->facility_name.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->addColumn('path_html', function ($value) {
                    return $value->picture_url_thumb;
                })
                ->rawColumns(['path_html', 'action']);
            return $datatables->make(true);
        }
        return view('fasilitas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fasilitas.create');
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
            return redirect('fasilitas');
        }

        $validator = \Validator::make($request->all(), [
            'facility_name' => 'required',
            'facility_description' => 'required',
            'facility_name_eng' => 'required',
            'facility_description_eng' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
           foreach ($request->file as $file) {
                $path = $file->store('facilities');

                \Storage::makeDirectory('thumbnails/facilities');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $facility = new Facility();
                $facility->facility_name = $request->facility_name;
                $facility->facility_name_eng = $request->facility_name_eng;
                $facility->facility_description = $request->facility_description;
                $facility->facility_description_eng = $request->facility_description_eng;
                $facility->facility_detail = $request->facilit_detail;
                $facility->facility_detail_eng = $request->facilit_detail_eng;
                $facility->facility_name_slug = str_slug($facility->facility_name);
                $facility->path = $path;
                $facility->path_thumb = 'thumbnails/'.$path;
                $facility->save();
            }
            DB::commit();

            notify()->flash('Success!', 'success', [
                'text' => 'Data Fasilitas berhasil ditambah',
            ]);
            return response()->json(['redirect_url' => url('fasilitas')]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            $pesan = config('app.debug') ? ' Pesan kesalahan: '.$e->getMessage() : '';
            return response()->json('Terjadi kesalahan pada database.'.$pesan, 500);
        }
        return response()->json('error', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('fasilitas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['facility'] = Facility::findOrFail($id);
        return view('fasilitas.edit', $this->data);
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
            'facility_name' => 'required',
            'facility_description' => 'required',
            'facility_name_eng' => 'required',
            'facility_description_eng' => 'required'
        ]);

        DB::beginTransaction();
        try
        {
            $facility = Facility::findOrFail($id);
            $facility->facility_name = $request->facility_name;
            $facility->facility_name_eng = $request->facility_name_eng;
            $facility->facility_description = $request->facility_description;
            $facility->facility_description_eng = $request->facility_description_eng;
            $facility->facility_detail = $request->facility_detail;
            $facility->facility_detail_eng = $request->facility_detail_eng;
            $facility->facility_name_slug = str_slug($facility->facility_name);
            if($request->file('path')) {
                unlink(storage_path('app/public/'.$facility->path));
                unlink(storage_path('app/public/thumbnails/'.$facility->path));
                $path = $request->file('path')->store('facilities');
                \Storage::makeDirectory('thumbnails/facilities');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));
                $facility->path = $path;
                $facility->path_thumb = 'thumbnails/'.$path;
            }
            $facility->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Data Fasilitas berhasil diubah',
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
        return redirect('fasilitas');
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
            $detail = Facility::where('id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->path));
                unlink(storage_path('app/public/'.$detail->path_thumb));
                $detail->delete();
            }
            Facility::destroy($id);
            notify()->flash('Success!', 'success', [
                'text' => 'Data Fasilitas berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('fasilitas');
    }

    
}
