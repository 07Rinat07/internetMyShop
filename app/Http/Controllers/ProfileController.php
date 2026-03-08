<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpsertRequest;
use App\Models\Profile;

class ProfileController extends Controller {
    public function __construct()
    {
        $this->authorizeResource(Profile::class, 'profile');
    }

    /**
     * Показывает список всех профилей
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $profiles = auth()->user()->profiles()->paginate(4);
        return view('user.profile.index', compact('profiles'));
    }

    /**
     * Возвращает данные профиля в формате JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        // TODO: здесь нужна какая-никакая проверка
        $profile = self::findOrFail();
        return response()->json($profile);
    }

    /**
     * Показывает форму для создания профиля
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('user.profile.create');
    }

    /**
     * Сохраняет новый профиль в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileUpsertRequest $request) {
        $profile = auth()->user()->profiles()->create($request->validated());

        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Новый профиль успешно создан');
    }

    /**
     * Показывает информацию о профиле
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile) {
        return view('user.profile.show', compact('profile'));
    }

    /**
     * Показывает форму для редактирования профиля
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile) {
        return view('user.profile.edit', compact('profile'));
    }

    /**
     * Обновляет профиль (запись в таблице БД)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpsertRequest $request, Profile $profile) {
        $profile->update($request->validated());
        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Профиль был успешно отредактирован');
    }

    /**
     * Удаляет профиль (запись в таблице БД)
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile) {
        $profile->delete();
        return redirect()
            ->route('user.profile.index')
            ->with('success', 'Профиль был успешно удален');
    }
}
