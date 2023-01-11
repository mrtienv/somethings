<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*404*/
Route::any('/404.html', 'PageController@not_found');

Route::get('/','HomeController@index');
Route::get('/{slug}-p{id}.html','PostController@index')->where(['slug' => '[\s\S]+','id' => '[0-9]+'])->middleware('Redirect.301');;
/*Category*/
Route::get('/category','CategoryController@index')->where(['slug' => '[\s\S]+','id' => '[0-9]+']);
Route::get('/{slug}-c{id}', 'CategoryController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);

/*Post*/
Route::get('/post','PostController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);
Route::get('/{slug}-p{id}.html','PostController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);

/*Sitemap*/
Route::get('/sitemap.xml','SitemapController@index');
Route::get('/sitemap-category.xml','SitemapController@category');
Route::get('/sitemap-news.xml','SitemapController@news');
Route::get('/sitemap-page.xml','SitemapController@page');
Route::get('/sitemap-posts-{year}-{month}.xml','SitemapController@post')->where(['year'=>'\d+', 'month'=>'\d+']);
/*Rating*/
Route::post('/rating/rating','RatingController@rating');
/*Rss*/
Route::get('/rss-feed','RssController@index');
Route::get('/rss/home.rss','RssController@home');
Route::get('/rss/{slug}.rss','RssController@detail')->where(['slug' => '[\s\S]+']);;
/*Crawler*/
Route::get('/crawler/{slug}','CrawlerController@index')->where(['slug' => '[\s\S]+']);
/*Error urls*/
Route::any('{slug}-{id}.html', 'PageController@error')->where(['slug' => '[\s\S]+','id' => '[0-9]+']);
/*Any*/
Route::any('{slug}', 'PageController@any')->where('slug', '.*');
