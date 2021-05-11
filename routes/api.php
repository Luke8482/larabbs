<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')
    ->namespace('Api')
    ->middleware('change-locale')
    ->name('api.v1.')
    ->group(function (){

        Route::middleware('throttle:'.config('api.rate_limits.sign'))
            ->group(function (){
                //图片验证码
                Route::post('captchas','CaptchasController@store')
                    ->name('captchas.store');
                //短信验证码
                Route::post('verificationCodes','VerificationCodesController@store')
                    ->name('verificationCodes.store');
                //用户注册
                Route::post('users','UsersController@store')
                    ->name('users.store');
                // 第三方登录
                Route::post('socials/{social_type}/authorizations','AuthorizationsController@socialStore')
                    ->where('social_type','wechat')
                    ->name('socials.authorizations.store');
                // 登录
                Route::post('authorizations','AuthorizationsController@store')
                    ->name('api.authorizations.store');
                // 刷新token
                Route::put('authorizations/current','AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current','AuthorizationsController@destroy')
                    ->name('authorizations.destroy');
            });


        Route::middleware('throttle:'.config('api.rate_limits.access'))
            ->group(function (){
                //游客可以访问的信息

                // 某个用户的详情
                Route::get('users/{user}','UsersController@show')
                    ->name('user.show');
                //分类列表
                Route::get('categories','CategoriesController@index')
                    ->name('categories.index');
                // 某个用户发布的话题
                Route::get('users/{user}/topics', 'TopicsController@userIndex')
                    ->name('users.topics.index');
                // 话题列表，详情
                Route::resource('topics','TopicsController')->only([
                    'index','show'
                ]);
                // 话题回复列表
                Route::get('topics/{topic}/replies','RepliesController@index')
                    ->name('topics.replies.index');
                // 某个用户的回复列表
                Route::get('users/{user}/replies','RepliesController@userIndex')
                    ->name('users.replies.index');
                // 资源推荐
                Route::get('links','LinksController@index')
                    ->name('links.index');
                // 活跃用户
                Route::get('actived/users','UsersController@activedIndex')
                    ->name('actived.users.index');

                // 自行设计课程CRUD 接口
                Route::resource('courses','CoursesController')->only([
                    'index','show'
                ]);

                Route::resource('chapters','ChaptersController')->only([
                    'index','show'
                ]);

                Route::resource('lessons','LessonsController')->only([
                    'index','show'
                ]);

                Route::resource('sections','SectionsController')->only([
                    'index','show'
                ]);

                //某个课程的章节信息
                Route::get('courses/{course}/chapters', 'ChaptersController@courseIndex')
                    ->name('courses.chapters.index');




                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function(){
                    // 当前登录的用户信息
                    Route::get('user','UsersController@me')
                        ->name('user.me');
                    // 编辑登录用户信息
                    Route::patch('user','UsersController@update')
                        ->name('user.update');
                    // 上传图片
                    Route::post('images','ImagesController@store')
                        ->name('images.store');

                    //上传图片(测试代码）
                    Route::post('imagesTest','ImagesController@storeTest')
                        ->name('images.storeTest');




                    // 发布话题
                    Route::resource('topics','TopicsController')->only([
                        'store','update','destroy'
                    ]);
                    //发布回复
                    Route::post('topics/{topic}/replies','RepliesController@store')
                        ->name('topics.replies.store');
                    // 删除回复
                    Route::delete('topics/{topic}/replies/{reply}','RepliesController@destroy')
                        ->name('topics.replies.destroy');
                    //通知列表
                    Route::get('notifications', 'NotificationsController@index')
                        ->name('notifications.index');
                    // 未读消息统计
                    Route::get('notifications/stats','NotificationsController@stats')
                        ->name('notifications.stats');
                    // 标记未读消息为已读
                    Route::patch('user/read/notifications','NotificationsController@read')
                        ->name('user.notification.read');
                    Route::get('user/permissions','PermissionsController@index')
                        ->name('user.permissions.index');


                    // 自行设计课程CRUD 接口
                    Route::resource('courses','CoursesController')->only([
                        'store','update','destroy'
                    ]);

                    Route::resource('chapters','ChaptersController')->only([
                        'store','update','destroy'
                    ]);

                    Route::resource('lessons','LessonsController')->only([
                        'store','update','destroy'
                    ]);

                    Route::resource('sections','SectionsController')->only([
                        'store','update','destroy'
                    ]);

                    //某个节的section信息（后台端口）
                    Route::get('lessons/{lesson}/sections', 'SectionsController@lessonIndex')
                        ->name('lessons.sections.index');

                    //调整section顺序的API（后台端口）
                    Route::post('sections/sort', 'SectionsController@sortUpdate')
                        ->name('sections.sortUpdate');

                });
            });

});


