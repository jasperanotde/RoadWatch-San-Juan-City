<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReportSubmission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'creator_id', 'details','photo', 'severity', 'urgency','status', 'assigned_user_id', 'finished_photo'
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

    public function submissions()
    {
        return $this->hasMany(ReportSubmission::class);
    }
    
    public function assignedUser()
    {
        return $this->belongsTo(User::class); // Assuming 'assignedUser' is the foreign key column in the 'reports' table
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
     * Get Report coordinate attribute.
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
        $mapPopupContent .= '<div class="my-2 text-lg font-poppins text-primary"><center>'.$this->name_link.'</div>';

         // Display the image using an <img> tag
         if ($this->photo) {
            $imagePath = json_decode($this->photo); // Replace with the actual path
            $firstImageUrl = !empty($imagePath) ? $imagePath[0] : 'default-image-url.jpg';
            // Add custom styling with Tailwind CSS classes
        $mapPopupContent .= '<div class="p-4 border rounded-lg bg-white shadow">';
        $mapPopupContent .= '<div class="relative w-32 h-32 mx-auto">';
        $mapPopupContent .= '<div class="absolute w-4 h-4 -bottom-2 left-1/2 transform -translate-x-2 bg-white border-t-2 border-l-2 border-gray-300 rotate-45"></div>';
        $mapPopupContent .= '<img src="'.$firstImageUrl.'" alt="Report Photo" class="rounded-lg w-full h-full object-cover">';
        $mapPopupContent .= '</div>';
        $mapPopupContent .= '</div>';
        }

        $mapPopupContent .= '<div class="my-2 text-slate-800"><strong>'.__('report.address').':</strong><br>'.$this->address.'</div>';
        $mapPopupContent .= '<div class="my-2 text-slate-800"><strong>'.__('report.details').':</strong><br>'.$this->details.'</div>';
        $mapPopupContent .= '<div class="my-2 text-slate-800"><strong>'.__('report.severity').':</strong><br>'.$this->severity.'</div>';
        $mapPopupContent .= '<div class="my-2 text-slate-800"><strong>'.__('report.urgency').':</strong><br>'.$this->urgency.'</div>';
        // $mapPopupContent .= '<div class="my-2"><strong>'.__('report.coordinate').':</strong><br>'.$this->coordinate.'</div>';
        $mapPopupContent .= '<div class="my-2 text-slate-800 "><strong>'.__('report.status').':<br><div class="text-lime-600">'.$this->status.'</div></strong></div>';

        return $mapPopupContent;
    }
}
