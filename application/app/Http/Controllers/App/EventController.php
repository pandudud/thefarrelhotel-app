<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;

use Yajra\Datatables\Facades\Datatables;
use TheFarrelHotel\Http\Models\Event;
use TheFarrelHotel\Http\Models\DetailEvent;

use DB, Form;

class EventController extends AppController
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
            $getData = Event::select('*')->where('events.deleted_at','=',null);

            $datatables = Datatables::of($getData)
                ->addColumn('action', function ($value) {

                    $html =
                        '<a href="'.url('event/'.$value->id.'').'" class="btn btn-xs blue " >Detail</a>'.
                        '<a href="'.url('event/'.$value->id.'/ubah').'" class="btn btn-xs purple-sharp tooltips" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '&nbsp;'

                        .\Form::open([ 'method'  => 'post', 'route' => [ 'event.destroyevent', $value->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="btn btn-xs red-haze dt-btn tooltips" data-swa-text="Hapus Data Event '.$value->id.'?" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>'
                        .\Form::close();

                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.create');
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
            return redirect('event');
        }

        $validator = \Validator::make($request->all(), [
            'event_name' => 'required',
            'event_name_eng' => 'required',
            'event_description' => 'required',
            'event_description_eng' => 'required',
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
            $event = new Event();
            $event->event_name = $request->event_name;
            $event->event_name_eng = $request->event_name_eng;
            $event->event_name_slug = str_slug($event->event_name);
            $event->event_description = $request->event_description;
            $event->event_description_eng = $request->event_description_eng;
            if($event->save())
            {
                foreach ($request->file as $file) {
                    $path = $file->store('picture_events');

                    \Storage::makeDirectory('thumbnails/picture_events');
                    $img = \Image::make(storage_path('app/public/' . $path));
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(storage_path('app/public/thumbnails/' . $path));

                    $modelDetail = new DetailEvent();
                    $modelDetail->event_id = $event->id;
                    $modelDetail->picture_event = $path;
                    $modelDetail->picture_event_thumb = 'thumbnails/'.$path;
                    $modelDetail->save();
                }
            }

            $event->save();

            DB::commit();

            notify()->flash('Success!', 'success', [
                'text' => 'Data Event berhasil ditambah',
            ]);
            return response()->json(['redirect_url' => url('event')]);
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
        return view('event.gambar', compact('id'));
    }

    public function storewith(Request $request)
    {
        DB::beginTransaction();
        try
        {
            foreach ($request->file as $file) {
                $path = $file->store('picture_events');

                \Storage::makeDirectory('thumbnails/picture_events');
                $img = \Image::make(storage_path('app/public/' . $path));
                $img->resize(900, 900, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(storage_path('app/public/thumbnails/' . $path));

                $modelDetail = new DetailEvent();
                $modelDetail->event_id = $request->event_id;
                $modelDetail->picture_event = $path;
                $modelDetail->picture_event_thumb = 'thumbnails/'.$path;
                $modelDetail->save();
            }
            DB::commit();

            return response()->json(['redirect_url' => url('event')]);

            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Event berhasil ditambah',
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
        return redirect('event');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DetailEvent::where('event_id', $id)->get();
        return view('event.show', compact('data', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['event'] = Event::findOrFail($id);
        return view('event.edit', $this->data);
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
                'event_name' => 'required',
                'event_description' => 'required'
        ]);

        DB::beginTransaction();
        try
        {
            $event = Event::findOrFail($id);
            $event->event_name = $request->event_name;
            $event->event_description = $request->event_description;
            $event->save();

            DB::commit();
            notify()->flash('Success!', 'success', [
                'text' => 'Event berhasil diubah',
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
        return redirect('event');
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
            $detail = DetailEvent::where('event_id', $id)->first();
            if($detail) {
                unlink(storage_path('app/public/'.$detail->picture_event));
                unlink(storage_path('app/public/'.$detail->picture_event_thumb));
                $detail->delete();
            }
            notify()->flash('Success!', 'success', [
                'text' => 'Gambar Event berhasil dihapus',
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            notify()->flash('Error!', 'error', [
                'text' => $e->getMessage(),
            ]);
        }
         return redirect('event');
    }

    public function destroyevent($id)
    {
       DB::beginTransaction();
        try
        {
            $detail = DetailEvent::where('event_id', $id)->get();
            foreach ($detail as $item) {
                unlink(storage_path('app/public/'.$item->picture_event));
                unlink(storage_path('app/public/thumbnails/'.$item->picture_event));
            }

            Event::destroy($id);
            DB::commit();
            notify()->flash('Sukses!', 'success', [
                'text' => 'Event berhasil dihapus',
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
        return redirect('event');
    }
    public function deleteGambar(Request $request)
    {
        $id = $request->id;
        $path = $request->path;
        try
        {
            DetailEvent::destroy($id);
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
        return response()->json(url('event'));
    }
}
