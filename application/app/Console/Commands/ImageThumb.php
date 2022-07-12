<?php

namespace TheFarrelHotel\Console\Commands;

use TheFarrelHotel\Http\Models\Around;
use TheFarrelHotel\Http\Models\DetailEvent;
use TheFarrelHotel\Http\Models\DetailPromotion;
use TheFarrelHotel\Http\Models\Facility;
use TheFarrelHotel\Http\Models\Gallery;
use TheFarrelHotel\Http\Models\Kamar\DetailRoom;
use TheFarrelHotel\Http\Models\Pengaturan\Banner;

use Illuminate\Console\Command;

class ImageThumb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:thumb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate image thumbnails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Around::imageThumb();
        DetailEvent::imageThumb();
        DetailPromotion::imageThumb();
        Facility::imageThumb();
        Gallery::imageThumb();
        DetailRoom::imageThumb();
        Banner::imageThumb();
    }
}
