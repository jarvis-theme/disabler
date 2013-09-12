<?php namespace Yusidabcs\Disabler;

use Produk;
use Pengaturan;
use Kategori;
use Sentry;
use Illuminate\View\Environment;


class Disabler{
	public $produk;
	public $login;
	protected $view;
	public function __construct(Environment $view)
    {
        $this->view = $view;
         if ( ! Sentry::check())
		{
		    return false;
		}
    }
	public function getProduk(){
		return Produk::all();				
	}
	public function setDisabler($id=null){
		if(Input::has('kategori')){
			Produk::where('kategoriId', '=', Input::get('kategori'))->update(array('visibility' => 0));
		}
		else if(Input::has('koleksi')){
			Produk::where('koleksiId', '=', Input::get('koleksi'))->update(array('visibility' => 0));
		}else{
			$pro = Produk::find($id);
			$pro->visibility = 0;
			$pro->save();
		}		
	}
}