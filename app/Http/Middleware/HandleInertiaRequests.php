<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $host = preg_replace('/^www\./', '', $request->getHost());

        $configDataByURL = User::leftJoin('user_configurations', 'user_configurations.user_id', '=', 'users.id')
                               ->where(['users.domain' => $host])
                               ->firstOrFail(['user_configurations.*', 'users.domain', 'users.email', 'users.phone']);
        //session(['site_config' => $configDataByURL]);
        return array_merge(parent::share($request), [
            'siteconfig' => $configDataByURL,
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);
    }
}
