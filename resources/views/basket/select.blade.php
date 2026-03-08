<form action="{{ route('basket.checkout') }}" method="get" id="profiles" class="profile-picker">
    <div class="form-group mb-0">
        <label for="profile-id">{{ __('site.basket.choose_profile') }}</label>
        <select name="profile_id" id="profile-id" class="form-control">
            <option value="0">{{ __('site.basket.choose_profile') }}</option>
            @foreach($profiles as $profile)
                <option value="{{ $profile->id }}"@if($profile->id == $current) selected @endif>
                    {{ $profile->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-0">
        <button type="submit" class="btn btn-dark">{{ __('site.basket.select') }}</button>
    </div>
</form>
