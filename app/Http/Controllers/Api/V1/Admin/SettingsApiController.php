<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\Admin\SettingResource;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SettingResource(Setting::all());
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->all());

        if ($request->input('logo', false)) {
            if (!$setting->logo || $request->input('logo') !== $setting->logo->file_name) {
                if ($setting->logo) {
                    $setting->logo->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
            }
        } elseif ($setting->logo) {
            $setting->logo->delete();
        }

        if ($request->input('favicon', false)) {
            if (!$setting->favicon || $request->input('favicon') !== $setting->favicon->file_name) {
                if ($setting->favicon) {
                    $setting->favicon->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('favicon')))->toMediaCollection('favicon');
            }
        } elseif ($setting->favicon) {
            $setting->favicon->delete();
        }

        if ($request->input('banner', false)) {
            if (!$setting->banner || $request->input('banner') !== $setting->banner->file_name) {
                if ($setting->banner) {
                    $setting->banner->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->toMediaCollection('banner');
            }
        } elseif ($setting->banner) {
            $setting->banner->delete();
        }

        if ($request->input('homepage_background', false)) {
            if (!$setting->homepage_background || $request->input('homepage_background') !== $setting->homepage_background->file_name) {
                if ($setting->homepage_background) {
                    $setting->homepage_background->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('homepage_background')))->toMediaCollection('homepage_background');
            }
        } elseif ($setting->homepage_background) {
            $setting->homepage_background->delete();
        }

        if ($request->input('watermark_image', false)) {
            if (!$setting->watermark_image || $request->input('watermark_image') !== $setting->watermark_image->file_name) {
                if ($setting->watermark_image) {
                    $setting->watermark_image->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('watermark_image')))->toMediaCollection('watermark_image');
            }
        } elseif ($setting->watermark_image) {
            $setting->watermark_image->delete();
        }

        return (new SettingResource($setting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
