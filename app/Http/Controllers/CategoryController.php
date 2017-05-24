<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\ProductFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    public function index(ProductFilters $filters)
    {
        if (Cache::has('categories')) {
            $categoriesHTML = Cache::get('categories');
        } else {
            Cache::forever('categories', $this->category_list());
            $categoriesHTML = Cache::get('categories');
        }

        if (empty($filters->filters())) {
            $products = Product::orderBy('created_at', 'desc')->paginate(12);
        } else {
            $products = Product::filter($filters);
        }
        $index = true;
        return view('products', ['categories' => $categoriesHTML, 'products' => $products, 'index' => $index]);
    }

    public function show(Category $category, ProductFilters $filters)
    {
        if (Cache::has('category.' . $category->slug)) {
            $categoriesHTML = Cache::get('category.' . $category->slug);
        } else {
            Cache::forever('category.' . $category->slug, $this->category_list());
            $categoriesHTML = Cache::get('category.' . $category->slug);
        }

        if (empty($filters->filters())) {
            $products = Cache::remember('category.' . $category->slug . '.paginatedProducts', 15, function () use ($category) {
                $category_with_products = $category->load('products');
                $products = $category_with_products->products;

                $products = $products->sortByDesc('created_at');

                return $products;
            });

            $currentPage = 0;

            //Define how many items we want to be visible in each page by default
            $perPage = 12;

            //Slice the collection to get the items to display in current page
            $currentProducts = $products->slice($currentPage * $perPage, $perPage)->all();

            $number_of_products = $products->count();

            //Create our paginator
            $paginatedProducts = new LengthAwarePaginator($currentProducts, $number_of_products, $perPage);
            $paginatedProducts->setPath(route("ProductCategory", $category->slug));

            return view('products', ['categories' => $categoriesHTML, 'products' => $paginatedProducts, 'category' => $category]);
        } else {
            $filters->getRequest()->request->add(['category' => $category->id]);
            $products = Product::filter($filters);

            return view('products', ['categories' => $categoriesHTML, 'products' => $products]);
        }
    }

    public function create()
    {
        $selectHTML = $this->renderCategoriesSelectHTML();
        return view('admin.categories.create', compact('selectHTML'));
    }

    public function store(Request $request)
    {
        if ($request->has('main_category')) {
            Category::create(['name' => $request->input('main_category'), 'category_parent_id' => 0]);
            flushCategoriesCache();
            return back()->with('success', "Kategorija je uspješno dodana.");
        }

        if ($request->has('parent_category') && $request->has('subcategory')) {
            Category::create(['name' => $request->input('subcategory'), 'category_parent_id' => $request->input('parent_category')]);
            flushCategoriesCache();
            return back()->with('success', "Podkategorija je uspješno dodana.");
        }

        return back()->with('error', "Kategorija nije uspješno dodana. Molimo pokušajte kasnije.");
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->input('category'));
        $this->checkForProducts($category);

        if (! CategoryController::$products) {
            if ($category->delete()) {
                flushCategoriesCache();
                return "success";
            } 
        } else {
            return "Ova kategorija ili neka njezina podkategorija ima u sebi proizvod(e).";
        }
    }
    
    public function getDeleteView()
    {
        $categories = Category::where('category_parent_id', '=', 0)->get();
        $html = '';
        for ($i = 0, $count = $categories->count(); $i < $count; $i++) {
            $html .= $this->generateHTMLButtons($categories[$i]);
        }
        return view('admin.categories.delete', compact('categories', 'html'));
    }

    public function generateHTMLButtons(Category $category)
    {
        static $j = 0;
        $html = '';
        if ($category->category_parent_id === 0) {
            if ($j === 1) {
                $html .= '<br><br>';
            }
            $html .= '<button class="btn btn-danger category_button" type="submit" name="category" value="' . $category->id . '">Obriši kategoriju - ' . $category->name . '</button><br>';
            $j = 1;
        }
        foreach ($category->childrenCategories as $subcategory) {
            $html .= '<button class="btn btn-danger category_button" type="submit" name="category" value="' . $subcategory->id . '">Obriši kategoriju - ' . $subcategory->name . '</button><br>';
            $html .= $this->generateHTMLButtons($subcategory);
        }

        return $html;

    }

    static $products = false;
    
    public function checkForProducts(Category $category)
    {
        if ($category->products->count() === 0) {
            if ($category->childrenCategories->count() !== 0) {
                foreach ($category->childrenCategories as $subcategory) {
                    $this->checkForProducts($subcategory);
                }
            }
        } else {
            CategoryController::$products = true;
        }
    }

    /**
     * Generate the the <select> HTML element for the current categories in the DB.
     *
     * @return string
     */
    public function renderCategoriesSelectHTML()
    {
        static $categories;

        if (! is_array($categories)) {
            $categories = Category::all();
        }

        $list_items = [];

        foreach ($categories as $category) {
            // always start only from the top parent categories in the tree
            if(! count($category->parentCategory)) {
                $list_items[] = $this->renderCategorySelectHTML($category);
            }
        }

        $list_items = implode('', $list_items);

        if (trim($list_items) == '') {
            return '';
        }

        return '<select id="select21" class="form-control" name="parent_category">' . $list_items . '</select>';
    }

    /**
     * Generate the <option> elements for the <select> element for the given (parent) category.
     *
     * @param  Category $category
     * @return string
     */
    public function renderCategorySelectHTML(Category $category)
    {
        static $already_displayed_IDs;

        $html = '';
        if (! $category->products()->count()) {
            if (! is_array($already_displayed_IDs) || ! in_array($category->id, $already_displayed_IDs)) {
                $html .= '<option value="' . $category->id . '">' . $category->name . '</option>';
                $already_displayed_IDs[] = $category->id;
            }
        }

        if (count($category->childrenCategories)) {
            foreach ($category->childrenCategories as $subcategory) {
                if (! $subcategory->products()->count()) {
                    if (! is_array($already_displayed_IDs) || ! in_array($subcategory->id, $already_displayed_IDs)) {
                        $html .= '<option value="' . $subcategory->id . '">' . $subcategory->name . '</option>';
                        $already_displayed_IDs[] = $subcategory->id;
                    }
                }
                $html .= $this->renderCategorySelectHTML($subcategory);
            }
        }

        return $html;
    }

    /**
     * Generate the category navigation HTML.
     *
     * @param  int $category_parent_id
     * @return string
     */
    public function category_list($category_parent_id = 0)
    {
        // napravi listu kategoriju samo jednom
        static $categories;

        if (! is_array($categories)) {
            $categories = Category::all();
        }

        $list_items = [];

        foreach ($categories as $category) {
            // ako se ne poklapa kategorija od koje se želi krenuti stvarati stablo, kreni u iduću iteraciju
            if ($category->category_parent_id !== $category_parent_id ) {
                continue;
            }

            // početni li tag
            $list_items[] = '<li>';

            // dodaj link u li tag
            if (count($category->childrenCategories)) {
                $list_items[] = '<a href="#">';
            } else {
                $route = route('ProductCategory', $category->slug);
                $list_items[] = '<a '.setActive('category/' . $category->slug . '/products').' href="'. $route . '">';
            }

            $list_items[] = $category->name;
            $list_items[] = '</a>';

            // rekurzija kroz djecu kategorije (ponavljanje cijelog ovog postupka)
            $list_items[] = $this->category_list($category->id);

            // zatvori li
            $list_items[] = '</li>';

        }

        // pretvori u string
        $list_items = implode('', $list_items);

        // ako je prazno vrati prazan string
        if (trim($list_items) == '') {
            return '';
        }

        // ako nije prazno spremi listu i vrati ju
        return '<ul class="nav-category nav-tree">' . $list_items . '</ul>';
    }
}
