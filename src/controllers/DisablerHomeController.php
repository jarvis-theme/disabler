<?php namespace Yusidabcs\Disabler;

#############################################################
############ This file is for the examples only! ############
#############################################################


/**
 * Libraries we can use.
 */
use Produk;
use Opsisku;
use Kategori;
use Koleksi;
use Sentry;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
/**
 * The cart main page.
 */
class DisablerHomeController  extends \Illuminate\Routing\Controllers\Controller
{
	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @access   public
	 * @var      boolean
	 */
	public $restful = true;
	
	public function getIndex()
	{
		 if (!Sentry::check())
            {
                // User is not logged in, or is not activated
                $msg = 'You have not access for this page.';
                return Redirect::to('admin/login')->with('error',$msg);
            }
        if(Input::get('status')!='' && Input::get('kategori')==''){
        	$produk = Produk::where('visibility','=',Input::get('status'))->paginate(15);
        }else if(Input::has('status')=='' && Input::has('kategori')!=''){
        	$produk = Produk::where('kategoriId','=',Input::get('kategori'))->paginate(15);
        }else if(Input::has('status')!='' && Input::has('kategori')!=''){
        	$produk = Produk::where('visibility','=',Input::get('status'))->where('kategoriId','=',Input::get('kategori'))->paginate(15);
        }else{
        	$produk = Produk::paginate(15);	
        }		
		return View::make('disabler::index')->with('produk',$produk)
			->with('kategori',Kategori::all())
			->with('koleksi',Koleksi::all());
	}
	public function postIndex()
	{
		if (!Sentry::check())
        {
            // User is not logged in, or is not activated
            $msg = 'You have been logout automaticaly.';            
            return Redirect::to('admin/login')->with('error',$msg);
        }
        $hapus =  Input::get('hapus');
        $hapus= explode(';', $hapus);
        if(Input::get('tipe')=='disable'){
        	$i=0;
	        foreach ($hapus as $value) {
	            if($i!=count($hapus)-1){
	                $produk = Produk::find($value);
	                $produk->visibility=0;
	                $produk->save();
	            }            
	            $i++;
	        }
	        return 'true';		
        } else if(Input::get('tipe')=='enable'){
        	$i=0;
	        foreach ($hapus as $value) {
	            if($i!=count($hapus)-1){
	                $produk = Produk::find($value);
	                $produk->visibility=1;
	                $produk->save();
	            }            
	            $i++;
	        }
	        return 'true';		
        }
	}
	public function postAll()
	{
		if (!Sentry::check())
        {
            // User is not logged in, or is not activated
            $msg = 'You have been logout automaticaly.';
            return Redirect::to('admin/login')->with('error',$msg);
        }
        if(Input::get('status')=='disable'){
       		if(Input::get('tipe')=='1'){
	        	$pro1 = Produk::all();
	        	foreach ($pro1 as $key => $value) {
	        		
	        		if( $value->opsisku->count()==0){
	        			if($value->stok==0){		        			
		        			$value->visibility = 0;
		        			$value->save();	
	        			}
	        		}else{
	        			$stok = Opsisku::select(DB::raw('sum(stok) as stok'))->where('produkId','=',$value->id)->first()->stok;
	        			if($stok==0){
	        				$value->visibility = 0;
	        				$value->save();
	        			}
	        		}
	        	}        	
	        } else if(Input::get('tipe')=='2'){
	        	$kat = Input::get('kategori');
	        	$id = explode(';', getChildren(Kategori::find($kat)));        	
	        	Produk::where('kategoriId', '=', $kat)->update(array('visibility' => 0));
	        	foreach ($id as $key => $value) {
	        		Produk::where('kategoriId', '=', $value)->update(array('visibility' => 0));
	        	}
	        
	    	} else if(Input::get('tipe')=='3'){
	        	$kat = Input::get('koleksi');
	        	Produk::where('koleksiId', '=', $kat)->update(array('visibility' => 0));
	        } 	
        }else if(Input::get('status')=='enable'){
        	if(Input::get('tipe')=='2'){
	        	$kat = Input::get('kategori');        
	        	Produk::where('kategoriId', '=', $kat)->update(array('visibility' => 1));
	        	$id = explode(';', getChildren(Kategori::find($kat)));        	
	        	foreach ($id as $key => $value) {
	        		Produk::where('kategoriId', '=', $value)->update(array('visibility' => 1));
	        	}
	        
	    	} else if(Input::get('tipe')=='3'){
	        	$kat = Input::get('koleksi');
	        	Produk::where('koleksiId', '=', $kat)->update(array('visibility' => 1));
	        }
        }       
        return Redirect::to('disabler')->with('message',Input::get('status'));
	}

}