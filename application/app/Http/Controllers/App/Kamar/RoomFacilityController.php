<?php

namespace TheFarrelHotel\Http\Controllers\App\Kamar;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Kamar\Room;
use TheFarrelHotel\Http\Models\Kamar\DetailRoom;
use TheFarrelHotel\Http\Models\Kamar\RoomRoomFacility;
use TheFarrelHotel\Http\Models\Kamar\RoomFacility;

use DB, Form;

class RoomFacilityController extends AppController
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
            $getData = RoomFacility::select('*')->where('room_facilities.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('kamar/fasilitas-kamar/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'fasilitas-kamar.destroy', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Fasilitas Kamar '.$value->id.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('kamar.fasilitas-kamar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //dd('selet');
        
        return view('kamar.fasilitas-kamar.create');
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
            'facility_name' => 'required',
            'icon_fa' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $roomfasilitas = new RoomFacility();
            $roomfasilitas->facility_name = $request->facility_name;
            $roomfasilitas->icon_fa = $request->icon_fa;
            $roomfasilitas->save();
            DB::commit();
            notify()->flash('Sukses!', 'success', [
                'text' => 'Fasilitas Kamar berhasil ditambah',
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
        return redirect('kamar/fasilitas-kamar');
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
        $data = DetailRoom::where('room_id', $id)->get();
        return view('kamar.fasilitas-kamar.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['roomfasilitas'] = RoomFacility::findOrFail($id);
        return view('kamar.fasilitas-kamar.edit', $this->data);
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
                'icon_fa' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
            $roomfasilitas = RoomFacility::findOrFail($id);
            $roomfasilitas->facility_name = $request->facility_name;
            $roomfasilitas->icon_fa = $request->icon_fa;
            
            $roomfasilitas->save();
            

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Fasilitas Kamar berhasil diubah',
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
        return redirect('kamar/fasilitas-kamar');
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
            RoomFacility::destroy($id);
            notify()->flash('Success!', 'success', [
                'text' => 'Fasilitas Kamar berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('kamar/fasilitas-kamar');
    }

    
}
