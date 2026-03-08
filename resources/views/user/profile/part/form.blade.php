@csrf
<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
<div class="form-group">
    <label for="profile-title">{{ __('site.forms.profile_title') }}</label>
    <input type="text" class="form-control" id="profile-title" name="title"
           placeholder="{{ __('site.forms.profile_title') }}"
           required maxlength="255" value="{{ old('title') ?? $profile->title ?? '' }}">
</div>
<div class="form-group">
    <label for="profile-name">{{ __('site.forms.full_name') }}</label>
    <input type="text" class="form-control" id="profile-name" name="name"
           placeholder="{{ __('site.forms.full_name') }}"
           required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
</div>
<div class="form-group">
    <label for="profile-email">{{ __('site.forms.email') }}</label>
    <input type="email" class="form-control" id="profile-email" name="email"
           placeholder="{{ __('site.forms.email') }}"
           required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
</div>
<div class="form-group">
    <label for="profile-phone">{{ __('site.forms.phone') }}</label>
    <input type="text" class="form-control" id="profile-phone" name="phone"
           placeholder="{{ __('site.forms.phone') }}"
           required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
</div>
<div class="form-group">
    <label for="profile-address">{{ __('site.forms.address') }}</label>
    <input type="text" class="form-control" id="profile-address" name="address"
           placeholder="{{ __('site.forms.address') }}"
           required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
</div>
<div class="form-group">
    <label for="profile-comment">{{ __('site.forms.comment') }}</label>
    <textarea class="form-control" id="profile-comment" name="comment"
              placeholder="{{ __('site.forms.comment') }}"
              maxlength="255" rows="4">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
</div>
<div class="action-row">
    <button type="submit" class="btn btn-success">{{ __('site.forms.save') }}</button>
</div>
