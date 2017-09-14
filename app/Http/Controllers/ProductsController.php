<?php

namespace App\Http\Controllers;

use App\Manufacturer;
use App\Product;
use App\Category;
use Carbon\Carbon;
use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotWritableException;

class ProductsController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        if (Cache::has('CategoriesSelectHTML')) {
            $selectHTML = Cache::get('CategoriesSelectHTML');
        } else {
            $selectHTML = $this->renderCategoriesSelectHTML();
            Cache::forever('CategoriesSelectHTML', $selectHTML);
        }

        $manufacturers = Cache::rememberForever('manufacturers', function () {
            return Manufacturer::all()->toJson();
        });

        return view('admin.products.create', compact('selectHTML', 'manufacturers'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'manufacturer_id' => 'required|exists:product_manufacturers,id',
            'catalogNumber' => 'required|unique:products',
            'EAN' => 'required|unique:products',
            'description' => 'required',
            'parent_subcategory' => 'required|integer',
            'unit' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:10240'
        ];

        $messages = [
            'name.required' => 'Naziv proizvoda je obavezan.',
            'manufacturer_id.required' => 'Proizvođač je obavezan.',
            'manufacturer_id.exists' => 'Proizvođač već mora postojati u bazi.',
            'catalogNumber.required' => 'Kataloški broj je obavezan.',
            'catalogNumber.unique' => 'Kataloški broj mora biti jedinstven.',
            'EAN.required' => 'EAN je obavezan.',
            'EAN.unique' => 'EAN mora biti jedinstven.',
            'description.required' => 'Opis proizvoda je obavezan.',
            'parent_subcategory.required' => 'Morate odabrati kategoriju u koju proizvod spada.',
            'parent_subcategory.integer' => 'Niste ispravno odabrali kategoriju.',
            'unit.required' => 'Mjerna jedinica proizvoda je obavezna.',
            'images.required' => 'Obavezna je barem jedna slika.',
            'images.*.image' => 'Ova datoteka nije slika.',
            'images.*.mimes' => 'Dozvoljeni tipovi slika su: jpg, jpeg, png i gif.',
            'images.*.max' => 'Maksimalna veličina jedne slike je 10 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->except('images');

        if ($request->has('highlighted')) {
            $data['highlighted'] = true;
        }

        $product = Product::create($data);

        $images = collect($request->file('images'));
        $images->each(function ($item, $key) use (&$product) {
            $name = $item->getClientOriginalName();

            $image_file = Image::make($item);
            $path = public_path() . '/product_images/' . $product->slug .'/';
            File::makeDirectory($path, $mode = 0775, true, true);

            try {
                $image_file->save($path . $name);
            } catch (NotWritableException $e) {
                $product->delete();
                return back()->with(['error' => "Došlo je do pogreške. Molimo pokušajte kasnije."]);
            }

            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->path = $name;
            $image->save();
        });

        return back()->with('success', "Proizvod je uspješno dodan.");
    }
    
    public function show(Product $product)
    {
        $product = $product->load(['manufacturer', 'images']);

        $product_is_in_cart = false;
        $products_with_quantity = Cookie::get('cart_product_IDs');
        if (! is_null($products_with_quantity)) {
            $product_IDs = collect(unserialize($products_with_quantity))->pluck('product_id');
            if ($product_IDs->search($product->id) !== false) {
                $product_is_in_cart = true;
            } else {
                $product_is_in_cart = false;
            }
        } else {
            $product_is_in_cart = false;
        }

        return view('product_details', compact('product', 'product_is_in_cart'));
    }

    public function edit(Product $product)
    {
        $selectHTML = $this->renderCategoriesSelectHTML($product->parent_subcategory);
        $product = $product->load(['manufacturer', 'images']);

        $product_images = [];

        for ($i = 0; $i < count($product->images); $i++) {
            $product_images[$i]["name"] = $product->images[$i]->path;
            $product_images[$i]["size"] = filesize(public_path() .
                "/product_images/" . $product->slug . "/". $product->images[$i]->path);
            $product_images[$i]["type"] = mime_content_type(public_path() .
                "/product_images/" . $product->slug . "/". $product->images[$i]->path);
            $product_images[$i]["file"] = "/product_images/" . $product->slug . "/". $product->images[$i]->path;
            $product_images[$i]["data"]["imageID"] = $product->images[$i]->id;
            $product_images[$i]["data"]["url"] = "/product_images/" . $product->slug . "/". $product->images[$i]->path;
        }

        $product_images = json_encode($product_images);

        $manufacturers = Cache::rememberForever('manufacturers', function () {
            return Manufacturer::all()->toJson();
        });

        return view('admin.products.edit', compact('product', 'selectHTML', 'product_images', 'manufacturers'));
    }

    public function deleteProductImage(Request $request, Product $product)
    {
        $product_image = ProductImage::where('product_id', "=", $product->id)
                                     ->where('id', "=", $request->input('imageID'))->first();
        if (File::delete(
            public_path() . "/product_images/" . $product->slug . "/". $product_image->path
        ) && $product_image->delete()) {
            return "success";
        }
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required',
            'manufacturer_id' => 'required|exists:product_manufacturers,id',
            'catalogNumber' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'EAN' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'description' => 'required',
            'parent_subcategory' => 'required|integer',
            'unit' => 'required',
            'images' => 'sometimes|required',
            'images.*' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:10240'
        ];

        $messages = [
            'name.required' => 'Naziv proizvoda je obavezan.',
            'manufacturer_id.required' => 'Proizvođač je obavezan.',
            'manufacturer_id.exists' => 'Proizvođač već mora postojati u bazi.',
            'catalogNumber.required' => 'Kataloški broj je obavezan.',
            'catalogNumber.unique' => 'Kataloški broj mora biti jedinstven.',
            'EAN.required' => 'EAN je obavezan.',
            'EAN.unique' => 'EAN mora biti jedinstven.',
            'description.required' => 'Opis proizvoda je obavezan.',
            'parent_subcategory.required' => 'Morate odabrati kategoriju u koju proizvod spada.',
            'parent_subcategory.integer' => 'Niste ispravno odabrali kategoriju.',
            'unit.required' => 'Mjerna jedinica proizvoda je obavezna.',
            'images.required' => 'Obavezna je barem jedna slika.',
            'images.*.image' => 'Ova datoteka nije slika.',
            'images.*.mimes' => 'Dozvoljeni tipovi slika su: jpg, jpeg, png i gif.',
            'images.*.max' => 'Maksimalna veličina jedne slike je 10 MB.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product_images_count = ProductImage::where('product_id', "=", $product->id)->count();

        if ($product_images_count === 0 && $request->has('images') === false) {
            return back()->with("error", "Proizvod mora imati barem jednu sliku!");
        }

        if ($request->has('highlighted') && $request->input('highlighted') == 'on') {
            $data['highlighted'] = true;
        } else {
            $data['highlighted'] = false;
        }

        $product->update($data);

        $images = collect($request->file('images'));
        $images->each(function ($item, $key) use (&$product) {
            $name = $item->getClientOriginalName();

            $image_file = Image::make($item);
            $path = public_path() . '/product_images/' . $product->slug .'/';
            File::makeDirectory($path, $mode = 0775, true, true);

            try {
                $image_file->save($path . $name);
            } catch (NotWritableException $e) {
                $product->delete();
                return back()->with(['error' => "Došlo je do pogreške. Molimo pokušajte kasnije."]);
            }
                $image = new ProductImage();
                $image->product_id = $product->id;
                $image->path = $name;
                $image->save();
        });

        return back()->with('success', "Proizvod je uspješno uređen.");
    }

    /**
     * Delete Confirm
     *
     * @param   Product $product
     * @return  \Illuminate\View\View
     */
    public function getModalDelete(Product $product)
    {
        $type = 'delete';
        $model = 'product';
        $error = null;

        $confirm_route = route('admin.products.destroy', $product);
        return view('admin.layouts.modal_confirmation', compact('error', 'type', 'model', 'confirm_route', 'product'));
    }

    /**
     * Delete the given product.
     *
     * @param  Product $product
     * @return Redirect
     */
    public function destroy(Product $product)
    {
        $path = public_path() . '/product_images/' . $product->slug .'/';
        File::deleteDirectory($path);

        if ($product->delete()) {
            // Prepare the success message
            $success = "Proizvod je uspješno obrisan.";

            // Redirect to the user management page
            return Redirect::route('admin.products.index')->with('success', $success);
        }

        // Prepare the error message
        $error = "Dogodila se pogreška";

        // Redirect to the user page
        return Redirect::route('admin.products.index')->withInput()->with('error', $error);
    }

    public function search(Request $request)
    {
        $searchString = $request->input('search', '');
        $products = Product::where('name', 'LIKE', '%' . $searchString . '%')
            ->orWhere('catalogNumber', 'LIKE', '%' . $searchString . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('products_search', compact('products'));
    }

    public function getAllProducts()
    {
        $products = Product::with('manufacturer')->get();

        return Datatables::of($products)
            ->edit_column('created_at', function (Product $product) {
                Carbon::setLocale('hr');
                return $product->created_at->format('d.m.Y. H:i:s') . " (" . $product->created_at->diffForHumans() . ")";
            })
            ->edit_column('updated_at', function (Product $product) {
                Carbon::setLocale('hr');
                return $product->updated_at->format('d.m.Y. H:i:s') . " (" . $product->updated_at->diffForHumans() . ")";
            })
            ->add_column('actions', function (Product $product) {
                $actions = '<a href='. route('admin.products.edit', ['product' => $product]) .
                    '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Uredi proizvod"></i></a>';
                $actions .= '&nbsp;&nbsp;&nbsp;<a href='. route('admin.products.confirm-delete', $product->slug) .
                    ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="Obriši proizvod"></i></a>';
                return $actions;
            })->rawColumns(['actions'])->make(true);
    }

    /**
     * Generate the the <select> HTML element for the current categories in the DB.
     *
     * @param int $checkedCategory
     * @return string
     */
    public function renderCategoriesSelectHTML($checkedCategory = null)
    {
        static $categories;

        if (! is_array($categories)) {
            $categories = Category::all();
        }

        $list_items = [];

        foreach ($categories as $category) {
            // always start only from the top parent categories in the tree
            if (! count($category->parentCategory)) {
                $list_items[] = $this->renderCategorySelectHTML($category, $checkedCategory);
            }
        }

        $list_items = implode('', $list_items);

        if (trim($list_items) == '') {
            return '';
        }

        return '<select id="select21" class="form-control" name="parent_subcategory">' . $list_items . '</select>';
    }

    /**
     * Generate the <option> elements for the <select> element for the given (parent) category.
     *
     * @param  Category $category
     * @param int $checkedCategory
     * @return string
     */
    public function renderCategorySelectHTML(Category $category, $checkedCategory = null)
    {
        $html = '';

        static $x = 0;

        if (count($category->allChildrenCategories)) {
            foreach ($category->allChildrenCategories as $subcategory) {
                if ($x === 0) {
                    $html .= '<optgroup label="' . $category->name;
                    $x++;
                }
                if (count($subcategory->allChildrenCategories)) {
                    $html .= " - " . $subcategory->name;
                    $html .= $this->renderCategorySelectHTML($subcategory, $checkedCategory);
                } else {
                    if ($subcategory->id == $checkedCategory) {
                        $html .= '"><option value="'. $subcategory->id . '" selected >' . $subcategory->name . '</option>';
                    } else {
                        $html .= '"><option value="'. $subcategory->id . '">' . $subcategory->name . '</option>';
                    }
                    $html .= "</optgroup>";
                    $x = 0;
                }
            }
            return $html;
        } else {
            return '<option value="'. $category->id . '">' . $category->name . '</option>';
        }
    }
}
