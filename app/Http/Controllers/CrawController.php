<?php

namespace App\Http\Controllers;
include './DOMPARSER.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrawController extends Controller
{
    public function crawQuanAoTheThao(){

        set_time_limit(50000000);

        $ao=true;
        $quan=true;
        $giay=true;
        $phukien=true;

        //Ao tshirt nam
        if($ao){
            $data =[];
            $html = file_get_html('https://maxxsport.com.vn/ao-t-shirt-nam-1');
            $collection = $html->find('.products-view.products-view-grid')[0]->find('div.product-col');
            $i = 0;
            $index = 0;
            $index_img = 0;
            foreach($collection as $c){
                if($index%2){
                    try{
                        $data[$i] = collect();
                        $data[$i]->name = $c->find('.product-name a')[0]->innertext;
                        $data[$i]->price = str_replace(',','',str_replace('₫','',str_replace('.','',$c->find('.price.product-price')[0]->innertext)));

                        if($data[$i]->price == 'Liên hệ')
                            $data[$i]->price = 800000;

                        $url = 'https:'.$c->find('.image_link img')[0]->getAttribute('data-src');

                        $imgg = $index_img++.'_a.jpg';
                        $img = public_path().'/upload/product/'.$imgg;
                        file_put_contents($img, file_get_contents($url));

                        $data[$i]->imageLink = $imgg;
                        $data[$i]->link = 'https://maxxsport.com.vn'.$c->find('.image_link')[0]->href;

                        ///get detail

                        //get image list
                        $arrayImg = [];

                        if ((@file_get_html($data[$i]->link)) === false) {
                            $data[$i]=[];
                            $i--;
                        } else {
                            $html = file_get_html($data[$i]->link);
                            if(isset($html->find('.thumbnail-product.thumb_product_details')[0])){

                                $imagelist = $html->find('.thumbnail-product.thumb_product_details')[0]->find('.item img');
                                foreach($imagelist as $image){

                                    $url = 'https:'.$image->getAttribute('data-img');

                                    $imgg = $index_img++.'_a.jpg';
                                    $img = public_path().'/upload/product/'.$imgg;
                                    file_put_contents($img, file_get_contents($url));

                                    array_push($arrayImg, $imgg);
                                };
                                //get description
                                if(isset($html->find('.product_getcontent')[0])){
                                    $data[$i]->description = $html->find('.product_getcontent')[0]->innertext;
                                }
                                else{
                                    $data[$i]=[];
                                    $i--;
                                }
                            }
                            else{
                                $data[$i]=[];
                                $i--;
                            }
                        }
                        $data[$i]->imageList = '['.implode(',',$arrayImg).']';
                    }
                    catch(Exception $e){
                    }
                    //if($i == 3) break;

                    $imgg='';
                    $i++;
                }
                $index++;
            }
            //dd($data);
            foreach($data as $insert){
                DB::table('product')->insert([
                    [
                        'catalog_id' => 10,
                        'name' => $insert->name,
                        'content' => $insert->description,
                        'price' => $insert->price,
                        'discount' => 50000,
                        'image_link' => $insert->imageLink,
                        'image_list' => $insert->imageList,
                        'view' => 1,
                        'buyed' => 1,
                        'rate_total' => 4,
                        'rate_count' => 1,
                        'created' => 1645864550
                    ]
                ]);
            }
        }

        //Quan nam
        if($quan){
            $data =[];
            $html = file_get_html('https://maxxsport.com.vn/quan-nam');
            $collection = $html->find('.products-view.products-view-grid')[0]->find('div.product-col');
            $i = 0;
            $index = 0;
            $index_img = 0;
            foreach($collection as $c){
                if($index%2){
                    try{
                        $data[$i] = collect();
                        $data[$i]->name = $c->find('.product-name a')[0]->innertext;
                        $data[$i]->price = str_replace(',','',str_replace('₫','',str_replace('.','',$c->find('.price.product-price')[0]->innertext)));

                        if($data[$i]->price == 'Liên hệ')
                            $data[$i]->price = 800000;

                        $url = 'https:'.$c->find('.image_link img')[0]->getAttribute('data-src');

                        $imgg = $index_img++.'_q.jpg';
                        $img = public_path().'/upload/product/'.$imgg;
                        file_put_contents($img, file_get_contents($url));

                        $data[$i]->imageLink = $imgg;
                        $data[$i]->link = 'https://maxxsport.com.vn'.$c->find('.image_link')[0]->href;

                        ///get detail

                        //get image list
                        $arrayImg = [];

                        if ((@file_get_html($data[$i]->link)) === false) {
                            $data[$i]=[];
                            $i--;
                        } else {
                            $html = file_get_html($data[$i]->link);
                            if(isset($html->find('.thumbnail-product.thumb_product_details')[0])){

                                $imagelist = $html->find('.thumbnail-product.thumb_product_details')[0]->find('.item img');
                                foreach($imagelist as $image){

                                    $url = 'https:'.$image->getAttribute('data-img');

                                    $imgg = $index_img++.'_q.jpg';
                                    $img = public_path().'/upload/product/'.$imgg;
                                    file_put_contents($img, file_get_contents($url));

                                    array_push($arrayImg, $imgg);
                                };
                                //get description
                                if(isset($html->find('.product_getcontent')[0])){
                                    $data[$i]->description = $html->find('.product_getcontent')[0]->innertext;
                                }
                                else{
                                    $data[$i]=[];
                                    $i--;
                                }
                            }
                            else{
                                $data[$i]=[];
                                $i--;
                            }
                        }
                        $data[$i]->imageList = '['.implode(',',$arrayImg).']';
                    }
                    catch(Exception $e){
                    }
                    //if($i == 3) break;

                    $imgg='';
                    $i++;
                }
                $index++;
            }
            //dd($data);
            foreach($data as $insert){
                DB::table('product')->insert([
                    [
                        'catalog_id' => 11,
                        'name' => $insert->name,
                        'content' => $insert->description,
                        'price' => $insert->price,
                        'discount' => 50000,
                        'image_link' => $insert->imageLink,
                        'image_list' => $insert->imageList,
                        'view' => 1,
                        'buyed' => 1,
                        'rate_total' => 4,
                        'rate_count' => 1,
                        'created' => 1645864550
                    ]
                ]);
            }
        }

        //Giay nam
        if($giay){
            $data =[];
            $html = file_get_html('https://maxxsport.com.vn/giay-dep-nam');
            $collection = $html->find('.products-view.products-view-grid')[0]->find('div.product-col');
            $i = 0;
            $index = 0;
            $index_img = 0;
            foreach($collection as $c){
                if($index%2){
                    try{
                        $data[$i] = collect();
                        $data[$i]->name = $c->find('.product-name a')[0]->innertext;
                        $data[$i]->price = str_replace(',','',str_replace('₫','',str_replace('.','',$c->find('.price.product-price')[0]->innertext)));

                        if($data[$i]->price == 'Liên hệ')
                            $data[$i]->price = 800000;

                        $url = 'https:'.$c->find('.image_link img')[0]->getAttribute('data-src');

                        $imgg = $index_img++.'_g.jpg';
                        $img = public_path().'/upload/product/'.$imgg;
                        file_put_contents($img, file_get_contents($url));

                        $data[$i]->imageLink = $imgg;
                        $data[$i]->link = 'https://maxxsport.com.vn'.$c->find('.image_link')[0]->href;

                        ///get detail

                        //get image list
                        $arrayImg = [];

                        if ((@file_get_html($data[$i]->link)) === false) {
                            $data[$i]=[];
                            $i--;
                        } else {
                            $html = file_get_html($data[$i]->link);
                            if(isset($html->find('.thumbnail-product.thumb_product_details')[0])){

                                $imagelist = $html->find('.thumbnail-product.thumb_product_details')[0]->find('.item img');
                                foreach($imagelist as $image){

                                    $url = 'https:'.$image->getAttribute('data-img');

                                    $imgg = $index_img++.'_g.jpg';
                                    $img = public_path().'/upload/product/'.$imgg;
                                    file_put_contents($img, file_get_contents($url));

                                    array_push($arrayImg, $imgg);
                                };
                                //get description
                                if(isset($html->find('.product_getcontent')[0])){
                                    $data[$i]->description = $html->find('.product_getcontent')[0]->innertext;
                                }
                                else{
                                    $data[$i]=[];
                                    $i--;
                                }
                            }
                            else{
                                $data[$i]=[];
                                $i--;
                            }
                        }
                        $data[$i]->imageList = '['.implode(',',$arrayImg).']';
                    }
                    catch(Exception $e){
                    }
                    //if($i == 3) break;

                    $imgg='';
                    $i++;
                }
                $index++;
            }
            //dd($data);
            foreach($data as $insert){
                DB::table('product')->insert([
                    [
                        'catalog_id' => 12,
                        'name' => $insert->name,
                        'content' => $insert->description,
                        'price' => $insert->price,
                        'discount' => 50000,
                        'image_link' => $insert->imageLink,
                        'image_list' => $insert->imageList,
                        'view' => 1,
                        'buyed' => 1,
                        'rate_total' => 4,
                        'rate_count' => 1,
                        'created' => 1645864550
                    ]
                ]);
            }
        }

        //Phu kien nam
        if($phukien){
            $data =[];
            $html = file_get_html('https://maxxsport.com.vn/phu-kien');
            $collection = $html->find('.products-view.products-view-grid')[0]->find('div.product-col');
            $i = 0;
            $index = 0;
            $index_img = 0;
            foreach($collection as $c){
                if($index%2){
                    try{
                        $data[$i] = collect();
                        $data[$i]->name = $c->find('.product-name a')[0]->innertext;
                        $data[$i]->price = str_replace(',','',str_replace('₫','',str_replace('.','',$c->find('.price.product-price')[0]->innertext)));

                        if($data[$i]->price == 'Liên hệ')
                            $data[$i]->price = 800000;

                        $url = 'https:'.$c->find('.image_link img')[0]->getAttribute('data-src');

                        $imgg = $index_img++.'_pk.jpg';
                        $img = public_path().'/upload/product/'.$imgg;
                        file_put_contents($img, file_get_contents($url));

                        $data[$i]->imageLink = $imgg;
                        $data[$i]->link = 'https://maxxsport.com.vn'.$c->find('.image_link')[0]->href;

                        ///get detail

                        //get image list
                        $arrayImg = [];

                        if ((@file_get_html($data[$i]->link)) === false) {
                            $data[$i]=[];
                            $i--;
                        } else {
                            $html = file_get_html($data[$i]->link);
                            if(isset($html->find('.thumbnail-product.thumb_product_details')[0])){

                                $imagelist = $html->find('.thumbnail-product.thumb_product_details')[0]->find('.item img');
                                foreach($imagelist as $image){

                                    $url = 'https:'.$image->getAttribute('data-img');

                                    $imgg = $index_img++.'_pk.jpg';
                                    $img = public_path().'/upload/product/'.$imgg;
                                    file_put_contents($img, file_get_contents($url));

                                    array_push($arrayImg, $imgg);
                                };
                                //get description
                                if(isset($html->find('.product_getcontent')[0])){
                                    $data[$i]->description = $html->find('.product_getcontent')[0]->innertext;
                                }
                                else{
                                    $data[$i]=[];
                                    $i--;
                                }
                            }
                            else{
                                $data[$i]=[];
                                $i--;
                            }
                        }
                        $data[$i]->imageList = '['.implode(',',$arrayImg).']';
                    }
                    catch(Exception $e){
                    }
                    //if($i == 3) break;

                    $imgg='';
                    $i++;
                }
                $index++;
            }
            //dd($data);
            foreach($data as $insert){
                DB::table('product')->insert([
                    [
                        'catalog_id' => 13,
                        'name' => $insert->name,
                        'content' => $insert->description,
                        'price' => $insert->price,
                        'discount' => 50000,
                        'image_link' => $insert->imageLink,
                        'image_list' => $insert->imageList,
                        'view' => 1,
                        'buyed' => 1,
                        'rate_total' => 4,
                        'rate_count' => 1,
                        'created' => 1645864550
                    ]
                ]);
            }
        }
    }
    public function crawTheGioiDiDong(){

        set_time_limit(50000000);

        //Dien thoai di dong
        //Iphone
        $url_craw = 'https://hoanghamobile.com/dien-thoai-di-dong/iphone?p=2';
        $code_pre="SMPIP";
        $img_end="_dtiphone.jpg";
        $cat_id = 1;
        $manufac_id=2;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //Samsung
        $url_craw = 'https://hoanghamobile.com/dien-thoai-di-dong/samsung?p=2';
        $code_pre="SMPSAMSUNG";
        $img_end="_dtsamsung.jpg";
        $cat_id = 1;
        $manufac_id=1;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //Xiaomi
        $url_craw = 'https://hoanghamobile.com/dien-thoai-di-dong/xiaomi?p=2';
        $code_pre="SMPXIAO";
        $img_end="_dtxiaomi.jpg";
        $cat_id = 1;
        $manufac_id=3;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //Oppo
        $url_craw = 'https://hoanghamobile.com/dien-thoai-di-dong/oppo?p=2';
        $code_pre="SMPOPPO";
        $img_end="_dtoppo.jpg";
        $cat_id = 1;
        $manufac_id=4;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);



        //Laptop
        //Asus
        $url_craw = 'https://hoanghamobile.com/laptop/asus?p=2';
        $code_pre="LTASUS";
        $img_end="_ltasus.jpg";
        $cat_id = 2;
        $manufac_id=11;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //Dell
        $url_craw = 'https://hoanghamobile.com/laptop/dell?p=2';
        $code_pre="LTDELL";
        $img_end="_ltdell.jpg";
        $cat_id = 2;
        $manufac_id=8;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //MSI
        $url_craw = 'https://hoanghamobile.com/laptop/msi?p=2';
        $code_pre="LTMSI";
        $img_end="_ltmsi.jpg";
        $cat_id = 2;
        $manufac_id=9;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //HP
        $url_craw = 'https://hoanghamobile.com/laptop/hp?p=2';
        $code_pre="LTHP";
        $img_end="_lthp.jpg";
        $cat_id = 2;
        $manufac_id=10;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);


        //Tablet
        //Ipad
        $url_craw = 'https://hoanghamobile.com/tablet/ipad?p=2';
        $code_pre="TBLIPAD";
        $img_end="_TBLIPAD.jpg";
        $cat_id = 3;
        $manufac_id=2;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);
        //Samsung
        $url_craw = 'https://hoanghamobile.com/tablet/samsung?p=2';
        $code_pre="TBLSAMSUNG";
        $img_end="_TBLSAMSUNG.jpg";
        $cat_id = 3;
        $manufac_id=1;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);

        //Dong ho
        //Apple watch
        $url_craw = 'https://hoanghamobile.com/dong-ho/apple-watch?p=2';
        $code_pre="SMWAPPLE";
        $img_end="_SMWAPPLE.jpg";
        $cat_id = 4;
        $manufac_id=2;
        $this->crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id);


        return response("Done", 200);
    }
    public function crawHoangHaMobile($url_craw, $code_pre, $img_end, $cat_id, $manufac_id){
        if(true){
            $data =[];
            $html = file_get_html($url_craw);
            $collection = $html->find('.col-content.lts-product')[0]->find('.item');
            //dd($collection);
            $i = 0;
            $index = 0;
            $index_img = 0;

            //each product
            foreach($collection as $c){
                if(0==0){
                    try{
                        $product_name = trim($c->find('.info a')[0]->plaintext);
                        $product_price=str_replace('&#x20AB;','',str_replace(',','',str_replace('₫','',str_replace('.','',$c->find('.price strong')[0]->plaintext))));

                        $data[$i] = collect();
                        $data[$i]->name = $product_name;
                        $data[$i]->price = $product_price;
                        if($data[$i]->price == 'Liên hệ')
                            $data[$i]->price = 0;

                        $url = $c->find('.img img')[0]->getAttribute('src');
                        if(@file_get_contents($url) != false){

                            $imgg = $index_img++.$img_end;

                            file_put_contents(public_path().'/media/imgProduct/images/'.$imgg, file_get_contents($url));
                            file_put_contents(public_path().'/media/imgProduct/medium/'.$imgg, file_get_contents($url));
                            file_put_contents(public_path().'/media/imgProduct/thumb/'.$imgg, file_get_contents($url));

                            $data[$i]->imageLink = $imgg;
                        }
                        else
                            $data[$i]->imageLink = $url;
                        $data[$i]->link = 'https://hoanghamobile.com'.$c->find('.info a')[0]->href;
                        //dd($data[$i]->link);

                        ///get detail

                        //get image list
                        $arrayImg = [];
                        $html = file_get_html($data[$i]->link);

                                //get image list
                                $imagelist = $html->find('#imagePreview .viewer')[0]->find('div img');
                                //dd($imagelist);
                                foreach($imagelist as $key => $image){
                                    if($key==0 || $key%2!=0){
                                        $url = $image->src;
                                        if(@file_get_contents($url) != false){
                                            $imgg = $index_img++.$img_end;

                                            file_put_contents(public_path().'/media/imgProduct/images/'.$imgg, file_get_contents($url));
                                            file_put_contents(public_path().'/media/imgProduct/medium/'.$imgg, file_get_contents($url));
                                            file_put_contents(public_path().'/media/imgProduct/thumb/'.$imgg, file_get_contents($url));

                                            array_push($arrayImg, $imgg);
                                        }
                                    }
                                };
                                //get specs
                                $data[$i]->specs = $html->find('.specs-special')[0]->innertext;
                                //get description
                                $data[$i]->description = $html->find('#productContent')[0]->innertext;
                                $data[$i]->description =
                                str_replace('hoàng hà mobile','Whaale Mobile',
                                    str_replace('Hoàng Hà Mobile','Whaale Mobile',
                                        str_replace('src="/Uploads','src="https://hoanghamobile.com//Uploads',$data[$i]->description))
                                );


                        $data[$i]->imageList = $arrayImg;
                    }
                    catch(Exception $e){
                    }
                    //if($i == 3) break;
                    $imgg='';
                    $i++;
                }
                $index++;
            }
            //dd($data);
            foreach($data as $key => $insert){
                $id = DB::table('tbl_products')->insertGetId(
                    [
                        'code_id' => $code_pre.$key,
                        'product_name' => $insert->name,
                        'alias' => Str::slug($insert->name, '-'),
                        'cat_id' => $cat_id,
                        'manufa_id' => $manufac_id,
                        'quantity' => 0,
                        'price' => $insert->price,
                        'status_pro' => "Đang bán",
                        'product_dv' => "Chiếc",
                        'sales' => 0,
                        'price_sales' => '',
                        'status' => 1,
                        'product_featured' => 0,
                        'product_new' => 0,
                        'description' => $insert->description,
                        'content'=>$insert->specs,
                        'xuatxu'=>2,
                        'chatlieu'=>'',
                        'khoanggia'=>7,
                        'delete_pro'=>0,
                        'seo_title'=>$insert->name,
                        'seo_keyword'=>$insert->name,
                        'seo_description'=>$insert->name,
                        'date' => '2022-03-16 00:00:00',
                        'date_mod' => '2022-03-16 00:00:00',
                        'number_by' => 0,
                        'user_post' => 10,
                        'user_edit' => 'Triệu Xuân Đắc',
                        'show_index' => 1
                    ]
                );
                //main image
                DB::table('tbl_img')->insertGetId(
                    [
                        'id_product' => $id,
                        'img' => 'imgProduct/images/'.$insert->imageLink,
                        'medium' => 'imgProduct/medium/'.$insert->imageLink,
                        'thumbnail' => 'imgProduct/thumb/'.$insert->imageLink,
                        'status' => 1,
                        'date' => '2022-03-16'
                    ]
                );
                //sub image
                foreach($insert->imageList as $image){
                    DB::table('tbl_img')->insertGetId(
                        [
                            'id_product' => $id,
                            'img' => 'imgProduct/images/'.$image,
                            'medium' => 'imgProduct/medium/'.$image,
                            'thumbnail' => 'imgProduct/thumb/'.$image,
                            'status' => 0,
                            'date' => '2022-03-16'
                        ]
                    );
                }
            }
        }
    }
}
