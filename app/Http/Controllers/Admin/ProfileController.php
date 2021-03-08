<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    
    public function add()
    {
        return view('admin.profile.create');
      
    }

    public function create(Request $request)
    {
        
        $this->validate($request, Profile::$rules);
       
        $profile = new Profile;
        $form = $request->all();
        // \Debugbar::info($form);//デバック
       
      
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        // unset($form['image']);
        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }
      
    
    
    public function edit(Request $request)
    {
        //Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
         if (empty($profile)) {
         abort(404);    
         }
         return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
       
         // Validationをかける
         $this->validate($request, Profile::$rules);
         // Profile Modelからデータを取得する
         $profile = Profile::find($request->id);
         // 送信されてきたフォームデータを格納する
         $profile_form = $request->all();
         
         if ($request->remove == 'true') {
              $profile_form['image_path'] = null;
         } elseif ($request->file('image')) {
              $path = $request->file('image')->store('public/image');
         $news_form['image_path'] = basename($path);
         } else {
         $profile_form['image_path'] = $profile->image_path;
         }
       
       
         unset($profile_form['image']);
         unset($profile_form['remove']);
         unset($profile_form['_token']);

        //  // 該当するデータを上書きして保存する
        //  $profile>fill($profile_form)->save();
        //  $profile_form -> save();
         return redirect('admin/profile');
         }
         
}