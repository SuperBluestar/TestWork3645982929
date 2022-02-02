<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
   
class BlogController extends BaseController
{

    /**
     * Read Multi
     */
    public function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $countPerPage = isset($request->countPerPage) ? $request->countPerPage : 10;
        $search = isset($request->search) ? $request->search : "";
        $orderBy = isset($request->orderBy) ? $request->orderBy : "updated_at";
        $blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
    }

    /**
     * Create
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|min:10',
            'description' => 'required|min:10'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

    /**
     * Read One
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }
    
    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();
        
        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }
   
    /**
     * Delete
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}