<?php
use App\Enum\TypeEnum;
use App\Http\Controllers\Auth\FastLoginController;
use App\Http\Controllers\Auth\FastRegistrationController;
use App\Http\Controllers\Auth\NoRegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Axios\AxiosUploadPhotoController;
use App\Http\Controllers\Cabinet\CabinetUser\CabinetUserController;
use App\Http\Controllers\Cabinet\CabinetVendor\AuthVendorController;
use App\Http\Controllers\Cabinet\CabinetVendor\CabinetVendorController;
use App\Http\Controllers\Cabinet\CabinetVendor\LogoutVendorController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\FancyBox\FancyBoxSendingFromFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsVendorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/** * админка */
Route::post('/moonshine/setting', [\App\MoonShine\Controllers\SettingController::class, 'setting' ]);
Route::post('/moonshine/home', [\App\MoonShine\Controllers\HomeController::class, 'home' ]);
Route::post('/moonshine/order-paper/create', \App\MoonShine\Controllers\OrderPaperCreateController::class)
    ->middleware('auth:moonshine')
    ->name('moonshine.order-paper.create');
/**  * админка */

/**
 * fancybox-ajax
 */
/** получение самой формы  */
Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});

/** Отправка самой формы */
Route::controller(FancyBoxSendingFromFormController::class)->group(function () {
});

Route::post('/fast-login-ajax', [FastLoginController::class, 'handle'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('fast_login_ajax');

Route::post('/fast-registration-ajax', [FastRegistrationController::class, 'handle'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('fast_registration_ajax');

Route::post('/no-registration-ajax', [NoRegistrationController::class, 'handle'])
    ->name('no_registration_ajax');

/**
 * ///fancybox-ajax */


/** Главная **/
Route::get('/', [HomeController::class, 'index' ])->name('home');
/** ///Главная */

Route::get('/refresh-csrf', fn() => response()->json(['csrf_token' => csrf_token()]));


/** Материалы сертификаты **/
Route::controller(ProductController::class)->group(function () {

    Route::get('/{category}/certificates', 'index')
        ->name('certificates');

    Route::get('/certificates/{slug}', 'show')
        ->name('certificate');

});


/** ///Материалы сертификаты */
/** Заказы order **/
Route::controller(OrderController::class)->group(function () {

    Route::post('/certificates/{slug}', 'store')
        ->name('order.store');

    Route::get('/order/{number}', 'show')
        ->name('order.show');

    Route::get('/order/{number}/certificate', 'downloadCertificate')
        ->name('order.certificate');

    Route::post('/order/{number}/send-certificate', 'sendCertificate')
        ->name('order.certificate.send');

});
/** ///Заказы order */

/**  * Auth */
Route::controller(SignInController::class)->group(function () {

    Route::get('/login', 'login')
        ->middleware(RedirectIfAuthenticated::class)
        ->name('login');

    Route::post('/login', 'handleLogin')
        ->middleware(RedirectIfAuthenticated::class)
        ->middleware(ProtectAgainstSpam::class)
        ->name('handle_login');
});

Route::controller(SignUpController::class)->group(function () {

    Route::get('/sign-up', 'signUp')
        ->middleware(RedirectIfAuthenticated::class)
        ->name('sign_up');

    Route::post('/sign-up', 'handleSignUp')->middleware(ProtectAgainstSpam::class)
        ->name('handle_sign_up');

});

Route::controller(ForgotPasswordController::class)->group(function () {

    Route::get('/forgot-password', 'page')
        ->name('forgot')
        ->middleware(RedirectIfAuthenticated::class);

    Route::post('/forgot-password', 'handle')
        ->name('handel_forgot')
        ->middleware(RedirectIfAuthenticated::class);

});

Route::controller(ResetPasswordController::class)->group(function () {

        Route::get('/reset-password/{token}','page')
            ->name('password.reset')
            ->middleware(RedirectIfAuthenticated::class);

        Route::post('/reset-password', 'handle')
            ->name('password_handle')
            ->middleware(RedirectIfAuthenticated::class);

});

Route::controller(LogoutController::class)->group(function () {
    Route::post('/logout', 'logout')
        ->middleware(UserMiddleware::class)
    ->name('logout');
});
/**  ///Auth  */

/** Cabinet_user */
Route::controller(CabinetUserController::class)->group(function () {

    /** кабинет  */
    Route::get('/cabinet', 'cabinetUser')
        ->name('cabinet_user')
        ->middleware(UserMiddleware::class);

    /** кабинет страница обновления  */
    Route::get('/cabinet/setting/update', 'cabinetUserUpdate')
        ->name('cabinet_user_update')
        ->middleware(UserMiddleware::class);

    /** кабинет метод обновления  */
    Route::put('/cabinet/setting/update', 'cabinetUserUpdateHandel')
        ->name('cabinet_user_update_handel')
        ->middleware(UserMiddleware::class);

    Route::put('/cabinet/cabinet.user.update.password', 'settingPasswordHandel')
        ->name('cabinet_user_update_password')
        ->middleware(UserMiddleware::class);

    /** кабинет — список сертификатов */
    Route::get('/cabinet/my-certificates', 'cabinetUserCertificates')
        ->name('cabinet_user_certificates')
        ->middleware(UserMiddleware::class);
});
/** ///Cabinet_user */

/** ** аватар  **   **/
Route::controller(AxiosUploadPhotoController::class)->group(function () {
    Route::post('/cabinet.upload.photo', 'uploadPhoto')
        ->middleware(UserMiddleware::class);
});
/** ** аватар  **   **/

/** AuthVendor */
Route::controller(AuthVendorController::class)->group(function () {

    /** Вход в кабинет для поставщиков  */
    Route::get('/vendor-provider', 'login')
        ->middleware(IsVendorMiddleware::class)
        ->name('vendor_login');

    /** Вход в кабинет для поставщиков  */
    Route::post('/vendor-provider/auth/sign-in', 'handelSignIn')
        ->name('vendor_handel_sign_in');

    /** Регистрация в кабинет для поставщиков  */
    Route::get('/vendor-provider/auth/sign-up', 'signUp')
        ->name('vendor_sign_up');

    /** Регистрация в кабинет для поставщиков  */
    Route::post('/vendor-provider/auth/sign-up', 'handelSignUp')
        ->name('vendor_handel_sign_up');

    /** Регистрация в кабинет для поставщиков 2 шаг */
    Route::get('/vendor-provider/auth/sign-up/selfEmployed', 'selfEmployed')
        ->name(TypeEnum::route(TypeEnum::SELFEMPLOYED->value));

    /** Регистрация в кабинет для поставщиков 2 шаг */
    Route::get('/vendor-provider/auth/sign-up/legalEntity', 'legalEntity')
        ->name(TypeEnum::route(TypeEnum::LEGALENTITY->value));

    /** Регистрация в кабинет для поставщиков 2 шаг */
    Route::get('/vendor-provider/auth/sign-up/individualEntrepreneur', 'individualEntrepreneur')
        ->name(TypeEnum::route(TypeEnum::INDIVIDUALENTREPRENEUR->value));

    /** Регистрация в кабинет для поставщиков 2 шаг */
    Route::post('/vendor-provider/auth/sign-up/final', 'handelSignUpFinal')
        ->name('vendor_handel_sign_up_final');

    /** Хочу заполнить данные при встрече с представителем  */
    Route::post('/vendor-provider/auth/sign-up/i-want-to-meet', 'handelIWantToMeet')
        ->name('vendor_handel_i_want_to_meet');


});
/** ////AuthVendor  */

/** Cabinet_vendor */
Route::controller(CabinetVendorController::class)->group(function () {
    /** Вход в кабинет для поставщиков  */
    Route::get('/vendor-provider/cabinet', 'cabinetVendor')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor');

    /** Список своих услуг  */
    Route::get('/vendor-provider/cabinet/services', 'cabinetVendorServices')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_services');

    /** Добавить свою услугу */
    Route::get('/vendor-provider/cabinet/services/add', 'cabinetVendorServiceAdd')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_add');

    /** Сохранить новую услугу */
    Route::post('/vendor-provider/cabinet/services/add', 'cabinetVendorServiceStore')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_store');

    /** Редактировать услугу — форма */
    Route::get('/vendor-provider/cabinet/services/update/{id}', 'cabinetVendorServiceEdit')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_edit');

    /** Сохранить изменения услуги */
    Route::post('/vendor-provider/cabinet/services/update/{id}', 'cabinetVendorServiceUpdate')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_update');

    /** Удалить услугу */
    Route::delete('/vendor-provider/cabinet/services/delete/{id}', 'cabinetVendorServiceDelete')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_delete');

    /** Удалить видео услуги */
    Route::delete('/vendor-provider/cabinet/services/{id}/video', 'cabinetVendorServiceDeleteVideo')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_service_delete_video');

    /** Загрузка видео чанками */
    Route::post('/vendor-provider/cabinet/upload-video-chunk', 'uploadVideoChunk')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_upload_video_chunk');

    /** Загрузка основного изображения услуги */
    Route::post('/vendor-provider/cabinet/upload-image', 'uploadImage')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_upload_image');

    /** Загрузка изображения галереи услуги */
    Route::post('/vendor-provider/cabinet/upload-gallery-image', 'uploadGalleryImage')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_upload_gallery_image');

    /** Проверка сертификата */
    Route::get('/vendor-provider/cabinet/certificate-check', 'certificateCheck')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_certificate_check');

    Route::post('/vendor-provider/cabinet/certificate-check', 'certificateCheckHandle')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_certificate_check_handle');

    /** Погашение сертификата */
    Route::post('/vendor-provider/cabinet/certificate-redeem', 'certificateRedeem')
        ->middleware(IsVendorMiddleware::class)
        ->name('cabinet_vendor_certificate_redeem');
});

Route::controller(LogoutVendorController::class)->group(function () {
    Route::post('/vendor/logout', 'vendorLogout')
        ->middleware(IsVendorMiddleware::class)
        ->name('vendor_logout');
});
/** ///Cabinet_vendor */

/** Статичные страницы (материалы)  */
Route::get('/{slug}', [PageController::class, 'page'])->name('page');
/** Статичные страницы (материалы)  */

