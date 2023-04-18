<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // +++++++++++++++++++++++++++++++++ index() method +++++++++++++++++++++++++++++++++
    public function index()
    {
        // Get "All Posts"
        $posts=Post::all();
        // Go To "index.blade.php" With "All Posts"
        return view('index')->with('posts',$posts);
    }
    // +++++++++++++++++++++++++++++++++ create() method +++++++++++++++++++++++++++++++++
    function create()
    {
        //
    }
    // +++++++++++++++++++++++++++++++++ store() method +++++++++++++++++++++++++++++++++
    public function store(PostRequest $request)
    {
        // ============ Store "Article Cover image" ============
        if($request->hasFile("cover"))
        {
            $file=$request->file("cover");
            $imageName=time().'_'.$file->getClientOriginalName();
            $file->move(\public_path("cover/"),$imageName);
            // Store "Article Data" And "Cover image" in "posts table" in "Post Model"
            $post =new Post([
                "title" =>$request->title,
                "author" =>$request->author,
                "body" =>$request->body,
                "cover" =>$imageName,
            ]);
           $post->save();
        }
        // ============ Store "Article images" ============
        if($request->hasFile("images"))
        {
            $files=$request->file("images");
            // Store "Article Images" in "images table" in "Image Model"
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['post_id']=$post->id;
                $request['image']=$imageName;
                $file->move(\public_path("/images"),$imageName);
                Image::create($request->all());
            }
        }
        // Go To "index.blade.php" page
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }
    // +++++++++++++++++++++++ edit() method : Go To "edit.blade.php" page with "selected Articles" data +++++++++++++++++++++++
    public function edit($id)
    {
        // Get "Edit Article" with "id=$id"
        $posts=Post::findOrFail($id);
        // Go To "edit.blade.php" page And Take "edited post data"
        return view('edit')->with('posts',$posts);
    }
    // +++++++++++++++++++++++ deleteAll() method : Delete All "selected Articles" +++++++++++++++++++++++
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Articles have been deleted successfully']);
    }
    // +++++++++++++++++++++++ update() method : update "article" data +++++++++++++++++++++++
    public function update(PostRequest $request,$id)
    {
        $post=Post::findOrFail($id);
        // Check if "upload Cover" is already uploaded
        if($request->hasFile("cover"))
        {
            // Check if "upload Cover" is already uploaded in "public/" folder
            if (File::exists("cover/".$post->cover))
            {
                // Delete "old cover" image
                File::delete("cover/".$post->cover);
            }
            // insert "new cover" image
            $file=$request->file("cover");
            $post->cover=time()."_".$file->getClientOriginalName();
            $file->move(\public_path("/cover"),$post->cover);
            $request['cover']=$post->cover;
        }
        // ++++++++++++ Update "title , author , body , cover" of Article ++++++++++++
        $post->update([
            "title" =>$request->title,
            "author"=>$request->author,
            "body"=>$request->body,
            "cover"=>$post->cover,
        ]);
        // Check if "upload images" is already uploaded
        if($request->hasFile("images"))
        {
            $files=$request->file("images");
            // Make Loop on "All Uploaded Images"
            foreach($files as $file)
            {
                $imageName=time().'_'.$file->getClientOriginalName();
                // store "id" of "Article" in "post_id" foreign key column of "images table"
                $request["post_id"]=$id;
                // store Each "image Url" in "images column" of "images table"
                $request["image"]=$imageName;
                // insert "All Uploaded images" in "public/images" folder
                $file->move(\public_path("images"),$imageName);
                // insert "All Uploaded images" in "images table in DB"
                Image::create($request->all());
            }
        }

        return redirect("/");

    }
    // +++++++++++++++++++++++ update() method : update "article" data +++++++++++++++++++++++
    public function destroy($id)
    {
        // Get "Deleted Post" Data
        $posts=Post::findOrFail($id);
        //  Delete "Cover image" of "deleted post"
        if (File::exists("cover/".$posts->cover))
        {
            File::delete("cover/".$posts->cover);
        }
        //  Get All "images" of "deleted post"
        $images=Image::where("post_id",$posts->id)->get();
        //  Delete "All images" of "deleted post"
        foreach($images as $image)
        {
            if (File::exists("images/".$image->image))
            {
                File::delete("images/".$image->image);
            }
        }
        $posts->delete();
        return back();
    }

    public function deleteimage($id)
    {
        $images=Image::findOrFail($id);
        if (File::exists("images/".$images->image)) {
           File::delete("images/".$images->image);
       }

       Image::find($id)->delete();
       return back();
   }

   public function deletecover($id)
   {
    $cover=Post::findOrFail($id)->cover;
    if (File::exists("cover/".$cover)) {
       File::delete("cover/".$cover);
   }
   return back();
}


}
