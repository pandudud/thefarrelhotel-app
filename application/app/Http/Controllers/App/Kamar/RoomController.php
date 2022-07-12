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

class RoomController extends AppController
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
            $getData = Room::select('*')->where('rooms.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('kamar/kamar-hotel/'.$value->id.'').'" class="btn btn-xs blue " >Detail</a>'.
                        '<a href="'.url('kamar/kamar-hotel/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'post', 'route' => [ 'kamar-hotel.destroyroom', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Kamar '.$value->id.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('kamar.kamar-hotel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('selet');
        $data['room_facility_id'] = RoomFacility::pluck('facility_name', 'id');
        return view('kamar.kamar-hotel.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
                'room_name' => 'required',
                'room_price' => 'required',
                'room_description' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
            //$room_price = $request->room_price;
            $room = new Room();
            $room->room_name = $request->room_name;
            $room->room_name_eng = $request->room_name_eng;
            $room->room_name_slug = str_slug($request->room_name);
            $room->room_price =$request->room_price;
            $room->room_description = $request->room_description;
            $room->room_description_eng = $request->room_description_eng;

            if($room->save())
            {
                foreach ($request->file as $file) {
                    $path = $file->store('picture_rooms');

                    \Storage::makeDirectory('thumbnails/picture_rooms');
                    $img = \Image::make(storage_path('app/public/' . $path));
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(storage_path('app/public/thumbnails/' . $path));

                    $modelDetail = new DetailRoom();
                    $modelDetail->room_id = $room->id;
                    $modelDetail->picture_path = $path;
                    $modelDetail->picture_path_thumb = 'thumbnails/'.$path;
                    $modelDetail->save();
                }

                foreach($request->room_facility_id as $rrm) {
                    $rfid = explode(',', $rrm);
                    foreach($rfid as $item) {
                        $fasilitaskamar = new RoomRoomFacility();
                        $fasilitaskamar->room_id = $room->id;
                        $fasilitaskamar->room_facility_id = $item;
                        $fasilitaskamar->save();
                    }
                }
            }

            $room->save();

            DB::commit();

            return response()->json(['redirect_url' => url('kamar/kamar-hotel')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Kamar berhasil ditambah',
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
        return redirect('kamar/kamar-hotel');
    }

    public function gambar($id)
    {
       /* $event = Event::findOrFail($id);*/
        return view('kamar.kamar-hotel.gambar', compact('id'));
    }

    public function storewith(Request $request)
    {
        DB::beginTransaction();
        try
        {
            foreach ($request->file as $file) {
                $path = $file->store('picture_rooms');
                $modelDetail = new DetailRoom();
                $modelDetail->room_id = $request->room_id;
                $modelDetail->picture_path = $path;
                $modelDetail->save();
            }
            DB::commit();

            return response()->json(['redirect_url' => url('kamar/kamar-hotel')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Room berhasil ditambah',
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
        return redirect('kamar/kamar-hotel');
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
        return view('kamar.kamar-hotel.show', compact('data', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['room_facility_id'] = RoomFacility::pluck('facility_name', 'id');
        $this->data['room'] = Room::findOrFail($id);
        return view('kamar.kamar-hotel.edit', $this->data);
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
                'room_name' => 'required',
                'room_name_eng' => 'required',
                'room_price' => 'required',
                'room_description' => 'required',
                'room_description_eng' => 'required',
        ]);

        DB::beginTransaction();
        try
        {
            $room = Room::findOrFail($id);
            $room->room_name = $request->room_name;
            $room->room_name_eng = $request->room_name_eng;
            $room->room_price =$request->room_price;
            $room->room_description = $request->room_description;
            $room->room_description_eng = $request->room_description_eng;

            if($room->save())
            {
                RoomRoomFacility::where('room_id', $id)->delete();
                foreach($request->room_facility_id as $rrm) {
                    $rfid = explode(',', $rrm);
                    foreach($rfid as $item) {
                        $fasilitaskamar = new RoomRoomFacility();
                        $fasilitaskamar->room_id = $room->id;
                        $fasilitaskamar->room_facility_id = $item;
                        $fasilitaskamar->save();
                    }
                }
            }
            $room->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Kamar berhasil diubah',
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
        return redirect('kamar/kamar-hotel');
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
            $detail = DetailRoom::where('room_id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->picture_path));
                $detail->delete();
            }

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Kamar berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('kamar/kamar-hotel');
    }

    public function destroyroom($id)
    {
       try
        {
            RoomRoomFacility::where('room_id', $id)->delete();
            Room::destroy($id);
            notify()->flash('Success!', 'success', [
                'text' => 'Room berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('kamar/kamar-hotel');
    }
    public function deleteGambar(Request $request)
    {
        $id = $request->id;
        $path = $request->path;
        try
        {
            DetailRoom::destroy($id);
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
        return response()->json(url('kamar/kamar-hotel'));
    }
}
