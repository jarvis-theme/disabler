    <!DOCTYPE html>
    <html>
    <head>
    	<title>Jarvis Disabler/Enabler</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<!-- Bootstrap -->
    	{{HTML::style('packages/Yusidabcs/disabler/css/bootstrap.min.css')}}    
    	{{HTML::style('packages/Yusidabcs/disabler/css/bootstrap-responsive.min.css')}}
    	<style type="text/css">
    	body {
    		padding-top: 10px;
    		padding-bottom: 40px;
    	}
        .navbar-inner{
            background: none repeat scroll 0% 0% rgb(59, 59, 65);
        }
    	/* Custom container */
    	.container-narrow {
    		margin: 0 auto;
    		max-width: 700px;
    	}
    	.container-narrow > hr {
    		margin: 30px 0;
    	}

    	/* Main marketing message and sign up button */
    	.jumbotron {
    		margin: 60px 0;
    		text-align: center;
    	}
    	.jumbotron h1 {
    		font-size: 72px;
    		line-height: 1;
    	}
    	.jumbotron .btn {
    		font-size: 21px;
    		padding: 14px 24px;
    	}

    	/* Supporting marketing content */
    	.marketing {
    		margin: 10px 0 -10px 0;
    	}
    	.marketing p + h4 {
    		margin-top: 28px;
    	}
    	</style>
    </head>
    <body>
         <div class="navbar navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container-narrow">
                <h5 class="pull-left text-error"><i class="icon-off"></i> Jarvis Disabler/Enabler</h5>
                <ul class="nav nav-pills pull-right">
                    <li class="active"><input class="btn btn-medium btn-danger" type="button" id="disable" value="Disable">
                        &nbsp;<input class="btn btn-medium btn-success" type="button" id="enable" value="Enable">
                        <input  type="hidden" id="hapus" name='hapus'>
                    </li>                   
                </ul>
            </div>
              </div>
            </div>
    	<div class="container-narrow">
            <hr>
            @if(Session::has('message') || Input::has('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Selamat!</strong> Produk yang anda pilih sudah berhasi di {{Session::get('message')}} {{Input::get('success')}}.
            </div>
            @endif
            <div class="row-fluid marketing ">                
                <div class="span12">
                    <form class="form-inline pull-right" action="{{URL::to('disabler')}}" method="get">
                        <select name="status" class="input-small">
                            <option value="" {{Input::get('status')=='' ? 'selected':''}}>All</option>
                            <option value="1" {{Input::get('status')==1 ? 'selected':''}}>Enable</option>
                            <option value="0" {{Input::get('status')=='0' ? 'selected':''}}>Disable</option>                            
                        </select>
                        <select name="kategori">
                            <option value="">All</option>
                            @foreach($kategori as $item)
                                @if($item->parent==0)
                                <option value="{{$item->id}}" {{Input::get('kategori')==$item->id ? 'selected':''}}>{{$item->nama}}</option>
                                    @foreach($kategori as $subitem)
                                        @if($subitem->parent==$item->id)
                                        <option value="{{$subitem->id}}" {{Input::get('kategori')==$subitem->id ? 'selected':''}}>&nbsp;&nbsp;{{$subitem->nama}}</option>
                                            @foreach($kategori as $subitem2)
                                               @if($subitem2->parent==$subitem->id)
                                              <option value="{{$subitem2->id}}" {{Input::get('kategori')==$subitem2->id ? 'selected':''}}>&nbsp;&nbsp;&nbsp;&nbsp;{{$subitem2->nama}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        <input type="submit" value="filter" class=" btn btn-danger">
                    </form>
                </div>
                <hr>
                <div class="row-fluid ">             
                    <hr>
                    @if(count($produk)>0)
                    <table class="table table-striped">
                      <thead>
                          <tr>
                              <th><input type="checkbox" id="optionsCheckbox2" value="" onclick="checkAll()"></th>
                              <th class="hidden-phone">Gambar</th>
                              <th>Nama Produk</th>
                              <th>Kategori</th>
                              <th class="hidden-phone">Vendor</th>
                          </tr>
                      </thead>   
                      <tbody>
                        @for ($i=0; $i < count($produk) ; $i++)                         
                        <tr {{ $produk[$i]->visibility==0 ? 'style="font-style:italic;color: #b94a48"':''}}>
                            <td><input type="checkbox" name="delete" id="delete{{$i}}" value="{{$produk[$i]->id}}" onclick="checkThis(this)"></td>
                            <td class="hidden-phone">{{ HTML::image(getPrefixDomain().'/produk/thumb/'.$produk[$i]->gambar1, '', array('width'=>'40'))}}</td>
                            <td class="center">{{$produk[$i]->nama}}</td>
                            <td class="center">{{ buatKategori($kategori,$produk[$i]->kategoriId)}}</td>
                            <td class="center hidden-phone">{{$produk[$i]->vendor}}</td>                               
                        </tr>
                        @endfor


                    </tbody>
                </table>
                @else
                    <div class="alert alert-block">
                    <center><p>Produk tidak ditemukan.</p></center>
                    </div>
                
                @endif
            </div>

        </div>
        <center>{{$produk->links()}}</center>
        <hr>

        <div class="footer">
         <p>© jarvis-store | jarvis D/E 2013 <a href="#help" data-toggle="modal">Help</a></p>
     </div>

 </div>
 <div id="help" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Help</h3>
  </div>
  <div class="modal-body">
    <h4>About</h4>
    <p>Package ini berfungsi untuk mendisable atau mengenable produk-produk di toko online anda dengan lebih gampang. Kami menyediakan fitur enable dan disable sekaligus yang dapat anda pilih sendiri sesuai dengan kebutuhan anda.</p>
    <p>Untuk mendisable produk anda bisa memilih disable berdasarkan stok yang sudah habis, berdasarkan kategori ataupun berdasarkan koleksinya.</p>
    <p>Anda juga dapat mengenable kembali produk-produk berdasarkan kategori ataupun koleksi produk tersebut.</p>
    <p>Terima kasih dan selamat mencoba.</p>
  </div>  
</div>
 <!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Disable Produk</h3>
  </div>
  {{Form::open(array('url'=>'disabler/all','method'=>'post','id'=>'all'))}}
  <div class="modal-body">
    <div class="row-fluid">
        <div class="span4 well">
            <label class="radio">
              <input type="radio" name="tipe" id="optionsRadios1" value="1" >
              Out of Stok
            </label>           
        </div>
        <div class="span4 well">
            <label class="radio">
              <input type="radio" name="tipe" id="optionsRadios1" value="2" >
              by Kategori
            </label>           
        </div>
        <div class="span4 well">
            <label class="radio">
              <input type="radio" name="tipe" id="optionsRadios1" value="3" >
              by Koleksi
            </label>           
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 1">
            <i>Dengan memilih stok maka produk anda yang out of stok akan di disable otomatis.</i>         
        </div>               
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 2">
            <select name='kategori'>
                <option value="">Pilih Kategori</option>
                 @foreach($kategori as $item)
                    @if($item->parent==0)
                    <option value="{{$item->id}}" {{Input::get('kategori')==$item->id ? 'selected':''}}>{{$item->nama}}</option>
                        @foreach($kategori as $subitem)
                            @if($subitem->parent==$item->id)
                            <option value="{{$subitem->id}}" {{Input::get('kategori')==$subitem->id ? 'selected':''}}>&nbsp;&nbsp;{{$subitem->nama}}</option>
                                @foreach($kategori as $subitem2)
                                   @if($subitem2->parent==$subitem->id)
                                  <option value="{{$subitem2->id}}" {{Input::get('kategori')==$subitem2->id ? 'selected':''}}>&nbsp;&nbsp;&nbsp;&nbsp;{{$subitem2->nama}}</option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </select>            
        </div>               
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 3">    
            <select name='koleksi'>
                <option value="">Pilih Koleksi</option>
                 @foreach($koleksi as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>              
                @endforeach
            </select>                
        </div>               
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="status" value="disable">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <input class="btn btn-primary" type="submit" value="Disable">
  </div>
  {{Form::close()}}
</div>
 <!-- Modal 2-->
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Enable Produk</h3>
  </div>
  {{Form::open(array('url'=>'disabler/all','method'=>'post','id'=>'all'))}}
  <div class="modal-body">
    <div class="row-fluid">        
        <div class="span6 well">
            <label class="radio">
              <input type="radio" name="tipe" id="optionsRadios1" value="2" >
              by Kategori
            </label>           
        </div>
        <div class="span6 well">
            <label class="radio">
              <input type="radio" name="tipe" id="optionsRadios1" value="3" >
              by Koleksi
            </label>           
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 1">
            <i>Dengan memilih stok maka produk anda yang out of stok akan di enable otomatis.</i>         
        </div>               
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 2">
            <select name='kategori'>
                <option value="">Pilih Kategori</option>
                 @foreach($kategori as $item)
                    @if($item->parent==0)
                    <option value="{{$item->id}}" {{Input::get('kategori')==$item->id ? 'selected':''}}>{{$item->nama}}</option>
                        @foreach($kategori as $subitem)
                            @if($subitem->parent==$item->id)
                            <option value="{{$subitem->id}}" {{Input::get('kategori')==$subitem->id ? 'selected':''}}>&nbsp;&nbsp;{{$subitem->nama}}</option>
                                @foreach($kategori as $subitem2)
                                   @if($subitem2->parent==$subitem->id)
                                  <option value="{{$subitem2->id}}" {{Input::get('kategori')==$subitem2->id ? 'selected':''}}>&nbsp;&nbsp;&nbsp;&nbsp;{{$subitem2->nama}}</option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </select>            
        </div>               
    </div>
    <div class="row-fluid">
        <div class="span12 well place-stok 3">    
            <select name='koleksi'>
                <option value="">Pilih Koleksi</option>
                 @foreach($koleksi as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>              
                @endforeach
            </select>                
        </div>               
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="status" value="enable">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <input class="btn btn-primary" type="submit" value="Enable">
  </div>
  {{Form::close()}}
</div>
<script type="text/javascript">
 var URL = "{{ URL::to('')}}";
</script>           
 {{HTML::script("packages/yusidabcs/disabler/js/jquery-1.9.1.min.js")}}
 {{HTML::script("packages/yusidabcs/disabler/js/bootstrap.min.js")}}
{{HTML::script("packages/yusidabcs/disabler/js/js.js")}}

</body>
</html>