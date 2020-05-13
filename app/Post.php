<?php

namespace App;

use Carbon\Carbon;
use App\Http\UploadManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'slug', 'title', 'body', 'user_id',
        'category_id', 'categories', 'pagination', 'shared',
        'tags', 'type', 'ordertype', 'thumb', 'approve', 'show_in_homepage',
        'show_in_homepage', 'featured_at', 'published_at', 'deleted_at'
    ];

    protected $dates = ['created_at', 'featured_at', 'published_at', 'deleted_at'];

    protected $casts = ['shared', 'categories'];

    protected $softDelete = true;

    /**
     * Post belongs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Post has many entries
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entries()
    {
        return $this->hasMany('App\Entry', 'post_id');
    }

    /**
     * Post belongs to a category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id');
    }

    /**
     * Post has many poll options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollvotes()
    {
        return $this->hasMany('App\PollVotes', 'post_id');
    }

    /**
     * Post has many poll options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reactions()
    {
        return $this->hasMany('App\Reactions', 'post_id');
    }

    /**
     * Get Post All comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comments', 'content');
    }

    /**
     * Get post stats
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function popularityStats()
    {
        return $this->morphOne('App\Stats', 'trackable');
    }

    public function hit()
    {
        //check if a polymorphic relation can be set
        if ($this->exists) {
            $stats = $this->popularityStats()->first();

            if (empty($stats)) {
                //associates a new Stats instance for this instance
                $stats = new Stats();
                $this->popularityStats()->save($stats);
            }

            return $stats->updateStats();
        }
        return false;
    }

    /**
     * Get posts by stats
     */
    public function scopeGetStats($query, $days = 'one_day_stats', $orderType = 'DESC', $limit = 10)
    {
        $query->select('posts.*');

        $query->leftJoin('popularity_stats', 'popularity_stats.trackable_id', '=', 'posts.id');

        $query->where($days, '!=', 0);

        $query->take($limit);

        $query->orderBy($days, $orderType);

        return $query;
    }

    /**
     * Get posts by type
     *
     * @param  $type
     * @return mixed
     */
    public function scopeByType($query, $type)
    {
        if ($type == 'all') {
            return $query;
        }
        return $query->where('type', $type);
    }

    /**
     * Get approval posts
     *
     * @param  $type
     * @return mixed
     */
    public function scopeApprove($query, $type)
    {
        return $query->where('approve', $type);
    }

    /**
     * Get post by category
     *
     * @param  $query
     * @param  $categoryid
     * @return mixed
     */
    public function scopeByCategory($query, $categoryid)
    {
        return $query->where("category_id", $categoryid);
    }

    /**
     * Get post by category
     *
     * @param  $query
     * @param  $categoryid
     * @return mixed
     */
    public function scopeByPublished($query)
    {
        return $query->where('approve', 'yes')->where("published_at", '!=', null)
            ->where("published_at", '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->latest('published_at');
    }

    /**
     * Get post for home
     *
     * @param  $query
     * @param  $categoryid
     * @return mixed
     */
    public function scopeForHome($query, $features = null)
    {
        if ($features !== null || get_buzzy_config('AutoInHomepage') == 'no') {
            return $query->where("show_in_homepage", 'yes');
        }

        return $query;
    }

    public function scopeActiveTypes($query)
    {
        if (get_buzzy_config('p_buzzynews') == 'off') {
            $query->where("posts.type", '!=', 'news');
        }
        if (get_buzzy_config('p_buzzylists') == 'off') {
            $query->where("posts.type", '!=', 'list');
        }
        if (get_buzzy_config('p_buzzypolls') == 'off') {
            $query->where("posts.type", '!=', 'poll');
        }
        if (get_buzzy_config('p_buzzyquizzes') == 'off') {
            $query->where("posts.type", '!=', 'quiz');
        }
        if (get_buzzy_config('p_buzzyvideos') == 'off') {
            $query->where("posts.type", '!=', 'video');
        }

        return $query;
    }

    public function scopeAcceptedTypes($query, $types)
    {
        $this->types = json_decode($types);

        $query->where(
            function ($query) {
                foreach ($this->types as $kk => $type) {
                    if ($type == 'news' or $type == 'list' or $type == 'quiz' or $type == 'poll' or $type == 'video') {
                        if ($kk == 0) {
                            $query->where("posts.type",  $type);
                        } else {
                            $query->orWhere("posts.type",  $type);
                        }
                    } else {
                        $type = intval($type);
                        if ($kk == 0) {
                            $query->where('categories', 'LIKE',  '%"' . $type . ',%')->orWhere('categories', 'LIKE',  '%,' . $type . ',%');
                        } else {
                            $query->orWhere('categories', 'LIKE',  '%"' . $type . ',%')->orWhere('categories', 'LIKE',  '%,' . $type . ',%');
                        }
                    }
                }
            }
        );
        return $query;
    }

    public function getSharedAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @return bool|null
     */
    public function forceDelete()
    {
        $this->forceDeleting = true;

        // @TODO move this to repository
        if (!empty($this->thumb)) {
            $imageM = new UploadManager();
            $imageM->delete(makepreview($this->thumb, 'b', 'posts'));
            $imageM->delete(makepreview($this->thumb, 's', 'posts'));
        }

        // delete entries
        // $this->entries()->withTrashed()->forceDelete();

        $entries = \App\Entry::withTrashed()->where('post_id', $this->id)->get();
        foreach ($entries as $entryh) {
            $entryh->forceDelete();
        }

        $this->reactions()->forceDelete();
        $this->pollvotes()->forceDelete();
        $this->popularityStats()->forceDelete();

        $this->delete();

        $this->forceDeleting = false;
    }
}
