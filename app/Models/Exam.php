<?php

namespace App\Models;

use App\Observers\ExamVisitObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Exam extends Model
{
    use HasFactory , Sluggable;


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'exam_name',
        'slug',
        'request_access',
        'number_of_questions',
        'category_id',
        'difficulty',
        'type',
        'status',
        'activated_at',
        'deactivated_at',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activated_at' => 'datetime',
        'deactivated_at' => 'datetime',
        'request_access' => 'boolean',
    ];


    /**
     * @return HasOne
     */
    public function exam_visits() : HasOne
    {
        return $this->hasOne(ExamVisit::class );
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    /**
     * @return HasMany
     */
    public function questions() : HasMany
    {
        return $this->hasMany(TriviaQuestion::class);
    }

    /**
     * @return HasMany
     */
    public function score_board() : HasMany
    {
        return $this->hasMany(ScoreBoard::class , 'exam_id');
    }

    /**
     * @return HasMany
     */
    public function access() : HasMany
    {
        return $this->hasMany(Request::class );
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(ExamVisitObserver::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getCategoryIdAttribute($value)
    {
        return match ($value) {

            9 => 'General Knowledge',
            10 => 'Entertainment: Books',
            11 => 'Entertainment: Film',
            12 => 'Entertainment: Music',
            13 => 'Entertainment: Musicals & Theatres',
            14 => 'Entertainment: Television',
            15 => 'Entertainment: Video Games',
            16 => 'Entertainment: Board Games',
            17 => 'Science & Nature',
            18 => 'Science: Computers',
            19 => 'Science: Mathematics',
            20 => 'Mythology',
            21 => 'Sports',
            22 => 'Geography',
            23 => 'History',
            24 => 'Politics',
            25 => 'Art',
            26 => 'Celebrities',
            27 => 'Animals',
            28 => 'Vehicles',
            29 => 'Entertainment: Comics',
            30 => 'Science: Gadgets',
            31 => 'Entertainment: Japanese Anime & Manga',
            32 => 'Entertainment: Cartoon & Animations',

        };
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'exam_name'
            ]
        ];
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
