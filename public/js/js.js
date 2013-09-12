 function checkThis(id){
    var hapus = document.getElementById('hapus').value;
    var centang = id.checked;
    if(centang == true){
        nilai = id.value;
        hapus = nilai +';'+hapus;
        document.getElementById('hapus').value = hapus;
    }else{
        test = '';
        nilai = id.value;
        var word = hapus.split(";");
        for(i=0; i<word.length; i++){
            if(word[i] != nilai){
                test = word[i]+';'+test;
            }
        }
        test = test.substr(1,test.length);
        document.getElementById('hapus').value = test;
    }
}

var check = false;
function checkAll(){
    var panjang = document.getElementsByName('delete').length;
    var hapus = '';
    if(check == false){
        for(i=0; i<panjang; i++){
            document.getElementById('delete'+i).checked = true;
            var nilai = document.getElementById('delete'+i).value;
            hapus = nilai +';'+hapus;
        }
        document.getElementById('hapus').value = hapus;
        check = true;
    }else{
        for(i=0; i<panjang; i++){
            document.getElementById('delete'+i).checked = false;
        }
        document.getElementById('hapus').value = '';
        check = false
    }
}
function deleteChecked(){
    var hapus = document.getElementById('hapus').value;
    if(hapus != ''){
        konfirm = window.confirm('Hapus produk yang diberi tanda dicentang?');
        if(konfirm){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
$(document).ready(function(){  
    $('#disable').click(function(){
        var hapus = document.getElementById('hapus').value;
        if(hapus != ''){
            konfirm = window.confirm('Disable produk yang diberi tanda dicentang?');
            if(konfirm){
                $('#disable').button('loading');
                $.ajax({
                    url: URL+'/disabler',
                    type: 'post',
                    data : {hapus:hapus,tipe:'disable'}
                }).done(function(data){ 
                    if(data=='true'){
                        window.location=URL+'/disabler?success=disable';
                    }
                });     
            }else{
                return false;
            }
        }else{
             $('#myModal').modal('show');
        }       
    });
    $('#enable').click(function(){
        var hapus = document.getElementById('hapus').value;
        if(hapus != ''){
            konfirm = window.confirm('Enable produk yang diberi tanda dicentang?');
            if(konfirm){
                $('#enable').button('loading');
                $.ajax({
                    url: URL+'/disabler',
                    type: 'post',
                    data : {hapus:hapus,tipe:'enable'}
                }).done(function(data){ 
                    if(data=='true'){
                        window.location=URL+'/disabler?success=enable';
                    }
                });     
            }else{
                return false;
            }
        }else{
            $('#myModal2').modal('show');
        }       
    });
    $('#myModal, #myModal2').on('show', function () {
        $('.place-stok').hide();
    })
    var prev = '';
    $('[name="tipe"]').click(function(){
        a = this.value;
        if(prev!=''){
            $('.'+prev).hide(1,function(){
                $('.'+a).show();
                $('.'+prev+' select').prop('selectedIndex',0);
            });    
        }else{
            $('.'+this.value).show();    
        }
        
        prev = this.value;        
    });
    $('#all').submit(function(){
        valid = true;
        tipe = $('input[name="tipe"]:checked').val();
        if(tipe==2){
            kat = $('#all [name="kategori"]').val();            
            if(kat==''){
                alert ('Anda belum memilih salah satu kategori.')
                valid = false;
            }
        }else if(tipe==3){
            kol = $('#All [name="koleksi"]').val();
            if(kol==''){
                alert ('Anda belum memilih salah satu koleksi.') 
                valid = false;
            }
        }
        if(valid==true){
            $(this).find('input[type="submit"]').button('loading');
        }
        return valid;
    });
});