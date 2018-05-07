<?php

namespace App\Http\Controllers;

use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class ManufacturerController extends Controller
{
    public function index()
    {
        return view('admin.manufacturers.index');
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:product_manufacturers',
        ];

        $messages = [
            'name.required' => 'Naziv proizvođača je obavezan.',
            'name.unique' => 'Naziv proizvođača mora biti jedinstven.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Manufacturer::create($request->all());

        Cache::forget('manufacturers');

        return back()->with('success', "Proizvođač je uspješno dodan.");
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        $rules = [
            'name' => [
                'required',
                Rule::unique('product_manufacturers')->ignore($manufacturer->id),
            ],
        ];

        $messages = [
            'name.required' => 'Naziv proizvođača je obavezan.',
            'name.unique' => 'Naziv proizvođača mora biti jedinstven.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $manufacturer->update($request->all());

        Cache::forget('manufacturers');

        return back()->with('success', "Proizvođač je uspješno uređen.");
    }

    public function getAllManufacturers()
    {
        $manufacturers = Manufacturer::all();

        return Datatables::of($manufacturers)
            ->editColumn('created_at', function (Manufacturer $manufacturer) {
                Carbon::setLocale('hr');
                return $manufacturer->created_at->format('d.m.Y. H:i:s') . " (" . $manufacturer->created_at->diffForHumans() . ")";
            })
            ->editColumn('updated_at', function (Manufacturer $manufacturer) {
                Carbon::setLocale('hr');
                return $manufacturer->updated_at->format('d.m.Y. H:i:s') . " (" . $manufacturer->updated_at->diffForHumans() . ")";
            })
            ->addColumn('actions', function (Manufacturer $manufacturer) {
                $actions = '<a href='. route('admin.manufacturers.edit', ['manufacturer' => $manufacturer]) .
                    '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Uredi proizvođača"></i></a>';
                return $actions;
            })->rawColumns(['actions'])->make(true);
    }
}
