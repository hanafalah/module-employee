<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfilePhotoData;

interface ProfilePhoto extends DataManagement
{
    public function prepareStoreProfilePhoto(ProfilePhotoData $profile_photo_dto): Model;
    public function storeProfilePhoto(? ProfilePhotoData $profile_photo_dto = null): array;
}