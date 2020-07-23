<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;

class PicturesController extends Controller
{
    public function index()
    {
        $data=[];
        if(\Auth::check()){//認証済みの場合
            //認証済みユーザを取得
            $user=\Auth::user();
            //ユーザの投稿の一覧を作成日時の降順で取得
            $pictures=$user->feed_pictures()->orderBy('created_at','desc')->paginate(10);
            
            $data=[
                'user'=>$user,
                'pictures'=>$pictures,
                
                ];
        
        }
    
        //Welcomeビューでそれらを表示
        return view('welcome',$data);
    }
    
  /*  public function store(Request $request)
    {
        //バリテーション
        $request->validate([
            
            'content'=>'required|max:255',
            ]);
            
            //認証済みユーザ（閲覧者）の投稿として作成(リクエストされた値をもとに作成)
            $request->user()->pictures()->create([
                
                'content'=>$request->content,
                ]);
                
                //前のURLへリダイレクトさせる
                return back();
    }*/
    
    public function destroy($id)
    {
        //idの値で投稿を検索して取得
        $picture=Picture::findOrFail($id);
        
        //認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if(\Auth::id() === $picture->user_id){
            $picture->delete();
        }
        //前のURLへリダイレクトさせる
        return back();
    }
    public function upload(Request $request)
    {

        $select_id=$request->input('select_id');
        
        $upload_name=$_FILES['picture_url']['name'];
        
        $up_dir='upload/'.$select_id;
        
        $this->validate($request,[
            'picture_url'=>
                'required',
                'image',
                'dimensions:min_width=100,max_width=1500,min_height=100,max_height=800',
            'content'=>'required|max:255' 
                
                
                
                ]);
                
                if($request->file('picture_url')->isValid([])){

                    $filename=$request->file('picture_url')->storeAs($up_dir,$upload_name,'public');
                   
                   /* $goods=Picture::findOrFail($picture_url);
                    
                    $goods->image_name=basename($filename);
                    
                    $goods->save();*/
                    
                    $request->user()->pictures()->create([
                
                    'picture_url'=>$filename,
                    'content'=>$request->content,
                    ]);
                    
          
                     
                    return redirect()->to('/')->with('flashmessage','イメージ画像の登録が完了しました。');
                }
                else{
                    return redirect()->to('/')->with('flashmessage','イメージ画像の登録に失敗しました。');
                }
                    
                }
    }
    
