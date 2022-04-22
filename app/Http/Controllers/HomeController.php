<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Paginator::useBootstrap();
        $categories = Category::with('subcategories')->where('parent_id', null)->paginate(2);
        // dd($categories);
        return view('home')->with(compact('categories'));
    }

    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'image' => 'required|image',
                'subcategoryname' => 'required',
                'subcategoryemail' => 'required',
            ]);

            // dd($request->all());

            $new_category = new Category;
            $new_category->name = $request->input('name');
            $new_category->email_id = $request->input('email');

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Upload New Image
                    $image_name = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                    $image_extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                    $imageName = $image_name . '_' . time() . '.' . $image_extension;
                    $image_path = 'images/category/';
                    // Image::make($image_tmp)->resize(256, 256)->save($image_path);
                    $image_tmp->move($image_path, $imageName);

                    $new_category->image = $imageName;
                }
            }

            $new_category->save();

            foreach ($request->input('subcategoryname') as $key => $name) {
                $new_subcategory = new Category;
                $new_subcategory->name = $name;
                $new_subcategory->email_id = $request->input('subcategoryemail')[$key];
                $new_subcategory->parent_id = $new_category->id;
                $new_subcategory->save();
            }
            Mail::to($request->input('email'))->send(new \App\Mail\AddCategoryMail());
            $request->session()->flash('response_message', 'Category Added Successfully!');
            $request->session()->flash('response_class', 'alert-success');
            return redirect()->back();
        }
        return view('admin.add-category');
    }

    public function editCategory(Request $request, $id)
    {
        if ($id && Category::where('id', $id)->count() > 0) {
            if ($request->isMethod('post')) {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email',
                    'image' => 'required|image',
                    'subcategoryname' => 'required',
                    'subcategoryemail' => 'required',
                ]);

                // dd($request->all());

                $new_category = Category::find($id);
                $new_category->name = $request->input('name');
                $new_category->email_id = $request->input('email');

                if ($request->hasFile('image')) {
                    $image_tmp = $request->file('image');
                    if ($image_tmp->isValid()) {
                        // Upload New Image
                        $image_name = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                        $image_extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                        $imageName = $image_name . '_' . time() . '.' . $image_extension;
                        $image_path = 'images/category/';
                        // Image::make($image_tmp)->resize(256, 256)->save($image_path);
                        $image_tmp->move($image_path, $imageName);

                        $new_category->image = $imageName;
                    }
                }

                $new_category->save();

                Category::where('parent_id', $id)->delete();

                foreach ($request->input('subcategoryname') as $key => $name) {
                    $new_subcategory = new Category;
                    $new_subcategory->name = $name;
                    $new_subcategory->email_id = $request->input('subcategoryemail')[$key];
                    $new_subcategory->parent_id = $id;
                    $new_subcategory->save();
                }
                $request->session()->flash('response_message', 'Category Updated Successfully!');
                $request->session()->flash('response_class', 'alert-success');

                return redirect()->back();
            }
            $category_details = Category::with('subcategories')->where('id', $id)->first()->toArray();
            return view('admin.edit-category')->with(compact('id', 'category_details'));
        } else {
            abort(404);
        }
    }

    public function deleteSubCategory(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('id') != null) {
                Category::where('id', $request->input('id'))->delete();
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Deleted Successfully!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Data missing'
                ], 200);
            }
        } else {
            abort(404);
        }
    }

    public function deleteCategory(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('id') != null) {
                $count_subcategory = Category::where('parent_id', $request->input('id'))->count();
                if ($count_subcategory > 2) {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Can not deleted category having more than 2 sub category..'
                    ], 200);
                } else {
                    Category::where('id', $request->input('id'))->delete();
                    Category::where('parent_id', $request->input('id'))->delete();
                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Deleted Successfully!'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Data missing'
                ], 422);
            }
        } else {
            abort(404);
        }
    }
}
