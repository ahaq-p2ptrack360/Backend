<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVendorTypeRequest;
use App\Http\Requests\StoreVendorTypeRequest;
use App\Http\Requests\UpdateVendorTypeRequest;
use App\Models\VendorType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class VendorTypeController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('vendor_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // if(\Auth::user()->company_id != 0){
            // $vendorTypes = VendorType::with('parent:id,title')->where('company_id',1)->get();
        // }else{
            $vendorTypes = VendorType::with('parent:id,title','active','company',)->get();
        // }
        {
            $vendorTypes = DB::table('types')->select('company_id','title','parent_id','active')->get();
    
            return view('some-view')->with('types', $vendorTypes);
        }
        
        // return view('types.index', compact('vendorTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('vendor_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $parents = VendorType::where('parent_id',Null)->where('company_id',\Auth::user()->company_id)->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        // dd($parents);
        return view('types.create',compact('parents'));
    }

    // public function store(StoreVendorTypeRequest $request)
    // {
    //     $vendorType = VendorType::create($request->all());

    //     return redirect()->route('admin.vendor-types.index');
    // }

    public function edit(VendorType $vendorType)
    {
        abort_if(Gate::denies('vendor_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $parents = VendorType::where('parent_id',Null)->where('company_id',\Auth::user()->company_id)->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('types.edit', compact('vendorType','parents'));
    }

    // public function update(UpdateVendorTypeRequest $request, VendorType $vendorType)
    // {
    //     $vendorType->update($request->all());

    //     return redirect()->route('admin.vendor-types.index');
    // }

    public function show(VendorType $vendorType)
    {
        // abort_if(Gate::denies('vendor_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('types.index', compact('vendorType'));
    }

    public function destroy(VendorType $vendorType)
    {
        abort_if(Gate::denies('vendor_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendorType->delete();

        return back();
    }

    // public function massDestroy(MassDestroyVendorTypeRequest $request)
    // {
    //     VendorType::whereIn('id', request('ids'))->delete();

    //     return response(null, Response::HTTP_NO_CONTENT);
    // }

    public function getChildren(Request $request){
        if(isset($request->id)){
            $children = VendorType::select('id','title')->where('company_id',\Auth::user()->company_id)->where('parent_id',$request->id)->get()->toArray();
            $data['children'] = $children;  
            return $data;  
        }else{

        }
        
        // dd($data);
    }
}
