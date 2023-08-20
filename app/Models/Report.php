<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'creator_id', 'details','photo', 'severity', 'urgency','status'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = [
        'coordinate', 'map_popup_content',
    ];

    /**
     * Get report name_link attribute.
     *
     * @return string
     */
    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('report.report'),
        ]);
        $link = '<a href="'.route('reports.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }

    /**
     * report belongs to User model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get school coordinate attribute.
     *
     * @return string|null
     */
    public function getCoordinateAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude.', '.$this->longitude;
        }
    }


      /**
     * Get report address attribute.
     *
     * @return string|null
     */
    public function getAddress()
    {
        if ($this->address) {
            return $this->address;
        }
    }

    public function getDetails()
    {
        if ($this->district) {
            return $this->details;
        }
    }


    public function getPhoto()
    {
        if ($this->photo) {
            return $this->photo;
        }
    }

    public function getSeverity()
    {
        if ($this->photo) {
            return $this->severity;
        }
    }

    public function getUrgency()
    {
        if ($this->photo) {
            return $this->urgency;
        }
    }

    public function getStatus()
    {
        if ($this->photo) {
            return $this->status;
        }
    }

    /**
     * Get report map_popup_content attribute.
     *
     * @return string
     */
    public function getMapPopupContentAttribute()
    {
        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.name').':</strong><br>'.$this->name_link.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.address').':</strong><br>'.$this->address.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.details').':</strong><br>'.$this->details.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.photo').':</strong><br>'.$this->photo.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.severity').':</strong><br>'.$this->severity.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.urgency').':</strong><br>'.$this->urgency.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.coordinate').':</strong><br>'.$this->coordinate.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('report.status').':</strong><br>'.$this->status.'</div>';

        return $mapPopupContent;
    }
}
