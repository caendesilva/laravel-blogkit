<?php

namespace App\Models;

use App\Concerns\AnalyticsDateFormatting;
use App\Concerns\AnonymizesRequests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @property string $page URL of the page visited
 * @property ?string $referrer URL of the page that referred the user
 * @property ?string $user_agent User agent string of the visitor (only stored for bots)
 * @property string $anonymous_id Ephemeral anonymized visitor identifier that cannot be tied to a user
 */
class PageView extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'page',
        'referrer',
        'user_agent',
        'anonymous_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            // Normalize the page URL to use the path only
            $model->page = (parse_url($model->page, PHP_URL_PATH) ?? '/');

            // We only store the domain of the referrer
            if ($model->referrer) {
                if (! str_starts_with($model->referrer, '?ref=')) {
                    // We only store the domain of the referrer
                    $model->referrer = static::normalizeDomain($model->referrer);
                } else {
                    $domain = Str::after($model->referrer, '?ref=');
                    $domain = static::normalizeDomain($domain);

                    $model->referrer = "?ref=$domain";
                }
            } else {
                $model->referrer = null;
            }

            // We don't store user agents for non-bot users
            $crawlerKeywords = ['bot', 'crawl', 'spider', 'slurp', 'search', 'yahoo', 'facebook'];

            if (! Str::contains($model->user_agent, $crawlerKeywords, true)) {
                $model->user_agent = null;
            }
        });
    }

    public static function fromRequest(Request $request): static
    {
        // Is a ref query parameter present? If so, we'll store it as a referrer
        $ref = $request->query('ref');
        if ($ref) {
            $ref = '?ref='.$ref;
        }

        return static::create([
            'page' => $request->url(),
            'referrer' => $ref ?? $request->header('referer') ?? $request->header('referrer'),
            'user_agent' => $request->userAgent(),
            'anonymous_id' => self::anonymizeRequest($request),
        ]);
    }

    public function getCreatedAtAttribute(string $date): Carbon
    {
        // Include the timezone when casting the date to a string
        return Carbon::parse($date)->settings(['toStringFormat' => 'Y-m-d H:i:s T']);
    }

    protected static function normalizeDomain(string $url): string
    {
        if (! Str::startsWith($url, 'http')) {
            $url = 'https://'.$url;
        }

        return Str::after(parse_url($url, PHP_URL_HOST), 'www.');
    }

    protected static function anonymizeRequest(Request $request): string
    {
        // As we are not interested in tracking users, we generate an ephemeral hash
        // based on the IP, user agent, and a salt to track unique visits per day.
        // This system is designed so that a visitor cannot be tracked across days, nor can it be tied to a specific person.
        // Due to the salting with a secret environment value, it can't be reverse engineered by creating rainbow tables.
        // The current date is also included in the hash in order to make them unique per day.

        // The hash is made using the SHA-256 algorithm and truncated to 40 characters to save space, as we're not too worried about collisions.

        $forwardIp = $request->header('X-Forwarded-For');

        if ($forwardIp !== null) {
            // If the request is proxied, we use the first IP in the address list, as the actual IP belongs to the proxy which may change frequently.

            $ip = Str::before($forwardIp, ',');
        } else {
            $ip = $request->ip();
        }

        return substr(hash('sha256', $ip.$request->userAgent().config('hashing.anonymizer_salt').now()->format('Y-m-d')), 0, 40);
    }
}
