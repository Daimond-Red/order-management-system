<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Basecode\Classes\Repositories\BookingRepository;
use Illuminate\Support\Facades\Log;
use App\Booking;

class ExpireOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $bookingRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BookingRepository $bookingRepository)
    {

        parent::__construct();

        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        try {
            Log::info("my cron checking ");
            $collection = Booking::where('status', Booking::PENDING)->get();
            
            if(count($collection)) {
                foreach ($collection as $model) {

                    if($model->end_date_time) {

                        $date = strtotime( date('Y-m-d') );
                        $endDate = strtotime( $model->end_date_time );

                        if( $date > $endDate ) $model->status = Booking::EXPIRED;

                    } else {

                        $to_time = strtotime( date('Y-m-d H:i:s') );
                        $from_time = strtotime( $model->created_at );
                        $diff = round(abs($to_time - $from_time) / 60,0);
                        
                        if($diff >= 180) $model->status = Booking::EXPIRED;
                    }

                    $model->save();

                    if($model->status == Booking::EXPIRED) {
                        $this->bookingRepository->saveBookingLog($model);
                    
                    
                        $msg = str_replace('{order_no}', $model->order_no, _t('booking_expired_8'));
            
                        sendPushNotification($model->customer_id, [
                            'booking_id'    => $model->id,
                            'category'      => 'booking_expire',
                            'body'          => $msg
                        ]);
                    }
                }
            }
        } catch(Exception $e) {
            Log::info("my cron checking Exception");
        }
        
    }
}
