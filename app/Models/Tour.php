<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


class Tour extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'start',
        'end',
        'info',
        'state',
        'type',
        'user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'state' => 'integer',
        'type' => 'integer',
        'user' => 'integer',
    ];

    /**
     * Return a Tour State relation
     *
     * @return BelongsTo
     */
    public function tourState():BelongsTo
    {
        return $this->belongsTo(TourState::class,'state','id');
    }

    /**
     * Return a Tour Type relation
     *
     * @return BelongsTo
     */
    public function tourType():BelongsTo
    {
        return $this->belongsTo(TourType::class,'type','id');
    }

    /**
     * Return a User relation
     *
     * @return BelongsTo
     */
    public function getUser():BelongsTo
    {
        return $this->belongsTo(User::class,'user','id')->withTrashed();
    }

    /**
     * Return Start tour Date in format d-m-Y
     *
     * @return string
     */
    public function tourDate():string
    {
        return Carbon::parse($this->start)->format('d-m-Y');
    }

    /**
     * Calculate a available tour Spaces
     *
     * @return int
     */
    public function availableSpace():int
    {
        $approvals = $this->getLastApproval();
        $tourGuides = TourGuides::where('tour',"=",$this->id)->count();
        if($approvals->isEmpty()){
            $config = Configuration::select('data')->where('id', 1)->get();
            $clientTourMax = $config[0]->data["value"];

            $available = ($tourGuides==0)
                ? $clientTourMax
                : $tourGuides * $clientTourMax;
        }else{

            $available = ($tourGuides==0)
                ? $approvals[0]->new
                : $tourGuides * $approvals[0]->new;
        }

        $tourClients = TourClient::where('tour',"=",$this->id)->get();
        $count = 0;
        foreach ($tourClients as $tour){
            $count = $count + $tour->realTotalBooking();
        }

        return $available - $count;
    }

    /**
     * return a Calculate booking tour spaces
     *
     * @return int
     */
    public function usedSpace():int
    {
        $count = 0;
        $tourClients = TourClient::where('tour',"=",$this->id)->get();
        foreach ($tourClients as $tour){
            $count = $count + $tour->realTotalBooking();
        }

        return $count;
    }

    /**
     * Return an Empty or Last approval for this tour
     *
     * @return mixed
     */
    function getLastApproval():mixed
    {
        return Approval::where('tour','=', $this->id)
            ->whereIn('state', [3, 4])
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();
    }

    /**
     * Return an Original Total tour Space for each Guide
     *
     * @return int
     */
    public function originalSpaceValue():int
    {
        $approvals = $this->getLastApproval();

        if($approvals->isEmpty()){
            $config = Configuration::select('data')->where('id', 1)->get();
            return $config[0]->data["value"];
        }else{
            return $approvals[0]->new;
        }
    }

    /**
     * Return a selected guides for this tour
     *
     * @return Collection
     */
    public function selectedGuides():Collection
    {
        $guides = collect([]);
        $tourGuides = TourGuides::where('tour',"=",$this->id)->get();
        foreach ($tourGuides as $guide){
            $searchGuide = Guides::find($guide->guides);
            $guides->push($searchGuide);
        }

        return $guides;
    }

    /**
     * Returns the respective fee according to the tour and type of tour
     *
     * @param int $assignments
     * @return int
     */
    public function findGuideFee(int $assignments):int
    {
        $tourType = TourType::find($this->type);

        if($assignments == 0){
            return 0;
        }elseif ($assignments <=2 ){
            return $tourType->fee1;
        }elseif ($assignments <=4 ){
            return $tourType->fee2;
        }elseif ($assignments <=7 ){
            return $tourType->fee3;
        }else{
            return $tourType->fee4;
        }
    }

    /**
     * Create an array of all guides and validate whether or not payment applies for each guide.
     *
     * @return array
     */
    public function GuidesPayment():array
    {
        $account = [];
        $tourClients = TourClient::where('tour', $this->id)->get();

        foreach ($tourClients as $tourClient) {
            $guides = $tourClient->guides;
            $isApplyPay = $tourClient->isApplyPay();
            $bookings = $tourClient->bookings;

            if (!isset($account[$guides])) {
                $guideName = __('app.no_guide');
                if ($guides != null) {
                    $guide = $tourClient->getGuides;
                    $guideName = $guide->name . ' ' . $guide->lastName;
                }

                $account[$guides] = [
                    'bookings_apply' => $isApplyPay ? $bookings : 0,
                    'bookings_not_apply' => $isApplyPay ? 0 : $bookings,
                    'guide_id' => $guides ?? 0,
                    'guide' => $guideName,
                ];
            } else {
                if ($isApplyPay) {
                    $account[$guides]['bookings_apply'] = ($account[$guides]['bookings_apply'] ?? 0) + $bookings;
                } else {
                    $account[$guides]['bookings_not_apply'] = ($account[$guides]['bookings_not_apply'] ?? 0) + $bookings;
                }
            }
        }

        return $account;
    }

}
