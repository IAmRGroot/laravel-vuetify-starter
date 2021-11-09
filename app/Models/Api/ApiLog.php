<?php

namespace App\Models\Api;

use App\Facades\Auth;
use App\Models\Model;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Api\ApiLog.
 *
 * @property int                             $id
 * @property bool                            $is_incoming
 * @property string|null                     $ip
 * @property string                          $log_path
 * @property int|null                        $status_code
 * @property int|null                        $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereIsIncoming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereLogPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiLog extends Model
{
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_incoming' => 'boolean',
    ];

    /**
     * {@inheritdoc}
     */
    public function delete(): bool|null
    {
        if (Storage::disk('api_logs')->exists($this->log_path)) {
            Storage::disk('api_logs')->delete($this->log_path);
        }

        return parent::delete();
    }

    public static function createFileAndModel(
        string $name,
        bool $incoming,
        ?string $ip,
        string $method_url,
        string $content
    ): self {
        $now = now();

        $filename = "{$name}_{$now->format('Y-m-d-H-i-s-u')}.log";

        Storage::disk('api_logs')->put($filename, "REQUEST {$method_url}" . PHP_EOL . $content);

        $api_log              = new self();
        $api_log->is_incoming = $incoming;
        $api_log->ip          = $ip;
        $api_log->log_path    = $filename;
        $api_log->created_at  = $now;
        $api_log->updated_at  = $now;
        $api_log->save();

        return $api_log;
    }

    public static function fromImcomingRequest(Request $request): self
    {
        $route = Route::getCurrentRoute();
        $route = $route ? $route->getName() ?? 'unknown' : 'unknown';

        return self::createFileAndModel(
            $route,
            true,
            $request->ip(),
            "{$request->method()} {$request->fullUrl()}",
            (string) $request->getContent()
        );
    }

    public function updateFromException(Exception $exception): self
    {
        $this->status_code = $exception->getCode();
        $this->created_by  = Auth::id();
        $this->save();

        Storage::disk('api_logs')->append($this->log_path, 'EXCEPTION' . PHP_EOL . ((string) $exception));

        return $this;
    }

    public function updateFromHttpResponse(Response $response): self
    {
        $this->status_code = $response->getStatusCode();
        $this->created_by  = Auth::id();
        $this->save();

        Storage::disk('api_logs')->append($this->log_path, "RESPONSE {$response->getStatusCode()}" . PHP_EOL . $response->getContent());

        return $this;
    }
}
